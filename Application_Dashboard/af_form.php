<?php
session_start();
include_once('../db_connect.php');

error_reporting(E_ERROR | E_PARSE); // Only show critical errors
ini_set('display_errors', 0);

$user_id = $_SESSION['user_id'];

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../Account/session.php");
    exit();
}


// Fetch user firstname and lastname from the database using user ID
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);

// Fetch user record
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // If no user is found, output an error
    die('User not found.');
}
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../Account/session.php");
    exit();
}

// Prepare SQL to check if the user has existing data in user_applications
$req = $pdo->prepare("
    SELECT a.*, u.firstname, u.lastname 
    FROM user_applications as a 
    JOIN users as u ON a.user_id = u.id 
    WHERE u.id = :user_id
");
$req->execute(['user_id' => $user_id]);
$user_detail = $req->fetch(PDO::FETCH_ASSOC);
if (!$user_detail) {
    // If no user details found, it's a new user
    $is_new_user = true;
} else {
    // Existing user, load their data into form fields
    $is_new_user = false;
}

// Initialize variables to track which section to display
$formSection = 1; // Default form section

//save biodata form to db
if (isset($_POST['saveBio'])) {
    // Extract POST data
    $position = $_POST['position'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $birthCertificate = $_POST['birthCertificate'];
    $maritalStatus = $_POST['maritalStatus'];
    $stateOfOrigin = $_POST['stateOfOrigin'];
    $lga = $_POST['lga'];
    $nin = $_POST['nin'];
    $phoneNumber = $_POST['phoneNumber'];
    $emergencyNumber = $_POST['emergencyNumber'];
    $address = $_POST['address'];

    // Validate input
    if (empty($position) || empty($firstname) || empty($lastname) || empty($middlename) || empty($gender)) {
        echo '<script>alert("All fields are required.");</script>';
    } else {
        try {
            // Check if the user already has a record
            $checkRecordQuery = $pdo->prepare("SELECT id FROM user_applications WHERE user_id = :user_id");
            $checkRecordQuery->execute(['user_id' => $user_id]);

            if ($checkRecordQuery->rowCount() === 0) {
                // Insert new record
                $sql = "INSERT INTO user_applications (
                            user_id, position, firstname, lastname, middlename, gender, dateOfBirth, 
                            birthCertificate, maritalStatus, stateOfOrigin, lga, nin, 
                            phoneNumber, emergencyNumber, address
                        ) VALUES (
                            :user_id, :position, :firstname, :lastname, :middlename, :gender, :dateOfBirth, 
                            :birthCertificate, :maritalStatus, :stateOfOrigin, :lga, :nin, 
                            :phoneNumber, :emergencyNumber, :address
                        )";
            } else {
                // Update existing record
                $sql = "UPDATE user_applications SET 
                            position = :position,
                            firstname = :firstname,
                            lastname = :lastname,
                            middlename = :middlename,
                            gender = :gender,
                            dateOfBirth = :dateOfBirth,
                            birthCertificate = :birthCertificate,
                            maritalStatus = :maritalStatus,
                            stateOfOrigin = :stateOfOrigin,
                            lga = :lga,
                            nin = :nin,
                            phoneNumber = :phoneNumber,
                            emergencyNumber = :emergencyNumber,
                            address = :address
                        WHERE user_id = :user_id";
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':position' => $position,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':middlename' => $middlename,
                ':gender' => $gender,
                ':dateOfBirth' => $dateOfBirth,
                ':birthCertificate' => $birthCertificate,
                ':maritalStatus' => $maritalStatus,
                ':stateOfOrigin' => $stateOfOrigin,
                ':lga' => $lga,
                ':nin' => $nin,
                ':phoneNumber' => $phoneNumber,
                ':emergencyNumber' => $emergencyNumber,
                ':address' => $address
            ]);

            header("Location:" . $_SERVER['PHP_SELF'] . "#education-screen");
            exit();
            // Alert type -->  Form data saved sucessfully
            // Include alert box for better user Interface
            // Alert type -->  Form data saved sucessfully
            // Include alert box for better user Interface
            // Alert type -->  Form data saved sucessfully

        } catch (PDOException $e) {
            // Handle errors
             // echo 'Error: ' . $e->getMessage();
             // echo 'Error: ' . $e->getMessage();
             // echo 'Error: ' . $e->getMessage();
        }
    }
}

