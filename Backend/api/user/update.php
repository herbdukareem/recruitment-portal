<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    authenticateUser();
    $user_id = $_SESSION['user_id'];
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate update type
    $allowedTypes = ['basic', 'education', 'work', 'pmc'];
    if (empty($input['type']) || !in_array($input['type'], $allowedTypes)) {
        throw new Exception('Invalid update type', 400);
    }

    // Route to appropriate update handler
    switch ($input['type']) {
        case 'basic':
            require __DIR__ . '/update_handlers/basic.php';
            break;
        case 'education':
            require __DIR__ . '/update_handlers/education.php';
            break;
        case 'work':
            require __DIR__ . '/update_handlers/work.php';
            break;
        case 'pmc':
            require __DIR__ . '/update_handlers/pmc.php';
            break;
    }

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}