<?php
// Check if config file exists and constants are defined
if (!file_exists(__DIR__ . '/../../config/config.php')) {
    http_response_code(500);
    die(json_encode(['error' => 'Configuration file missing']));
}

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';
require_once __DIR__ . '/../../helpers/rate_limit.php';
limitRequests('bio', 5, 60); 
// Add this check right after including config.php
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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get input data
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$files = $_FILES ?? [];

// Check if admin role
if (empty($input['admin_role'])) {
    // Validate session for admin role
    if (!isset($_SESSION['user']['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'No applicant session']);
        exit;
    }
    $user_id = $_SESSION['user']['user_id'];
} else {
    try {
        // Validate required user fields
        $userFields = ['firstname', 'lastname', 'email', 'nin', 'password'];
        foreach ($userFields as $field) {
            if (empty($input[$field])) {
                http_response_code(400);
                echo json_encode(['error' => "Field $field is required"]);
                exit;
            }
        }

        $firstname = trim($input['firstname']);
        $lastname = trim($input['lastname']);
        $email = trim($input['email']);
        $nin = trim($input['nin']);
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid email format']);
            exit;
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Email already registered']);
            exit;
        }

        $hashedPassword = password_hash($input['password'], PASSWORD_DEFAULT);

        // Insert new user
        $userSql = $pdo->prepare(
            "INSERT INTO users (firstname, lastname, email, nin, password) 
            VALUES (?, ?, ?, ?, ?)"
        );
        $userSql->execute([$firstname, $lastname, $email, $nin,  $hashedPassword]);

        // Get the new user ID
        $user_id = $pdo->lastInsertId();

        if (!$user_id) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create user']);
            exit;
        }

        $_SESSION['user']['user_id'] = $user_id;

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}

// Validate required application fields
$requiredFields = [
    'positionType', 'supPosition', 'position', 
    'firstname', 'lastname', 'middlename', 'gender',
    'dateOfBirth', 'maritalStatus', 'stateOfOrigin',
    'lga', 'nin', 'phoneNumber', 'emergencyNumber', 'address'
];

$missingFields = [];
foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Missing required fields',
        'missing_fields' => $missingFields
    ]);
    exit;
}

