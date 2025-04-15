<?php
require_once __DIR__ . '/../../config/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Check if admin is authenticated
if (!isset($_SESSION['admin_id']) || !$_SESSION['admin_id']) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized: Admin only']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

if (!$input['user_id'] || !is_numeric($input['user_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing user ID']);
    exit;
}

$input['user_id'] = (int) $input['user_id'];

try {
    $pdo->beginTransaction();

    // Check if the user application exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_applications WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $input['user_id']]);
    $recordExists = $stmt->fetchColumn() > 0;

    if ($recordExists) {
        // Update status (you can customize status value here)
        $sql = "UPDATE user_applications SET status = :status WHERE user_id = :user_id";
        $params = [
            'status' => $input['status'],
            'user_id' => $input['user_id']
        ];
    } else {
        // Insert new record
        $sql = "INSERT INTO user_applications (user_id, status) VALUES (:user_id, :status)";
        $params = [
            'user_id' => $input['user_id'],
            'status' => $input['status']
        ];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Now set session for this user (impersonation)
    $_SESSION['user']['user_id'] = $input['user_id'];

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Applicant session started successfully',
        'next' => 'application-status_screen'
    ]);
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
