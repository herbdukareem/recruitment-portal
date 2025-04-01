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
    
    // Check if education exists
    $stmt = $pdo->prepare("SELECT user_id FROM user_education_details WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if ($stmt->rowCount() > 0) {
        // Update existing
        $sql = "UPDATE user_education_details SET
                    primary_school_name = ?,
                    primary_graduation_year = ?,
                    secondarySchoolName = ?,
                    secondaryGraduationYear = ?,
                    certificateType = ?,
                    classOfDegree = ?,
                    institution = ?,
                    course = ?,
                    highGraduationYear = ?,
                    nyscCertificateNumber = ?,
                    yearOfService = ?
                WHERE user_id = ?";
    } else {
        // Insert new
        $sql = "INSERT INTO user_education_details (
                    user_id, primary_school_name, primary_graduation_year,
                    secondarySchoolName, secondaryGraduationYear,
                    certificateType, classOfDegree, institution, course,
                    highGraduationYear, nyscCertificateNumber, yearOfService
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $user_id,
        $input['primary_school_name'] ?? null,
        $input['primary_graduation_year'] ?? null,
        $input['secondarySchoolName'] ?? null,
        $input['secondaryGraduationYear'] ?? null,
        $input['certificateType'] ?? null,
        $input['classOfDegree'] ?? null,
        $input['institution'] ?? null,
        $input['course'] ?? null,
        $input['highGraduationYear'] ?? null,
        $input['nyscCertificateNumber'] ?? null,
        $input['yearOfService'] ?? null
    ]);
    
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Education saved', 'next' => 'work']);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}