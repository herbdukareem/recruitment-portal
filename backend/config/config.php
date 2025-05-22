<?php
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Debug mode configuration (should be false in production)
define('DEBUG_MODE', true);

// Error reporting settings
error_reporting(E_ALL);
ini_set('display_errors', DEBUG_MODE ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../../logs/php_errors.log');

// Session security settings (MUST come before session_start())
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? '1' : '0');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_lifetime', '0'); // Until browser closes
ini_set('session.gc_maxlifetime', '1800'); // 30 minutes
ini_set('session.sid_length', '128');
ini_set('session.sid_bits_per_character', '6');

// =============================================
// DATABASE CONFIGURATION
// =============================================
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);


// Create PDO instance with enhanced security
try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false, // Important for security
            PDO::ATTR_PERSISTENT => false, // Better for performance
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false, // Enable in production with valid cert
        ]
    );
} catch (PDOException $e) {
    error_log("[DB CONNECTION ERROR] " . date('Y-m-d H:i:s') . " - " . $e->getMessage());
    http_response_code(503); // Service Unavailable
    header('Retry-After: 30'); // Suggest retry after 30 seconds
    die(json_encode([
        'error' => 'Service temporarily unavailable',
        'message' => DEBUG_MODE ? $e->getMessage() : 'Please try again later'
    ]));
}


// =============================================
// FILE UPLOAD CONFIGURATION
// =============================================
// In config.php - Update the UPLOAD_DIR definition:
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']);
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('UPLOAD_DIR', realpath(__DIR__ . '/../../uploads') . DIRECTORY_SEPARATOR);

// Ensure upload directory exists and is writable
if (!file_exists(UPLOAD_DIR)) {
    if (!mkdir(UPLOAD_DIR, 0755, true)) {
        error_log("Failed to create upload directory: " . UPLOAD_DIR);
        die(json_encode(['error' => 'System configuration error']));
    }
}

// Only try to create .htaccess if on Apache
if (function_exists('apache_get_version') && !file_exists(UPLOAD_DIR . '.htaccess')) {
    @file_put_contents(UPLOAD_DIR . '.htaccess', 
        "Order deny,allow\nDeny from all\n<FilesMatch \"\.(pdf|doc|docx|jpg|jpeg|png)$\">\nAllow from all\n</FilesMatch>");
}

// =============================================
// SECURITY FUNCTIONS
// =============================================

/**
 * Generate secure file URL with access token
 */
function generateSecureFileUrl($filename) {
    if (!file_exists(UPLOAD_DIR . $filename)) {
        return null;
    }
    
    $token = bin2hex(random_bytes(16));
    $_SESSION['file_tokens'][$filename] = $token;
    
    $baseUrl = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . 
               $_SERVER['HTTP_HOST'] . 
               str_replace($_SERVER['DOCUMENT_ROOT'], '', UPLOAD_DIR);
               
    return $baseUrl . rawurlencode($filename) . '?token=' . $token;
}

/**
 * Validate file access token
 */
function validateFileToken($filename, $token) {
    return isset($_SESSION['file_tokens'][$filename]) && 
           hash_equals($_SESSION['file_tokens'][$filename], $token);
}

// =============================================
// CORS & HEADER SECURITY
// =============================================
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.example.com; style-src 'self' 'unsafe-inline'; img-src 'self' data:;");

// Force HTTPS in production
if (!DEBUG_MODE && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on')) {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}