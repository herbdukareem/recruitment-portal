<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';

// Start secure session
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
    // Debug: Log session start
    error_log('Starting education endpoint for session: ' . session_id());
    
    // Authenticate user
    authenticateUser();
    
    // Debug: Log session data
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
    
    // Test database connection
    $pdo->query("SELECT 1")->fetch();

    $stmt = $pdo->prepare("
        SELECT COUNT(*) as record_count 
        FROM user_education_details 
        WHERE user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    $count = $stmt->fetchColumn();

    if ($count === 0) {
        echo json_encode([
            'success' => true,
            'data' => null,
            'message' => 'No education records found',
            'user_id' => $user_id,
            'record_exists' => false
        ]);
        exit;
    }

    // Fetch full data if exists
    $stmt = $pdo->prepare("SELECT * FROM user_education_details WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $education = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $education,
        'user_id' => $user_id,
        'record_exists' => true
    ]);

    } catch (PDOException $e) {
        error_log('PDOException in education endpoint: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Database error',
            'debug' => $e->getMessage() // Remove in production
        ]);
} catch (Exception $e) {
    $code = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 400;
    error_log('Exception in education endpoint: ' . $e->getMessage());
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'code' => $code,
        'debug' => [ // Remove in production
            'session_user_id' => $_SESSION['user']['user_id'] ?? null,
            'error_trace' => $e->getTraceAsString()
        ]
    ]);
}