// Fetch user data for display in the form after saving
$fetchUserData = $pdo->prepare("SELECT * FROM user_applications WHERE user_id = :user_id");
$fetchUserData->execute(['user_id' => $user_id]);
$user_data = $fetchUserData->fetch(PDO::FETCH_ASSOC);



//Submission of Education data to db
if (isset($_POST['saveEdu'])) {
    // Retrieve POST data with null fallback for empty values
    $primary_school_name = !empty($_POST['primary_school_name']) ? $_POST['primary_school_name'] : null;
    $primary_graduation_year = !empty($_POST['primary_graduation_year']) ? $_POST['primary_graduation_year'] : null;
    $secondarySchoolName = !empty($_POST['secondarySchoolName']) ? $_POST['secondarySchoolName'] : null;
    $secondaryGraduationYear = !empty($_POST['secondaryGraduationYear']) ? $_POST['secondaryGraduationYear'] : null;
    $certificateType = !empty($_POST['certificateType']) ? $_POST['certificateType'] : null;
    $classOfDegree = !empty($_POST['classOfDegree']) ? $_POST['classOfDegree'] : null;
    $institution = !empty($_POST['institution']) ? $_POST['institution'] : null;
    $course = !empty($_POST['course']) ? $_POST['course'] : null;
    $highGraduationYear = !empty($_POST['highGraduationYear']) ? $_POST['highGraduationYear'] : null;
    $nyscCertificateNumber = !empty($_POST['nyscCertificateNumber']) ? $_POST['nyscCertificateNumber'] : null;
    $yearOfService = !empty($_POST['yearOfService']) ? $_POST['yearOfService'] : null;

    try {
        // Check if user education history already exists
        $checkUserEducationHistory = $pdo->prepare("SELECT id FROM user_education_details WHERE user_id = :user_id");
        $checkUserEducationHistory->execute(['user_id' => $user_id]);

        if ($checkUserEducationHistory->rowCount() === 0) {
            // Insert new record
            $sql = "INSERT INTO user_education_details (
                        user_id, primary_school_name, primary_graduation_year, 
                        secondarySchoolName, secondaryGraduationYear, 
                        certificateType, classOfDegree, 
                        institution, course,
                        highGraduationYear, nyscCertificateNumber,
                        yearOfService
                    ) VALUES (
                        :user_id, :primary_school_name, :primary_graduation_year, 
                        :secondarySchoolName, :secondaryGraduationYear, 
                        :certificateType, :classOfDegree, 
                        :institution, :course, 
                        :highGraduationYear, :nyscCertificateNumber, 
                        :yearOfService
                    )";
        } else {
            // Update existing record (added missing commas)
            $sql = "UPDATE user_education_details SET
                        primary_school_name = :primary_school_name,
                        primary_graduation_year = :primary_graduation_year,
                        secondarySchoolName = :secondarySchoolName,
                        secondaryGraduationYear = :secondaryGraduationYear,
                        certificateType = :certificateType,
                        classOfDegree = :classOfDegree,
                        institution = :institution,
                        course = :course,
                        highGraduationYear = :highGraduationYear,
                        nyscCertificateNumber = :nyscCertificateNumber,
                        yearOfService = :yearOfService
                    WHERE user_id = :user_id";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':primary_school_name' => $primary_school_name,
            ':primary_graduation_year' => $primary_graduation_year,
            ':secondarySchoolName' => $secondarySchoolName,
            ':secondaryGraduationYear' => $secondaryGraduationYear,
            ':certificateType' => $certificateType,
            ':classOfDegree' => $classOfDegree,
            ':institution' => $institution,
            ':course' => $course,
            ':highGraduationYear' => $highGraduationYear,
            ':nyscCertificateNumber' => $nyscCertificateNumber,
            ':yearOfService' => $yearOfService,
        ]);
        
        header("Location:" . $_SERVER['PHP_SELF'] . "#work-screen");
        exit();

        // Client-side alert for successful form submission
        // echo "<script>alert('Education details saved successfully!');</script>";
    } catch (PDOException $e) {
        // Client-side alert for error during form submission
        // echo "<script>alert('Error saving education details: " . $e->getMessage() . "');</script>";
    }
}
// Fetch user Education Detials for display in the form after saving
$fetchUserEducationData = $pdo->prepare("SELECT * FROM user_education_details WHERE user_id = :user_id");
$fetchUserEducationData->execute(['user_id' => $user_id]);
$user_edu_data = $fetchUserEducationData->fetch(PDO::FETCH_ASSOC);



