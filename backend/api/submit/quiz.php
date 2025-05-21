<?php
if ($method !== 'POST') {
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
    $pdo->beginTransaction();
    
    $input = $_POST;
    
    // Check if a record exists
    $checkQuizScore = $pdo->prepare("SELECT COUNT(*) FROM quiz_scores WHERE user_id = :user_id");
    $checkQuizScore->execute(['user_id' => $user_id]);
    $recordExists = $checkQuizScore->fetchColumn() > 0; // Fetch the count correctly

    if (!$recordExists) {
        $sql = "INSERT INTO quiz_scores (user_id, score, score_percentage)
                VALUES (?, ?, ?)";
    } else {
        $sql = "UPDATE quiz_scores SET score = ?, score_percentage = ? 
                WHERE user_id = ?";
    }

    // Execute query
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $user_id,
        $input['score'] ?? '',
        $input['scorePercentage'] ?? ''
    ]);

    // Delay before redirecting
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Quiz Submitted', 'next' => 'application-status_screen']);

} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
