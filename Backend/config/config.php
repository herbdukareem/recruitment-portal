<?php
// Define debug mode first
define('DEBUG_MODE', true);
error_reporting(E_ALL);
ini_set('display_errors', DEBUG_MODE ? '1' : '0');

// Session settings MUST come before session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
ini_set('session.use_strict_mode', 1);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'recruitment_portal');
define('DB_USER', 'root');
define('DB_PASS', '');

// File upload settings
define('UPLOAD_DIR', __DIR__ . '/../../uploads/');
define('ALLOWED_FILE_TYPES', ['pdf', 'doc', 'jpg']);
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// File URL generator
function generateSecureFileUrl($path) {
    $base = 'https://yourdomain.com'; // Change this
    return $base . str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
}
// Production
// if (!isset($_SERVER['HTTPS']) && $_SERVER['HTTP_HOST'] != 'localhost') {
//     header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
//     exit();
// }

// Create PDO instance
try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    http_response_code(500);
    die("Database connection error");
}