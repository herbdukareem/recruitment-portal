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
        throw new Exception('Admin not found', 404); // Ensure this is an integer
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
    // Ensure the response code is always an integer
    $statusCode = is_int($e->getCode()) && $e->getCode() >= 100 && $e->getCode() < 600 
        ? $e->getCode() 
        : 500;
    
    http_response_code($statusCode);
    
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'message' => 'Failed to fetch admin data',
        'error_id' => uniqid('ERR-', true)
    ]);
}