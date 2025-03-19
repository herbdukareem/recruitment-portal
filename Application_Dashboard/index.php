<?php
    session_start();
    include_once('../db_connect.php');

    error_reporting(E_ERROR | E_PARSE); // Only show critical errors
    ini_set('display_errors', 0);

    $user_id = $_SESSION['user_id'];
    $adminRole = false;

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: ./Auth/auth.php?display=login");
        exit();
    }


    // Fetch user firstname and lastname from the database using user ID
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user_names = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch user record
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die('User not found.');
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location: ./Auth/auth.php?display=login");
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
        $is_new_user = true;
    } else {
        $is_new_user = false;
    }

    $formSection = 1;

    //save biodata form to db
    if (isset($_POST['saveBio'])) {
        $positionType = $_POST['positionType'];
        $supPosition = $_POST['supPosition'];
        $position = $_POST['position'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $dateOfBirth = $_POST['dateOfBirth'];
        $maritalStatus = $_POST['maritalStatus'];
        $stateOfOrigin = $_POST['stateOfOrigin'];
        $lga = $_POST['lga'];
        $nin = $_POST['nin'];
        $phoneNumber = $_POST['phoneNumber'];
        $emergencyNumber = $_POST['emergencyNumber'];
        $address = $_POST['address'];

       // Check if NIN exists in the database
        $checkNIN = $pdo->prepare("SELECT user_id FROM user_applications WHERE nin = :nin");
        $checkNIN->execute([":nin" => $nin]);
        $existingNIN = $checkNIN->fetch(PDO::FETCH_ASSOC);

        if (empty($positionType) || empty($supPosition) || empty($position) || empty($firstname) || empty($lastname) || empty($middlename) || empty($gender)) {
            $_SESSION['alert_message'] = "All fields are required.";
            $_SESSION['alert_type'] = "warning";
            header("Location:" . $_SERVER['PHP_SELF'] . "#bio-screen");
            return;
        } else {
                try {
                    // Check if user already exists in user_applications
                    $checkRecordQuery = $pdo->prepare("SELECT * FROM user_applications WHERE user_id = :user_id");
                    $checkRecordQuery->execute([":user_id" => $user_id]);

                    if ($checkRecordQuery->rowCount() === 0) {
                        if ($existingNIN && $existingNIN !== $user_id) {
                            // NIN belongs to another user, block insertion
                            $_SESSION['alert_message'] = "Application Failed! This NIN is already registered with another applicant.";
                            $_SESSION['alert_type'] = "danger";
                            header("Location:" . $_SERVER['PHP_SELF'] . "#biodata-screen");
                            exit();
                        } else {
                            // Insert new record
                            $sql = "INSERT INTO user_applications (
                                        user_id, positionType, supPosition, position, firstname, lastname, middlename, gender, dateOfBirth, 
                                        maritalStatus, stateOfOrigin, lga, nin, 
                                        phoneNumber, emergencyNumber, address
                                    ) VALUES (
                                        :user_id, :positionType, :supPosition, :position, :firstname, :lastname, :middlename, :gender, :dateOfBirth, 
                                        :maritalStatus, :stateOfOrigin, :lga, :nin, 
                                        :phoneNumber, :emergencyNumber, :address
                                    )";
                        }
                    } else {
                        // Allow update if user already exists
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
                                    nin = :nin,
                                    lga = :lga,
                                    phoneNumber = :phoneNumber,
                                    emergencyNumber = :emergencyNumber,
                                    address = :address
                                WHERE user_id = :user_id";
                    }

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':user_id' => $user_id,
                        ':positionType' => $positionType,
                        ':supPosition' => $supPosition,
                        ':position' => $position,
                        ':firstname' => $firstname,
                        ':lastname' => $lastname,
                        ':middlename' => $middlename,
                        ':gender' => $gender,
                        ':dateOfBirth' => $dateOfBirth,
                        ':maritalStatus' => $maritalStatus,
                        ':stateOfOrigin' => $stateOfOrigin,
                        ':lga' => $lga,
                        ':nin' => $nin,
                        ':phoneNumber' => $phoneNumber,
                        ':emergencyNumber' => $emergencyNumber,
                        ':address' => $address
                    ]);

                    // File upload handling
                    $uploadDirectory = "./uploads/";
                    $allowedFileTypes = ['doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png']; 

                    // Ensure the upload directory exists
                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }

                    // Initialize variables to store file paths
                    $lgaPath = null;
                    $birthCertPath = null;
                    $passportPath = null;

                    $fileInputs = ['lgaCertificate', 'birthCertificate', 'passport'];

                    foreach ($fileInputs as $inputName) {
                        if (isset($_FILES[$inputName]) && $_FILES[$inputName]["error"] == 0) {
                            $fileTmpPath = $_FILES[$inputName]["tmp_name"];
                            $fileExt = strtolower(pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION));

                            // Verify the file extension
                            if (in_array($fileExt, $allowedFileTypes)) {
                                // Create a unique file name
                                $newFileName = $user_id . "_" . $inputName . "." . $fileExt;
                                $uploadPath = $uploadDirectory . $newFileName;

                                if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                                    $_SESSION['alert_message'] = "$newFileName has been uploaded successfully";
                                    $_SESSION['alert_type'] = "success";
                                    if ($inputName === 'lgaCertificate') {
                                        $lgaPath = $uploadPath;
                                    } elseif ($inputName === 'birthCertificate') {
                                        $birthCertPath = $uploadPath;
                                    } else {
                                        $passportPath = $uploadPath;
                                    }
                                } else {
                                    $_SESSION['alert_message'] = "Error moving file: $_FILES[$inputName]['name']";
                                    $_SESSION['alert_type'] = "warning";
                                }
                            } else {
                                $_SESSION['alert_message'] = "Invalid file type for: $_FILES[$inputName]['name'] ";
                                $_SESSION['alert_type'] = "warning";
                            }
                        } else {
                            $_SESSION['alert_message'] = "No file uploaded or an error occurred for $inputName";
                            $_SESSION['alert_type'] = "warning";
                        }
                    }

                    if (!empty($lgaPath) || !empty($birthCertPath) || !empty($passportPath)) {
                        $checkFilePath = $pdo->prepare("SELECT id FROM user_files WHERE user_id = :user_id");
                        $checkFilePath->execute([':user_id' => $user_id]);
                    
                        try {
                            if ($checkFilePath->rowCount() === 0) {
                                $sql = "INSERT INTO user_files (user_id, lga_file_path, birth_certificate_file_path, passport_file_path) 
                                        VALUES (:user_id, :lga_file_path, :birth_certificate_file_path, :passport_file_path)";
                            } else {
                                $sql = "UPDATE user_files SET
                                            lga_file_path = :lga_file_path,
                                            birth_certificate_file_path = :birth_certificate_file_path,
                                            passport_file_path = :passport_file_path
                                        WHERE user_id = :user_id";
                            }
                    
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':user_id' => $user_id,
                                ':lga_file_path' => $lgaPath ?? '',
                                ':birth_certificate_file_path' => $birthCertPath ?? '',
                                ':passport_file_path' => $passportPath ?? ''
                            ]);
                    
                            $_SESSION['alert_message'] = "File saved successfully";
                            $_SESSION['alert_type'] = "success";
                            header("Location: " . $_SERVER['PHP_SELF'] . "#education-screen");
                            exit();
                            
                        } catch (PDOException $e) {
                            $_SESSION['alert_message'] = "Error saving file: " . $e->getMessage();
                            $_SESSION['alert_type'] = "warning";
                        }
                    } else {
                        $_SESSION['alert_message'] = "No valid file uploaded.";
                        $_SESSION['alert_type'] = "warning";
                    }
                } catch (PDOException $e) {
                    echo 'Error: ' . $e->getMessage();
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

            // File upload handling
            $uploadDirectory = "./uploads/";
            $allowedFileTypes = ['doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png'];

            // Ensure the upload directory exists
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            // Initialize variables to store file paths
            $secPath = null;
            $highCertPath = null;
            $nyscPath = null;

            $fileInputs = ['secondaryCertificate', 'highCertificate', 'nyscCertificate'];

            foreach ($fileInputs as $inputName) {
                if (isset($_FILES[$inputName]) && $_FILES[$inputName]["error"] == 0) {
                    $fileTmpPath = $_FILES[$inputName]["tmp_name"];
                    $fileExt = strtolower(pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION));

                    // Verify the file extension
                    if (in_array($fileExt, $allowedFileTypes)) {
                        // Create a unique file name
                        $newFileName = $user_id . "_" . $inputName . "." . $fileExt;
                        $uploadPath = $uploadDirectory . $newFileName;

                        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                            $_SESSION['alert_message'] = "Files uploaded successfully";
                            $_SESSION['alert_type'] = "success";
                            if ($inputName === 'secondaryCertificate') {
                                $secPath = $uploadPath;
                            } elseif ($inputName === 'highCertificate') {
                                $highCertPath = $uploadPath;
                            } else {
                                $nyscPath = $uploadPath;
                            }
                        } else {
                            $_SESSION['alert_message'] = "Error moving file: $newFileName";
                            $_SESSION['alert_type'] = "danger";
                        }
                    } else {
                        $_SESSION['alert_message'] = "Invalid file type for $inputName";
                        $_SESSION['alert_type'] = "warning";
                    }
                } else {
                    $_SESSION['alert_message'] = "No file uploaded";
                    $_SESSION['alert_type'] = "warning";
                }
            }

            // Check if a record already exists for the user
            $checkFileRecord = $pdo->prepare("SELECT id FROM user_files WHERE user_id = :user_id");
            $checkFileRecord->execute([':user_id' => $user_id]);

            if ($checkFileRecord->rowCount() > 0) {
                // Update existing record
                $sql = "UPDATE user_files SET 
                            sec_file_path = COALESCE(:sec_file_path, sec_file_path),
                            high_certificate_file_path = COALESCE(:high_certificate_file_path, high_certificate_file_path),
                            nysc_file_path = COALESCE(:nysc_file_path, nysc_file_path)
                        WHERE user_id = :user_id";
            } else {
                // Insert a new record if none exists
                $sql = "INSERT INTO user_files (user_id, sec_file_path, high_certificate_file_path, nysc_file_path) 
                        VALUES (:user_id, :sec_file_path, :high_certificate_file_path, :nysc_file_path)";
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':sec_file_path' => $secPath,
                ':high_certificate_file_path' => $highCertPath,
                ':nysc_file_path' => $nyscPath
            ]);
            $_SESSION['alert_message'] = "File saved successfully";
            $_SESSION['alert_type'] = "success";
            
            header("Location:" . $_SERVER['PHP_SELF'] . "#work-screen");
            exit();
                $_SESSION['alert_message'] = "Education details saved successfully";
                $_SESSION['alert_type'] = "success";
        } catch (PDOException $e) {
            $_SESSION['alert_message'] = "Error saving education details";
            $_SESSION['alert_type'] = "danger";
        }
    }
    // Fetch user Education Detials for display in the form after saving
    $fetchUserEducationData = $pdo->prepare("SELECT * FROM user_education_details WHERE user_id = :user_id");
    $fetchUserEducationData->execute(['user_id' => $user_id]);
    $user_edu_data = $fetchUserEducationData->fetch(PDO::FETCH_ASSOC);



    if (isset($_POST['saveWork'])) {
        // Retrieve POST data with empty string fallback for empty values
        $organizationName = !empty($_POST['organizationName']) ? $_POST['organizationName'] : '';
        $rank = !empty($_POST['rank']) ? $_POST['rank'] : '';
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
                            user_id, organizationName, rank, 
                            responsibilities, startDate, 
                            endDate
                        ) VALUES (
                            :user_id, :organizationName, :rank, 
                            :responsibilities, :startDate, 
                            :endDate
                        )";
            } else {
                // Update existing record
                $sql = "UPDATE user_work_details SET
                            organizationName = :organizationName,
                            rank = :rank,
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
                ':rank' => $rank,
                ':responsibilities' => $responsibilities,
                ':startDate' => $startDate,
                ':endDate' => $endDate,
            ]);
            $_SESSION['alert_message'] = "Error saving Work History details";
            $_SESSION['alert_type'] = "success";
            header("Location:" . $_SERVER['PHP_SELF'] . "#pmc-screen");
            exit();
        } catch (PDOException $e) {
            $_SESSION['alert_message'] = "Work History details saved successfully!";
            $_SESSION['alert_type'] = "danger";
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
        $membershipType = !empty($_POST['membershipType']) ? $_POST['membershipType'] : '';
        $membershipResposibilities = !empty($_POST['membershipResposibilities']) ? $_POST['membershipResposibilities'] : '';
        $certificateDate = !empty($_POST['certificateDate']) ? $_POST['certificateDate'] : null;

        try {
            // Check if user PMC details already exist
            $checkUserPMCDetails = $pdo->prepare("SELECT id FROM user_pmc_details WHERE user_id = :user_id");
            $checkUserPMCDetails->execute(['user_id' => $user_id]);

            if ($checkUserPMCDetails->rowCount() === 0) {
                // Insert new record
                $sql = "INSERT INTO user_pmc_details (
                            user_id, bodyName, membershipID, membershipType,
                            membershipResposibilities, certificateDate 
                        ) VALUES (
                            :user_id, :bodyName, :membershipID, :membershipType, 
                            :membershipResposibilities, :certificateDate 
                        )";
            } else {
                // Update existing record
                $sql = "UPDATE user_pmc_details SET
                            bodyName = :bodyName,
                            membershipID = :membershipID,
                            membershipType = :membershipType,
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
                ':membershipType' => $membershipType,
                ':membershipResposibilities' => $membershipResposibilities,
                ':certificateDate' => $certificateDate,
            ]);

            // File upload handling
            $uploadDirectory = "./uploads/";
            $allowedFileTypes = ['doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png'];
            
            // List of file input names to handle
            $fileInputs = ['membershipCertificate']; // Add more input names if needed

            foreach ($fileInputs as $inputName) {
                if (isset($_FILES[$inputName]) && $_FILES[$inputName]["error"] == 0) {
                    $fileTmpPath = $_FILES[$inputName]["tmp_name"];
                    $fileExt = strtolower(pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION));

                    // Verify the file extension
                    if (in_array($fileExt, $allowedFileTypes)) {
                        // Create a unique file name
                        $newFileName = $user_id . "_" . $inputName . "." . $fileExt;
                        $pmcPath = $uploadDirectory . $newFileName;

                        // Move the uploaded file to the destination path
                        if (move_uploaded_file($fileTmpPath, $pmcPath)) {
                            $_SESSION['alert_message'] = "The file $inputName has been uploaded successfully!";
                            $_SESSION['alert_type'] = "success";
                        } else {
                            $_SESSION['alert_message'] = "Error: There was an error moving the file $inputName";
                            $_SESSION['alert_type'] = "warning";
                        }
                    } else {
                        $_SESSION['alert_message'] = "Error: Invalid file type for $inputName";
                        $_SESSION['alert_type'] = "warning";
                    }
                } else {
                    $_SESSION['alert_message'] = "Error: No file uploaded or there was an issue with the upload for $inputName'";
                    $_SESSION['alert_type'] = "danger";
                }
            };

            // checking if user USER ID exist
            $checkPMCPath = $pdo->prepare("SELECT id FROM user_files WHERE user_id=:user_id");
            $checkPMCPath -> execute([':user_id' => $user_id]);

            if($checkPMCPath->rowCount() > 0){
                $sql = "UPDATE user_files SET 
                            pmc_file_path = :pmc_file_path
                        WHERE user_id = :user_id";
            } else {
                $sql = "INSERT INTO (
                            user_id,
                            pmc_file_path
                        ) VALUES (
                            user_id = :user_id,
                            pmc_file_path = :pmc_file_path
                        )";
            };

            $stmt=$pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                'pmc_file_path' => $pmcPath
            ]);
            $_SESSION['alert_message'] = "Files saved successfully!";
            $_SESSION['alert_type'] = "success";
            header("Location:" . $_SERVER['PHP_SELF'] . "#summary-screen");
            exit();

        } catch (PDOException $e) {
            $_SESSION['alert_message'] = "Error saving files!";
            $_SESSION['alert_type'] = "danger";
        }
    }
    // Fetch user Education Detials for display in the form after saving
    $fetchUserPMCData = $pdo->prepare("SELECT * FROM user_pmc_details WHERE user_id = :user_id");
    $fetchUserPMCData->execute(['user_id' => $user_id]);
    $user_pmc_data = $fetchUserPMCData->fetch(PDO::FETCH_ASSOC);

    // Saving Quiz Score to DB
    if (isset($_POST['saveQuizScore'])) {
        $quizScore = $_POST['score'];
        $quizPercentage = $_POST['scorePercentage'];
    
        try {
            // Check if a record exists
            $checkQuizScore = $pdo->prepare("SELECT COUNT(*) FROM quiz_scores WHERE user_id = :user_id");
            $checkQuizScore->execute(['user_id' => $user_id]);
            $recordExists = $checkQuizScore->fetchColumn() > 0; // Fetch the count correctly
    
            if (!$recordExists) {
                $sql = "INSERT INTO quiz_scores (user_id, score, score_percentage)
                        VALUES (:user_id, :score, :score_percentage)";
                echo "<script>console.log('Inserting new score')</script>";
            } else {
                $sql = "UPDATE quiz_scores SET score = :score, score_percentage = :score_percentage 
                        WHERE user_id = :user_id";
                echo "<script>console.log('Updating existing score');</script>";
            }
    
            // Execute query
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':score' => $quizScore,
                ':score_percentage' => $quizPercentage
            ]);
    
            // Delay before redirecting
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '#biodata-screen';
                    }, 5000); // Redirects after 5 seconds
                  </script>";
                  $_SESSION['alert_message'] = "Test Submitted successfuly";
                  $_SESSION['alert_type'] = "success";
            
            header("Location:" . $_SERVER['PHP_SELF'] . "#application-status_screen");
        } catch (PDOException $e) {
            $_SESSION['alert_message'] = "Error saving files!";
            $_SESSION['alert_type'] = "danger";
            echo "<script>alert('Error saving Quiz Score: " . $e->getMessage() . "');</script>";
        }
    }
    

    //Fetching user score from DB
    $fetchUserQuizScore = $pdo->prepare("SELECT * FROM quiz_scores WHERE user_id = :user_id");
    $fetchUserQuizScore->execute(['user_id' => $user_id]);
    $userQuizScore = $fetchUserQuizScore->fetch(PDO::FETCH_ASSOC);

    // Prepare SQL to merge all user data
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
            FROM user_files
        ) as f ON u.id = f.user_id
        JOIN (
            SELECT *
            FROM user_work_details
        )as w ON u.id = w.user_id
        JOIn (
            SELECT *
            FROM user_pmc_details
        )as p ON u.id = p.user_id
        WHERE u.id = :user_id

    ");
    $fetchAllUserData->execute(['user_id' => $user_id]);
    $allUserData = $fetchAllUserData->fetch(PDO::FETCH_ASSOC);

    
    // Check if all previous forms are completed
    $formsCompleted = !empty($allUserData);

   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Dashboard | University Of Ilorin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/formStyles.css">
	<link rel="stylesheet" href="../style/alert.css">
    <link rel="shortcut icon" href="../images/logo-plain.jpg" type="image/x-icon">
