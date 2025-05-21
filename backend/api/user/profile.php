<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';

header('Content-Type: application/json');

try {
    authenticateUser();
    $user_id = $_SESSION['user_id'];

    // Get all profile data in a transaction
    $pdo->beginTransaction();

    $profile = [
        'basic' => fetchBasicUserInfo($pdo, $user_id),
        'application' => fetchApplicationData($pdo, $user_id),
        'education' => fetchEducationData($pdo, $user_id),
        'work_history' => fetchWorkHistory($pdo, $user_id),
        'pmc_details' => fetchPmcDetails($pdo, $user_id),
        'quiz_scores' => fetchQuizScores($pdo, $user_id),
        'files' => fetchFileReferences($pdo, $user_id)
    ];

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'data' => $profile
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code($e->getCode() ?: 400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

// Helper functions would be in auth_helper.php