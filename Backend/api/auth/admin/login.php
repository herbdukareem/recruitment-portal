<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../helpers/auth_helper.php';
require_once __DIR__ . '/../../../helpers/rate_limit.php';
limitRequests('login', 5, 60); // 5 attempts per minute

// session_start([
//     'cookie_lifetime' => 86400,
//     'cookie_secure' => isset($_SERVER['HTTPS']),
//     'cookie_httponly' => true,
//     'cookie_samesite' => 'Lax'
// ]);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (empty($input['admin_id']) || empty($input['admin_password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

try {
    // Fetch admin from database
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE admin_id = :admin_id");
    $stmt->execute([':admin_id' => $input['admin_id']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
        exit;
    }

    // Verify password
    if (!password_verify($input['admin_password'], $admin['admin_password'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
        exit;
    }
    
    // After successful authentication:
    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['admin_role'] = $admin['admin_role'];
    $_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time
    
    // Set CSRF token
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'admin' => [
            'id' => $admin['id'],
            'admin_id' => $admin['admin_id'],
            'role' => $admin['admin_role']
        ]
    ]);

    // Regenerate session ID to prevent fixation
    session_regenerate_id(true);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}