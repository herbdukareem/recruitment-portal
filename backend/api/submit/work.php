<?php
// Check HTTP method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Validate session
if (!isset($_SESSION['user']['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No applicant session']);
    exit;
}

$user_id = $_SESSION['user']['user_id'];

try {
    // Get input data - parse JSON if content type is application/json
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
    
    if (strpos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON: ' . json_last_error_msg()]);
            exit;
        }
    } else {
        $input = $_POST;
    }
    
    if (!is_array($input)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input data']);
        exit;
    }
    
    // Validate required fields
    $requiredFields = ['organizationName', 'rank', 'responsibilities', 'startDate', 'endDate'];
    $missingFields = [];
    
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            $missingFields[] = $field;
        }
    }
    
    if (!empty($missingFields)) {
        http_response_code(400);
        echo json_encode([
            'error' => 'Missing required fields',
            'missing_fields' => $missingFields
        ]);
        exit;
    }
    
    // Validate dates
    $startDate = $input['startDate'];
    $endDate = $input['endDate'];
    
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid date format. Use YYYY-MM-DD']);
        exit;
    }
    
    // Check if end date is after start date
    if (strtotime($endDate) < strtotime($startDate)) {
        http_response_code(400);
        echo json_encode(['error' => 'End date cannot be before start date']);
        exit;
    }
    
    $pdo->beginTransaction();
    
    // Check if work history exists
    $checkStmt = $pdo->prepare("SELECT id FROM user_work_details WHERE user_id = ?");
    $checkStmt->execute([$user_id]);
    
    if ($checkStmt->rowCount() > 0) {
        // Update existing
        $sql = "UPDATE user_work_details SET
            organizationName = :orgName,
            `rank` = :rank,
            responsibilities = :resp,
            startDate = :startDate,
            endDate = :endDate
            WHERE user_id = :userId";
    } else {
        // Insert new
        $sql = "INSERT INTO user_work_details (
            user_id, organizationName, `rank`,
            responsibilities, startDate, endDate
            ) VALUES (:userId, :orgName, :rank, :resp, :startDate, :endDate)";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':userId' => $user_id,
        ':orgName' => trim($input['organizationName']),
        ':rank' => trim($input['rank']),
        ':resp' => trim($input['responsibilities']),
        ':startDate' => $input['startDate'],
        ':endDate' => $input['endDate']
    ]);
    
    $pdo->commit();
    
    echo json_encode([
        'success' => true, 
        'message' => 'Work history saved successfully', 
        'next' => 'pmc'
    ]);
    
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
}