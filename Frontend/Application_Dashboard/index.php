
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

		// AJAX call to fetch user data
		const fetchUserProfile = async () => {
			try {
				const user_id = JSON.parse(localStorage.getItem('user'));
				const response = await fetch(`/test/backend/user/data?user_id=${user_id.id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('csrf_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				const data = await response.json();
				populateUserProfile(data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		};

		const fetchUserBio = async () => {
			try {
				const user_id = JSON.parse(localStorage.getItem('user'));
				const response = await fetch(`/test/backend/user/bio?user_id=${user_id.id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('csrf_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				const bio = await response.json();
				populateUserData(bio.data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		const fetchUserEducation = async () => {
			try {
				const user_id = JSON.parse(localStorage.getItem('user'));
				const response = await fetch(`/test/backend/user/education?user_id=${user_id.id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('csrf_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				const edu = await response.json();
				console.log(edu)
				populateUserEdu(edu.data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		const fetchUserWork = async () => {
			try {
				const user_id = JSON.parse(localStorage.getItem('user'));
				const response = await fetch(`/test/backend/user/work?user_id=${user_id.id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('csrf_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				const work = await response.json();
				console.log(work)
				populateUserWork(work.data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		const fetchUserPmc = async () => {
			try {
				const user_id = JSON.parse(localStorage.getItem('user'));
				const response = await fetch(`/test/backend/user/pmc?user_id=${user_id.id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('csrf_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				const pmc = await response.json();
				console.log(pmc)
				populateUserPmc(pmc.data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		const fetchUserSum = async () => {
			try {
				const user_id = JSON.parse(localStorage.getItem('user'));
				const response = await fetch(`/test/backend/user/summary?user_id=${user_id.id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('csrf_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				const sum = await response.json();
				console.log(sum)
				populateUserSum(sum.data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		function populateUserProfile(data) {
			const profile = document.getElementById('profile');

			if (!data) {
				profile.innerHTML = `
					<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
						<circle cx="18" cy="12" r="0" fill="#00045c">
							<animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/>
						</circle>
						<circle cx="12" cy="12" r="0" fill="#00045c">
							<animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/>
						</circle>
						<circle cx="6" cy="12" r="0" fill="#00045c">
							<animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/>
						</circle>
					</svg>
				`;
			} else {
				profile.innerText = `${data.data.firstname} ${data.data.lastname}`;
			}

		}

		function populateUserData(user_data) {
			document.getElementById('positionType').value = user_data.positionType || '';
			document.getElementById('supPosition').value = user_data.supPosition || '';
			document.getElementById('position').value = user_data.position || '';
			document.querySelector('input[name="firstname"]').value = user_data.firstname || '';
			document.querySelector('input[name="middlename"]').value = user_data.middlename || '';
			document.querySelector('input[name="lastname"]').value = user_data.lastname || '';
			if (user_data.email) {
				document.querySelector('input[name="email"]').value = user_data.email || '';
				document.querySelector('input[name="password"]').value = '';
			}
			document.querySelector('select[name="gender"]').value = user_data.gender || '';
			document.querySelector('input[name="dateOfBirth"]').value = user_data.dateOfBirth || '';
			document.querySelector('select[name="maritalStatus"]').value = user_data.maritalStatus || '';
			document.getElementById('state').value = user_data.stateOfOrigin || '';
			document.getElementById('lga').value = user_data.lga || '';
			document.querySelector('input[name="nin"]').value = user_data.nin || '';
			document.querySelector('input[name="phoneNumber"]').value = user_data.phoneNumber || '';
			document.querySelector('input[name="emergencyNumber"]').value = user_data.emergencyNumber || '';
			document.querySelector('input[name="address"]').value = user_data.address || '';
		}

		function populateUserEdu(edu) {
			document.getElementById('primary_school_name').value = edu.primary_school_name || '';
			document.getElementById('primary_graduation_year').value = edu.primary_graduation_year || '';
			document.getElementById('secondarySchoolName').value = edu.secondarySchoolName || '';
			document.getElementById('secondaryGraduationYear').value = edu.secondaryGraduationYear || '';
			document.getElementById('certificateType').value = edu.certificateType || '';
			document.getElementById('classOfDegree').value = edu.classOfDegree || '';
			document.getElementById('institution').value = edu.institution || '';
			document.getElementById('course').value = edu.course || '';
			document.getElementById('highGraduationYear').value = edu.institution || '';
			document.getElementById('nyscCertificateNumber').value = edu.nyscCertificateNumber || '';
			document.getElementById('yearOfService').value = edu.yearOfService || '';
		}

		function populateUserWork(work) {
			document.getElementById('organizationName').value = work.organizationName || '';
			document.getElementById('rank').value = work.rank || '';
			document.getElementById('responsibilities').value = work.responsibilities || '';
			document.getElementById('startDate').value = work.startDate || '';
			document.getElementById('endDate').value = work.endDate || '';
		}

		function populateUserPmc(pmc) {
			document.getElementById('bodyName').value = pmc.bodyName || '';
			document.getElementById('membershipID').value = pmc.membershipID || '';
			document.getElementById('membershipType').value = pmc.membershipType || '';
			document.getElementById('membershipResposibilities').value = pmc.membershipResposibilities || '';
			document.getElementById('certificateDate').value = pmc.certificateDate || '';
		}

		function populateUserSum(sumData){
			document.querySelector('.form-head h2 span').textContent = sumData.application.position || 'Position not provided';
			const passportImg = document.querySelector('.form-head img');
			const passportMessage = document.querySelector('.form-head p');
			if (sumData.application.passportFilePath) {
				passportImg.src = sumData.application.passportFilePath;
				passportImg.style.display = 'block';
				passportMessage.style.display = 'none';
			} else {
				passportImg.style.display = 'none';
				passportMessage.style.display = 'block';
			}
			// Bio Data Summary
			document.querySelector('[label="First Name"]').nextElementSibling.textContent = sumData.application.firstname || 'N/A';
			document.querySelector('[label="Middle Name"]').nextElementSibling.textContent = sumData.application.middlename || 'N/A';
			document.querySelector('[label="Last Name"]').nextElementSibling.textContent = sumData.application.lastname || 'N/A';
			document.querySelector('[label="Gender"]').nextElementSibling.textContent = sumData.application.gender || 'N/A';
			document.querySelector('[label="Date Of Birth"]').nextElementSibling.textContent = sumData.application.dateOfBirth || 'N/A';
			document.querySelector('[label="Marital Status"]').nextElementSibling.textContent = sumData.application.maritalStatus || 'N/A';
			document.querySelector('[label="Phone Number"]').nextElementSibling.textContent = sumData.application.phoneNumber || 'N/A';
			document.querySelector('[label="Emergency Number"]').nextElementSibling.textContent = sumData.application.emergencyNumber || 'N/A';
			document.querySelector('[label="NIN"]').nextElementSibling.textContent = sumData.application.nin || 'N/A';
			document.querySelector('[label="State Of Origin"]').nextElementSibling.textContent = sumData.application.stateOfOrigin || 'N/A';
			document.querySelector('[label="Local Government"]').nextElementSibling.textContent = sumData.application.lga || 'N/A';
			document.querySelector('[label="Residential Address"]').nextElementSibling.textContent = sumData.application.address || 'N/A';
			// Populate LGA Indigene/Origin Certificate Link (Assumed Link)
			const lgaCert = document.querySelector('a[href^="../Application_Dashboard/"]');
			if (lgaCert) {
				lgaCert.href = sumData.application.lgaFilePath ? `../Application_Dashboard/${sumData.application.lgaFilePath}` : '#';
				lgaCert.style.display = sumData.application.lgaFilePath ? 'inline' : 'none';
			}
			// Populate Birth Certificate Link (Assumed Link)
			const birthCert = document.querySelector('a[href^="../Application_Dashboard/"]:not([href^="#"])');
			if (birthCert) {
				birthCert.href = sumData.application.birthCertificateFilePath ? `../Application_Dashboard/${sumData.application.birthCertificateFilePath}` : '#';
				birthCert.style.display = sumData.application.birthCertificateFilePath ? 'inline' : 'none';
			}
			// Education Summary
			document.querySelector('[label="Primary School Name"]').nextElementSibling.textContent = sumData.education.primary_school_name || 'N/A';
			document.querySelector('[label="Graduation Year"]').nextElementSibling.textContent = sumData.education.primary_graduation_year || 'N/A';
			document.querySelector('[label="Secondary Education"]').nextElementSibling.textContent = sumData.education.secondarySchoolName || 'N/A';
			document.querySelector('[label="Secondary Education Certificate"]').nextElementSibling.textContent = sumData.education.secondaryCertificate || 'N/A';
			document.querySelector('[label="Secondary Graduation Year"]').nextElementSibling.textContent = sumData.education.secondaryGraduationYear || 'N/A';
			document.querySelector('[label="Higher Institution Name"]').nextElementSibling.textContent = sumData.education.institution || 'N/A';
			document.querySelector('[label="Certificate Type"]').nextElementSibling.textContent = sumData.education.certificateType || 'N/A';
			document.querySelector('[label="Class Of Degree"]').nextElementSibling.textContent = sumData.education.classOfDegree || 'N/A';
			document.querySelector('[label="Course"]').nextElementSibling.textContent = sumData.education.course || 'N/A';
			document.querySelector('[label="Higher Education Certificate"]').nextElementSibling.textContent = sumData.education.highCertificateFilePath || 'N/A';
			document.querySelector('[label="Higher Education Graduation Year"]').nextElementSibling.textContent = sumData.education.highGraduationYear || 'N/A';
			// NYSC Summary (not used directly in the provided data, assuming this is not available)
			document.querySelector('[label="Certificate Number"]').nextElementSibling.textContent = sumData.education.nyscCertificateNumber || 'N/A';
			document.querySelector('[label="Year Of Service"]').nextElementSibling.textContent = sumData.education.yearOfService || 'N/A';
			document.querySelector('[label="NYSC Certificate"]').nextElementSibling.textContent = sumData.education.nyscFilePath || 'N/A';
			// Work History Summary
			document.querySelector('[label="Organization Name"]').nextElementSibling.textContent = sumData.work_history.organizationName || 'N/A';
			document.querySelector('[label="Rank"]').nextElementSibling.textContent = sumData.work_history.rank || 'N/A';
			document.querySelector('[label="Responsibilities"]').nextElementSibling.textContent = sumData.work_history.responsibilities || 'N/A';
			document.querySelector('[label="Start Date"]').nextElementSibling.textContent = sumData.work_history.startDate || 'N/A';
			document.querySelector('[label="End Date"]').nextElementSibling.textContent = sumData.work_history.endDate || 'N/A';
			// Professional Membership Summary
			document.querySelector('[label="Body Name"]').nextElementSibling.textContent = sumData.pmc_details.bodyName || 'N/A';
			document.querySelector('[label="Membership ID"]').nextElementSibling.textContent = sumData.pmc_details.membershipID || 'N/A';
			document.querySelector('[label="Membership Type"]').nextElementSibling.textContent = sumData.pmc_details.membershipType || 'N/A';
			document.querySelector('[label="Responsibilities"]').nextElementSibling.textContent = sumData.pmc_details.membershipResposibilities || 'N/A';
			document.querySelector('[label="Certificate Date"]').nextElementSibling.textContent = sumData.pmc_details.certificateDate || 'N/A';
			document.querySelector('[label="Certificate"]').nextElementSibling.textContent = sumData.pmc_details.pmcFilePath || 'N/A';
		}




		// Initialize when DOM is loaded
		document.addEventListener('DOMContentLoaded', () => {
			checkSession();
			fetchUserProfile();
			fetchUserBio();
			fetchUserEducation();
			fetchUserWork();
			fetchUserPmc();
			fetchUserSum();
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
                <p id="profile">
					<!-- Populate with JS -->
                </p>
            </div>

        </div>

        <div id="db-panel">
            <div class="head-panel">
                <a href="../index.php"><img src="../images/logo-plain.jpg" alt="unilorin Logo"></a>
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