<?php
   
    
	if (isset($user_id)) {
        // Fetch user firstname and lastname from the database using user ID
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $user_names = $stmt->fetch(PDO::FETCH_ASSOC);


		// Fetch user data for display in the form after saving
		$fetchUserData = $pdo->prepare("SELECT * FROM user_applications WHERE user_id = :user_id");
		$fetchUserData->execute(['user_id' => $user_id]);
		$user_data = $fetchUserData->fetch(PDO::FETCH_ASSOC);

		// Fetch user Education Detials for display in the form after saving
		$fetchUserEducationData = $pdo->prepare("SELECT * FROM user_education_details WHERE user_id = :user_id");
		$fetchUserEducationData->execute(['user_id' => $user_id]);
		$user_edu_data = $fetchUserEducationData->fetch(PDO::FETCH_ASSOC);

		// Fetch user Education Detials for display in the form after saving
		$fetchUserWorkData = $pdo->prepare("SELECT * FROM user_work_details WHERE user_id = :user_id");
		$fetchUserWorkData->execute(['user_id' => $user_id]);
		$user_work_data = $fetchUserWorkData->fetch(PDO::FETCH_ASSOC);

		$fetchUserPMCData = $pdo->prepare("SELECT * FROM user_pmc_details WHERE user_id = :user_id");
		$fetchUserPMCData->execute(['user_id' => $user_id]);
		$user_pmc_data = $fetchUserPMCData->fetch(PDO::FETCH_ASSOC);
		//Fetching user score from DB
		$fetchUserQuizScore = $pdo->prepare("SELECT * FROM quiz_scores WHERE user_id = :user_id");
		$fetchUserQuizScore->execute(['user_id' => $user_id]);
		$userQuizScore = $fetchUserQuizScore->fetch(PDO::FETCH_ASSOC);

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
	}
?>
<?php include_once('./Backend/editSession-hook.php') ?>
<?php include_once('./Backend/editFetch-hook.php') ?>
<?php include_once('./Backend/backend-hook.php') ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=in, initial-scale=1.0">
    <title>Document</title>
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
</head>
<body>
    <div id="add_applicant">
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
	<script type="module" src="../scripts/main.js"></script>
</body>
</html>