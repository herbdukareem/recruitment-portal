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

// Validate session and user_id
if (!isset($_SESSION['user']['user_id']) || !is_numeric($_SESSION['user']['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No valid applicant session']);
    exit;
}

$user_id = (int) $_SESSION['user']['user_id'];
if ($user_id <= 0) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$files = $_FILES ?? [];

try {
    $pdo->beginTransaction();
    
    // Check for existing PMC record
    $checkStmt = $pdo->prepare("SELECT id FROM user_pmc_details WHERE user_id = ?");
    $checkStmt->execute([$user_id]);

    $isUpdate = $checkStmt->rowCount() > 0;

    if ($isUpdate) {
        $sql = "UPDATE user_pmc_details SET
                    bodyName = ?, membershipID = ?, membershipType = ?,
                    membershipResposibilities = ?, certificateDate = ?
                WHERE user_id = ?";
        $params = [
            $input['bodyName'] ?? '',
            $input['membershipID'] ?? '',
            $input['membershipType'] ?? '',
            $input['membershipResposibilities'] ?? '',
            !empty($input['certificateDate']) ? $input['certificateDate'] : null,
            $user_id
        ];
    } else {
        $sql = "INSERT INTO user_pmc_details (
                    user_id, bodyName, membershipID,
                    membershipType, membershipResposibilities, certificateDate
                ) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $user_id,
            $input['bodyName'] ?? '',
            $input['membershipID'] ?? '',
            $input['membershipType'] ?? '',
            $input['membershipResposibilities'] ?? '',
            !empty($input['certificateDate']) ? $input['certificateDate'] : null
        ];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Process file uploads
    $filePaths = ['pmc_file_path' => null];
    $fileFields = ['membershipCertificate' => 'pmc_file_path'];

    foreach ($fileFields as $field => $dbField) {
        if (!empty($files[$field]['tmp_name'])) {
            $file = $files[$field];
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($fileExt, ALLOWED_FILE_TYPES)) {
                throw new Exception("Invalid file type for $field. Allowed types: " . implode(', ', ALLOWED_FILE_TYPES));
            }

            if ($file['size'] > MAX_FILE_SIZE) {
                throw new Exception("File exceeds max size (" . (MAX_FILE_SIZE / 1024 / 1024) . "MB)");
            }

            $newFilename = "user_{$user_id}_{$field}." . $fileExt;
            $destination = UPLOAD_DIR . $newFilename;

            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                throw new Exception("Failed to save uploaded file.");
            }

            $filePaths[$dbField] = "/uploads/" . $newFilename;

            // Delete old file if exists
            $stmt = $pdo->prepare("SELECT $dbField FROM user_files WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $oldFile = $stmt->fetchColumn();

            if ($oldFile && file_exists($_SERVER['DOCUMENT_ROOT'] . $oldFile)) {
                @unlink($_SERVER['DOCUMENT_ROOT'] . $oldFile);
            }
        }
    }

    // Handle file record in DB
    $checkFiles = $pdo->prepare("SELECT 1 FROM user_files WHERE user_id = ?");
    $checkFiles->execute([$user_id]);
    $filesExist = $checkFiles->fetchColumn();

    if ($filesExist) {
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
            $sql = "INSERT INTO user_files (user_id, " . implode(', ', $fields) . ") VALUES (?, " . implode(', ', $values) . ")";
            $pdo->prepare($sql)->execute($params);
        }
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'PMC details and file uploaded successfully',
        'next' => 'summary'
    ]);

} catch (Exception $e) {
    $pdo->rollBack();

    // Clean up uploaded files
    foreach ($filePaths as $path) {
        if ($path !== null && file_exists($_SERVER['DOCUMENT_ROOT'] . $path)) {
            @unlink($_SERVER['DOCUMENT_ROOT'] . $path);
        }
    }

    http_response_code(500);
    echo json_encode([
        'error' => 'An error occurred',
        'message' => $e->getMessage()
    ]);
}
