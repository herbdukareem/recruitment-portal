
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

    <script>

		let adminRole;
		let user_id;
		let user_data;
		let form;
	
		// let allApplicants = [];

		const checkSession = async () => {
			try {
				console.log('Initiating session check...');
				
				const response = await fetch('/test/backend/auth/user/session', {
					method: 'GET',
					credentials: 'include',
					headers: {
						'Content-Type': 'application/json',
						'X-Requested-With': 'XMLHttpRequest',
						'Authorization': `Bearer ${localStorage.getItem('admin_token') || ''}`
					}
				});
		
				console.log('Session check response status:', response.status); // Debug log
		
				// Handle 401 Unauthorized
				if (response.status === 401) {
					console.warn('Session expired or invalid - redirecting to login');
					localStorage.removeItem('admin_token');
					sessionStorage.removeItem('session_valid');
					window.location.href = './Auth/auth.php';
					return false;
				}
		
				// Handle other error statuses
				if (!response.ok) {
					const errorText = await response.text();
					throw new Error(`Server responded with ${response.status}: ${errorText}`);
				}
		
				const data = await response.json();

				console.log('Session check response data:', data);
		
				if (data.success && data.admin) {
					console.log('Session valid for admin:', data.admin.id); 
					this.currentUser = data.admin;
					sessionStorage.setItem('session_valid', 'true');
					// this.updateUI();
					return true;
				}
		
				console.warn('Session check failed - no valid admin data');
				return false;
				
			} catch (error) {
				console.error('Session check failed:', {
					error: error.message,
					stack: error.stack,
					timestamp: new Date().toISOString()
				});
				
				showAlert('dashboard_alert_con', 'Session verification failed. Please login again.', 'danger');
				
				// For network errors, don't redirect immediately - might be temporary
				if (error.name !== 'TypeError') {
					localStorage.removeItem('admin_token');
					window.location.href = 'auth.php';
				}
				
				return false;
			}
		};

		const setupFormHandlers = () => {
			// Biodata form
			document.getElementById('bioForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('bio', new FormData(e.target));
			});
			
			// Education form
			document.getElementById('eduForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('education', new FormData(e.target));
			});
			
			// Work history form
			document.getElementById('workForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('work', new FormData(e.target));
			});
			
			// PMC form
			document.getElementById('pmcForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('pmc', new FormData(e.target));
			});
			
			// File upload form
			document.getElementById('fileForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await uploadFiles(new FormData(e.target));
			});
		}

		const submitForm = async (endpoint, formData) => {
			try {
				const response = await fetch(`/test/backend/submit/${endpoint}`, {
					method: 'POST',
					body: JSON.stringify(Object.fromEntries(formData)),
					headers: {
						'Content-Type': 'application/json'
					}
				});
				
				const data = await response.json();
				
				if (data.success) {
					this.showAlert('alert-container-application', data.message, 'success');
					user_id = data.user_id
					localStorage.setItem('userID', user_id)
					if (data.next) {
						setTimeout(() => {
							this.navigateToStep(data.next);
						}, 5200);
					}
				} else {
					this.showAlert('alert-container-application', data.error || 'Submission failed', 'danger');
				}
			} catch (error) {
				console.error('Form submission error:', error);
				this.showAlert('alert-container-application', 'Network error', 'danger');
			}
		}

		const uploadFiles = async (formData) => {
			try {
				const response = await fetch('/backend/files', {
					method: 'POST',
					body: formData
				});
				
				const data = await response.json();
				
				if (data.success) {
					this.showSuccess(data.message);
					this.navigateToStep(data.next);
				} else {
					this.showError(data.error || 'File upload failed');
				}
			} catch (error) {
				console.error('File upload error:', error);
				this.showError('Network error');
			}
		}

		function navigateToStep(step) {
			try {
				// Validate step input
				if (typeof step !== 'string' || !step.trim()) {
					throw new Error('Invalid step parameter');
				}

				const formScreens = {
					"cpl": "cpl-screen",
					"bio": "biodata-screen",
					"edu": "education-screen",
					"work": "work-screen",
					"pmc": "pmc-screen",
					"sum": "summary-screen",
					"app-status": "application-status_screen"
				};

				const stepId = formScreens[step] || `${step}-screen`;
				const targetElement = document.getElementById(stepId);

				if (!targetElement) {
					console.error(`Element with ID '${stepId}' not found`);
					return false;
				}

				// Update URL hash without page jump (replaces PHP's header location)
				history.replaceState(null, null, `#${stepId}`);
				
				// Get all buttons and screens
				const buttons = Object.keys(formScreens)
					.map(key => document.getElementById(`${key}-btn`))
					.filter(btn => btn && getComputedStyle(btn).display !== "none");
				
				const screens = Object.values(formScreens)
					.map(id => document.getElementById(id))
					.filter(screen => screen);

				// Update UI
				buttons.forEach(btn => btn.style.background = "none");
				screens.forEach(screen => screen.style.display = "none");
				
				// Highlight active button and show target screen
				const activeBtn = document.getElementById(`${step}-btn`);
				if (activeBtn) activeBtn.style.background = "#bd911985";
				targetElement.style.display = "block";

				// Smooth scroll to element
				targetElement.scrollIntoView({
					behavior: 'smooth',
					block: 'start'
				});

				return true;
			} catch (error) {
				console.error('Error navigating to step:', error);
				return false;
			}
		}

		// Initialize when DOM is loaded
		document.addEventListener('DOMContentLoaded', () => {
			// Initialize functions
			checkSession();
			setupFormHandlers();
			
			// Form filtering setup
			const filterForm = document.getElementById('filterForm');

			if (filterForm) {
				const filterInputs = filterForm.querySelectorAll('select, input');
				
				// Real-time filtering with debounce
				filterInputs.forEach(input => {
				input.addEventListener('input', debounce(function() {
					loadApplicants();
				}, 300));
				});
				
				// Prevent default form submission
				filterForm.addEventListener('submit', function(e) {
					e.preventDefault();
					loadApplicants();
				});
			}

			// Event delegation for dynamic buttons
			document.addEventListener('click', (e) => {
				// View details button
				if (e.target.classList.contains('view-details-btn')) {
					const index = e.target.getAttribute('data-index');
					toggleDetails(index);
				}
				
				// Edit button
				if (e.target.classList.contains('edit-btn')) {
					const userId = e.target.getAttribute('data-user-id');
					handleEditApplicant(userId);
				}
			});
			
						
			
		});

	</script>
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
            <button id="logout">
                Log out
            </button>
        </div>
    </div>
	<script type="module" src="../scripts/main.js"></script>
	<script src="./script/logout.js"></script>

</body>


</html>