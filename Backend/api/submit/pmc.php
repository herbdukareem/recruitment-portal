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
    
    // Check if PMC data exists
    $checkStmt = $pdo->prepare("SELECT id FROM user_pmc_details WHERE user_id = ?");
    $checkStmt->execute([$user_id]);
    
    if ($checkStmt->rowCount() > 0) {
        // Update existing
        $sql = "UPDATE user_pmc_details SET
                    bodyName = ?,
                    membershipID = ?,
                    membershipType = ?,
                    membershipResposibilities = ?,
                    certificateDate = ?
                WHERE user_id = ?";
    } else {
        // Insert new
        $sql = "INSERT INTO user_pmc_details (
                    user_id, bodyName, membershipID,
                    membershipType, membershipResposibilities,
                    certificateDate
                ) VALUES (?, ?, ?, ?, ?, ?)";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $user_id,
        $input['bodyName'] ?? '',
        $input['membershipID'] ?? '',
        $input['membershipType'] ?? '',
        $input['membershipResposibilities'] ?? '',
        !empty($input['certificateDate']) ? $input['certificateDate'] : null
    ]);
    
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'PMC details saved', 'next' => 'summary']);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}