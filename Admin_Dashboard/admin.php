<?php include_once('./Backend/session-hook.php') ?>
<?php include_once('./Backend/backend-hook.php') ?>
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
		 .modal {
			display: none;
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
		}
		.modal-content {
			background-color: white;
			margin: 15% auto;
			padding: 20px;
			border-radius: 10px;
			width: 50%;
			text-align: center;
		}
		.close {
			float: right;
			font-size: 20px;
			font-weight: bold;
			cursor: pointer;
		}
		.btn {
			padding: 10px 20px;
			border: none;
			cursor: pointer;
		}
		.btn-success {
			background-color: green;
			color: white;
		}
		.btn-danger {
			background-color: red;
			color: white;
		}
	</style>
	<!--Topbar -->
	<div class="transition admin_top_nav" style="padding: 0 10px;">
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
													<?php echo isset($columnCount) ? $columnCount : 0; ?>
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
												<p class="text-light">shortlisted Applicant</p>
												<h5 class="text-light">
													<?php echo isset($shortlistedCount) ? $shortlistedCount : 0; ?>
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
												<p class="text-light">Interviewed</p>
												<h5 class="text-light">
													<?php echo isset($interviewedCount) ? $interviewedCount : 0; ?>
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
												<p class="text-light">Unmployed</p>
												<h5 class="text-light">
													<?php echo isset($unemployedCount) ? $unemployedCount : 0; ?>
												</h5>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php echo $user_id ?>
				<!-- Search -->
				<div id="query-navbar" class="col-12">
					<form action="" method="post">
						<div>
							<select name="position" id="position">
								<option value="">--All Position--</option>
							</select>
						</div>
						<div>
							<select name="status" id="">
								<option value="">--All Status--</option>
								<option value="Interviewed">Interviewed</option>
								<option value="employed">Employed</option>
								<option value="shortlisted">shortlisted</option>
								<option value="declined">Declined</option>
							</select>
						</div>
						<div>
							<input type="text" name="nin" placeholder="NIN">
						</div>
						<div>
							<button style="padding:5px" name="search">
								<svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24"><path fill="#fff" fill-rule="evenodd" d="M10.44 2.75a7.69 7.69 0 1 0 4.615 13.842c.058.17.154.329.29.464l3.84 3.84a1.21 1.21 0 0 0 1.71-1.712l-3.84-3.84a1.2 1.2 0 0 0-.463-.289A7.69 7.69 0 0 0 10.44 2.75m-5.75 7.69a5.75 5.75 0 1 1 11.5 0a5.75 5.75 0 0 1-11.5 0" clip-rule="evenodd"/></svg>
							</button>
						</div>
						
					</form>
				</div>
				<div id="content">
					<?php include_once('./include/botAI.php'); ?>
					<?php 
						$index = 0;
						renderPositionSection($allApplicant, $index, $adminRole);
						$index++;
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


	<script>

		const position = [
			"Professor",
			"Associate Professor/Reader",
			"Lecturer I",
			"Lecturer II",
			"Assistant Lecturer",
			"Administrative Cadre",
			"Executive Officer Cadre",
			"Clerical Officer Cadre",
			"Secretarial Cadre",
			"Secretarial Assistant Cadre",
			"Portel",
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
			"Fireman Cadre",
			"Fire Superintendent Cadre - 120",
			"Fire Officer Cadre - 122",
		]
		// Get the select element
		const positionSelect = document.getElementById("position");

		// Populate the dropdown
		position.forEach(pos => {
			let option = document.createElement("option");
			option.value = pos; // Set the value
			option.textContent = pos; // Set the display text
			positionSelect.appendChild(option);
		});
	</script>
	<!-- JS Libraies -->
	<script src="assets/modules/jquery/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<!-- Template JS File -->
	<script src="assets/js/script.js"></script>
	<script type="module" src="../scripts/main.js"></script>

</body>

</html>