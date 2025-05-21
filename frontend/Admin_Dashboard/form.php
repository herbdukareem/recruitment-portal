<?php include_once('./Backend/editSession-hook.php') ?>
<?php $form = true ?>
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