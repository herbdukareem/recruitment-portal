<?php
	session_start();
	include_once('../db_connect.php');

	// error_reporting(E_ERROR | E_PARSE); // Only show critical errors
	// ini_set('display_errors', 0);

	$admin_unid = $_SESSION['admin_unid'];

	//Check if the user is logged in
	if (!isset($_SESSION['admin_unid'])) {
		// Redirect to login page if not logged in
		header("Location: ./auth.php");
		exit();
	}

	$positions = [
		"Administrative Cadre",
		"Executive Officer Cadre",
		"Clerical Officer Cadre",
		"Secretarial Cadre",
		"Secretarial Assistant Cadre",
		"Porter",
		"Office Assistant Cadre",
		"Accountant Cadre",
		"Executive Officer (Accounts) Cadre",
		"Stores Officers' Cadre",
		"Store Attendant",
		"Internal Auditors' Cadre",
		"Executive Officer (Audit) Cadre",
		"Information Officer Cadre",
		"Protocol Officer Cadre",
		"Photographer Cadre",
		"Video Camera Operator Cadre",
		"Information Assistant Cadre",
		"Executive Officer (Information) Cadre",
		"Doctors Cadre",
		"Pharmacists Cadre",
		"Nursing Officer Cadre",
		"Pharmacy Technician Cadre",
		"Medical Laboratory Technologist Cadre",
		"Medical Laboratory Technician Cadre",
		"Medical Laboratory Assistant Cadre",
		"Health Records Officer",
		"Environmental Health Officer Cadre",
		"Veterinary Officer Cadre",
		"Legal Officer Cadre",
		"Library Officer Cadre",
		"Library Assistant Cadre",
		"Bindery Officers' Cadre",
		"Bindery Assistant Cadre",
		"Data Operator/I.T. Operator Cadre",
		"Data Analyst Cadre",
		"Computer Electronics Engineer Cadre",
		"Systems Programmer/Analyst Cadre",
		"Director, COMSIT",
		"Engineer Cadre",
		"Architect Cadre",
		"Quantity Surveyor Cadre",
		"Physical Planning Unit",
		"Maintenance Officer",
		"Workshop Attendant/Assistant/Superintendent Cadre",
		"Driver Cadre",
		"Driver/Mechanic Cadre",
		"Craftsman (Carpentry & Mason, Welding, Plumbing, Electrical, R&G, Mechanical, etc.)",
		"Technical Officer Cadre",
		"Artisan/Craftsman",
		"Power Station Operator Cadre",
		"Horticulturist Cadre (Parks & Gardens)",
		"Estate Officers' Cadre",
		"Gardening Staff (Biological and Parks & Gardens Units)",
		"Turnstile Keeper Cadre",
		"Zoo Keeper Cadre",
		"Curator Cadre",
		"Farm Officer/Manager",
		"Agricultural/Animal Health/Forestry Superintendent Cadre",
		"Technologist Cadre",
		"Laboratory Supervisor",
		"Staff School Cadre I (Lower Basic)",
		"Staff School Cadre II (Upper Basic)",
		"Security Cadre",
		"Planning Officer Cadre",
		"Coach Cadre",
		"Coordinator Cadre (SIWES)",
		"Counsellor Cadre",
		"Signer (Interpreter) Cadre",
		"Archives Assistant Cadre",
		"Archives' Officer Cadre",
		"Archivist Cadre",
		"Graphic Arts Assistant Cadre",
		"Graphic Arts Officers' Cadre",
		"Cook/Steward/Catering Officer Cadre",
		"Laundry Cadre",
		"Fireman Cadre",
		"Fire Superintendent Cadre - 120",
		"Fire Officer Cadre - 122",
	];
	$positionData = []; // Initialize an array to hold data for all positions


	//Get position and users data that apply for the position
	//Get position and users data that apply for the position
	//Get position and users data that apply for the position
	foreach ($positions as $position) {
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
				w.role, 
				w.responsibilities, 
				w.startDate, 
				w.endDate, 
				p.bodyName,
				p.membershipID, 
				p.membershipResposibilities, 
				p.certificateDate
			FROM user_applications AS b
			JOIN users AS u ON b.user_id = u.id
			JOIN user_education_details AS e ON u.id = e.user_id
			JOIN user_pmc_details AS p ON u.id = p.user_id
			JOIN user_work_details AS w ON u.id = w.user_id
			WHERE b.position = :position
		');

		$fetchData->execute(['position' => $position]);
		$positionData[$position] = $fetchData->fetchAll(PDO::FETCH_ASSOC); // Store results in the array
	};


	//for total number of Application Submitted
	//for total number of Application Submitted
	//for total number of Application Submitted
	// Prepare and execute the count query
	$totalcount = 0;
	foreach ($positions as $position){
		$countQuery = $pdo->prepare('
			SELECT COUNT(*) AS total_users
			FROM user_applications AS b
				JOIN users AS u ON b.user_id = u.id
				JOIN user_education_details AS e ON u.id = e.user_id
				JOIN user_pmc_details AS p ON u.id = p.user_id
				JOIN user_work_details AS w ON u.id = w.user_id
				WHERE b.position = :position
		');
		// Execute the query with the current position
		$countQuery->execute(['position' => $position]);

		// Fetch the total count for the current position
		$totalCountForPosition = $countQuery->fetchColumn(); 
		$totalApplications[$position] = $totalCountForPosition; // Store count for current position

		$totalcount += $totalCountForPosition;
	};



	//Gender count for selected position 
	//Gender count for selected position 
	//Gender count for selected position 
	$genders = ['Male', 'Female'];
	$totalGenderCount = [];

	foreach ($positions as $position) {
		foreach ($genders as $gender) {
			// Prepare the query to count based on gender and position
			$countGenderQuery = $pdo->prepare('
				SELECT COUNT(*) AS total_gender
				FROM user_applications AS b
				JOIN users AS u ON b.user_id = u.id
				WHERE b.gender = :gender AND b.position = :position
			');

			// Execute the query with the current gender and position
			$countGenderQuery->execute([
				'gender' => $gender,
				'position' => $position // Looping through all positions
			]);

			// Store the count for the current gender and position
			$totalGenderCount[$position][$gender] = $countGenderQuery->fetchColumn();
		}
	}




	//for total number of Gender Applicant
	//for total number of Gender Applicant
	//for total number of Gender Applicant
	// Prepare and execute the count query
	foreach ($genders as $gender){
		$countGendertQuery = $pdo->prepare('
			SELECT COUNT(*) AS total_gender
			FROM user_applications AS b
				WHERE b.gender = :gender
		');
		// Execute the query with the current position
		$countGendertQuery->execute(['gender' => $gender]);
		$totalgender[$gender] =$countGendertQuery->fetchColumn();  // Store count for current position
	};

	//for all user that signup
	//for all user that signup
	//for all user that signup N
	// Prepare and execute the count query
	$countSignupUsersQuery = $pdo->prepare('
		SELECT COUNT(*)
		FROM users AS u
	');
	$countSignupUsersQuery->execute();
	$totalSingupUsers = $countSignupUsersQuery->fetchColumn(); // Get the total count





?>
<!doctype html>
<html lang="en">

<head>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dashboard - UNILORIN</title>
	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="assets/modules/bootstrap-5.1.3/css/bootstrap.css">
	<!-- Style CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- FontAwesome CSS-->
	<link rel="stylesheet" href="assets/modules/fontawesome6.1.1/css/all.css">
	<!-- Boxicons CSS-->
	<link rel="stylesheet" href="assets/modules/boxicons/css/boxicons.min.css">
	<!-- Apexcharts  CSS -->
	<link rel="stylesheet" href="assets/modules/apexcharts/apexcharts.css">
    <link rel="shortcut icon" href="../images/logo-plain.jpeg.jpg" type="image/x-icon">


	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	

</head>
<body>
<style>
	.admin_top_nav{
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	.position{
		display: none;
	}
    .details-row {
        display: none;
    }
</style>
	<!--Topbar -->
	<div class="topbar transition admin_top_nav">
		<div class="bars">
			<button type="button" class="btn transition" id="sidebar-toggle">
				<i class="fa fa-bars"></i>
			</button>
		</div>
		<div class="bars">
			<div class="hdd-text mx-4 mt-3 fs-2">
				<h4 class="">University of Ilorin Admin Dashbaord</h4>
			</div>

			<div class="menu mx-5 ">

				<ul class="mx-5">
					<li class="nav-item dropdown">
						<a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
							aria-expanded="false">
							<img src="assets/images/avatar/avatar-1.png" alt="">
							<b><?php echo htmlspecialchars($_SESSION['admin_id']) ?></b>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<!--Sidebar-->
	<?php include_once('sidebar.php') ?>
	<div class="sidebar-overlay"></div>

	<!--Content Start-->
	<div class="content-start transition">
		<div class="container-fluid dashboard">
			

			<!-- dashboard -->
			<div id="dashboard" class="position row" style="display: flex;">
				<div class="card-header">
					<h1>Dashboard</h1>
					<p></p>
				</div>

				<div class="col-md-6 col-lg-3">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-5 d-flex align-items-center">
									<svg width="30" height="30" viewBox="0 0 42 42" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path
											d="M38.4998 10.4995H35.0002V38.4999H38.4998C40.4245 38.4999 42 36.9238 42 34.9992V13.9992C42 12.075 40.4245 10.4995 38.4998 10.4995Z"
											fill="#2BC155"></path>
										<path
											d="M27.9998 10.4995V6.9998C27.9998 5.07515 26.4243 3.49963 24.5001 3.49963H17.4998C15.5757 3.49963 14.0001 5.07515 14.0001 6.9998V10.4995H10.5V38.4998H31.5V10.4995H27.9998ZM24.5001 10.4995H17.4998V6.99929H24.5001V10.4995Z"
											fill="#2BC155"></path>
										<path
											d="M3.50017 10.4995C1.57551 10.4995 0 12.075 0 13.9997V34.9997C0 36.9243 1.57551 38.5004 3.50017 38.5004H6.99983V10.4995H3.50017Z"
											fill="#2BC155"></path>
									</svg>
								</div>
								<div class="col-7">
									<p class="text-light">Application Submitted</p>
									<h5 class="text-light"><?php echo $totalcount ?></h5>
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
									<svg width="30" height="30" viewBox="0 0 42 42" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd"
											d="M15.1812 22.0083C15.0651 21.9063 14.7969 21.6695 14.7015 21.5799C12.3755 19.3941 10.8517 15.9712 10.8517 12.1138C10.8517 5.37813 15.4869 0.0410156 21.0011 0.0410156C26.5152 0.0410156 31.1503 5.37813 31.1503 12.1138C31.1503 15.9679 29.6292 19.3884 27.3094 21.5778C27.2118 21.6699 26.9385 21.9116 26.8238 22.0125L26.8139 22.1799C26.8789 23.1847 27.5541 24.0553 28.5233 24.3626C35.7277 26.641 40.9507 32.0853 41.8277 38.538C41.9484 39.3988 41.6902 40.2696 41.1198 40.9254C40.5495 41.5813 39.723 41.9579 38.8541 41.9579C32.4956 41.9591 9.50675 41.9591 3.14821 41.9591C2.27873 41.9591 1.45183 41.5824 0.881272 40.9263C0.310711 40.2701 0.0524068 39.3989 0.172348 38.5437C1.05148 32.0851 6.27447 26.641 13.4778 24.3628C14.4504 24.0544 15.1263 23.1802 15.1885 22.1722L15.1812 22.0083Z"
											fill="#FF9B52"></path>
									</svg>
								</div>
								<div class="col-8">
									<p class="text-light">Users</p>
									<h5 class="text-light"><?php echo $totalSingupUsers ?></h5>
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
									<svg width="30" height="30" viewBox="0 0 42 42" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path
											d="M33.25 8.75H31.5V5.25C31.5 4.78587 31.3156 4.34075 30.9874 4.01256C30.6593 3.68437 30.2141 3.5 29.75 3.5C29.2859 3.5 28.8407 3.68437 28.5126 4.01256C28.1844 4.34075 28 4.78587 28 5.25V8.75H14V5.25C14 4.78587 13.8156 4.34075 13.4874 4.01256C13.1592 3.68437 12.7141 3.5 12.25 3.5C11.7859 3.5 11.3408 3.68437 11.0126 4.01256C10.6844 4.34075 10.5 4.78587 10.5 5.25V8.75H8.75C7.35761 8.75 6.02226 9.30312 5.03769 10.2877C4.05312 11.2723 3.5 12.6076 3.5 14V15.75H38.5V14C38.5 12.6076 37.9469 11.2723 36.9623 10.2877C35.9777 9.30312 34.6424 8.75 33.25 8.75Z"
											fill="#3F9AE0"></path>
										<path
											d="M3.5 33.25C3.5 34.6424 4.05312 35.9777 5.03769 36.9623C6.02226 37.9469 7.35761 38.5 8.75 38.5H33.25C34.6424 38.5 35.9777 37.9469 36.9623 36.9623C37.9469 35.9777 38.5 34.6424 38.5 33.25V19.25H3.5V33.25Z"
											fill="#3F9AE0"></path>
									</svg>
								</div>
								<div class="col-8">
									<p class="text-light"> Approved Applicant</p>
									<h5 class="text-light"><?php echo $totalgender['Male'] ?></h5>
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
									<i class="fas fa-id-card  icon-home bg-warning text-light"></i>
								</div>
								<div class="col-8">
									<p class="text-light">Not Approved</p>
									<h5 class="text-light"><?php echo $totalgender['Female'] ?></h5>
								</div>
							</div>
						</div>
					</div>

				</div>
				


				

				<div class="col-md-8 mx-auto"> <!-- Adjust the column size as needed -->
					<canvas id="myChart"></canvas>
				</div>

				

			</div>
			<div id="content"></div>
			<?php include_once('botAI.php') ?>
			<?php
			// Example of calling the function for different positions
			//  Administrative Cadre
			renderPositionSection('Administrative_Cadre', 'Administrative Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Executive_Officer_Cadre', 'Executive Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Clerical_Officer_Cadre', 'Clerical Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Secretarial_Cadre', 'Secretarial Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Secretarial_Assistant_Cadre', 'Secretarial Assistant Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Porter', 'Porter', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Office_Assistant_Cadre', 'Office Assistant Cadre', $totalApplications, $totalGenderCount, $positionData);

			// Bursary
			renderPositionSection('Accountant_Cadre', 'Accountant Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Executive_Officer_(Accounts)_Cadre', 'Executive Officer (Accounts) Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Stores_Officers_Cadre', 'Stores Officers\' Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Store_Attendant', 'Store Attendant', $totalApplications, $totalGenderCount, $positionData);

			// Internal Audit Unit
			renderPositionSection('Internal_Auditors_Cadre', 'Internal Auditors\' Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Executive_Officer_(Audit)_Cadre', 'Executive Officer (Audit) Cadre', $totalApplications, $totalGenderCount, $positionData);
			
			
			// Internal Audit Unit
			renderPositionSection('Information_Officer_Cadre', 'Information Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Protocol_Officer_Cadre', 'Protocol Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Photographer_Cadre', 'Photographer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Video_Camera_Operator_Cadre', 'Video Camera Operator Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Information_Assistant_Cadre', 'Information Assistant Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Executive_Officer_(Information)_Cadre', 'Executive Officer (Information) Cadre', $totalApplications, $totalGenderCount, $positionData);

			// Health Services
			renderPositionSection('Doctors_Cadre', 'Doctors Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Pharmacists_Cadre', 'Pharmacists Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Nursing_Officer_Cadre', 'Nursing Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Pharmacy_Technician_Cadre', 'Pharmacy Technician Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Medical_Laboratory_Technologist_Cadre', 'Medical Laboratory Technologist Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Medical_Laboratory_Technician_Cadre', 'Medical Laboratory Technician Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Medical_Laboratory_Assistant_Cadre', 'Medical Laboratory Assistant Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Health_Records_Office', 'Health Records Officer', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Environmental_Health_Officer_Cadre', 'Environmental Health Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Veterinary_Officer_Cadre', 'Veterinary Officer Cadre', $totalApplications, $totalGenderCount, $positionData);

			// Legal Unit
			renderPositionSection('Legal_Officer_Cadre', 'Legal Officer Cadre', $totalApplications, $totalGenderCount, $positionData);

			// University Library
			renderPositionSection('Library_Officer_Cadre', 'Library Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Library_Assistant_Cadre', 'Library Assistant Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Bindery_Officers_Cadre', 'Bindery Officers\' Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Bindery_Assistant_Cadre', 'Bindery Assistant Cadre', $totalApplications, $totalGenderCount, $positionData);


			// Directorate of COMSIT
			renderPositionSection('Data_Operator_IT_Operator_Cadre', 'Data Operator/I.T. Operator Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Data_Analyst_Cadre', 'Data Analyst Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Computer_Electronics_Engineer_Cadre', 'Computer Electronics Engineer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Systems_Programmer/Analyst_Cadre', 'Systems Programmer/Analyst Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Director_COMSIT', 'Director, COMSIT', $totalApplications, $totalGenderCount, $positionData);

			// Works Unit
			renderPositionSection('Engineer_Cadre', 'Engineer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Architect_Cadre', 'Architect Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Quantity_Surveyor_Cadre', 'Quantity Surveyor Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Physical_Planning_Unit', 'Physical Planning Unit', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Maintenance_Officer', 'Maintenance Officer', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Workshop_Attendant/Assistant/Superintendent_Cadre', 'Workshop Attendant/Assistant/Superintendent Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Driver_Cadre', 'Driver Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Driver/Mechanic_Cadre', 'Driver/Mechanic Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Craftsman', 'Craftsman (Carpentry & Mason, Welding, Plumbing, Electrical, R&G, Mechanical, etc.)', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Technical_Officer_Cadre', 'Technical Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Artisan/Craftsman', 'Artisan/Craftsman', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Power_Station_Operator_Cadre', 'Power Station Operator Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Horticulturist_Cadre', 'Horticulturist Cadre (Parks & Gardens)', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Estate_Officers_Cadre', 'Estate Officers\' Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Gardening_Staff', 'Gardening Staff (Biological and Parks & Gardens Units)', $totalApplications, $totalGenderCount, $positionData);

			//  Zoo/Biological Garden
			renderPositionSection('Turnstile_Keeper_Cadre', 'Turnstile Keeper Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Zoo_Keeper_Cadre', 'Zoo Keeper Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Curator_Cadre', 'Curator Cadre', $totalApplications, $totalGenderCount, $positionData);


			// University Farm
			renderPositionSection('Farm_Officer', 'Farm Officer/Manager', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Agricultural_Animal_Health_Forestry_Superintendent_Cadre', 'Agricultural/Animal Health/Forestry Superintendent Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Livestock_Supervisor', 'Farm/Livestock Supervisor', $totalApplications, $totalGenderCount, $positionData);

			// Laboratory
			renderPositionSection('Technologist_Cadre', 'Technologist Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Laboratory_Supervisor', 'Laboratory Supervisor', $totalApplications, $totalGenderCount, $positionData);

			// University School
			renderPositionSection('Staff_School_Cadre_I', 'Staff School Cadre I (Lower Basic)', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Staff_School_Cadre_II', 'Staff School Cadre II (Upper Basic)', $totalApplications, $totalGenderCount, $positionData);

			// Directorate of Security
			renderPositionSection('Security_Cadre', 'Security Cadre', $totalApplications, $totalGenderCount, $positionData);

			// Academic Planning Unit
			renderPositionSection('Planning_Officer_Cadre', 'Planning Officer Cadre', $totalApplications, $totalGenderCount, $positionData);

			// Sport
			renderPositionSection('Coach_Cadre', 'Coach Cadre', $totalApplications, $totalGenderCount, $positionData);

			// SIWES
			renderPositionSection('Coordinator_Cadre', 'Coordinator Cadre (SIWES)', $totalApplications, $totalGenderCount, $positionData);

			// Counselling Center
			renderPositionSection('Counsellor_Cadre', 'Counsellor Cadre', $totalApplications, $totalGenderCount, $positionData);

			// Centre for Supportive Services
			renderPositionSection('Signer_Cadre', 'Signer (Interpreter) Cadre', $totalApplications, $totalGenderCount, $positionData);

			// Archives Centre
			renderPositionSection('Archives_Assistant_Cadre', 'Archives Assistant Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Archives_Officer_Cadre', 'Archives\' Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Archivist_Cadre', 'Archivist Cadre', $totalApplications, $totalGenderCount, $positionData);

			// Educational Technology
			renderPositionSection('Graphic_Arts_Assistant_Cadre', 'Graphic Arts Assistant Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Graphic_Arts_Officers_Cadre', 'Graphic Arts Officers\' Cadre', $totalApplications, $totalGenderCount, $positionData);
			
			// Guest Houses
			renderPositionSection('Cook_Steward_Catering_Officer_Cadre', 'Cook/Steward/Catering Officer Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Laundry_Cadre', 'Laundry Cadre', $totalApplications, $totalGenderCount, $positionData);

			// Fire Services
			renderPositionSection('Fireman_Cadre', 'Fireman Cadre', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Fire_Superintendent_Cadre', 'Fire Superintendent Cadre - 120', $totalApplications, $totalGenderCount, $positionData);
			renderPositionSection('Fire_Officer_Cadre', 'Fire Officer Cadre - 122', $totalApplications, $totalGenderCount, $positionData);
			// Add more calls as needed
			?>

			
			
		</div>
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
	<script src="assets/modules/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
	<script src="assets/modules/popper/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


	<!-- Template JS File -->
	<script src="assets/js/script.js"></script>
	<script src="assets/js/custom.js"></script>
</body>

</html>