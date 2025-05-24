<?php

header('Content-Type: application/json');

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Get token and email from URL
$token = $input['token'] ?? '';
$email = $input['email'] ?? '';

if (empty($token) || empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing token or email']);
    exit;
}

// Get new password from POST body
$data = json_decode(file_get_contents('php://input'), true);
$password = $input['password'] ?? '';
$confirm_password = $input['confirm_password'] ?? '';

if (empty($password) || empty($confirm_password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Password fields are required']);
    exit;
}

if ($password !== $confirm_password) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Passwords do not match']);
    exit;
}

if (strlen($password) < 6) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Password must be at least 6 characters']);
    exit;
}

// Check if token matches the one stored for the email
$stmt = $pdo->prepare("SELECT reset_token, reset_expires FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !$user['reset_token']) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid email or token']);
    exit;
}

// Optional: Check if token is expired
if ($user['reset_expires'] && strtotime($user['reset_expires']) < time()) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Reset token has expired']);
    exit;
}

if (!hash_equals($user['reset_token'], $token)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid reset token']);
    exit;
}

// Hash new password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Update password and clear reset token
$update = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE email = ?");
if ($update->execute([$hashedPassword, $email])) {
    echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to update password']);
}