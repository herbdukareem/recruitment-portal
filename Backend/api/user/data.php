<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';
require_once __DIR__ . '/../../helpers/rate_limit.php';

header('Content-Type: application/json');

try {
    // Rate limiting (30 requests/minute)
    limitRequests('user_data', 30, 60);
    
    // Authenticate user
    authenticateUser();
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        SELECT 
            u.id, u.email, u.created_at, u.last_login,
            b.firstname, b.lastname, b.phoneNumber, b.position, b.status
        FROM users u
        LEFT JOIN user_applications b ON u.id = b.user_id
        WHERE u.id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        throw new Exception('User not found', 404);
    }

    // Add rate limit headers
    foreach (getRateLimitHeaders('user_data', 30, 60) as $name => $value) {
        header("$name: $value");
    }

    echo json_encode([
        'success' => true,
        'data' => $userData
    ]);

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}