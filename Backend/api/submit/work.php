<?php
if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Validate session
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No applicant session']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $pdo->beginTransaction();
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Check if work history exists
    $checkStmt = $pdo->prepare("SELECT id FROM user_work_details WHERE user_id = ?");
    $checkStmt->execute([$user_id]);
    
    if ($checkStmt->rowCount() > 0) {
        // Update existing
        $sql = "UPDATE user_work_details SET
                    organizationName = ?,
                    rank = ?,
                    responsibilities = ?,
                    startDate = ?,
                    endDate = ?
                WHERE user_id = ?";
    } else {
        // Insert new
        $sql = "INSERT INTO user_work_details (
                    user_id, organizationName, rank,
                    responsibilities, startDate, endDate
                ) VALUES (?, ?, ?, ?, ?, ?)";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $user_id,
        $input['organizationName'] ?? '',
        $input['rank'] ?? '',
        $input['responsibilities'] ?? '',
        !empty($input['startDate']) ? $input['startDate'] : null,
        !empty($input['endDate']) ? $input['endDate'] : null
    ]);
    
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Work history saved', 'next' => 'pmc']);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}