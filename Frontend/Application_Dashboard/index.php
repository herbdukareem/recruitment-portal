
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
	<script src="../scripts/alert.js"></script>
    <script>

		let adminRole;
	
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
						'Authorization': `Bearer ${localStorage.getItem('csrf_token') || ''}`
					}
				});
		
				console.log('Session check response status:', response.status); // Debug log
		
				// Handle 401 Unauthorized
				if (response.status === 401) {
					console.warn('Session expired or invalid - performing full cleanup');
					
					// Clear all authentication-related data
					localStorage.removeItem('csrf_token');
					sessionStorage.removeItem('session_valid');
					
					// Clear cookies
					document.cookie = 'PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
					
					// Redirect with cache busting and force login display
					window.location.href = './Auth/auth.php?display=login&nocache=' + Date.now();
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
					window.location.href = './Auth/auth.php?display=login';
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
			
			// PMC form
			document.getElementById('proficiencyTestForm').addEventListener('submit', async (e) => {
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
					showAlert('dashboard_alert_con', data.message, 'success');
					user_id = data.user_id
					localStorage.setItem('userID', user_id)
					if (data.next) {
						setTimeout(() => {
							this.navigateToStep(data.next);
						}, 5200);
					}
				} else {
					showAlert('dashboard_alert_con', data.error || 'Submission failed', 'danger');
				}
			} catch (error) {
				console.error('Form submission error:', error);
				showAlert('dashboard_alert_con', 'Network error', 'danger');
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
		
		function renderNavListBtn() {
			const profTestBtn = document.getElementById('prof_test');
			let form = true;

			if (!form) {
				profTestBtn.innerHTML = `
					 <button id="cpl-btn" class="all-bt-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                            <path fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" d="M38.5 5.5h-29c-2.2 0-4 1.8-4 4v29c0 2.2 1.8 4 4 4h29c2.2 0 4-1.8 4-4v-29c0-2.2-1.8-4-4-4" stroke-width="1"/><path fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" d="M34.3 35.9L24 30.5l-10.3 5.4V19L24 12.1L34.3 19zM24 12.1v18.4z" stroke-width="1"/>
                        </svg>
                        CPL Test
                    </button>
				`;
			}
		}

		let user_profile;
		let user_data;

		// AJAX call to fetch user data
		const fetchUserProfile = async () => {
			// console.log(user_id);
			try {
				const user_id = localStorage.getItem('userID');

				const response = await fetch(`/test/backend/user/data?user_id=${user_id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('csrf_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				user_profile = await response.json();
				console.log(user_profile)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		const fetchUserData = async () => {
			// console.log(user_id);
			try {
				const user_id = localStorage.getItem('userID');

				const response = await fetch(`/test/backend/user/bio?user_id=${user_id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('csrf_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				user_data = await response.json();
				console.log(user_data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		function populateUserData(user_data, user_profile) {
			// Position selects (you'll need to set these based on your data)
			document.getElementById('positionType').value = user_data.positionType || '';
			document.getElementById('supPosition').value = user_data.supPosition || '';
			document.getElementById('position').value = user_data.position || '';
			
			// Basic info
			document.querySelector('input[name="firstname"]').value = user_profile.firstname || '';
			document.querySelector('input[name="middlename"]').value = user_data.middlename || '';
			document.querySelector('input[name="lastname"]').value = user_profile.lastname || '';
			
			// Email and password (if applicable)
			if (user_names.email) {
				document.querySelector('input[name="email"]').value = user_profile.email || '';
				document.querySelector('input[name="password"]').value = '';
			}
			
			// Personal details
			document.querySelector('select[name="gender"]').value = user_data.gender || '';
			document.querySelector('input[name="dateOfBirth"]').value = user_data.dateOfBirth || '';
			document.querySelector('select[name="maritalStatus"]').value = user_data.maritalStatus || '';
			
			// Location info
			document.getElementById('state').value = user_data.stateOfOrigin || '';
			// You'll need to populate LGA based on state selection
			document.getElementById('lga').value = user_data.lga || '';
			
			// Identification
			document.querySelector('input[name="nin"]').value = user_data.nin || '';
			
			// Contact info
			document.querySelector('input[name="phoneNumber"]').value = user_data.phoneNumber || '';
			document.querySelector('input[name="emergencyNumber"]').value = user_data.emergencyNumber || '';
			document.querySelector('input[name="address"]').value = user_data.address || '';
			
			// Note: For file inputs, you can't set the value directly due to security restrictions
			// You might want to display the existing filenames differently
		}

		// Initialize when DOM is loaded
		document.addEventListener('DOMContentLoaded', () => {
			checkSession();
			fetchUserProfile();
			fetchUserData();
			populateUserData();
			setupFormHandlers();
			renderNavListBtn();
			
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
                <p id="user_profile">
					<!-- Populate with JS -->
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
            <div id="dashboard_alert_con" ></div>
            <?php
                include_once('../pages/biodata.php');
                include_once('../pages/education.php');
                include_once('../pages/work.php');
                include_once('../pages/pmc.php');
                include_once('../pages/summary.php');

                // Ensure quiz score does not exist before showing proficiency page
				include_once('../pages/proficiency.php');
				include_once('../pages/application_status.php');
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