<?php
require_once __DIR__.'/../../config/config.php';
require_once __DIR__.'/../../helpers/auth_helper.php';
require_once __DIR__.'/../../helpers/middleware.php';

// Check authentication
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

try {

    // $userId = $_POST['user_id'] ?? null;
    // $status = $_POST['status'] ?? null;

    if (empty($input['user_id'])) {
        throw new Exception('Missing required parameters');
    }

    $_SESSION['user']['user_id'] = $input['user_id']

    echo json_encode([
        'success' => true,
        'message' => 'Edit session initiated successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Update failed: '.$e->getMessage()
    ]);
}