if (isset($_POST['saveWork'])) {
    // Retrieve POST data with empty string fallback for empty values
    $organizationName = !empty($_POST['organizationName']) ? $_POST['organizationName'] : '';
    $role = !empty($_POST['role']) ? $_POST['role'] : '';
    $responsibilities = !empty($_POST['responsibilities']) ? $_POST['responsibilities'] : '';
    $startDate = !empty($_POST['startDate']) ? $_POST['startDate'] : null;
    $endDate = !empty($_POST['endDate']) ? $_POST['endDate'] : null;

    try {
        // Check if user work history already exists
        $checkUserWorkHistory = $pdo->prepare("SELECT id FROM user_work_details WHERE user_id = :user_id");
        $checkUserWorkHistory->execute(['user_id' => $user_id]);

        if ($checkUserWorkHistory->rowCount() === 0) {
            // Insert new record
            $sql = "INSERT INTO user_work_details (
                        user_id, organizationName, role, 
                        responsibilities, startDate, 
                        endDate
                    ) VALUES (
                        :user_id, :organizationName, :role, 
                        :responsibilities, :startDate, 
                        :endDate
                    )";
        } else {
            // Update existing record
            $sql = "UPDATE user_work_details SET
                        organizationName = :organizationName,
                        role = :role,
                        responsibilities = :responsibilities,
                        startDate = :startDate,
                        endDate = :endDate
                    WHERE user_id = :user_id";
        }

        // Prepare and execute the query
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':organizationName' => $organizationName,
            ':role' => $role,
            ':responsibilities' => $responsibilities,
            ':startDate' => $startDate,
            ':endDate' => $endDate,
        ]);

        header("Location:" . $_SERVER['PHP_SELF'] . "#pmc-screen");
        exit();

        // Client-side alert for successful form submission
        // echo "<script>alert('Education details saved successfully!');</script>";
    } catch (PDOException $e) {
        // Client-side alert for error during form submission
        // echo "<script>alert('Error saving education details: " . $e->getMessage() . "');</script>";
    }
}
// Fetch user Education Detials for display in the form after saving
$fetchUserWorkData = $pdo->prepare("SELECT * FROM user_work_details WHERE user_id = :user_id");
$fetchUserWorkData->execute(['user_id' => $user_id]);
$user_work_data = $fetchUserWorkData->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['savePMC'])) {
    // Retrieve POST data with empty string fallback for empty values
    $bodyName = !empty($_POST['bodyName']) ? $_POST['bodyName'] : '';
    $membershipID = !empty($_POST['membershipID']) ? $_POST['membershipID'] : '';
    $membershipResposibilities = !empty($_POST['membershipResposibilities']) ? $_POST['membershipResposibilities'] : '';
    $certificateDate = !empty($_POST['certificateDate']) ? $_POST['certificateDate'] : null;

    try {
        // Check if user PMC details already exist
        $checkUserPMCDetails = $pdo->prepare("SELECT id FROM user_pmc_details WHERE user_id = :user_id");
        $checkUserPMCDetails->execute(['user_id' => $user_id]);

        if ($checkUserPMCDetails->rowCount() === 0) {
            // Insert new record
            $sql = "INSERT INTO user_pmc_details (
                        user_id, bodyName, membershipID, 
                        membershipResposibilities, certificateDate 
                    ) VALUES (
                        :user_id, :bodyName, :membershipID, 
                        :membershipResposibilities, :certificateDate 
                    )";
        } else {
            // Update existing record
            $sql = "UPDATE user_pmc_details SET
                        bodyName = :bodyName,
                        membershipID = :membershipID,
                        membershipResposibilities = :membershipResposibilities,
                        certificateDate = :certificateDate
                    WHERE user_id = :user_id";
        }

        // Prepare and execute the query
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':bodyName' => $bodyName,
            ':membershipID' => $membershipID,
            ':membershipResposibilities' => $membershipResposibilities,
            ':certificateDate' => $certificateDate,
        ]);
        header("Location:" . $_SERVER['PHP_SELF'] . "#summary-screen");
        exit();

        // Client-side alert for successful form submission
        // echo "<script>alert('Education details saved successfully!');</script>";
    } catch (PDOException $e) {
        // Client-side alert for error during form submission
        // echo "<script>alert('Error saving education details: " . $e->getMessage() . "');</script>";
    }
}
// Fetch user Education Detials for display in the form after saving
$fetchUserPMCData = $pdo->prepare("SELECT * FROM user_pmc_details WHERE user_id = :user_id");
$fetchUserPMCData->execute(['user_id' => $user_id]);
$user_pmc_data = $fetchUserPMCData->fetch(PDO::FETCH_ASSOC);