</head>

<body>
    <div class="db-winscroll">
        <div class="nav-bar">
            <div class="left-nav">
                <svg id="open_panel" onclick="openPanelHandler()" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5L12 12L19 5M12 12H12M5 19L12 12L19 19"><animate fill="freeze" attributeName="d" dur="0.4s" values="M5 5L12 12L19 5M12 12H12M5 19L12 12L19 19;M5 5L12 5L19 5M5 12H19M5 19L12 19L19 19"/></path></svg>
                
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

        <div id="db-panel">
            <div class="head-panel">
                <a href="../index.php"><img src="../images/logo-plain.jpg" alt="unilorin Logo"></a>
                <svg id="close_panel" onclick="closePanelHandler" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><g fill="none" stroke="var(--main-color-light)" stroke-dasharray="16" stroke-dashoffset="16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7l10 10"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.4s" values="16;0"/></path><path d="M17 7l-10 10"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.4s" dur="0.4s" values="16;0"/></path></g></svg>
            </div>
            <div class="body-panel">
                <ul>
                    <?php 
                        include_once('../pages/nav_lists.php');
                    ?>
                </ul>
            </div>
        </div>
       
        
        <div id="display-screen">
            <div id="alert-con" 
                data-message="<?php echo htmlspecialchars($_SESSION['alert_message'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
                data-type="<?php echo htmlspecialchars($_SESSION['alert_type'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <?php 
                // Clear session messages after loading
                unset($_SESSION['alert_message']);
                unset($_SESSION['alert_type']);
            ?>
            <?php
                include_once('../pages/biodata.php');
                include_once('../pages/education.php');
                include_once('../pages/work.php');
                include_once('../pages/pmc.php');
                include_once('../pages/summary.php');

                
                // Ensure quiz score does not exist before showing proficiency page
                if (!empty($formsCompleted) && !isset($userQuizScore['score'])) {
                    include_once('../pages/proficiency.php');
                } else {
                    echo '
                        <div id="cpl-screen" style="display:none">
                            <div class="error-400">
                                <h2>Page Restriction!</h2>
                                <p>Fill all required forms to proceed.</p>   
                            </div>
                        </div>
                    ';
                };

                // Ensure quiz score exist before showing application status page
                if (!empty($formsCompleted) && isset($userQuizScore['score'])) {
                    include_once('../pages/application_status.php');
                } else {
                    echo '
                        <div id="application-status_screen" style="display:none">
                            <div class="error-400">
                                <h2>Page Restriction!</h2>
                                <p>Fill all required forms, and take <u>COMPUTER PROFICENCY TEST</u> to view application status.</p>   
                            </div>
                        </div>
                    ';
                };

            ?>

        </div>

    </div>

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
	<script type="module" src="../scripts/main.js"></script>

</body>


</html>