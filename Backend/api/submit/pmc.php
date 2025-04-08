<?php
// Configuration check
if (!file_exists(__DIR__ . '/../../config/config.php')) {
    http_response_code(500);
    die(json_encode(['error' => 'Configuration file missing']));
}

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';
require_once __DIR__ . '/../../helpers/rate_limit.php';
limitRequests('bio', 5, 60); 

// Validate required constants
$requiredConstants = ['ALLOWED_FILE_TYPES', 'MAX_FILE_SIZE', 'UPLOAD_DIR'];
foreach ($requiredConstants as $constant) {
    if (!defined($constant)) {
        http_response_code(500);
        die(json_encode([
            'error' => 'System configuration error',
            'message' => "Constant $constant is not defined"
        ]));
    }
}

// Ensure upload directory exists and is writable
if (!file_exists(UPLOAD_DIR)) {
    if (!mkdir(UPLOAD_DIR, 0755, true)) {
        http_response_code(500);
        die(json_encode([
            'error' => 'System Error',
            'message' => 'Failed to create upload directory',
            'directory' => UPLOAD_DIR
        ]));
    }
}

if (!is_writable(UPLOAD_DIR)) {
    http_response_code(500);
    die(json_encode([
        'error' => 'System Error',
        'message' => 'Upload directory is not writable',
        'directory' => UPLOAD_DIR
    ]));
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Validate session
if (!isset($_SESSION['user']['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No applicant session']);
    exit;
}

$user_id = $_SESSION['user']['user_id'];
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$files = $_FILES ?? [];

try {
    $pdo->beginTransaction();
    
    // Handle PMC details
    $checkStmt = $pdo->prepare("SELECT id FROM user_pmc_details WHERE user_id = ?");
    $checkStmt->execute([$user_id]);
    
    if ($checkStmt->rowCount() > 0) {
        // Update existing PMC details
        $sql = "UPDATE user_pmc_details SET
                    bodyName = ?,
                    membershipID = ?,
                    membershipType = ?,
                    membershipResposibilities = ?,
                    certificateDate = ?
                WHERE user_id = ?";
    } else {
        // Insert new PMC details
        $sql = "INSERT INTO user_pmc_details (
                    user_id, bodyName, membershipID,
                    membershipType, membershipResposibilities,
                    certificateDate
                ) VALUES (?, ?, ?, ?, ?, ?)";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $input['bodyName'] ?? '',
        $input['membershipID'] ?? '',
        $input['membershipType'] ?? '',
        $input['membershipResposibilities'] ?? '',
        !empty($input['certificateDate']) ? $input['certificateDate'] : null,
        $user_id
    ]);

    // Process file uploads
    $filePaths = [
        'pmc_file_path' => null,
    ];

    $fileFields = [
        'membershipCertificate' => 'pmc_file_path',
    ];

    foreach ($fileFields as $field => $dbField) {
        if (!empty($files[$field]['tmp_name'])) {
            $file = $files[$field];

            // Validate file extension
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExt, ALLOWED_FILE_TYPES)) {
                throw new Exception("Invalid file type. Allowed: " . implode(', ', ALLOWED_FILE_TYPES));
            }

            // Validate file size
            if ($file['size'] > MAX_FILE_SIZE) {
                throw new Exception("File exceeds maximum size of " . (MAX_FILE_SIZE / 1024 / 1024) . "MB");
            }

            // Generate secure filename
            $newFilename = "user_{$user_id}_" . "_{$field}" . ".{$fileExt}";
            $destination = UPLOAD_DIR . $newFilename;

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                throw new Exception("Failed to move uploaded file: " . error_get_last()['message']);
            }

            $filePaths[$dbField] = "/uploads/" . $newFilename;
            
            // Delete old file if exists
            $stmt = $pdo->prepare("SELECT $dbField FROM user_files WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $oldFile = $stmt->fetchColumn();
            
            if ($oldFile && file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }
    }

    // Handle file records in database
    $checkFiles = $pdo->prepare("SELECT 1 FROM user_files WHERE user_id = ?");
    $checkFiles->execute([$user_id]);
    $filesExist = $checkFiles->fetchColumn();

    if ($filesExist) {
        // Update existing files
        $updates = [];
        $params = [];
        
        foreach ($filePaths as $field => $path) {
            if ($path !== null) {
                $updates[] = "$field = ?";
                $params[] = $path;
            }
        }
        
        if (!empty($updates)) {
            $params[] = $user_id;
            $sql = "UPDATE user_files SET " . implode(', ', $updates) . " WHERE user_id = ?";
            $pdo->prepare($sql)->execute($params);
        }
    } else {
        // Insert new files
        $fields = [];
        $values = [];
        $params = [$user_id];
        
        foreach ($filePaths as $field => $path) {
            if ($path !== null) {
                $fields[] = $field;
                $values[] = '?';
                $params[] = $path;
            }
        }
        
        if (!empty($fields)) {
            $sql = "INSERT INTO user_files (user_id, " . implode(', ', $fields) . 
                   ") VALUES (?, " . implode(', ', $values) . ")";
            $pdo->prepare($sql)->execute($params);
        }
    }

    $pdo->commit();
    
    echo json_encode([
        'success' => true, 
        'message' => 'PMC details and files saved successfully', 
        'next' => 'summary'
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    
    // Clean up any uploaded files on error
    foreach ($filePaths as $path) {
        if ($path !== null && file_exists($path)) {
            @unlink($path);
        }
    }
    
    http_response_code(500);
    echo json_encode([
        'error' => 'Error processing request',
        'message' => $e->getMessage()
    ]);
}