<?php
session_start();
include_once('../db_connect.php');


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../Account/session.php");
    exit();
}

// If logged in, display the page content


// Ensure the session contains the user ID
if (!isset($_SESSION['logged_in_user']['id'])) {
    die('User not logged in.');
}

$user_id = $_SESSION['logged_in_user']['id'];
$firstname = $_SESSION['logged_in_user']['firstame'];
$lastname = $_SESSION['logged_in_user']['lastname'];
$email = $_SESSION['logged_in_user']['email'];

//save biodata form to db
if (isset($_POST['save'])) {
    // Extract POST data
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $maritalStatus = $_POST['maritalStatus'];
    $stateOfOrigin = $_POST['stateOfOrigin'];
    $localGovernmentArea = $_POST['localGovernmentArea'];
    $nin = $_POST['nin'];
    $phoneNumber = $_POST['phoneNumber'];
    $emergencyNumber = $_POST['emergencyNumber'];
    $address = $_POST['address'];

    // Validate input
    if (empty($firstname) || empty($lastname) || empty($middlename) || empty($gender)) {
        echo "All fields are required.";
    } else {
        $checkRecordQuery = $pdo->prepare("SELECT id FROM user_applications WHERE user_id = :user_id");
        $checkRecordQuery->execute(['user_id' => $user_id]);

        if ($checkRecordQuery->rowCount() === 0) {
            // Insert new record
            $sql = "INSERT INTO user_applications (user_id, firstname, lastname, middlename, gender, dateOfBirth, maritalStatus, stateOfOrigin, localGovernmentArea, nin, phoneNumber, emergencyNumber, address) 
                    VALUES (:user_id, :firstname, :lastname, :middlename, :gender, :dateOfBirth, :maritalStatus, :stateOfOrigin, :localGovernmentArea, :nin, :phoneNumber, :emergencyNumber, :address)";
        } else {
            // Update existing record
            $sql = "UPDATE user_applications SET 
                        firstname = :firstname,
                        lastname = :lastname,
                        middlename = :middlename,
                        gender = :gender,
                        dateOfBirth = :dateOfBirth,
                        maritalStatus = :maritalStatus,
                        stateOfOrigin = :stateOfOrigin,
                        localGovernmentArea = :localGovernmentArea,
                        nin = :nin,
                        phoneNumber = :phoneNumber,
                        emergencyNumber = :emergencyNumber,
                        address = :address
                    WHERE user_id = :user_id";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':middlename' => $middlename,
            ':gender' => $gender,
            ':dateOfBirth' => $dateOfBirth,
            ':maritalStatus' => $maritalStatus,
            ':stateOfOrigin' => $stateOfOrigin,
            ':localGovernmentArea' => $localGovernmentArea,
            ':nin' => $nin,
            ':phoneNumber' => $phoneNumber,
            ':emergencyNumber' => $emergencyNumber,
            ':address' => $address
        ]);

        try {
            echo "Registration successful!";
            // Redirect to the form page
            header("Location: af_form.php");
            exit();
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "Email or NIN already registered.";
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}

// Fetch the user record
$recordStmt = $pdo->prepare("SELECT * 
    FROM user_applications AS a 
    JOIN users AS u ON a.user_id = u.id
    WHERE a.user_id = :user_id");

$recordStmt->execute(['user_id' => $user_id]);
$record = $recordStmt->fetch(PDO::FETCH_ASSOC);





// Fetch existing primary school records to display in the table 
$user_id = $_SESSION['logged_in_user']['id'];
$records = [];

try {
    $fetchSQL = "SELECT id, school_name, graduation_year FROM primary_educations WHERE user_id = :user_id";
    $stmt = $pdo->prepare($fetchSQL);
    $stmt->execute(['user_id' => $user_id]);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching records: " . $e->getMessage();
}

// Handle form submission to db
if (isset($_POST['save'])) {
    $school_name = $_POST['school_name'];
    $graduation_year = $_POST['graduation_year'];

    // Validate input
    if (empty($school_name) || empty($graduation_year)) {
        echo "School Name and Graduation Year are required.";
    } else {
        // Insert into the database
        try {
            $insertSQL = "INSERT INTO primary_educations (user_id, school_name, graduation_year) 
                          VALUES (:user_id, :school_name, :graduation_year)";
            $stmt = $pdo->prepare($insertSQL);
            $stmt->execute([
                ':user_id' => $user_id,
                ':school_name' => $school_name,
                ':graduation_year' => $graduation_year
            ]);

            // Refresh the page to show updated data
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Handle delete request
if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];

    try {
        $deleteSQL = "DELETE FROM primary_educations WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($deleteSQL);
        $stmt->execute([':id' => $delete_id, ':user_id' => $user_id]);

        // Refresh the page to show updated data
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment | NNPC Limited</title>
    <link rel="shortcut icon" href="../Account/NNPC-Logo-500x281.png" type="image/x-icon">
    <link rel="shortcut icon" href="../nnpc.svg" type="image/x-icon">
    <link rel="stylesheet" href="./af_style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">
</head>

<body>
    <div class="db-winscroll">
        <div id="db-panel">
            <div class="head-panel">
                <a href="../index.html"><img src="../images/nnpc.svg" alt="NNPC Logo"></a>
            </div>
            <div class="body-panel">
                <ul>
                    <li>
                        <button id="bio-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="#ededed" fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8m-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4z" clip-rule="evenodd" />
                            </svg>
                            Bio Data
                        </button>
                    </li>
                    <li>
                        <button id="edu-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                <path fill="#ededed" d="M3.33 8L10 12l10-6l-10-6L0 6h10v2zM0 8v8l2-2.22V9.2zm10 12l-5-3l-2-1.2v-6l7 4.2l7-4.2v6z" />
                            </svg>
                            Education
                        </button>
                    </li>
                    <li>
                        <button id="work-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                <path fill="#ededed" fill-rule="evenodd" d="M6 1a1.75 1.75 0 0 0-1.75 1.75V4H3a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.25V2.75A1.75 1.75 0 0 0 10 1zm4.25 3V2.75A.25.25 0 0 0 10 2.5H6a.25.25 0 0 0-.25.25V4zM3 5.5h10a.5.5 0 0 1 .5.5v1h-11V6a.5.5 0 0 1 .5-.5m-.5 3V13a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8.5H9V10H7V8.5z" clip-rule="evenodd" />
                            </svg>
                            Work History
                        </button>
                    </li>
                    <li>
                        <button id="pmc-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                <path fill="#ededed" d="M211 7.3C205 1 196-1.4 187.6.8s-14.9 8.9-17.1 17.3l-15.8 62.5l-62-17.5c-8.4-2.4-17.4 0-23.5 6.1s-8.5 15.1-6.1 23.5l17.5 62l-62.5 15.9c-8.4 2.1-15 8.7-17.3 17.1S1 205 7.3 211l46.2 45l-46.2 45c-6.3 6-8.7 15-6.5 23.4s8.9 14.9 17.3 17.1l62.5 15.8l-17.5 62c-2.4 8.4 0 17.4 6.1 23.5s15.1 8.5 23.5 6.1l62-17.5l15.8 62.5c2.1 8.4 8.7 15 17.1 17.3s17.3-.2 23.4-6.4l45-46.2l45 46.2c6.1 6.2 15 8.7 23.4 6.4s14.9-8.9 17.1-17.3l15.8-62.5l62 17.5c8.4 2.4 17.4 0 23.5-6.1s8.5-15.1 6.1-23.5l-17.5-62l62.5-15.8c8.4-2.1 15-8.7 17.3-17.1s-.2-17.4-6.4-23.4l-46.2-45l46.2-45c6.2-6.1 8.7-15 6.4-23.4s-8.9-14.9-17.3-17.1l-62.5-15.8l17.5-62c2.4-8.4 0-17.4-6.1-23.5s-15.1-8.5-23.5-6.1l-62 17.5l-15.9-62.5c-2.1-8.4-8.7-15-17.1-17.3S307 1 301 7.3l-45 46.2z" />
                            </svg>
                            Professional Members
                        </button>
                    </li>
                    <li>
                        <button id="sum-btn" class="all-bt-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <g fill="#ededed">
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1em" viewBox="0 0 24 24">
                        <path fill="#000" d="M3 18h18v-2H3zm0-5h18v-2H3zm0-7v2h18V6z" />
                    </svg>
                    <h1>GRADUATE TRAINEE</h1>
                </div>
                <div class="right-nav">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <g fill="none" stroke="#290dfd" stroke-width="1.5">
                            <circle cx="12" cy="9" r="3" opacity="0.5" />
                            <circle cx="12" cy="12" r="10" />
                            <path stroke-linecap="round" d="M17.97 20c-.16-2.892-1.045-5-5.97-5s-5.81 2.108-5.97 5" opacity="0.5" />
                        </g>
                    </svg>
                    <p><?= $_SESSION['logged_in_user']['lastName'] . ' ' . $_SESSION['logged_in_user']['firstName']; ?></p>
                </div>

            </div>
           
            <div id="biodata-screen" style="display: block;">
                <div class="head-bio">
                    <div class="left-bio">
                        <h2>Bio Data</h2>
                    </div>
                    <div class="right-bio">
                        <p><a href="" style="color: #008f4a;"> Job Application</a> / <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                    <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                                </svg>Bio Data</a></p>
                    </div>
                </div>
                <div class="body-bio">
                    <form action="" method="post">
                        <div class="form-head">
                            <h2>Candidate Bio Data</h2>
                        </div>
                        <div class="form-body">
                            <table>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="fname">Firstname</label>
                                        </div>
                                        <div>
                                            <input type="text" name="firstname" id="" value="<?= $_SESSION['logged_in_user']['firstName'];?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="mname">Middlename</label>
                                        </div>
                                        <div>
                                            <input type="text" name="middlename" id=""  value="<?= $record['middlename']?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="lname">Lastname</label>
                                        </div>
                                        <div>
                                            <input type="text" name="lastname" id=""  value=" <?= $_SESSION['logged_in_user']['lastName']?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="gender">Gender</label>
                                        </div>
                                        <div>
                                            <select name="gender" id="" value="<?= $record['gender']?>">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="DoF">Date of Birth</label>
                                        </div>
                                        <div>
                                            <input type="date" name="dateOfBirth" id="" value="<?= $record['dateOfBirth']?>" placeholder="mm/dd/yy">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Birth Certifiate <i>(file types, jpeg, png, pdf, size limit 2MB)</i></label>
                                        </div>
                                        <div>
                                            <input type="file" name="birthCertificate" id="" value="" placeholder="No file chosen">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Marital status</label>
                                        </div>
                                        <div>
                                            <select name="maritalStatus" id="" Value="<?= $record['maritalStatus']?>">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="Married">Married</option>
                                                <option value="Single">Single</option>
                                                <option value="Divorce">Divorce</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">State of Origin</label>
                                        </div>
                                        <div>
                                            <select name="stateOfOrigin" id="" Value="<?= $record['stateOfOrigin']?>">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="lga">LGA</label>
                                        </div>
                                        <div>
                                            <select name="localGovernmentArea" id="" Value="<?= $record['localGovernmentArea']?>">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="Obokun">Obokun</option>
                                                <option value="Ido">Ido</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="lga-cert">LGA Indigene\Origin Certifiate <i>(file types, jpeg, png, pdf, size limit 2MB)</i></label>
                                        </div>
                                        <div>
                                            <input type="file" name="lgaCertificate" id="" value="" placeholder="No file chosen">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="nin">NIN</label>
                                        </div>
                                        <div>
                                            <input type="text" name="nin" id="" value="<?= $record['nin']?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="number">Phone Number</label>
                                        </div>
                                        <div id="Emergency">
                                            <select name="phone_abb" id="" >
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                            </select>
                                            <input type="text" name="phoneNumber" id=""  value="<?= $record['phoneNumber']?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Emergency number</label>
                                        </div>
                                        <div id="Emergency">
                                            <select name="" id="">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                            </select>
                                            <input type="text" name="emergencyNumber" id="" value="<?= $record['emergencyNumber']?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Residetial Address</label>
                                        </div>
                                        <div>
                                            <input type="text" name="address" id="" value="<?= $record['address']?>">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-footer">
                            <button type="submit" name="save">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                    <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                                </svg>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="education-screen" style="display: none;">
                <div class="head-edu">
                    <div class="left-edu">
                        <h2>Education</h2>
                    </div>
                    <div class="right-edu">
                        <p><a href="" style="color: #008f4a;"> Job Application</a> / <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                    <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                                </svg>Education</a></p>
                    </div>
                </div>
                <div class="body-edu">
                    <div class="left-body-edu">
                        <div id="pri-btn">Primary Education</div>
                        <div id="sec-btn">Secondary Education</div>
                        <div id="higher-btn">Higher Education</div>
                        <div id="nysc-btn">NYSC</div>
                    </div>
                    <div class="right-body-edu">
                        <div id="primary">
                            <!-- Display form input include save -->
                            <form action="" method="post">
                                <div class="form-head">
                                    <h2>Primary Education</h2>
                                </div>
                                <div class="no-br">

                                    <table >
                                        <thead>
                                            <tr>
                                                <th>School Name</th>
                                                <th>Graduation Year</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="input-table-body">
                                            <!-- INPUT TEXT WILL BE DISPLAY -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button name="save">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                                        </svg>
                                        Save
                                    </button>
                                </div>
                            </form>
                            
                            <!-- Add form iincludes add up -->
                            <form action="" method="post" class="mar-top">
                                <div class="form-head">
                                    <h2>Primary Education</h2>
                                </div>
                                <div class="form-body">
                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">School Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addText" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addYear" value="">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button id="addRow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="64" stroke-dashoffset="64" d="M13 3l6 6v12h-14v-18h8"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="64;0"/></path><path stroke-dasharray="14" stroke-dashoffset="14" stroke-width="1" d="M12.5 3v5.5h6.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" values="14;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M9 14h6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.9s" dur="0.2s" values="8;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M12 11v6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="1.1s" dur="0.2s" values="8;0"/></path></g>
                                        </svg>
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="secondary" style="display: none;">
                            <form action="">
                                <div class="form-head">
                                    <h2>Secondary Education</h2>
                                </div>
                                <div class="no-br">

                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">School Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for=""></label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </form>
                            <form action="" class="mar-top">
                                <div class="form-head">
                                    <h2>Secondary Education</h2>
                                </div>
                                <div class="form-body">
                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">School Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                                        </svg>
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="higher" style="display: none;">
                            <form action="">
                                <div class="form-head">
                                    <h2>Higher Education</h2>
                                </div>
                                <div class="no-br">

                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">School Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for=""></label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </form>
                            <form action="" class="mar-top">
                                <div class="form-head">
                                    <h2>Higher Education</h2>
                                </div>
                                <div class="form-body">
                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">School Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                                        </svg>
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="nysc" style="display: none;">
                            <form action="">
                                <div class="form-head">
                                    <h2>NYSC</h2>
                                </div>
                                <div class="no-br">

                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">Camp Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for=""></label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </form>
                            <form action="" class="mar-top">
                                <div class="form-head">
                                    <h2>NYSC</h2>
                                </div>
                                <div class="form-body">
                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">Camp Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="" value="">
                                                </div>
                                            </td>
                                        </tr>

                                        </tr>
                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                                        </svg>
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="work-screen" style="display: none;">
                <div class="head-work">
                    <div class="left-work">
                        <h2>Work History</h2>
                    </div>
                    <div class="right-work">
                        <p>
                            <a href="" style="color: #008f4a;"> Job Application</a> / <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                    <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                                </svg>
                                Work History
                            </a>
                        </p>
                    </div>
                </div>
                <div class="body-work">
                    <form action="">
                        <div class="form-head">
                            <h2>Work History</h2>
                        </div>
                        <div class="no-br">

                            <table col>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Organization Name</label>
                                            <input type="text" name="" id="" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Role</label>
                                            <input type="text" name="" id="" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Resposibilities</label>
                                            <input type="text" name="" id="" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Start Date</label>
                                            <input type="text" name="" id="" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">End Date</label>
                                            <input type="text" name="" id="" value="">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                    <form action="" class="mar-top">
                        <div class="form-head">
                            <h2>Primary Education</h2>
                        </div>
                        <div class="form-body">
                            <table>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Organization Name</label>
                                        </div>
                                        <div>
                                            <input type="text" name="" id="" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Role</label>
                                        </div>
                                        <div>
                                            <input type="text" name="" id="" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div>
                                            <label for="">Resposibilities <i>(max of 1000 words)</i></label>
                                        </div>
                                        <div>
                                            <textarea name="" id=""></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Start Date</label>
                                        </div>
                                        <div>
                                            <input type="date" name="" id="" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">End Date</label>
                                        </div>
                                        <div>
                                            <input type="date" name="" id="" value="">
                                        </div>
                                        <div style="font-size: 12px;">
                                            <input type="checkbox">currently in this role
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-footer">
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                    <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                                </svg>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="pmc-screen" style="display: none;">
                <div class="head-pmc">
                    <div class="left-pmc">
                        <h2>Professional Memberships</h2>
                    </div>
                    <div class="right-pmc">
                        <p>
                            <a href="" style="color: #008f4a;"> Job Application</a> / <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                    <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                                </svg>
                                Professional Memberships
                            </a>
                        </p>
                    </div>
                </div>
                <div class="body-pmc">
                   add certificate
                </div>
            </div>

            <div id="summary-screen" style="display: none;">
                <div class="head-sum">
                    <div class="left-sum">
                        <h2>Application Preview</h2>
                    </div>
                    <div class="right-sum">
                        <p>
                            <a href="" style="color: #008f4a;"> Job Application</a> / <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                    <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                                </svg>
                                Appication Summary
                            </a>
                        </p>
                    </div>
                </div>
                <div class="body-sum">
                    <div class="biodate-sum">
                        <h3>Bio Data</h3>
                    </div>
                    <div class="work-sum">
                        <h3>Work History</h3>
                    </div>
                    <div class="primary-sum">
                        <H3>Primary Education</H3>
                    </div>
                    <div class="secondary-sum">
                        <h3>Secondary Education</h3>
                    </div>
                    <div class="higher-sum"></div>
                    <h3>Higher Education</h3>
                    <div class="nysc-sum">
                        <h3>NYSC Education</h3>
                    </div>
                    <div class="pmc-sum">
                        <h3>Prodessional Memberships and Certifications</h3>
                    </div>
                </div>
            </div>

            



            <div id="footer">
                <div class="left-footer">
                    <p><b>Copyright </b>&copy;<b style="color: blue"> 2024 </b><b>NNPC</b>. All right reserved</p>
                </div>
                <div class="right-footer">
                    <p>NNPC Limited</p>
                </div>
            </div>
        </div>

    </div>
    <script src="./af_function.js"></script>
    <script>
        // Function to dynamically add rows to the input table
        const AddRow = document.getElementById('addRow')
        AddRow.addEventListener("click", (e)=>{
            e.preventDefault();
            const table = document.getElementById('input-table-body');
            const AddText = document.getElementById('addText');
            const AddYear = document.getElementById('addYear');
            const row = document.createElement('tr');
            const rowCount = tableBody.getElementsByTagName('tr').length;

             // Check if inputs are not empty
             if (AddText && AddYear) {
                // Check if the number of rows is less than 2
                if (rowCount < 2) {
                    // Create a new row
                    const row = document.createElement('tr');

                    // Insert input values into the row's cells
                    row.innerHTML = `
                            <td><input type="text" name="name[]" value="${AddText.value}" required></td>
                            <td><input type="email" name="email[]" value="${AddYear.value}" required></td>
                            <td><button type="button" onclick="removeRow(this)">Remove</button></td>
                        `;

                    // Append the row to the table
                    tableBody.appendChild(row);

                    // Clear input fields
                    AddText.value = "";
                    AddYear.value = "";
                } else {
                    alert('Cannot input more than 2 rows.');
                }
            } else {
                alert('Please fill out both fields.');
            }

            // row.innerHTML = `
            //     <td><input type="text" name="name[]" value="${AddText.value}" required></td>
            //     <td><input type="email" name="email[]" value="${AddYear.value}" required></td>
            //     <td><button type="button" onclick="removeRow(this)">Remove</button></td>
            // `;

            // table.appendChild(row);
            // AddText.value = "";
            // AddYear.value = "";
        })

        // Function to remove a row
        function removeRow(button) {
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        // Function to handle form submission via AJAX
        function submitForm() {
            const form = document.getElementById('dynamic-form');
            const formData = new FormData(form);

            // Use fetch API to send the form data to the server
            fetch('save_and_display_ajax.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Expect a JSON response from the server
            .then(data => {
                if (data.success) {
                    // Clear the input table after successful submission
                    document.getElementById('input-table').innerHTML = `
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    `;

                    // Display the saved data in the "saved-data-table"
                    const savedDataTable = document.getElementById('saved-data-table');
                    data.saved_data.forEach(row => {
                        const newRow = savedDataTable.insertRow();
                        newRow.innerHTML = `<td>${row.id}</td><td>${row.name}</td><td>${row.email}</td>`;
                    });
                } else {
                    alert('Error saving data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to submit form');
            });
        }
    </script>
</body>


</html>