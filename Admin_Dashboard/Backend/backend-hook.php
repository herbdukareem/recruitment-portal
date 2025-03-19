<?php
	// Applicatrion submitted
	// Default SQL Query (Fetch All Applicants)
	$sql = "
	SELECT 
		u.id AS user_id,
		u.created_at,
		b.position, 
		b.firstname, 
		b.middlename, 
		b.lastname, 
		b.gender, 
		b.dateOfBirth,
		b.maritalStatus,
		u.email, 
		b.phoneNumber, 
		b.nin,
		b.emergencyNumber,
		b.address,
		b.lga,
		b.stateOfOrigin,
		e.primary_school_name, 
		e.primary_graduation_year, 
		e.secondarySchoolName, 
		e.secondaryGraduationYear, 
		e.certificateType, 
		e.classOfDegree, 
		e.institution, 
		e.course, 
		e.highGraduationYear, 
		e.nyscCertificateNumber, 
		e.yearOfService,
		w.organizationName, 
		w.rank, 
		w.responsibilities, 
		w.startDate, 
		w.endDate, 
		p.bodyName,
		p.membershipID, 
		p.membershipResposibilities, 
		p.certificateDate,
		q.score_percentage,
		f.lga_file_path,
		f.birth_certificate_file_path,
		f.passport_file_path,
		f.sec_file_path,
		f.high_certificate_file_path,
		f.nysc_file_path,
		f.pmc_file_path
	FROM user_applications AS b
	JOIN users AS u ON b.user_id = u.id
	JOIN user_education_details AS e ON u.id = e.user_id
	JOIN user_pmc_details AS p ON u.id = p.user_id
	JOIN user_work_details AS w ON u.id = w.user_id
	JOIN quiz_scores AS q ON u.id = q.user_id
	JOIN user_files AS f ON u.id = f.user_id
	WHERE b.position IS NOT NULL";  // Default condition

	$params = [];

	// If Search is Performed
	if (isset($_POST['search'])) {
		$position = $_POST['position'] ?? '';
		$status = $_POST['status'] ?? '';
		$nin = $_POST['nin'] ?? '';

		if (!empty($position)) {
			$sql .= " AND b.position = :position";
			$params[':position'] = $position;
		}

		if (!empty($status)) {
			$sql .= " AND b.status = :status";
			$params[':status'] = $status;
		}

		if (!empty($nin)) {
			$sql .= " AND b.nin = :nin";
			$params[':nin'] = $nin;
		}
	}

	// Execute Query
	$fetchData = $pdo->prepare($sql);
	$fetchData->execute($params);
	$allApplicant = $fetchData->fetchAll(PDO::FETCH_ASSOC);

	if (!is_array($allApplicant)) {
		var_dump($allApplicant); // Debugging
		die("Unexpected data type from database.");
	};
	
	$columnCount = count($allApplicant);

	// Shortlisted Applicants
	$query = $pdo->prepare("SELECT COUNT(*) as total FROM user_applications WHERE status = 'shortlisted'");
	$query->execute();
	$result = $query->fetch(PDO::FETCH_ASSOC);
	$shortlistedCount = $result['total'];

	// Interviewed Applicants
	$query = $pdo->prepare("SELECT COUNT(*) as total FROM user_applications WHERE status = 'interviewed'");
	$query->execute();
	$result = $query->fetch(PDO::FETCH_ASSOC);
	$interviewedCount = $result['total'];

	// Unemployed Applicants
	$query = $pdo->prepare("SELECT COUNT(*) as total FROM user_applications WHERE status = 'unemployed'");
	$query->execute();
	$result = $query->fetch(PDO::FETCH_ASSOC);
	$unemployedCount = $result['total'];
	
	// Application Validation
	try {
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveStatus'])) {
			$user_id = $_POST['user_id'];
			$status = $_POST['status'];
	
			// Validate the user_id and status
			if (empty($user_id) || empty($status)) {
				echo "User ID or Status is missing!";
			} else {
				$sql = "UPDATE user_applications SET status = :status WHERE user_id = :user_id";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([':status' => $status, ':user_id' => $user_id]);
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	// Create Admin
	if (isset($_POST['createAdmin'])) {
		$admin_role = $_POST['admin_role']; // Fixed typo
		$admin_id = $_POST['admin_id'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['c-password'];
	
		// Check if admin already exists
		$checkAdmin = $pdo->prepare("SELECT admin_id FROM admins WHERE admin_id = :admin_id");
		$checkAdmin->execute([':admin_id' => $admin_id]);
		$existingAdmin = $checkAdmin->fetch(PDO::FETCH_ASSOC);
	
		// Check if all fields are filled
		if (empty($admin_id) || empty($admin_role) || empty($password) || empty($confirmPassword)) {
			$_SESSION['alert_message'] = "All fields are required.";
			$_SESSION['alert_type'] = "warning";
		} elseif ($existingAdmin) { 
			// Prevent duplicate admin accounts
			$_SESSION['alert_message'] = "Admin ID already exists. Please use a different ID.";
			$_SESSION['alert_type'] = "danger";
		} elseif ($password !== $confirmPassword) { 
			// Validate password match
			$_SESSION['alert_message'] = "Passwords do not match.";
			$_SESSION['alert_type'] = "danger";
		} else {
			// Hash password before storing
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	
			// Insert new admin
			$insertAdmin = $pdo->prepare("INSERT INTO admins (admin_id, admin_role, admin_password) VALUES (:admin_id, :admin_role, :admin_password)");
			$insertAdmin->execute([
				':admin_id'   => $admin_id,
				':admin_role' => $admin_role,
				':admin_password'   => $hashed_password
			]);
	
			$_SESSION['alert_message'] = "Admin created successfully!";
			$_SESSION['alert_type'] = "success";
			header("Location:" . $_SERVER["PHP_SELF"] . "#create_admin" );
			exit();
		}
	}

	$formSection = 1;

	if (isset($_POST['saveBio'])) {
		$positionType = $_POST['positionType'];
		$supPosition = $_POST['supPosition'];
		$position = $_POST['position'];
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$gender = $_POST['gender'];
		$dateOfBirth = $_POST['dateOfBirth'];
		$maritalStatus = $_POST['maritalStatus'];
		$stateOfOrigin = $_POST['stateOfOrigin'];
		$lga = $_POST['lga'];
		$nin = $_POST['nin'];
		$phoneNumber = $_POST['phoneNumber'];
		$emergencyNumber = $_POST['emergencyNumber'];
		$address = $_POST['address'];
	
		if (empty($positionType) || empty($supPosition) || empty($position) || empty($firstname) || empty($lastname) || empty($middlename) || empty($gender) || empty($email) || empty($password)) {
			$_SESSION['alert_message'] = "All fields are required.";
			$_SESSION['alert_type'] = "warning";
			header("Location:" . $_SERVER['PHP_SELF'] . "#bio-screen");
			exit();
		}
	
		try {
			if (!$pdo->inTransaction()) { // Ensure transaction starts only if not already active
				$pdo->beginTransaction();
			}
	
			// Check if email already exists
			$checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = :email");
			$checkEmail->execute([':email' => $email]);
			$existingEmail = $checkEmail->fetch(PDO::FETCH_ASSOC);
	
			if ($existingEmail) {
				$_SESSION['alert_message'] = "Email already registered.";
				$_SESSION['alert_type'] = "danger";
				header("Location: " . $_SERVER['PHP_SELF'] . "#bio-screen");
				exit();
			}
	
			// Check if NIN already exists
			$checkNIN = $pdo->prepare("SELECT user_id FROM user_applications WHERE nin = :nin");
			$checkNIN->execute([':nin' => $nin]);
			$existingUser = $checkNIN->fetch(PDO::FETCH_ASSOC);
	
			if ($existingUser) {
				$user_id = $existingUser['user_id']; // Use existing user_id
			} else {
				// Hash the password
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	
				// Insert user into users table
				$createUser = $pdo->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)");
				$createUser->execute([
					':firstname' => $firstname,
					':lastname' => $lastname,
					':email' => $email,
					':password' => $hashedPassword
				]);
	
				$user_id = $pdo->lastInsertId();

				$_SESSION['user_id'] = $user_id;
			}
	
			// Check if user already has an application
			$checkRecordQuery = $pdo->prepare("SELECT * FROM user_applications WHERE user_id = :user_id");
			$checkRecordQuery->execute([":user_id" => $user_id]);
	
			if ($checkRecordQuery->rowCount() === 0) {
				$sql = "INSERT INTO user_applications (
							user_id, positionType, supPosition, position, firstname, lastname, middlename, gender, dateOfBirth, 
							maritalStatus, stateOfOrigin, lga, nin, phoneNumber, emergencyNumber, address
						) VALUES (
							:user_id, :positionType, :supPosition, :position, :firstname, :lastname, :middlename, :gender, :dateOfBirth, 
							:maritalStatus, :stateOfOrigin, :lga, :nin, :phoneNumber, :emergencyNumber, :address
						)";
			} else {
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

			/** FILE UPLOAD HANDLING **/
			$uploadDirectory = "./uploads/";
			$allowedFileTypes = ['doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png'];
	
			if (!is_dir($uploadDirectory)) {
				mkdir($uploadDirectory, 0777, true);
			}
	
			$fileInputs = ['lgaCertificate', 'birthCertificate', 'passport'];
			$filePaths = [];
	
			foreach ($fileInputs as $inputName) {
				if (isset($_FILES[$inputName]) && $_FILES[$inputName]["error"] == 0) {
					$fileTmpPath = $_FILES[$inputName]["tmp_name"];
					$fileExt = strtolower(pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION));
	
					if (in_array($fileExt, $allowedFileTypes)) {
						$newFileName = $user_id . "_" . $inputName . "." . $fileExt;
						$uploadPath = $uploadDirectory . $newFileName;
	
						if (move_uploaded_file($fileTmpPath, $uploadPath)) {
							$filePaths[$inputName] = $uploadPath;
						}
					}
				}
			}
	
			if (!empty($filePaths)) {
				$checkFilePath = $pdo->prepare("SELECT id FROM user_files WHERE user_id = :user_id");
				$checkFilePath->execute([':user_id' => $user_id]);
	
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
					':lga_file_path' => $filePaths['lgaCertificate'] ?? '',
					':birth_certificate_file_path' => $filePaths['birthCertificate'] ?? '',
					':passport_file_path' => $filePaths['passport'] ?? ''
				]);
			}
	
			$_SESSION['alert_message'] = "Applicant details saved successfully!";
			$_SESSION['alert_type'] = "success";
			header("Location: " . strtok($_SERVER["REQUEST_URI"], '?') . "#education-screen");
			exit();
			$pdo->commit();
		} catch (PDOException $e) {
			if ($pdo->inTransaction()) { // Rollback only if a transaction is active
				$pdo->rollBack();
			}
			$_SESSION['alert_message'] = "Error: " . $e->getMessage();
			$_SESSION['alert_type'] = "danger";
			echo "Error: " . $e->getMessage(); // Debugging
		}
	}

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
            
           
			$_SESSION['alert_message'] = "Education details saved successfully";
			$_SESSION['alert_type'] = "success";
			header("Location:" . $_SERVER['PHP_SELF'] . "#work-screen");
            exit();
        } catch (PDOException $e) {
            $_SESSION['alert_message'] = "Error saving education details";
            $_SESSION['alert_type'] = "danger";
        }
    }

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

	

	if (isset($_POST['saveEditUser'])) {
		if (!empty($_POST['editUser'])) {
			$_SESSION['user_id'] = $_POST['editUser'];
	
			$_SESSION['alert_message'] = "You can proceed to edit applicant";
			$_SESSION['alert_type'] = "success";
	
			header("Location: form.php");
			exit();
		} else {
			echo "Error: No user ID selected.";
		}
	}
	

	if (isset($_POST['new_applicant'])) {
		unset($_SESSION['user_id']); // Remove stored user_id
		$_SESSION['alert_message'] = "New applicant session started!";
		$_SESSION['alert_type'] = "info";
	
		// Redirect to the same page to refresh the form
		header("Location: " . $_SERVER['PHP_SELF'] . "#biodata-screen");
		exit();
	};

	
	


?>