<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';

header('Content-Type: application/json');

try {
    // 1. Authenticate the admin
    authenticateAdmin();
    
    // 2. Get admin ID from session
    $adminId = $_SESSION['admin_id'];
    $adminRole = $_SESSION['admin_role'];
    
    // 3. Fetch additional admin data from database
    $stmt = $pdo->prepare("
        SELECT 
            admin_id,
            admin_role,
            last_login,
            created_at
        FROM admins
        WHERE admin_id = :admin_id
    ");
    $stmt->execute([':admin_id' => $adminId]);
    $adminData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$adminData) {
        throw new Exception('Admin not found', 404);
    }
    
    // 4. Prepare response data
    $response = [
        'success' => true,
        'data' => [
            'admin_id' => $adminData['admin_id'],
            'role' => $adminData['admin_role'],
            'last_login' => $adminData['last_login'],
            'account_created' => $adminData['created_at']
        ]
    ];
    
    // 5. Return the response
    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'message' => 'Failed to fetch admin data'
    ]);
}