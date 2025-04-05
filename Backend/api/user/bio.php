<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax'
    ]);
}

header('Content-Type: application/json');

try {
    // Authenticate the user
    authenticateUser();
    
    // Debug: Log session data (remove in production)
    error_log('Session data: ' . print_r($_SESSION, true));

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
    
    $user_id = (int)$user_id;

    // Verify permission (allow current user or admin)
    if(isset($_SESSION['admin_role'])){
        $is_admin = ($_SESSION['admin_role']);
        if ($current_user_id !== $user_id || !$is_admin) {
            throw new Exception('Unauthorized to access this user data', 403);
        }
    } else {
        if ($current_user_id !== $user_id) {
            throw new Exception('Unauthorized to access this user data', 403);
        }
    }

    // Fetch user data
    $stmt = $pdo->prepare("SELECT * FROM user_applications WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $bio = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $bio ?: null,
        'debug' => [ // Remove in production
            'requested_user_id' => $user_id,
            'current_user_id' => $current_user_id,
            // 'is_admin' => $is_admin
        ]
    ]);

} catch (Exception $e) {
    $code = is_int($e->getCode()) ? $e->getCode() : 400;
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'debug' => [ // Remove in production
            'session_user_id' => $_SESSION['user']['user_id'] ?? null,
            'error_code' => $code
        ]
    ]);
}