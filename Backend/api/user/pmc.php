<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';

header('Content-Type: application/json');

try {
    authenticateUser();
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        SELECT * FROM user_pmc_details 
        WHERE user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    $pmcDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $pmcDetails ?: []
    ]);

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}