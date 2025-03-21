<?php
	session_start();
	include_once('../db_connect.php');

	error_reporting(E_ERROR | E_PARSE); // Only show critical errors
    ini_set('display_errors', 0);

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_login'])) {

		$admin_id = trim($_POST['admin_id']);
		$admin_password = trim($_POST['admin_password']);

		// Check for empty fields
		if (empty($admin_id) || empty($admin_password)) {
			$_SESSION['alert_message'] = "All fields are required.";
			$_SESSION['alert_type'] = "warning";
		}

		// Fetch admin details from the database
		$sql = "SELECT * FROM admins WHERE admin_id = :admin_id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":admin_id" => $admin_id]);
		$admin = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($admin) {
			if (password_verify($admin_password, $admin['admin_password'])) { // Fixed column name
				// Store admin details in session
				$_SESSION["admin_unid"] = $admin["id"];
				$_SESSION["admin_id"] = $admin["admin_id"];
				$_SESSION["admin_role"] = $admin["admin_role"];

				$_SESSION['alert_message'] = "Login successful!";
				$_SESSION['alert_type'] = "success";

				header("Location: admin.php"); // Redirect to admin dashboard
				exit();
			} else {
				$_SESSION['alert_message'] = "Incorrect password!";
				$_SESSION['alert_type'] = "danger";
			}
		} else {
			$_SESSION['alert_message'] = "Admin ID does not exist!";
			$_SESSION['alert_type'] = "danger";
		}
	}



?>


<!doctype html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login to Admin Page | University Of Ilorin</title>

	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="../style/alert.css">
    <link rel="shortcut icon" href="../images/logo-plain.jpg" type="image/x-icon">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<style>
	.lg {
		width: 250px;
		height: 250px;
		/* border: 1px solid white; */
		margin: auto;
		padding-top: 30%;
	}
</style>

<body>

	<div id="auth">

		<div class="row h-100">
			<div id="auth-left" class="col-lg-7 d-none d-lg-block">
				<div class="lg">
					<img class="img-fluid" src="../images/logo.png" alt="">
				</div>
			</div>
			<div id="auth-right" class="col-lg-5 col-12">
				<div class="auth-logo ">
					<a href="index.html" class="d-flex">
						<img src="../images/logo-plain.jpg"   alt="Logo">
						<h5 class="px-4 mt-1 fs-4">University of Ilorin Nigeria</h5>
					</a>
				</div>
				<!-- <div id="alert-con" class="alert"></div> -->
				<div id="admin_login" style="display: block;">
					
					<!-- <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p> -->

					<form method="post">
						<h1 class="auth-title fs-5">Log in As an Administartor</h1>
						<div class="form-group position-relative has-icon-left mb-4">
							<div class="form-control-icon">
								<div id="alert-con" 
									data-message="<?php echo htmlspecialchars($_SESSION['alert_message'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
									data-type="<?php echo htmlspecialchars($_SESSION['alert_type'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
								</div>
								<?php 
									// Clear session messages after loading
									unset($_SESSION['alert_message']);
									unset($_SESSION['alert_type']);
								?>
							</div>
						</div>
						<div class="form-group position-relative has-icon-left mb-4">
							<input type="text" class="form-control form-control-xl" placeholder="Username" name="admin_id">
							<div class="form-control-icon">
								<i class="bi bi-person"></i>
							</div>
						</div>
						<div class="form-group position-relative has-icon-left mb-4">
							<input type="password" class="form-control form-control-xl" placeholder="Password" name="admin_password">
							<div class="form-control-icon">
								<i class="bi bi-shield-lock"></i>
							</div>
						</div>
						<button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit" name="admin_login">Log in</button>
					</form>
					<div class="text-center mt-5 text-lg fs-4">
						<p class="text-gray-600">Don't have an account? <a href="auth-register.html"
								class="font-bold">Sign
								up</a>.</p>
						<p><a class="font-bold" href="" id="forgot_btn">Forgot password?</a>.</p>
					</div>
				</div>
				<div id="admin_forgot" style="display: none;">
					<h1 class="auth-title">Forgot Password.</h1>
					<p class="auth-subtitle mb-5">Input your email and we will send you reset password link.</p>
		
					<form action="">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit" name="admin_forgot_pass">Send</button>
					</form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Remember your account? <a href="" id="login_btn" class="font-bold">Log in</a>.
                        </p>
                    </div>
				</div>
			</div>

		</div>
	</div>

	<script>
		const loginPage = document.getElementById('admin_login');
		const forgotPage = document.getElementById('admin_forgot');
		const logBtn = document.getElementById('login_btn');
		const forgotBtn = document.getElementById('forgot_btn');

		logBtn.addEventListener('clcik', (e)=>{
			loginPage.style.display = "block";
			forgotPage.style.display = "none"
		});
		forgotBtn.addEventListener('clcik', (e)=>{
			loginPage.style.display = "none";
			forgotBtn.style.display = "block"
		});

	</script>
	<script type="module" src="../scripts/main.js"></script>

	<!-- Template JS File -->
	<script src="assets/js/script.js"></script>
	<script src="assets/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>