<?php
require_once __DIR__ . '/../../../helpers/mailer.php';
require_once __DIR__ . '/../../../helpers/generatestring.php'; // assuming generateNewString is defined here

header('Content-Type: application/json');

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $pdo->beginTransaction();

    $input = $_POST;
    $email = $input['email'] ?? '';

    // Validate email
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     http_response_code(400);
    //     echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    //     exit;
    // }

    // Check if user exists
    $checkUserEmail = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $checkUserEmail->execute([':email' => $email]);
    $existingEmail = $checkUserEmail->fetchColumn() > 0;

    if (!$existingEmail) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email does not exist']);
        exit;
    }

    // Generate token and expiry time (5 minutes)
    $token = generateNewString(32);
    $tokenExpire = date('Y-m-d H:i:s', time() + (5 * 60));

    // Send the reset email
    if (!sendResetEmail($email, $token)) {
        throw new Exception('Failed to send reset email');
    }

    // Store token and expiry in DB
    $sql = "UPDATE users SET
                reset_token = :resetToken,
                reset_expires = :resetExpires
            WHERE email = :email";
    $updateReset = $pdo->prepare($sql);
    $updateReset->execute([
        ':resetToken' => $token,
        ':resetExpires' => $tokenExpire,
        ':email' => $email
    ]);

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Password reset email sent'
    ]);

} catch (\Throwable $th) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong',
        'error' => $th->getMessage()
    ]);
}
