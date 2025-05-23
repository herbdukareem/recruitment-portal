<?php
require_once __DIR__ . '/../../../config/database.php'; // PDO connection

// Step 1: Handle GET request (display form)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $email = $_GET['email'] ?? '';
    $token = $_GET['token'] ?? '';

    // Basic validation
    if (!$email || !$token) {
        echo "Invalid reset link.";
        exit;
    }

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Reset Password</title>
        <style>
            body { font-family: Arial; padding: 30px; }
            input { margin: 5px 0; padding: 8px; width: 300px; }
            button { padding: 10px 20px; }
        </style>
    </head>
    <body>
        <h2>Reset Your Password</h2>
        <form method="POST">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <label>New Password:</label><br>
            <input type="password" name="password" required><br><br>
            <button type="submit">Reset Password</button>
        </form>
    </body>
    </html>

    <?php
    exit;
}

// Step 2: Handle POST request (update password)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $token = $_POST['token'] ?? '';
    $newPassword = $_POST['password'] ?? '';

    if (!$email || !$token || !$newPassword) {
        echo "All fields are required.";
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Find user with matching email and token
        $stmt = $pdo->prepare("SELECT id, reset_expires FROM users WHERE email = :email AND reset_token = :token");
        $stmt->execute([':email' => $email, ':token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Invalid or expired token.";
            exit;
        }

        // Check if token expired
        if (strtotime($user['reset_expires']) < time()) {
            echo "This reset link has expired.";
            exit;
        }

        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = :password, reset_token = NULL, reset_expires = NULL WHERE id = :id");
        $update->execute([
            ':password' => $hashedPassword,
            ':id' => $user['id']
        ]);

        $pdo->commit();

        echo "Password has been successfully reset. You may now log in.";
    } catch (\Throwable $e) {
        $pdo->rollBack();
        echo "Something went wrong. Please try again.";
    }
};