<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';
require_once __DIR__ . '/../../helpers/rate_limit.php';

header('Content-Type: application/json');

// Authenticate admin
authenticateAdmin();

// Apply rate limiting to this endpoint
limitRequests('admin_applicants', 60, 60); // 60 requests per minute

try {
    // Get query parameters
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $perPage = isset($_GET['per_page']) ? min(max(5, (int)$_GET['per_page']), 100) : 20;
    $offset = ($page - 1) * $perPage;

    // Initialize search/filter conditions
    $conditions = [];
    $params = [];
    $searchableFields = [
        'position', 'status', 'nin', 'firstname', 'lastname', 'email'
    ];

    // Build search conditions
    foreach ($searchableFields as $field) {
        if (!empty($_GET[$field])) {
            $conditions[] = "b.$field LIKE :$field";
            $params[":$field"] = '%' . $_GET[$field] . '%';
        }
    }

    // Date range filter
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $conditions[] = "u.created_at BETWEEN :start_date AND :end_date";
        $params[':start_date'] = $_GET['start_date'] . ' 00:00:00';
        $params[':end_date'] = $_GET['end_date'] . ' 23:59:59';
    }

    // Build WHERE clause
    $whereClause = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

    // Base query for applicants
    $sql = "
        SELECT 
            u.id AS user_id,
            u.created_at,
            b.position, 
            b.firstname, 
            b.middlename, 
            b.lastname, 
            b.gender, 
            b.dateOfBirth,
            b.maritalStatus,
            u.email, 
            b.phoneNumber, 
            b.nin,
            b.emergencyNumber,
            b.address,
            b.lga,
            b.stateOfOrigin,
            e.primary_school_name, 
            e.primary_graduation_year, 
            e.secondarySchoolName, 
            e.secondaryGraduationYear, 
            e.certificateType, 
            e.classOfDegree, 
            e.institution, 
            e.course, 
            e.highGraduationYear, 
            e.nyscCertificateNumber, 
            e.yearOfService,
            w.organizationName, 
            w.rank, 
            w.responsibilities, 
            w.startDate, 
            w.endDate, 
            p.bodyName,
            p.membershipID, 
            p.membershipResposibilities, 
            p.certificateDate,
            q.score_percentage,
            f.lga_file_path,
            f.birth_certificate_file_path,
            f.passport_file_path,
            f.sec_file_path,
            f.high_certificate_file_path,
            f.nysc_file_path,
            f.pmc_file_path
        FROM user_applications AS b
        JOIN users AS u ON b.user_id = u.id
        JOIN user_education_details AS e ON u.id = e.user_id
        JOIN user_pmc_details AS p ON u.id = p.user_id
        JOIN user_work_details AS w ON u.id = w.user_id
        JOIN quiz_scores AS q ON u.id = q.user_id
        JOIN user_files AS f ON u.id = f.user_id
        $whereClause
        ORDER BY u.created_at DESC
        LIMIT :offset, :per_page"
    ;

    // Count query for pagination
    $countSql = "
        SELECT COUNT(*) as total
        FROM users u
        JOIN user_applications b ON u.id = b.user_id
        $whereClause
    ";

    // Prepare and execute main query
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':per_page', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    $applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get total count for pagination
    $countStmt = $pdo->prepare($countSql);
    foreach ($params as $key => $value) {
        $countStmt->bindValue($key, $value);
    }
    $countStmt->execute();
    $totalCount = $countStmt->fetchColumn();

    // Add rate limit headers
    $rateLimitHeaders = getRateLimitHeaders('admin_applicants', 60, 60);
    foreach ($rateLimitHeaders as $name => $value) {
        header("$name: $value");
    }

    // Return response
    echo json_encode([
        'success' => true,
        'data' => $applicants,
        'pagination' => [
            'total' => (int)$totalCount,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($totalCount / $perPage)
        ]
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error',
        'message' => DEBUG_MODE ? $e->getMessage() : null
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}