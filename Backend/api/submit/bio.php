<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';
require_once __DIR__ . '/../../helpers/rate_limit.php';
limitRequests('bio', 5, 60); // 5 attempts per minute

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
    $stmt= $pdo->prepare("DELETE FROM users WHERE email = :email");
    $stmt->execute([':email' => $input['email']]);
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
        'middlename' => trim($input['middlename']),
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

    // Process file uploads
    $filePaths = [
        'lga_file_path' => null,
        'birth_certificate_file_path' => null,
        'passport_file_path' => null
    ];

    $fileFields = [
        'lgaFile' => 'lga_file_path',
        'birthCertificate' => 'birth_certificate_file_path',
        'passportPhoto' => 'passport_file_path'
    ];

    foreach ($fileFields as $field => $dbField) {
        if (!empty($files[$field]['tmp_name'])) {
            $file = $files[$field];

            // Validate file
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $fileSize = $file['size'];

            if (!in_array($fileExt, ALLOWED_FILE_TYPES)) {
                throw new Exception("Invalid file type for $field. Allowed types: " . implode(', ', ALLOWED_FILE_TYPES));
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

            $filePaths[$dbField] = $destination;
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
        if ($path !== null && file_exists($path)) {
            @unlink($path);
        }
    }

    http_response_code(500);
    echo json_encode([
        'error' => 'Error processing request',
        'details' => $e->getMessage()
    ]);
}