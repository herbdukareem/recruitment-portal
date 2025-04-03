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

if(isset($input['email'])){
    if (empty($input['email']) || empty($input['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'All fields are required']);
        exit;
    }
} else {
    if (empty($input['nin']) || empty($input['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'All fields are required']);
        exit;
    }
}


try {
    if(isset($input['email'])){
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([
            ':email' => $input['email']
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE nin = :nin");
        $stmt->execute([
            ':nin' => $input['nin']
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    };
    

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
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_firstname'] = $user['firstname'];
    $_SESSION['user_lastname'] = $user['lastname'];
    $_SESSION['user_email'] = $user['email'];
    
    // Set CSRF token
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'user' => [
            'user_id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email']
        ]
    ]);

    // Regenerate session ID to prevent fixation
    session_regenerate_id(true);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}