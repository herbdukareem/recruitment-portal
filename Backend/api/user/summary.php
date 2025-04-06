<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';
require_once __DIR__ . '/../../helpers/rate_limit.php';

header('Content-Type: application/json');

try {
    // Apply rate limiting (15 requests per minute)
    limitRequests('user_full_profile', 15, 60);

    // Authenticate the user
    authenticateUser();
    // Get current user ID from session
    $current_user_id = $_SESSION['user']['user_id'] ?? null;
    if (!$current_user_id) {
        throw new Exception('User not authenticated', 401);
    }

    // Extract user_id from URL parameter
    $user_id = $_GET['user_id'] ?? null; // Simplified parameter extraction
    
    // If no user_id provided, default to current user
    if (!$user_id) {
        $user_id = $current_user_id;
    }
    
    // Validate user_id
    if (!is_numeric($user_id)) {
        throw new Exception('Invalid User ID format', 400);
    }
    // Start transaction for data consistency
    $pdo->beginTransaction();

    // Main query with LEFT JOINs to get all data in one request
    $sql = "
        SELECT 
            -- User basic info
            u.id, u.email, u.created_at, u.last_login,
            b.position, b.firstname, b.lastname, b.middlename, b.gender,
            b.dateOfBirth, b.maritalStatus, b.phoneNumber, b.nin,
            b.emergencyNumber, b.address, b.lga, b.stateOfOrigin, b.status,
            e.primary_school_name, e.primary_graduation_year,
            e.secondarySchoolName, e.secondaryGraduationYear,
            e.certificateType, e.classOfDegree, e.institution, e.course,
            e.highGraduationYear, e.nyscCertificateNumber, e.yearOfService,
            w.organizationName, w.rank, w.responsibilities,
            w.startDate, w.endDate,
            p.bodyName, p.membershipID, p.membershipType,
            p.membershipResposibilities, p.certificateDate,
            f.passport_file_path, f.birth_certificate_file_path,
            f.sec_file_path, f.high_certificate_file_path,
            f.nysc_file_path, f.pmc_file_path
            
        FROM users u
        JOIN user_applications b ON u.id = b.user_id
        JOIN user_education_details e ON u.id = e.user_id
        JOIN user_pmc_details p ON u.id = p.user_id
        JOIN user_work_details w ON u.id = w.user_id
        JOIN user_files f ON u.id = f.user_id
        WHERE u.id = :user_id
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        throw new Exception('User not found', 404);
    }

    // Process file paths into secure URLs
    $fileFields = [
        'passport_file_path',
        'birth_certificate_file_path',
        'sec_file_path',
        'high_certificate_file_path',
        'nysc_file_path',
        'pmc_file_path'
    ];

    foreach ($fileFields as $field) {
        if (!empty($result[$field])) {
            $result[$field] = generateSecureFileUrl($result[$field]);
        } else {
            $result[$field] = null;
        }
        unset($result[$field]);
    }

    // Reorganize data into logical groups
    $profileData = [
        'basic' => [
            'id' => $result['id'],
            'email' => $result['email'],
            'created_at' => $result['created_at'],
            'last_login' => $result['last_login']
        ],
        'application' => [
            'position' => $result['position'],
            'firstname' => $result['firstname'],
            'lastname' => $result['lastname'],
            'middlename' => $result['middlename'],
            'gender' => $result['gender'],
            'dateOfBirth' => $result['dateOfBirth'],
            'maritalStatus' => $result['maritalStatus'],
            'phoneNumber' => $result['phoneNumber'],
            'nin' => $result['nin'],
            'emergencyNumber' => $result['emergencyNumber'],
            'address' => $result['address'],
            'lga' => $result['lga'],
            'stateOfOrigin' => $result['stateOfOrigin'],
            'status' => $result['status']
        ],
        'education' => [
            'primary_school_name' => $result['primary_school_name'],
            'primary_graduation_year' => $result['primary_graduation_year'],
            'secondarySchoolName' => $result['secondarySchoolName'],
            'secondaryGraduationYear' => $result['secondaryGraduationYear'],
            'certificateType' => $result['certificateType'],
            'classOfDegree' => $result['classOfDegree'],
            'institution' => $result['institution'],
            'course' => $result['course'],
            'highGraduationYear' => $result['highGraduationYear'],
            'nyscCertificateNumber' => $result['nyscCertificateNumber'],
            'yearOfService' => $result['yearOfService']
        ],
        'work_history' => [
            'organizationName' => $result['organizationName'], 
            'rank' => $result['rank'], 
            'responsibilities' => $result['responsibilities'],
            'startDate' => $result['startDate'], 
            'endDate' => $result['endDate'],
        ],
        'pmc_details' => [
            'bodyName' => $result['bodyName'],
            'membershipID' => $result['membershipID'],
            'membershipType' => $result['membershipType'],
            'membershipResposibilities' => $result['membershipResposibilities'],
            'certificateDate' => $result['certificateDate']
        ],
        // 'files' => [
        //     'passport' => $result['passport_file_path'],
        //     'birth_certificate' => $result['birth_certificate_file_path'],
        //     'secondary_certificate' => $result['sec_file_path'],
        //     'higher_certificate' => $result['high_certificate_file_path'],
        //     'nysc_certificate' => $result['nysc_file_path'],
        //     'pmc_certificate' => $result['pmc_file_path']
        // ]
    ];

    $pdo->commit();

    // Add rate limit headers
    foreach (getRateLimitHeaders('user_full_profile', 15, 60) as $name => $value) {
        header("$name: $value");
    }

    echo json_encode([
        'success' => true,
        'data' => $profileData,
        'meta' => [
            'generated_at' => time(),
            'schema_version' => '1.1'
        ]
    ]);

} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error',
        'message' => DEBUG_MODE ? $e->getMessage() : null
    ]);
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}