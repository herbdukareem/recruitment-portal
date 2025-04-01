<?php
if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Validate session
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No applicant session']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $pdo->beginTransaction();
    
    // Initialize file paths
    $filePaths = [
        'sec_file_path' => null,
        'high_certificate_file_path' => null,
        'nysc_file_path' => null,
        'pmc_file_path' => null,
        'lga_file_path' => null,
        'birth_certificate_file_path' => null,
        'passport_file_path' => null
    ];
    
    // Process each file upload
    foreach ($_FILES as $field => $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Validate file
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $fileSize = $file['size'];
            
            if (!in_array($fileExt, ALLOWED_FILE_TYPES)) {
                throw new Exception("Invalid file type for $field");
            }
            
            if ($fileSize > MAX_FILE_SIZE) {
                throw new Exception("File too large for $field (max " . (MAX_FILE_SIZE / 1024 / 1024) . "MB)");
            }
            
            // Generate unique filename
            $newFilename = "user_{$user_id}_" . time() . "_{$field}.{$fileExt}";
            $destination = UPLOAD_DIR . $newFilename;
            
            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                throw new Exception("Failed to move uploaded file: $field");
            }
            
            // Map to correct database field
            switch ($field) {
                case 'secondaryCertificate':
                    $filePaths['sec_file_path'] = $destination;
                    break;
                case 'highCertificate':
                    $filePaths['high_certificate_file_path'] = $destination;
                    break;
                case 'nyscCertificate':
                    $filePaths['nysc_file_path'] = $destination;
                    break;
                case 'membershipCertificate':
                    $filePaths['pmc_file_path'] = $destination;
                    break;
                case 'lgaFile':
                    $filePaths['lga_file_path'] = $destination;
                    break;
                case 'birthCertificate':
                    $filePaths['birth_certificate_file_path'] = $destination;
                    break;
                case 'passportPhoto':
                    $filePaths['passport_file_path'] = $destination;
                    break;
            }
        }
    }
    
    // Check if file record exists
    $checkStmt = $pdo->prepare("SELECT id FROM user_files WHERE user_id = ?");
    $checkStmt->execute([$user_id]);
    
    if ($checkStmt->rowCount() > 0) {
        // Update existing - only update fields that have files
        $sql = "UPDATE user_files SET ";
        $params = [];
        $updates = [];
        
        foreach ($filePaths as $field => $path) {
            if ($path !== null) {
                $updates[] = "$field = ?";
                $params[] = $path;
            }
        }
        
        if (empty($updates)) {
            throw new Exception("No valid files uploaded");
        }
        
        $sql .= implode(', ', $updates) . " WHERE user_id = ?";
        $params[] = $user_id;
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    } else {
        // Insert new - only include fields that have files
        $fields = [];
        $placeholders = [];
        $params = [];
        
        foreach ($filePaths as $field => $path) {
            if ($path !== null) {
                $fields[] = $field;
                $placeholders[] = '?';
                $params[] = $path;
            }
        }
        
        if (empty($fields)) {
            throw new Exception("No valid files uploaded");
        }
        
        $sql = "INSERT INTO user_files (user_id, " . implode(', ', $fields) . ") ";
        $sql .= "VALUES (?, " . implode(', ', $placeholders) . ")";
        array_unshift($params, $user_id);
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }
    
    $pdo->commit();
    echo json_encode([
        'success' => true,
        'message' => 'Files uploaded successfully',
        'next' => 'summary'
    ]);
} catch (Exception $e) {
    $pdo->rollBack();
    
    // Clean up any uploaded files on error
    foreach ($filePaths as $path) {
        if ($path !== null && file_exists($path)) {
            unlink($path);
        }
    }
    
    http_response_code(500);
    echo json_encode(['error' => 'File upload error: ' . $e->getMessage()]);
}