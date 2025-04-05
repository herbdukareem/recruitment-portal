<?php
require_once __DIR__ . '/../../../config/config.php';

// Set default headers first
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

try {
    // Handle CORS first
    $allowedOrigins = [
        'http://localhost',
        'http://127.0.0.1',
        'https://yourproductiondomain.com'
    ];

    if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
        header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    // Handle preflight OPTIONS request
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        exit(0);
    }

    // Session configuration
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
                || ($_SERVER['SERVER_PORT'] == 443);

    $sessionParams = [
        'lifetime' => 86400,
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax'
    ];

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }

    session_set_cookie_params($sessionParams);
    
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Validate session
    if (empty($_SESSION['user']['user_id'])) {
        throw new Exception('Unauthorized - No session found', 401);
    }

    // Verify database connection
    if (!$pdo) {
        throw new Exception('Database connection failed', 500);
    }

    // Verify user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    if (!$stmt) {
        throw new Exception('Database query preparation failed', 500);
    }

    $stmt->execute([$_SESSION['user']['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Clear invalid session
        session_unset();
        session_destroy();
        throw new Exception('User not found', 401);
    }

    // Successful response
    echo json_encode([
        'success' => true,
        'user' => [
            'user_id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'nin' => $user['nin']
        ]
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Database error occurred'
    ]);
} catch (Exception $e) {
    $code = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
    http_response_code($code);
    error_log("Error in session check: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}