// Prepare SQL to merge user data
$fetchAllUserData = $pdo->prepare("
    SELECT * 
    FROM users as u
    JOIN user_applications as b ON u.id = b.user_id 
    JOIN (
        SELECT *
        FROM user_education_details
    ) as e ON u.id = e.user_id
    JOIN (
    	SELECT *
        FROM user_work_details
    )as w ON u.id = w.user_id
    WHERE u.id = :user_id

");
$fetchAllUserData->execute(['user_id' => $user_id]);
$allUserData = $fetchAllUserData->fetch(PDO::FETCH_ASSOC); 

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Dashboard | University Of Ilorin</title>
    <link rel="shortcut icon" href="../images/logo-plain.jpeg.jpg" type="image/x-icon">
    <link rel="stylesheet" href="./af_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">
</head>

<body>
    <div class="db-winscroll">
        <div id="db-panel">
            <div class="head-panel">
                <a href="../index.php"><img src="../images/logo-plain.jpeg.jpg" alt="unilorin Logo"></a>
                <svg id="close_panel" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><g fill="none" stroke="var(--main-color-light)" stroke-dasharray="16" stroke-dashoffset="16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7l10 10"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.4s" values="16;0"/></path><path d="M17 7l-10 10"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.4s" dur="0.4s" values="16;0"/></path></g></svg>
            </div>
            <div class="body-panel">
                <ul>
                    <li>
                        <button id="bio-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="var(--main-color-light)`" fill-rule="var(--main-color-light)" d="M12 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8m-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4z" clip-rule="evenodd" />
                            </svg>
                            Bio Data
                        </button>
                    </li>
                    <li>
                        <button id="edu-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                <path fill="var(--main-color-light)" d="M3.33 8L10 12l10-6l-10-6L0 6h10v2zM0 8v8l2-2.22V9.2zm10 12l-5-3l-2-1.2v-6l7 4.2l7-4.2v6z" />
                            </svg>
                            Education
                        </button>
                    </li>
                    <li>
                        <button id="work-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                <path fill="" fill-rule="var()--main-color-light" d="M6 1a1.75 1.75 0 0 0-1.75 1.75V4H3a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.25V2.75A1.75 1.75 0 0 0 10 1zm4.25 3V2.75A.25.25 0 0 0 10 2.5H6a.25.25 0 0 0-.25.25V4zM3 5.5h10a.5.5 0 0 1 .5.5v1h-11V6a.5.5 0 0 1 .5-.5m-.5 3V13a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8.5H9V10H7V8.5z" clip-rule="evenodd" />
                            </svg>
                            Work History
                        </button>
                    </li>
                    <li>
                        <button id="pmc-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                <path fill="var(--main-color-light)" d="M211 7.3C205 1 196-1.4 187.6.8s-14.9 8.9-17.1 17.3l-15.8 62.5l-62-17.5c-8.4-2.4-17.4 0-23.5 6.1s-8.5 15.1-6.1 23.5l17.5 62l-62.5 15.9c-8.4 2.1-15 8.7-17.3 17.1S1 205 7.3 211l46.2 45l-46.2 45c-6.3 6-8.7 15-6.5 23.4s8.9 14.9 17.3 17.1l62.5 15.8l-17.5 62c-2.4 8.4 0 17.4 6.1 23.5s15.1 8.5 23.5 6.1l62-17.5l15.8 62.5c2.1 8.4 8.7 15 17.1 17.3s17.3-.2 23.4-6.4l45-46.2l45 46.2c6.1 6.2 15 8.7 23.4 6.4s14.9-8.9 17.1-17.3l15.8-62.5l62 17.5c8.4 2.4 17.4 0 23.5-6.1s8.5-15.1 6.1-23.5l-17.5-62l62.5-15.8c8.4-2.1 15-8.7 17.3-17.1s-.2-17.4-6.4-23.4l-46.2-45l46.2-45c6.2-6.1 8.7-15 6.4-23.4s-8.9-14.9-17.3-17.1l-62.5-15.8l17.5-62c2.4-8.4 0-17.4-6.1-23.5s-15.1-8.5-23.5-6.1l-62 17.5l-15.9-62.5c-2.1-8.4-8.7-15-17.1-17.3S307 1 301 7.3l-45 46.2z" />
                            </svg>
                            Professional Members
                        </button>
                    </li>
                    <li>
                        <button id="sum-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="var(--main-color-light)">
                                    <path d="m12 2l.117.007a1 1 0 0 1 .876.876L13 3v4l.005.15a2 2 0 0 0 1.838 1.844L15 9h4l.117.007a1 1 0 0 1 .876.876L20 10v9a3 3 0 0 1-2.824 2.995L17 22H7a3 3 0 0 1-2.995-2.824L4 19V5a3 3 0 0 1 2.824-2.995L7 2z" />
                                    <path d="M19 7h-4l-.001-4.001z" />
                                </g>
                            </svg>
                            Summary
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div id="display-screen">
            <div class="nav-bar">
                <div class="left-nav">
                    <svg id="open_panel" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5L12 12L19 5M12 12H12M5 19L12 12L19 19"><animate fill="freeze" attributeName="d" dur="0.4s" values="M5 5L12 12L19 5M12 12H12M5 19L12 12L19 19;M5 5L12 5L19 5M5 12H19M5 19L12 19L19 19"/></path></svg>
                    
                    <h1>APPLICANT</h1>
                </div>
                <div class="right-nav">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <g fill="none" stroke="" stroke-width="1.5">
                            <circle cx="12" cy="9" r="3" opacity="0.5" />
                            <circle cx="12" cy="12" r="10" />
                            <path stroke-linecap="round" d="M17.97 20c-.16-2.892-1.045-5-5.97-5s-5.81 2.108-5.97 5" opacity="0.5" />
                        </g>
                    </svg>
                    <p>
                        <?php echo htmlspecialchars($_SESSION['user_firstname']) . ' ' . htmlspecialchars($_SESSION['user_lastname']); ?>
                    </p>
                </div>

            </div>
            <?php include_once('biodata.php') ?>

            <?php include_once('education.php') ?>

            <?php include_once('work.php') ?>

            <?php include_once('pmc.php') ?>

            <?php include_once('summary.php') ?>

            <div id="footer">
                <div class="left-footer">
                    <p>Copyright &copy; 2024 University Of Ilorin. All Rights Reserved</p>
                </div>
                <div class="right-footer">
                    <a href="./logout.php">
                        <button>
                            Log out
                        </button>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <script src="./af_function.js"></script>
    <script>
        // JavaScript to display the correct section based on the URL hash
        window.onload = function () {
            // Hide all sections by default
            document.getElementById('biodata-screen').style.display = 'none';
            document.getElementById('education-screen').style.display = 'none';
            document.getElementById('work-screen').style.display = 'none';
            document.getElementById('pmc-screen').style.display = 'none';
            document.getElementById('summary-screen').style.display = 'none';

            // Check which section to display based on the URL hash
            if (window.location.hash === "#education-screen") {
                document.getElementById('education-screen').style.display = 'block';
            } else if (window.location.hash === "#work-screen") {
                document.getElementById('work-screen').style.display = 'block';
            } else if (window.location.hash === "#pmc-screen") {
                document.getElementById('pmc-screen').style.display = 'block';
            } else if (window.location.hash === "#summary-screen") {
                document.getElementById('summary-screen').style.display = 'block';
            } else {
                // Default to biodata screen if no hash or an unrecognized hash is found
                document.getElementById('biodata-screen').style.display = 'block';
            }
        };

          //db-pannel control
        const openPanel = document.getElementById('open_panel');
        const closePanel = document.getElementById('close_panel');
        const dbPanel = document.getElementById('db-panel');

        
        openPanel.addEventListener('click', (e)=>{
            dbPanel.style.display = 'block'
            closePanel.style.display = 'block'
        });
        closePanel.addEventListener('click', (e)=>{
            dbPanel.style.display = 'none'
            closePanel.style.display = 'none'

        });
    </script>


</body>


</html>