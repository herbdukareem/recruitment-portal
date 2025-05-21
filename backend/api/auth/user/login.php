<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../helpers/auth_helper.php';
require_once __DIR__ . '/../../../helpers/rate_limit.php';

// Apply rate limiting (5 attempts per minute)
limitRequests('login', 5, 60);

// Configure secure session parameters before starting
$isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
$sessionParams = [
    'name' => 'SecureSessionID',
    'cookie_lifetime' => 86400, // 1 day
    'cookie_path' => '/',
    'cookie_domain' => $_SERVER['HTTP_HOST'],
    'cookie_secure' => $isSecure,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true,
    'use_only_cookies' => true,
    'hash_function' => 'sha256',
    'gc_maxlifetime' => 86400
];

// Set custom session parameters
// session_set_cookie_params($sessionParams);

// Start session with secure settings
if (session_status() === PHP_SESSION_NONE) {
    session_start($sessionParams);
}

header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get and validate JSON input
$input = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON input']);
    exit;
}

// Validate required fields
$loginField = isset($input['email']) ? 'email' : 'nin';
if (empty($input[$loginField]) || empty($input['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

try {
    // Fetch user from database using prepared statement
    $stmt = $pdo->prepare("SELECT * FROM users WHERE $loginField = :identifier");
    $stmt->bindParam(':identifier', $input[$loginField], PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
        exit;
    }

    // Verify password
    if (!password_verify($input['password'], $user['password'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
        exit;
    }

    // Check account status
    if (isset($user['status']) && $user['status'] !== 'active') {
        http_response_code(403);
        echo json_encode(['error' => 'Account is not active']);
        exit;
    }

    // Regenerate session ID to prevent fixation
    session_regenerate_id(true);

    // Generate new CSRF token for the session
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Store minimal user data in session
    $_SESSION['user'] = [
        'user_id' => $user['id'],
        'firstname' => $user['firstname'],
        'lastname' => $user['lastname'],
        'email' => $user['email'],
        'logged_in' => true,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'last_login' => time(),
        'csrf_token' => $_SESSION['csrf_token']
    ];

    // Set secure session cookie
    setcookie(
        session_name(),
        session_id(),
        [
            'expires' => time() + 86400,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]
    );

    // Successful login response
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'user' => [
            'id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email']
        ],
        'csrf_token' => $_SESSION['csrf_token']
    ]);

} catch (PDOException $e) {
    error_log('Database error during login: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
} catch (Exception $e) {
    error_log('Error during login: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
} finally {
    // Close session if it was opened
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }
}