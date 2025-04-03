<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../helpers/auth_helper.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
$requiredFields = ['firstname', 'lastname', 'email', 'nin', 'password', 'confirm_password'];
foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Field $field is required"]);
        exit;
    }
}

if ($input['password'] !== $input['confirm_password']) {
    http_response_code(400);
    echo json_encode(['error' => 'Passwords do not match']);
    exit;
}

try {
    // Check if admin already exists
    $stmt = $pdo->prepare("SELECT email FROM users WHERE email = :email AND nin = :nin");
    $stmt->execute([':email' => $input['email'], ':nin' => $input['nin']]);
    
    if ($stmt->rowCount() > 0) {
        http_response_code(409);
        echo json_encode(['error' => 'Appliant email or nin already exists']);
        exit;
    }
    if (strlen($input['password']) < 8) {
        http_response_code(400);
        echo json_encode(['error' => 'Password must be at least 8 characters']);
        exit;
    }
    // Hash password
    $hashedPassword = password_hash($input['password'], PASSWORD_DEFAULT);

    // Create new admin
    $stmt = $pdo->prepare("
        INSERT INTO users (firstname, lastname, email, nin, password) 
        VALUES (:firstname, :lastname, :email, :nin, :password)
    ");
    
    $stmt->execute([
        ':firstname' => $input['firstname'],
        ':lastname' => $input['lastname'],
        ':email' => $input['email'],
        ':nin' => $input['nin'],
        ':password' => $hashedPassword
    ]);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute-([':email'=>$input['email']]);
    $user_id = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_firstname'] = $input['firstname'];
    $_SESSION['user_lastname'] = $input['lastname'];
    $_SESSION['user_email'] = $input['email'];
    $_SESSION['nin'] = $input['nin'];

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Sign up created successfully'
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}