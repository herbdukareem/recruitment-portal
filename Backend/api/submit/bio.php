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

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$requiredFields = [
    'positionType', 'supPosition', 'position', 
    'firstname', 'lastname', 'middlename', 'gender',
    'dateOfBirth', 'maritalStatus', 'stateOfOrigin',
    'lga', 'nin', 'phoneNumber', 'emergencyNumber', 'address'
];

foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Field $field is required"]);
        exit;
    }
}

try {
    $pdo->beginTransaction();
    
    // Check if application exists
    $stmt = $pdo->prepare("SELECT user_id FROM user_applications WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    if ($stmt->rowCount() > 0) {
        // Update existing
        $sql = "UPDATE user_applications SET 
                    positionType = ?,
                    supPosition = ?,
                    position = ?,
                    firstname = ?,
                    lastname = ?,
                    middlename = ?,
                    gender = ?,
                    dateOfBirth = ?,
                    maritalStatus = ?,
                    stateOfOrigin = ?,
                    lga = ?,
                    nin = ?,
                    phoneNumber = ?,
                    emergencyNumber = ?,
                    address = ?
                WHERE user_id = ?";
    } else {
        // Insert new
        $sql = "INSERT INTO user_applications (
                    user_id, positionType, supPosition, position,
                    firstname, lastname, middlename, gender,
                    dateOfBirth, maritalStatus, stateOfOrigin,
                    lga, nin, phoneNumber, emergencyNumber, address
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $user_id,
        $input['positionType'],
        $input['supPosition'],
        $input['position'],
        $input['firstname'],
        $input['lastname'],
        $input['middlename'],
        $input['gender'],
        $input['dateOfBirth'],
        $input['maritalStatus'],
        $input['stateOfOrigin'],
        $input['lga'],
        $input['nin'],
        $input['phoneNumber'],
        $input['emergencyNumber'],
        $input['address']
    ]);
    
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Biodata saved', 'next' => 'education']);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}