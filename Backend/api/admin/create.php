<?php
if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$admin_role = $_POST['admin_role'];
$admin_id = $_POST['admin_id'];
$password = $_POST['password'];
$confirmPassword = $_POST['c-password'];

// Validation checks
if (empty($admin_id) || empty($admin_role) || empty($password) || empty($confirmPassword)) {
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

if ($password !== $confirmPassword) {
    echo json_encode(['error' => 'Passwords do not match']);
    exit;
}

// Check if admin exists
$checkAdmin = $pdo->prepare("SELECT admin_id FROM admins WHERE admin_id = :admin_id");
$checkAdmin->execute([':admin_id' => $admin_id]);

if ($checkAdmin->rowCount() > 0) {
    echo json_encode(['error' => 'Admin ID already exists']);
    exit;
}

// Hash password and create admin
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$insertAdmin = $pdo->prepare("INSERT INTO admins (admin_id, admin_role, admin_password) VALUES (:admin_id, :admin_role, :admin_password)");
$insertAdmin->execute([
    ':admin_id' => $admin_id,
    ':admin_role' => $admin_role,
    ':admin_password' => $hashed_password
]);

echo json_encode(['success' => 'Admin created successfully']);