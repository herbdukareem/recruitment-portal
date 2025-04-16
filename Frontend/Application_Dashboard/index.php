
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
	<link rel="stylesheet" href="./styles/alert.css">
    <link rel="shortcut icon" href="../images/logo-plain.jpg" type="image/x-icon">
	<script src="../scripts/alert.js"></script>
    <script>

		let adminRole;
		let form
	
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
				const form = e.target;
				const formData = new FormData(form);
				await submitForm('bio', formData);
			});

			// Education form
			document.getElementById('eduForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				const form = e.target;
				const formData = new FormData(form);
				// for (let [key, value] of formData.entries()) {
				// 	console.log(key, value);
				// }
				console.log(formData)
				await submitForm('education', formData);
			});
			
			// Work history form
			document.getElementById('workForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('work', new FormData(e.target));
			});
			
			// PMC form
			document.getElementById('pmcForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				const form = e.target;
				const formData = new FormData(form);
				await submitForm('pmc', formData);
			});
			
			// PMC form
			document.getElementById('proficiencyTestForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('quiz', new FormData(e.target));
			});
			
		}

		const submitForm = async (endpoint, formData) => {
			try {
				const response = await fetch(`/test/backend/submit/${endpoint}`, {
					method: 'POST',
					body: formData, 
				});
				
				const data = await response.json();
				
				if (data.success) {
					showAlert('dashboard_alert_con', data.message, 'success');
					const user_id = data.user_id;
					localStorage.setItem('userID', user_id);
					if (data.next) {
						setTimeout(() => {
							if (data.next === 'application-status_screen') {
								document.getElementById('cpl-screen').style.display = 'none';
								this.navigateToStep(data.next);
							}
							this.navigateToStep(data.next);
						}, 5200);
					}
				} else {
					showAlert('dashboard_alert_con', data.error || 'Submission failed', 'danger');
				}
			} catch (error) {
				console.error('Form submission error:', error);
				showAlert('dashboard_alert_con', 'Something went wrong', 'danger');
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

		const fetchUserProfile = async () => {
			try {
				const user = JSON.parse(localStorage.getItem('user'));
				const token = localStorage.getItem('csrf_token');

				if (!user?.id || !token) {
					console.error("User ID or CSRF token not found.");
					return;
				}

				const response = await fetch(`/test/backend/user/data?user_id=${user.id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${token}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				const data = await response.json();
				const user_cred = data;

				populateUserProfile(data)

				// Fetch bio and pass both sets of data to the populate function
				await fetchUserBio(user_cred.data);

			} catch (error) {
				console.error("Error fetching user profile:", error);
			}
		};

		const fetchUserBio = async (user_cred = {}) => {
			try {
				const user = JSON.parse(localStorage.getItem('user'));
				const token = localStorage.getItem('csrf_token');

				if (!user?.id || !token) {
					console.error("User ID or CSRF token not found.");
					return;
				}

				const response = await fetch(`/test/backend/user/bio?user_id=${user.id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${token}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				const bio = await response.json();
				const user_data = bio?.data || {};
				console.log(user_cred.data)

				populateUserData(user_data, user_cred); 

			} catch (error) {
				console.error("Error fetching user bio:", error);
			}
		};


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
			const testButton = document.getElementById('prof_test')
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
				html = `
						<button id="cpl-btn" class="all-bt-bg">
							<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
								<path fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" d="M38.5 5.5h-29c-2.2 0-4 1.8-4 4v29c0 2.2 1.8 4 4 4h29c2.2 0 4-1.8 4-4v-29c0-2.2-1.8-4-4-4" stroke-width="1"/>
								<path fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" d="M34.3 35.9L24 30.5l-10.3 5.4V19L24 12.1L34.3 19zM24 12.1v18.4z" stroke-width="1"/>
							</svg>
							CPL Test
						</button>	
					`;
				const sum = await response.json();
				if(sum.data.files.pmc_certificate !== null && sum.data.files.pmc_certificate !== ''){
					testButton.innerHTML = html
				};
				form = true
				populateUserSum(sum.data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		const fetchUserStatus = async () => {
			try {
				const user_id = JSON.parse(localStorage.getItem('user'));
				const response = await fetch(`/test/backend/user/status?user_id=${user_id.id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('csrf_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				const status = await response.json();
				if(status.data !== null){
					document.getElementById('prof_test').style.display = 'none'
				}
				if(status.data === null){
					document.getElementById('application-status_screen').innerHTML = `<p style="color:red">"You must complete the test before accessing this page. Please go to the test page now.</p>`
				}
				populateUserStatus(status.data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		function populateUserProfile(data) {
			const profile = document.getElementById('profile');
			const ninCon = document.querySelector('input[name="nin"]');

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
				ninCon.value = data.nin || '';

			}

		}

		function populateUserData(user_data, user_cred) {
			document.getElementById('positionType').value = user_data.positionType || '';
			document.getElementById('supPosition').value = user_data.supPosition || '';
			document.getElementById('position').value = user_data.position || '';
			document.querySelector('input[name="firstname"]').value = user_cred.firstname || '';
			document.querySelector('input[name="middlename"]').value = user_data.middlename || '';
			document.querySelector('input[name="lastname"]').value = user_cred.lastname || '';
			if (user_data.email) {
				document.querySelector('input[name="email"]').value = user_data.email || '';
				document.querySelector('input[name="password"]').value = '';
			}
			document.querySelector('select[name="gender"]').value = user_data.gender || '';
			document.querySelector('input[name="dateOfBirth"]').value = user_data.dateOfBirth || '';
			document.querySelector('select[name="maritalStatus"]').value = user_data.maritalStatus || '';
			document.getElementById('state').value = user_data.stateOfOrigin || '';
			document.getElementById('lga').value = user_data.lga || '';
			document.querySelector('input[name="nin"]').value = user_cred.nin || '';
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

		function populateUserSum(sumData) {
			// Application Summary Section
			document.querySelector('#application-title h2 span').textContent = sumData.application.position || 'Position not provided';

			const passportImg = document.querySelector('#passport-photo');
			if (sumData.files.passport) {
				passportImg.innerHTML = `<img src="../..${sumData.files.passport}" alt="${sumData.application.firstname}_passport" width="100px"/>`;
			} else {
				passportImg.innerHTML = '<p>No passport found</p>';
			}


			// Bio Data Section
			document.querySelector('#sfname').textContent = sumData.application.firstname || 'N/A';
			document.querySelector('#smname').textContent = sumData.application.middlename || 'N/A';
			document.querySelector('#slname').textContent = sumData.application.lastname || 'N/A';
			document.querySelector('#sgender').textContent = sumData.application.gender || 'N/A';
			document.querySelector('#sdob').textContent = sumData.application.dateOfBirth || 'N/A';
			document.querySelector('#smaritalstatus').textContent = sumData.application.maritalStatus || 'N/A';
			document.querySelector('#sphoneNumber').textContent = sumData.application.phoneNumber || 'N/A';
			document.querySelector('#semerNumber').textContent = sumData.application.emergencyNumber || 'N/A';
			document.querySelector('#snin').textContent = sumData.application.nin || 'N/A';
			document.querySelector('#ssof').textContent = sumData.application.stateOfOrigin || 'N/A';
			document.querySelector('#slga').textContent = sumData.application.lga || 'N/A';
			document.querySelector('#saddress').textContent = sumData.application.address || 'N/A';

			// Links for LGA and Birth Certificates
			const lgaCert = document.querySelector('#slgaCert');
			if (sumData.files.lga_certificate) {
				lgaCert.href = `../..${sumData.files.lga_certificate}`;
				lgaCert.style.display = 'inline';
			} else {
				lgaCert.href = '#';
				lgaCert.style.display = 'none';
			}

			const birthCert = document.querySelector('#sbirthCert');
			if (sumData.files.birth_certificate) {
				birthCert.href = `../..${sumData.files.birth_certificate}`;
				birthCert.style.display = 'inline';
			} else {
				birthCert.href = '#';
				birthCert.style.display = 'none';
			}

			// Education Section
			document.querySelector('#spriSchoolName').textContent = sumData.education.primary_school_name || 'N/A';
			document.querySelector('#spriGradYear').textContent = sumData.education.primary_graduation_year || 'N/A';
			document.querySelector('#ssecName').textContent = sumData.education.secondarySchoolName || 'N/A';
			document.querySelector('#ssecGradYear').textContent = sumData.education.secondaryGraduationYear || 'N/A';
			// NYSC Section
			document.querySelector('#snyscCertNo').textContent = sumData.education.nyscCertificateNumber || 'N/A';
			document.querySelector('#snyscYOS').textContent = sumData.education.yearOfService || 'N/A';
			const secEduCert = document.querySelector('#ssecEduCert');
			if (sumData.files.secondary_certificate) {
				secEduCert.href = `../..${sumData.files.secondary_certificate}`;
				secEduCert.style.display = 'inline';
			} else {
				secEduCert.href = '#';
				secEduCert.style.display = 'none';
			}
			
			document.querySelector('#shighName').textContent = sumData.education.institution || 'N/A';
			document.querySelector('#scertType').textContent = sumData.education.certificateType || 'N/A';
			document.querySelector('#scod').textContent = sumData.education.classOfDegree || 'N/A';
			document.querySelector('#scourse').textContent = sumData.education.course || 'N/A';
			const highCert = document.querySelector('#shighCert');
			if (sumData.files.higher_certificate) {
				highCert.href = `../..${sumData.files.higher_certificate}`;
				highCert.style.display = 'inline';
			} else {
				highCert.href = '#';
				highCert.style.display = 'none';
			}
			document.querySelector('#shighCert').href = sumData.education.highCertificateFilePath || '#';
			document.querySelector('#shighGradYear').textContent = sumData.education.highGraduationYear || 'N/A';

			// NYSC Section
			document.querySelector('#snyscCertNo').textContent = sumData.education.nyscCertificateNumber || 'N/A';
			document.querySelector('#snyscYOS').textContent = sumData.education.yearOfService || 'N/A';
			const nyscCert = document.querySelector('#snyscCert');
			if (sumData.files.nysc_certificate) {
				nyscCert.href = `../..${sumData.files.nysc_certificate}`;
				nyscCert.style.display = 'inline';
			} else {
				nyscCert.href = '#';
				nyscCert.style.display = 'none';
			}

			// Work History Section
			document.querySelector('#sorgName').textContent = sumData.work_history.organizationName || 'N/A';
			document.querySelector('#sorgRank').textContent = sumData.work_history.rank || 'N/A';
			document.querySelector('#sorgRes').textContent = sumData.work_history.responsibilities || 'N/A';
			document.querySelector('#sstartDate').textContent = sumData.work_history.startDate || 'N/A';
			document.querySelector('#sendDate').textContent = sumData.work_history.endDate || 'N/A';

			// Professional Membership Section
			document.querySelector('#sbodyName').textContent = sumData.pmc_details.bodyName || 'N/A';
			document.querySelector('#smemId').textContent = sumData.pmc_details.membershipID || 'N/A';
			document.querySelector('#smemTpe').textContent = sumData.pmc_details.membershipType || 'N/A';
			document.querySelector('#smemRes').textContent = sumData.pmc_details.membershipResposibilities || 'N/A';
			document.querySelector('#smemCertDate').textContent = sumData.pmc_details.certificateDate || 'N/A';
			const memCert = document.querySelector('#smemCert');
			if (sumData.files.pmc_certificate) {
				memCert.href = `../..${sumData.files.pmc_certificate}`;
				memCert.style.display = 'inline';
			} else {
				memCert.href = '#';
				memCert.style.display = 'none';
			}
		}

		function populateUserStatus(status) {
			document.getElementById('aname').innerText = status.firstname + ' ' + status.lastname;  // Name
			document.getElementById('aposition').innerText = status.position;  // Position
			document.getElementById('aquizpercent').innerText = status.score_percentage + '%';  // Quiz score percentage
			document.getElementById('adate').innerText = status.completed_at;  // Date of completion
			
			// Handling the status button
			const statusButton = document.getElementById('astatus');
			statusButton.style.color = 'white';
			// Change status when button is clicked (toggle example)
			statusButton.addEventListener('click', function() {
				if (status.status === 'shortlisted') {
					statusButton.style.backgroundColor = 'green';
					statusButton.innerText = status.status;  
				} else if(status.status === 'rejected') {
					statusButton.style.backgroundColor = 'red';
					statusButtoninnerTexts = status.status;  
				} else if(status.status === 'interviewed'){
					statusButton.style.backgroundColor = 'blue';
					statusButton.innerText = status.status; 
				} else {
					statusButton.innerText = 'pending...'; 
				}
				
				// Optionally, update the button or send an update request to the backend
				alert("Status updated to: " + status.status); // Notify the user of the status change
			});
		}

		document.addEventListener('DOMContentLoaded', () => {
			checkSession();
			fetchUserProfile();
			fetchUserBio();
			fetchUserEducation();
			fetchUserWork();
			fetchUserPmc();
			fetchUserSum();
			fetchUserStatus();
			setupFormHandlers();
			// renderNavListBtn();
			
		});

	</script>
</head>

<body>
    <div class="db-winscroll">
        <div class="nav-bar">
            <div class="left-nav">
                <svg id="open_panel" onClick="closePanelHandler()" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5L12 12L19 5M12 12H12M5 19L12 12L19 19"><animate fill="freeze" attributeName="d" dur="0.4s" values="M5 5L12 12L19 5M12 12H12M5 19L12 12L19 19;M5 5L12 5L19 5M5 12H19M5 19L12 19L19 19"/></path></svg>
                
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

	<script>
		let openPanel = false;

		function closePanelHandler() {
			// const panel = document.getElementById('toggle_panel');
			const dbPanel = document.getElementById('db-panel');

			if (!openPanel){
				dbPanel.style.transform = "translateX(0px)";
				openPanel = true;
			} else {
				dbPanel.style.transform = "translateX(-180px)";
				openPanel = false;
			}
		}
	</script>
	<script type="module" src="../scripts/main.js"></script>
	<script src="./script/logout.js"></script>

</body>


</html>