// Validate NIN format (assuming 11 digits)
if (!preg_match('/^\d{11}$/', $input['nin'])) {
    // Only try to delete if we created a new user in this request
    if (!empty($input['admin_role'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([':id' => $user_id]);
        } catch (PDOException $e) {
            error_log("Failed to delete user after NIN validation: " . $e->getMessage());
        }
    }
    http_response_code(400);
    echo json_encode(['error' => 'NIN must be 11 digits']);
    exit;
}

// Check if NIN already exists for another user
$ninCheck = $pdo->prepare("SELECT user_id FROM user_applications WHERE nin = ? AND user_id != ?");
$ninCheck->execute([$input['nin'], $user_id]);
if ($ninCheck->rowCount() > 0) {
    http_response_code(400);
    echo json_encode(['error' => 'This NIN is already registered by another applicant']);
    exit;
}

// Process file uploads
    $filePaths = [
        'lga_file_path' => null,
        'birth_certificate_file_path' => null,
        'passport_file_path' => null
    ];

try {
    // Start transaction
    $pdo->beginTransaction();
    
    // Prepare application data
    $appData = [
        'user_id' => $user_id,
        'positionType' => $input['positionType'],
        'supPosition' => $input['supPosition'],
        'position' => $input['position'],
        'firstname' => trim($input['firstname']),
        'lastname' => trim($input['lastname']),
        'middlename' => trim($input['middlename'] ?? ''),
        'gender' => $input['gender'],
        'dateOfBirth' => $input['dateOfBirth'],
        'maritalStatus' => $input['maritalStatus'],
        'stateOfOrigin' => $input['stateOfOrigin'],
        'lga' => $input['lga'],
        'nin' => $input['nin'],
        'phoneNumber' => $input['phoneNumber'],
        'emergencyNumber' => $input['emergencyNumber'],
        'address' => $input['address']
    ];
    
    $updateUser = null;
    // Check if application exists
    $checkApp = $pdo->prepare("SELECT user_id FROM user_applications WHERE user_id = ?");
    $checkApp->execute([$user_id]);
    
    if ($checkApp->rowCount() > 0) {
        // Update existing application
        $sql = "UPDATE user_applications SET 
                    positionType = :positionType,
                    supPosition = :supPosition,
                    position = :position,
                    firstname = :firstname,
                    lastname = :lastname,
                    middlename = :middlename,
                    gender = :gender,
                    dateOfBirth = :dateOfBirth,
                    maritalStatus = :maritalStatus,
                    stateOfOrigin = :stateOfOrigin,
                    lga = :lga,
                    nin = :nin,
                    phoneNumber = :phoneNumber,
                    emergencyNumber = :emergencyNumber,
                    address = :address
                WHERE user_id = :user_id";
        $updateUser = true;

    } else {
        // Insert new application
        $sql = "INSERT INTO user_applications (
                user_id, positionType, supPosition, position, firstname, lastname, middlename, 
                gender, dateOfBirth, maritalStatus, stateOfOrigin, lga, nin, 
                phoneNumber, emergencyNumber, address
                ) VALUES (
                :user_id, :positionType, :supPosition, :position, :firstname, :lastname, :middlename, 
                :gender, :dateOfBirth, :maritalStatus, :stateOfOrigin, :lga, :nin, 
                :phoneNumber, :emergencyNumber, :address)";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($appData);

    $updateData = [
        'user_id' => $user_id,
        'firstname' => trim($input['firstname']),
        'lastname' => trim($input['lastname']),
    ];

    if($updateUser){
        $checkUser = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $checkUser->execute([$user_id]);

        if($checkUser){
            $updateUserStmt = $pdo->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname WHERE id = :user_id");
            $updateUserStmt->execute($updateData);
        }
    };
    
    // Add this before file uploads
    if (!is_writable(UPLOAD_DIR)) {
        http_response_code(500);
        die(json_encode([
            'error' => 'System Error',
            'message' => 'Upload directory is not writable',
            'directory' => UPLOAD_DIR,
            'permissions' => substr(sprintf('%o', fileperms(UPLOAD_DIR)), -4)
        ]));
    }
    
    $fileFields = [
        'lgaCertificate' => 'lga_file_path',
        'birthCertificate' => 'birth_certificate_file_path',
        'passport' => 'passport_file_path'
    ];
    
    foreach ($fileFields as $field => $dbField) {
        if (!empty($files[$field]['tmp_name'])) {
            $file = $files[$field];
            
            // Validate file extension
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExt, ALLOWED_FILE_TYPES)) {
                throw new Exception(
                    "Invalid file type for $field. Allowed types: " . 
                    implode(', ', ALLOWED_FILE_TYPES)
                );
            }
            
            // Validate file size
            if ($file['size'] > MAX_FILE_SIZE) {
                throw new Exception(
                    "File too large for $field (max " . 
                    (MAX_FILE_SIZE / 1024 / 1024) . "MB)"
                );
            }
            
            // Generate unique filename
            $newFilename = "user_{$user_id}_{$field}.{$fileExt}";
            $destination = UPLOAD_DIR . $newFilename;
            
            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                $error = error_get_last();
                throw new Exception(
                    "Failed to move uploaded file: " . 
                    ($error['message'] ?? 'Unknown error')
                );
            }
            
            $filePaths[$dbField] = '/uploads/' . $newFilename;
        }
    }
    
    // Handle file record in database
    $checkFiles = $pdo->prepare("SELECT id FROM user_files WHERE user_id = ?");
    $checkFiles->execute([$user_id]);
    
    if ($checkFiles->rowCount() > 0) {
        // Update existing files
        $updateSql = "UPDATE user_files SET ";
        $updateParams = [];
        $updates = [];
        
        foreach ($filePaths as $field => $path) {
            if ($path !== null) {
                $updates[] = "$field = ?";
                $updateParams[] = $path;
            }
        }
        
        if (!empty($updates)) {
            $updateSql .= implode(', ', $updates) . " WHERE user_id = ?";
            $updateParams[] = $user_id;
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute($updateParams);
        }
    } else {
        // Insert new files
        $insertFields = [];
        $insertValues = [];
        $insertParams = [$user_id];
        
        foreach ($filePaths as $field => $path) {
            if ($path !== null) {
                $insertFields[] = $field;
                $insertValues[] = '?';
                $insertParams[] = $path;
            }
        }
        
        if (!empty($insertFields)) {
            $insertSql = "INSERT INTO user_files (user_id, " . implode(', ', $insertFields) . 
                         ") VALUES (?" . str_repeat(', ?', count($insertFields)) . ")";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->execute($insertParams);
        }
    }
    
    // Commit transaction
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Biodata and files saved successfully',
        'next' => 'education',
        'user_id' => $user_id
    ]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    
    // Clean up uploaded files on error
    foreach ($filePaths as $path) {
        if ($path !== null) {
            $fullPath = __DIR__ . '/../../' . ltrim($path, '/');
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
    }

    
    http_response_code(500);
    echo json_encode([
        'error' => 'Error processing request',
        'details' => $e->getMessage()
    ]);
}