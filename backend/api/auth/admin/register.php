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
$requiredFields = ['admin_id', 'admin_role', 'password', 'confirm_password'];
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
    $stmt = $pdo->prepare("SELECT admin_id FROM admins WHERE admin_id = :admin_id");
    $stmt->execute([':admin_id' => $input['admin_id']]);
    
    if ($stmt->rowCount() > 0) {
        http_response_code(409);
        echo json_encode(['error' => 'Admin ID already exists']);
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
        INSERT INTO admins (admin_id, admin_role, admin_password) 
        VALUES (:admin_id, :admin_role, :admin_password)
    ");
    
    $stmt->execute([
        ':admin_id' => $input['admin_id'],
        ':admin_role' => $input['admin_role'],
        ':admin_password' => $hashedPassword
    ]);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Admin created successfully'
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}