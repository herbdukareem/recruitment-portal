<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../helpers/auth_helper.php';

// Start secure session
$isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
$requiredFields = ['firstname', 'lastname', 'email', 'nin', 'password', 'confirm_password'];
foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Field $field is required"]);
        exit;
    }
}

// Validate email format
if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email format']);
    exit;
}

// Validate password match
if ($input['password'] !== $input['confirm_password']) {
    http_response_code(400);
    echo json_encode(['error' => 'Passwords do not match']);
    exit;
}

// Validate password strength
if (strlen($input['password']) < 8) {
    http_response_code(400);
    echo json_encode(['error' => 'Password must be at least 8 characters']);
    exit;
}

try {
    // Check if user already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR nin = :nin");
    $stmt->execute([':email' => $input['email'], ':nin' => $input['nin']]);
    
    if ($stmt->rowCount() > 0) {
        http_response_code(409);
        echo json_encode(['error' => 'User with this email or NIN already exists']);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($input['password'], PASSWORD_DEFAULT);

    // Begin transaction
    $pdo->beginTransaction();

    // Create new user
    $stmt = $pdo->prepare("
        INSERT INTO users (firstname, lastname, email, nin, password) 
        VALUES (:firstname, :lastname, :email, :nin, :password)
    ");
    
    $stmt->execute([
        ':firstname' => htmlspecialchars($input['firstname']),
        ':lastname' => htmlspecialchars($input['lastname']),
        ':email' => $input['email'],
        ':nin' => $input['nin'],
        ':password' => $hashedPassword
    ]);

    // Get the new user ID
    $user_id = $pdo->lastInsertId();

    // Set session variables
    $_SESSION['user'] = [
        'id' => $user_id,
        'firstname' => htmlspecialchars($input['firstname']),
        'lastname' => htmlspecialchars($input['lastname']),
        'email' => $input['email'],
        'nin' => $input['nin'],
        'logged_in' => true,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'last_login' => time()
    ];

    // Generate CSRF token
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Commit transaction
    $pdo->commit();

    // Regenerate session ID
    session_regenerate_id(true);

    // Success response
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Registration successful',
        'user' => [
            'id' => $user_id,
            'firstname' => htmlspecialchars($input['firstname']),
            'lastname' => htmlspecialchars($input['lastname']),
            'email' => $input['email']
        ],
        'csrf_token' => $_SESSION['csrf_token']
    ]);

} catch (PDOException $e) {
    // Rollback transaction if it was started
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Database error during registration: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
} catch (Exception $e) {
    // Rollback transaction if it was started
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Error during registration: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}