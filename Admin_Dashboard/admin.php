<?php
	session_start();
	include_once('../db_connect.php');

	// error_reporting(E_ERROR | E_PARSE); // Only show critical errors
	// ini_set('display_errors', 0);

	$admin_unid = $_SESSION['admin_unid'];
	$adminRole = $_SESSION["admin_role"];

	//Check if the user is logged in
	if (!isset($_SESSION['admin_unid'])) {
		// Redirect to login page if not logged in
		header("Location: ./auth.php");
		exit();
	}

	// $positions = [
	// 	"Professor",
	// 	"Associate Professor/Reader",
	// 	"Lecturer I",
	// 	"Lecturer II",
	// 	"Assistant Lecturer",
	// 	"Administrative Cadre",
	// 	"Executive Officer Cadre",
	// 	"Clerical Officer Cadre",
	// 	"Secretarial Cadre",
	// 	"Secretarial Assistant Cadre",
	// 	"Portel",
	// 	"Office Assistant Cadre",
	// 	"Accountant Cadre",
	// 	"Executive Officer (Accounts) Cadre",
	// 	"Stores Officers' Cadre",
	// 	"Store Attendant",
	// 	"Internal Auditors' Cadre",
	// 	"Executive Officer (Audit) Cadre",
	// 	"Information Officer Cadre",
	// 	"Protocol Officer Cadre",
	// 	"Photographer Cadre",
	// 	"Video Camera Operator Cadre",
	// 	"Information Assistant Cadre",
	// 	"Executive Officer (Information) Cadre",
	// 	"Doctors Cadre",
	// 	"Pharmacists Cadre",
	// 	"Nursing Officer Cadre",
	// 	"Pharmacy Technician Cadre",
	// 	"Medical Laboratory Technologist Cadre",
	// 	"Medical Laboratory Technician Cadre",
	// 	"Medical Laboratory Assistant Cadre",
	// 	"Health Records Officer",
	// 	"Environmental Health Officer Cadre",
	// 	"Veterinary Officer Cadre",
	// 	"Legal Officer Cadre",
	// 	"Library Officer Cadre",
	// 	"Library Assistant Cadre",
	// 	"Bindery Officers' Cadre",
	// 	"Bindery Assistant Cadre",
	// 	"Data Operator/I.T. Operator Cadre",
	// 	"Data Analyst Cadre",
	// 	"Computer Electronics Engineer Cadre",
	// 	"Systems Programmer/Analyst Cadre",
	// 	"Director, COMSIT",
	// 	"Engineer Cadre",
	// 	"Architect Cadre",
	// 	"Quantity Surveyor Cadre",
	// 	"Physical Planning Unit",
	// 	"Maintenance Officer",
	// 	"Workshop Attendant/Assistant/Superintendent Cadre",
	// 	"Driver Cadre",
	// 	"Driver/Mechanic Cadre",
	// 	"Craftsman (Carpentry & Mason, Welding, Plumbing, Electrical, R&G, Mechanical, etc.)",
	// 	"Technical Officer Cadre",
	// 	"Artisan/Craftsman",
	// 	"Power Station Operator Cadre",
	// 	"Horticulturist Cadre (Parks & Gardens)",
	// 	"Estate Officers' Cadre",
	// 	"Gardening Staff (Biological and Parks & Gardens Units)",
	// 	"Turnstile Keeper Cadre",
	// 	"Zoo Keeper Cadre",
	// 	"Curator Cadre",
	// 	"Farm Officer/Manager",
	// 	"Agricultural/Animal Health/Forestry Superintendent Cadre",
	// 	"Technologist Cadre",
	// 	"Laboratory Supervisor",
	// 	"Staff School Cadre I (Lower Basic)",
	// 	"Staff School Cadre II (Upper Basic)",
	// 	"Security Cadre",
	// 	"Planning Officer Cadre",
	// 	"Coach Cadre",
	// 	"Coordinator Cadre (SIWES)",
	// 	"Counsellor Cadre",
	// 	"Signer (Interpreter) Cadre",
	// 	"Archives Assistant Cadre",
	// 	"Archives' Officer Cadre",
	// 	"Archivist Cadre",
	// 	"Graphic Arts Assistant Cadre",
	// 	"Graphic Arts Officers' Cadre",
	// 	"Cook/Steward/Catering Officer Cadre",
	// 	"Laundry Cadre",
	// 	"Fireman Cadre",
	// 	"Fire Superintendent Cadre - 120",
	// 	"Fire Officer Cadre - 122",
	// ];
	$fetchData = $pdo->prepare('
		SELECT 
			u.id AS user_id,
			u.created_at,
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
		WHERE b.position IS NOT NULL
	');
	$fetchData->execute();
	$allApplicant = $fetchData->fetchAll(PDO::FETCH_ASSOC);

	if (!is_array($allApplicant)) {
		var_dump($allApplicant); // Debugging
		die("Unexpected data type from database.");
	};
	
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
	
	

?>
<!doctype html>
<html lang="en">

<head>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admin Dashboard | UNILORIN</title>
	<link rel="stylesheet" href="./assets/css/style.css">
	<!-- FontAwesome CSS-->
	<link rel="stylesheet" href="./assets/modules/fontawesome6.1.1/css/all.css">
	<!-- Boxicons CSS-->
	<link rel="stylesheet" href="./assets/modules/boxicons/css/boxicons.min.css">
	<!-- Apexcharts  CSS -->
	<link rel="stylesheet" href="./assets/modules/apexcharts/apexcharts.css">
    <link rel="shortcut icon" href="../images/logo-plain.jpg" type="image/x-icon">
	<link rel="stylesheet" href="../style/formStyles.css">
	<link rel="stylesheet" href="../style/alert.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	

</head>
<body>

	<style>
		.admin_top_nav{
			position: sticky;
			top: 0;
			right: 0;
			bottom: 0;
			z-index: 99;
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-bottom: 2px solid #00044B;
			background-color: #fff;
		}
		.position{
			display: none;
		}
		.details-row {
			display: none;
		}
		.status_con {
			position: fixed;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			z-index: 9999;
			background-color: rgba(0, 0, 0, 0.6);
			display: none;
		}

		.modal {
			position: absolute;
			top: 40%;
			left: 40%;
			width: 300px;
			background-color: #fff;
			color: black;
			padding: 15px;
			height: 180px;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
			display: flex;
			flex-direction: column;
			justify-content: space-between;
		}

		.modal_text {
			font-size: 20px;
			text-align: center;
			margin-bottom: 10px;
		}

		.modal_btn {
			display: flex;
			justify-content: space-between;
			padding: 10px;
		}

		.c_btn {
			padding: 7px 15px;
			border-radius: 5px;
			cursor: pointer;
			font-size: 14px;
		}

		.c_btn.danger {
			color: #bd0303;
			background-color: rgba(255, 0, 0, 0.5);
			border: 1px solid #bd0303;
		}

		.c_btn.success {
			color: green;
			background-color: rgba(0, 128, 0, 0.5);
			border: 1px solid green;
		}

		.c_btn.close {
			background-color: #ccc;
			border: 1px solid #999;
			color: #333;
		}

		.position a{
			text-decoration: underline;
		}
		.button-container {
			display: flex;
			justify-content: center; 
		}

		.button-container button {
			flex: 1 1 auto; 
			min-width: 30px;
			max-width: 50px;
			overflow: hidden;
			white-space: nowrap;
			text-overflow: ellipsis; 
			height: 40px; 
			font-size: 14px;
		}

	</style>

	<!--Topbar -->
	<div class="transition admin_top_nav">
		<div class="bars">
			<div class="hdd-text mx-4 mt-3 fs-2">
				<h4 class="" style="color: #00044B;">University of Ilorin Admin Dashbaord</h4>
			</div>
		</div>

		<div class="bars flex-bar">
			<div class="menu mx-5 ">
				<ul class="mx-5">
					<li class="nav-item dropdown">
						<a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
							aria-expanded="false">
							<img src="./assets/images/avatar/avatar-1.png" alt="">
							<b><?php echo htmlspecialchars($_SESSION['admin_id']) ?></b>
						</a>
					</li>
				</ul>
			</div>

			<?php 
				if ( !empty($adminRole) && $adminRole === 'sup_admin'){
			?>
				<button type="button" class="btn transition" id="admin_sidebar_toggle">
					<i class="fa fa-bars"></i>
				</button>
				<!-- Admin side bar -->
				<div id="admin_sidebar" class="admin_sidebar">
					<ul>
						<li><a href="" id="btn-all">All Applicant</a></li>
						<li><a href="" id="btn-add">Add Applicant</a></li>
						<li><a href="" id="btn-create">Create Admin</a></li>
					</ul>
				</div>
			<?php } ?>
		</div>

	</div>

	<div id="app-data" data-applications='<?php echo json_encode($jsArrayOutput); ?>'></div>
	
	<div class="main">

		<!-- Sorted Applicant -->
		<div id="sort_applicant" style="display:block">
			<div class="content-start transition">
				<div id="dashboard" class="row">
					<div id="query-navbar" class="col-12">
						<p>This will be query slot</p>
					</div>

					<div class="container-fluid">
						<div class="row flex1">
							<div class="col-md-6 col-lg-3">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-5 d-flex align-items-center">
												<svg width="30" height="30" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="..." fill="#2BC155"></path>
												</svg>
											</div>
											<div class="col-7">
												<p class="text-light">Application Submitted</p>
												<h5 class="text-light">
													<?php echo isset($totalcount) ? $totalcount : 0; ?>
												</h5>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-lg-3">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-4 d-flex align-items-center">
												<svg width="30" height="30" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="..." fill="#FF9B52"></path>
												</svg>
											</div>
											<div class="col-8">
												<p class="text-light">Users</p>
												<h5 class="text-light">
													<?php echo isset($totalSingupUsers) ? $totalSingupUsers : 0; ?>
												</h5>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-lg-3">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-4 d-flex align-items-center">
												<svg width="30" height="30" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="..." fill="#3F9AE0"></path>
												</svg>
											</div>
											<div class="col-8">
												<p class="text-light">Approved Applicants</p>
												<h5 class="text-light">
													<?php echo isset($totalgender['Male']) ? $totalgender['Male'] : 0; ?>
												</h5>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-lg-3">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-4 d-flex align-items-center">
												<i class="fas fa-id-card icon-home bg-warning text-light"></i>
											</div>
											<div class="col-8">
												<p class="text-light">Not Approved</p>
												<h5 class="text-light">
													<?php echo isset($totalgender['Female']) ? $totalgender['Female'] : 0; ?>
												</h5>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Chart -->
						<!-- <div class="col-md-8 mx-auto">
							<canvas id="myChart" style="width: 100%;"></canvas>
						</div> -->
					</div>
				</div>

				<div id="content">
					<?php include_once('./include/botAI.php'); ?>
					<?php 
					$index = 0;
					foreach ($allApplicant as $key => $applicant) {
						renderPositionSection($key, $applicant, $index);
						$index++; // Increment index after each iteration
					}
					?>
				</div>

				
			</div>
		</div>


		<?php if(!empty($adminRole) && $adminRole === 'sup_admin'){	?>
			<!-- Add Applicant -->
			<div id="add_applicant" style="display: none;">
				<div class="db-winscroll">
					<div id="db-panel">
						<div class="body-panel">
							<div class="head-panel">
								<svg id="close_panel" onclick="closePanelHandler" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><g fill="none" stroke="var(--main-color-light)" stroke-dasharray="16" stroke-dashoffset="16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7l10 10"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.4s" values="16;0"/></path><path d="M17 7l-10 10"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.4s" dur="0.4s" values="16;0"/></path></g></svg>
							</div>
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
			</div>

			<!-- Create admin -->
			<div id="create_admin" style="display: none;">
				<?php include_once('./include/createAdmin.php') ?>
			</div>
		<?php } ?>
	
	</div>
	
	<!-- Footer -->
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


	
	<!-- JS Libraies -->
	<script src="assets/modules/jquery/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<!-- Template JS File -->
	<script src="assets/js/script.js"></script>
	<script type="module" src="../scripts/main.js"></script>

</body>

</html>