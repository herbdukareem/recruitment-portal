<?php
require_once __DIR__ . '/../../config/config.php';

// First check if session is already active
if (session_status() === PHP_SESSION_ACTIVE) {
    session_write_close();
}

// Now safely configure session parameters
$isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
            || ($_SERVER['SERVER_PORT'] == 443);

session_set_cookie_params([
    'lifetime' => 86400,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => $isSecure,
    'httponly' => true,
    'samesite' => 'Lax' // Requires PHP 7.3+
]);

// Only start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// For PHP < 7.3 SameSite cookie (alternative approach)
if (PHP_VERSION_ID < 70300 && session_status() === PHP_SESSION_ACTIVE) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        session_id(),
        [
            'expires' => time() + 86400,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => 'Lax'
        ]
    );
}

// Handle CORS headers safely
$allowedOrigins = [
    'http://localhost',
    'http://127.0.0.1',
    'https://yourproductiondomain.com'
];

// Check if origin exists and is allowed
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }
    
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    
    exit(0);
}

// 5. Check session
try {
    if (empty($_SESSION['admin_id'])) {
        throw new Exception('Unauthorized', 401);
    }

    // 6. Verify admin exists in database
    $stmt = $pdo->prepare("SELECT admin_id, admin_role FROM admins WHERE admin_id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();

    if (!$admin) {
        session_destroy();
        throw new Exception('Admin not found', 401);
    }

    // 7. Return admin data
    echo json_encode([
        'success' => true,
        'admin' => [
            'id' => $admin['admin_id'],
            'role' => $admin['admin_role']
        ]
    ]);

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}