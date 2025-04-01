<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';
require_once __DIR__ . '/../../helpers/file_helper.php';

header('Content-Type: application/json');

try {
    authenticateUser();
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        SELECT 
            passport_file_path,
            birth_certificate_file_path,
            sec_file_path,
            high_certificate_file_path,
            nysc_file_path,
            pmc_file_path
        FROM user_files
        WHERE user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    $files = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

    // Convert paths to secure URLs
    $fileUrls = [];
    foreach ($files as $type => $path) {
        if ($path) {
            $fileUrls[$type] = generateSecureFileUrl($path);
        }
    }

    echo json_encode([
        'success' => true,
        'data' => $fileUrls
    ]);

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}