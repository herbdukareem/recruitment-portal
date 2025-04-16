<?php
if (!file_exists(__DIR__ . '/../../config/config.php')) {
    http_response_code(500);
    die(json_encode(['error' => 'Configuration file missing']));
}

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';
require_once __DIR__ . '/../../helpers/rate_limit.php';
limitRequests('bio', 5, 60); 

$requiredConstants = ['ALLOWED_FILE_TYPES', 'MAX_FILE_SIZE', 'UPLOAD_DIR'];
foreach ($requiredConstants as $constant) {
    if (!defined($constant)) {
        http_response_code(500);
        die(json_encode(['error' => 'System configuration error', 'message' => "Constant $constant is not defined"]));
    }
}

if (!file_exists(UPLOAD_DIR)) {
    if (!mkdir(UPLOAD_DIR, 0755, true)) {
        http_response_code(500);
        die(json_encode(['error' => 'System Error', 'message' => 'Failed to create upload directory', 'directory' => UPLOAD_DIR]));
    }
}

if (!is_writable(UPLOAD_DIR)) {
    http_response_code(500);
    die(json_encode(['error' => 'System Error', 'message' => 'Upload directory is not writable', 'directory' => UPLOAD_DIR]));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_SESSION['user']['user_id']) || !is_numeric($_SESSION['user']['user_id']) || (int)$_SESSION['user']['user_id'] <= 0) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid or missing applicant session']);
    exit;
}

$user_id = (int) $_SESSION['user']['user_id'];
error_log("Processing education for user_id: $user_id");

$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$files = $_FILES ?? [];
$filePaths = [];

try {
    $pdo->beginTransaction();

    // EDUCATION: Check if record exists
    $stmt = $pdo->prepare("SELECT user_id FROM user_education_details WHERE user_id = ?");
    $stmt->execute([$user_id]);

    if ($stmt->rowCount() > 0) {
        // Update existing education
        $sql = "UPDATE user_education_details SET
                    primary_school_name = ?, primary_graduation_year = ?, 
                    secondarySchoolName = ?, secondaryGraduationYear = ?, 
                    certificateType = ?, classOfDegree = ?, institution = ?, 
                    course = ?, highGraduationYear = ?, 
                    nyscCertificateNumber = ?, yearOfService = ?
                WHERE user_id = ?";
        $params = [
            $input['primary_school_name'],
            $input['primary_graduation_year'],
            $input['secondarySchoolName'],
            $input['secondaryGraduationYear'],
            $input['certificateType'],
            $input['classOfDegree'],
            $input['institution'],
            $input['course'],
            $input['highGraduationYear'],
            strval($input['nyscCertificateNumber']),
            $input['yearOfService'],
            $user_id
        ];
    } else {
        // Insert new education
        $sql = "INSERT INTO user_education_details (
                    user_id, primary_school_name, primary_graduation_year, 
                    secondarySchoolName, secondaryGraduationYear, 
                    certificateType, classOfDegree, institution, course, 
                    highGraduationYear, nyscCertificateNumber, yearOfService
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $user_id,
            $input['primary_school_name'],
            $input['primary_graduation_year'],
            $input['secondarySchoolName'],
            $input['secondaryGraduationYear'],
            $input['certificateType'],
            $input['classOfDegree'],
            $input['institution'],
            $input['course'],
            $input['highGraduationYear'],
            strval($input['nyscCertificateNumber']),
            $input['yearOfService']
        ];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // FILES: Process file uploads
    $filePaths = [
        'sec_file_path' => null,
        'high_certificate_file_path' => null,
        'nysc_file_path' => null
    ];

    $fileFields = [
        'secondaryCertificate' => 'sec_file_path',
        'highCertificate' => 'high_certificate_file_path',
        'nyscCertificate' => 'nysc_file_path'
    ];

    foreach ($fileFields as $field => $dbField) {
        if (!empty($files[$field]['tmp_name'])) {
            $file = $files[$field];
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($fileExt, ALLOWED_FILE_TYPES)) {
                throw new Exception("Invalid file type for $field. Allowed: " . implode(', ', ALLOWED_FILE_TYPES));
            }

            if ($file['size'] > MAX_FILE_SIZE) {
                throw new Exception("File too large for $field (max " . (MAX_FILE_SIZE / 1024 / 1024) . "MB)");
            }

            $newFilename = "user_{$user_id}_{$field}." . $fileExt;
            $destination = UPLOAD_DIR . $newFilename;

            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                throw new Exception("Failed to move uploaded file: " . error_get_last()['message']);
            }

            $filePaths[$dbField] = "/uploads/" . $newFilename;
        }
    }

    // FILES DB
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
        'message' => 'Education and files saved successfully',
        'next' => 'work'
    ]);

} catch (Exception $e) {
    $pdo->rollBack();

    // Clean up any uploaded files
    foreach ($filePaths as $path) {
        if ($path !== null) {
            $fullPath = $_SERVER['DOCUMENT_ROOT'] . $path;
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
    }

    http_response_code(500);
    echo json_encode([
        'error' => 'Error processing request',
        'message' => $e->getMessage()
    ]);
}
