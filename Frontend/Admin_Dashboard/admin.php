<!doctype html>
<html lang="en">

<head>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admin Dashboard | UNILORIN</title>
	<link rel="stylesheet" href="./assets/css/style.css">
	<link rel="stylesheet" href="./assets/css/alert.css">
	<!-- FontAwesome CSS-->
	<link rel="stylesheet" href="./assets/modules/fontawesome6.1.1/css/all.css">
	<!-- Boxicons CSS-->
	<link rel="stylesheet" href="./assets/modules/boxicons/css/boxicons.min.css">
	<!-- Apexcharts  CSS -->
	<link rel="stylesheet" href="./assets/modules/apexcharts/apexcharts.css">
    <link rel="shortcut icon" href="../images/logo-plain.jpg" type="image/x-icon">
	<link rel="stylesheet" href="../style/formStyles.css">
	<!-- <script type="module" src="./script/loadApplicants.js"></script> -->
	<script src="./script/alert.js"></script>

	<script>

		let adminRole;
		let user_data;
		let form;
	
		// let allApplicants = [];

		const checkSession = async () => {
			try {
				console.log('Initiating session check...');
				
				const response = await fetch('/test/backend/admin/session', {
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
					window.location.href = 'auth.php';
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

		const loadAdminData = async () => {
			try {
				// 1. Fetch admin data from server
				const response = await fetch('/test/backend/admin/data', {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
					},
					credentials: 'include'
				});

				if (!response.ok) {
					throw new Error('Failed to fetch admin data');
				}

				const adminData = await response.json();

				adminRole = adminData.data.role;

				// 2. Update admin info in navbar
				document.getElementById('admin-id-display').innerText = adminData.data.admin_id;
				
				// 3. Render admin controls based on role
				const adminControls = document.getElementById('admin-controls');
				
				if (adminData.data.role === 'sup_admin') {
					adminControls.innerHTML = `
						<button type="button" class="btn transition" id="admin_sidebar_toggle">
							<i class="fa fa-bars"></i>
						</button>
						<div id="admin_sidebar" class="admin_sidebar">
							<ul>
								<li><a href="#" id="btn-all">All Applicants</a></li>
								<li><a href="#" id="btn-add">Add Applicant</a></li>
								<li><a href="#" id="btn-create">Create Admin</a></li>
							</ul>
						</div>
					`;

					// Event listeners for navigation buttons
					document.getElementById('btn-all').addEventListener('click', function(e) {
						e.preventDefault();
						showSection('sort_applicant');
					});

					document.getElementById('btn-add').addEventListener('click', function(e) {
						e.preventDefault();
						showSection('add_applicant');
					});

					document.getElementById('btn-create').addEventListener('click', function(e) {
						e.preventDefault();
						showSection('create_admin');
					});

					// // Toggle sidebar
					document.getElementById('admin_sidebar_toggle').addEventListener('click', ()=>{
						document.getElementById('admin_sidebar').style.right = "0";
						console.log('clicked')
					});
				}
				renderUserLoginInput();
				renderNavListBtn();

			} catch (error) {
				console.log('Error loading admin data:', error);
				showAlert('dashboard_alert_con', 'Failed to load admin data', 'danger');
			}
		};

		// Function to show a specific section and hide others
		function showSection(sectionId) {
			// Hide all sections
			document.getElementById('sort_applicant').style.display = 'none';
			document.getElementById('add_applicant').style.display = 'none';
			document.getElementById('create_admin').style.display = 'none';
			
			// Show the requested section
			document.getElementById(sectionId).style.display = 'block';
			
			// Store the active section in localStorage
			localStorage.setItem('activeSection', sectionId);
		}

		// Render Applications Stats
		const loadStats =  async () => {
			try {
				const response = await fetch('/test/backend/admin/stats', {
					method: 'GET',
					headers: {
						'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
					}
				});
				
				const dashboardData = await response.json();
				
				const applicationStats = document.getElementById('dashboard');

				applicationStats.innerHTML = `
					<div class="container-fluid">
						<div class="row flex1">

							<div class="col-md-6 col-lg-3">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-5 d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><path fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="m5 10l3 3l6-6M5 24l3 3l6-6M5 38l3 3l6-6m7-11h22M21 38h22M21 10h22"/></svg>
											</div>
											<div class="col-7">
												<p class="text-light">All Applications</p>
												<h5 class="text-light">
													${dashboardData.filters.status_counts.all}
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
												<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="#e4b535" d="M17 22q-2.075 0-3.537-1.463T12 17t1.463-3.537T17 12t3.538 1.463T22 17t-1.463 3.538T17 22m.5-5.2v-2.3q0-.2-.15-.35T17 14t-.35.15t-.15.35v2.275q0 .2.075.388t.225.337l1.525 1.525q.15.15.35.15t.35-.15t.15-.35t-.15-.35zM5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h4.175q.275-.875 1.075-1.437T12 1q1 0 1.788.563T14.85 3H19q.825 0 1.413.588T21 5v4q0 .425-.288.713T20 10t-.712-.288T19 9V5h-2v2q0 .425-.288.713T16 8H8q-.425 0-.712-.288T7 7V5H5v14h4.5q.425 0 .713.288T10.5 20t-.288.713T9.5 21zm7-16q.425 0 .713-.288T13 4t-.288-.712T12 3t-.712.288T11 4t.288.713T12 5"/></svg>
											</div>
											<div class="col-8">
												<p class="text-light">Pending</p>
												<h5 class="text-light">
													${dashboardData.filters.status_counts.pending}
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
												<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="#e4b535" d="M3 18h18V6H3zM1 5a1 1 0 0 1 1-1h20a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm8 5a1 1 0 1 0-2 0a1 1 0 0 0 2 0m2 0a3 3 0 1 1-6 0a3 3 0 0 1 6 0m-2.998 6c-.967 0-1.84.39-2.475 1.025l-1.414-1.414A5.5 5.5 0 0 1 8.002 14a5.5 5.5 0 0 1 3.889 1.61l-1.414 1.415A3.5 3.5 0 0 0 8.002 16m8.205-1.293l4-4l-1.414-1.414l-3.293 3.293l-1.793-1.793l-1.414 1.414l2.5 2.5l.707.707z"/></svg>
											</div>
											<div class="col-8">
												<p class="text-light">Shortlisted</p>
												<h5 class="text-light">
													${dashboardData.filters.status_counts.shortlisted}
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
												<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="#e4b535" d="M20 4a2 2 0 0 1 2 2v10c0 1.11-.89 2-2 2h4v2H0v-2h4a2 2 0 0 1-2-2V6c0-1.11.89-2 2-2zm0 2H4v10h16zm-8 6c2.21 0 4 .9 4 2v1H8v-1c0-1.1 1.79-2 4-2m0-5a2 2 0 1 1 0 4c-1.11 0-2-.89-2-2s.9-2 2-2"/></svg>
											</div>
											<div class="col-8">
												<p class="text-light">Interviewed</p>
												<h5 class="text-light">
													${dashboardData.filters.status_counts.interviewed}
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
												<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><g fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><path d="M19.01 42H9a3 3 0 0 1-3-3V9a3 3 0 0 1 3-3h30a3 3 0 0 1 3 3v10.03m0 10.005V41a1 1 0 0 1-1 1H29.037M42 29.035H18"/><path d="m23 23l-6 6l6 6"/></g></svg>
											</div>
											<div class="col-8">
												<p class="text-light">Rejected</p>
												<h5 class="text-light">
													${dashboardData.filters.status_counts.rejected}
												</h5>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				`;

				renderTable(dashboardData.data)

			} catch (error) {
				showAlert('dashboard_alert_con', 'Failed to load applicants', 'danger');
			}
		};

		// Main function to load applicants
		const loadApplicants = async () => {
			try {
				
				// Get current filter values
				const position = document.getElementById('filter_position')?.value || '';
				const status = document.getElementById('filter_status')?.value || '';
				const nin = document.getElementById('filter_nin')?.value || '';
				
				const response = await fetch(`/test/backend/admin/applicants?position=${position}&status=${status}&nin=${nin}`, {
					method: 'GET',
					headers: {
						'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
					}
				});

				if (!response.ok) {
					throw new Error(`HTTP error! status: ${response.status}`);
				}

				const result = await response.json();
				
				if (result.success) {
      				renderTable(result.data);
				} else {
					throw new Error(result.message || 'Failed to load applicants');
				}
			} catch (error) {
				console.error('Error loading applicants:', error);
				showError('Failed to load applicants: ' + error.message);
			}
		};

		// Show loading animation
		function showLoading() {
			const container = document.getElementById('applicants-table-container');
			if (container) {
				container.innerHTML = `
				<div class="text-center py-4">
					<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24">
					<circle cx="18" cy="12" r="0" fill="#00045c">
						<animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" 
						keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" 
						repeatCount="indefinite" values="0;2;0;0"/>
					</circle>
					<circle cx="12" cy="12" r="0" fill="#00045c">
						<animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" 
						keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" 
						repeatCount="indefinite" values="0;2;0;0"/>
					</circle>
					<circle cx="6" cy="12" r="0" fill="#00045c">
						<animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" 
						keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" 
						repeatCount="indefinite" values="0;2;0;0"/>
					</circle>
					</svg>
					<p>Loading applicants...</p>
				</div>
				`;
			}
		}

		// Render the table with applicant data
		function renderTable(applicants) {
			const container = document.getElementById('applicants-table-container');
			if (!container) return;

			// Get admin role (you'll need to set this from your session)
			// adminRole = localStorage.getItem('admin_role') || '';

			let html = `
				<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th scope="col">Id</th>
						<th scope="col">Profile</th>
						<th scope="col">Email</th>
						<th scope="col">CPL%</th>
						<th scope="col">Reg Date/Time</th>
						<th scope="col">View Details</th>
						${adminRole === 'sup_admin' ? '<th scope="col">Action</th>' : ''}
					</tr>
					</thead>
					<tbody>
			`;
			console.log(adminRole + ": admin_Role for table");

			if (applicants.length === 0) {
				html += `
				<tr>
					<td colspan="${adminRole === 'sup_admin' ? '7' : '6'}">No applicants found</td>
				</tr>
				`;
			} else {
				applicants.forEach((applicant, index) => {
				html += renderApplicantRow(applicant, index, adminRole);
				});
			}

			html += `
					</tbody>
				</table>
				</div>
			`;

			container.innerHTML = html;
		}

		function safeData(value, fallback = 'N/A') {
			if (value === null || value === undefined || value === '') return fallback;
			return String(value)
				.replace(/&/g, "&amp;")
				.replace(/</g, "&lt;")
				.replace(/>/g, "&gt;")
				.replace(/"/g, "&quot;")
				.replace(/'/g, "&#039;");
		}

		function fileLink(path, text) {
			if (!path) return '';
			return `<a href="../..${safeData(path)}" target="_blank">${text}</a>`;
		}

		// Render a single applicant row
		function renderApplicantRow(applicant, index, adminRole) {
			const defaultAvatar = '../assets/images/default-avatar.png';
			const avatarPath = applicant.passport_file_path || defaultAvatar;
			console.log(adminRole + ": admin_Role for applicant table");

			return `
				<tr>
					<td>${index + 1}</td>
					<td>
						<a href="../..${avatarPath}" target="_blank">
							<img src="../..${avatarPath}" 
								alt="${applicant.lastname || 'Applicant'}" 
								width="50" height="50" style="border-radius:50%"
								onerror="this.onerror=null;this.src='${defaultAvatar}'">
						</a>
					</td>
					<td>${applicant.email || 'N/A'}</td>
					<td>${applicant.score_percentage || '0'}%</td>
					<td>${applicant.created_at || 'N/A'}</td>
					<td>
						<button id="btn_${applicant.user_id}-${index}" class="btn btn-primary view-details-btn" onClick="toggleDetails(${applicant.user_id}, ${index})">
							View Details
						</button>
					</td>
					${adminRole === 'sup_admin' ? 
					`<td>
						<form id="setSession_${applicant.user_id}" method="POST" class="d-inline" style="all:unset">
							<input type="hidden" id="setUserId_${applicant.user_id}" name="setUserId" value="${applicant.user_id}" />
							<button type="submit" class="btn btn-primary edit-btn" data-user-id="${applicant.user_id}">
								Edit
							</button>
						</form>
					</td>` 
					: ''}
				</tr>
				<tr class="details-row" id="details_${applicant.user_id}-${index}" style="display:none;">
					<td colspan="${adminRole === 'sup_admin' ? '7' : '6'}">
						${renderApplicantDetails(applicant)}
					</td>
				</tr>
			`;
		}

		// Render applicant details
		function renderApplicantDetails(applicant) {
			return `
				<div class="applicant-details">
					<table class="table">
						<tbody>
							<tr>
								<td><strong>Position:</strong> ${safeData(applicant.position)}</td>
							</tr>
							<tr>
								<td><strong>Firstname:</strong> ${safeData(applicant.firstname)}</td>
								<td><strong>Middlename:</strong> ${safeData(applicant.middlename)}</td>
								<td><strong>Lastname:</strong> ${safeData(applicant.lastname)}</td>
							</tr>
							<tr>
								<td><strong>Gender:</strong> ${safeData(applicant.gender)}</td>
								<td><strong>DOB:</strong> ${safeData(applicant.dateOfBirth)}</td>
								<td><strong>MS:</strong> ${safeData(applicant.maritalStatus)}</td>
							</tr>
							<tr>
								<td><strong>Phone No.:</strong> ${safeData(applicant.phoneNumber)}</td>
								<td><strong>Emergency No.:</strong> ${safeData(applicant.emergencyNumber)}</td>
								<td><strong>NIN:</strong> ${safeData(applicant.nin)}</td>
							</tr>
							<tr>
								<td><strong>Address:</strong> ${safeData(applicant.address)}</td>
								<td><strong>LGA:</strong> ${safeData(applicant.lga)}</td>
								<td><strong>SOO:</strong> ${safeData(applicant.stateOfOrigin)}</td>
							</tr>
							<tr>
								<td><strong>Pri Name:</strong> ${safeData(applicant.primary_school_name)}</td>
								<td><strong>Year:</strong> ${safeData(applicant.primary_graduation_year)}</td>
								<td></td>
							</tr>
							<tr>
								<td><strong>Sec Name:</strong> ${safeData(applicant.secondarySchoolName)}</td>
								<td><strong>Year:</strong> ${safeData(applicant.secondaryGraduationYear)}</td>
								<td>${fileLink(applicant.sec_file_path, 'Sec Cert')}</td>
							</tr>
							<tr>
								<td><strong>Insti Name:</strong> ${safeData(applicant.institution)}</td>
								<td><strong>Cert:</strong> ${safeData(applicant.certificateType)}</td>
								<td>${fileLink(applicant.high_certificate_file_path, 'High Inst Cert')}</td>
							</tr>
							<tr>
								<td><strong>Degree:</strong> ${safeData(applicant.classOfDegree)}</td>
								<td><strong>Course:</strong> ${safeData(applicant.course)}</td>
								<td><strong>Year:</strong> ${safeData(applicant.highGraduationYear)}</td>
							</tr>
							<tr>
								<td><strong>Organization Name:</strong> ${safeData(applicant.organizationName)}</td>
								<td><strong>Rank:</strong> ${safeData(applicant.rank)}</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="3"><strong>Responsibilities:</strong> ${safeData(applicant.responsibilities)}</td>
							</tr>
							<tr>
								<td><strong>Start Date:</strong> ${safeData(applicant.startDate)}</td>
								<td><strong>End Date:</strong> ${safeData(applicant.endDate)}</td>
								<td></td>
							</tr>
							<tr>
								<td><strong>Body Name:</strong> ${safeData(applicant.organizationName)}</td>
								<td><strong>Membership ID:</strong> ${safeData(applicant.rank)}</td>
								<td><strong>Membership Type:</strong> ${safeData(applicant.rank)}</td>
							</tr>
							<tr>
								<td colspan="3"><strong>Responsibilities:</strong> ${safeData(applicant.responsibilities)}</td>
							</tr>
							<tr>
								<td><strong>Cert Date:</strong> ${safeData(applicant.startDate)}</td>
								<td>${fileLink(applicant.sec_file_path, 'PMC Cert')}</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="3">
									${renderStatusForm(applicant.user_id)}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			`;
		}

		// Render Status action form
		function renderStatusForm(userId) {
			return `
				<form action="" method="POST" class="statusForm" id="statusForm_${userId}">
					<input type="hidden" name="user_id" value="${userId}">
					<input type="hidden" name="status" id="statusInput_${userId}" value="">
			
					<div class="button-container">
						<button type="button" class="btn btn-primary" 
							onclick="confirmHandler('${userId}', 'shortlisted')">
							Shortlist
						</button>
				
						<button type="button" class="btn btn-warning" 
							onclick="confirmHandler('${userId}', 'interviewed')">
							Interviewed
						</button>
				
						<button type="button" class="btn btn-danger" 
							onclick="confirmHandler('${userId}', 'rejected')">
							Rejected
						</button>
					</div>
			
					<div id="statusModal_${userId}" class="modal" style="display: none;">
						<div class="modal-content">
							<span class="close" onclick="closeModal('${userId}')">&times;</span>
							<p id="modalMessage_${userId}"></p>
							<button type="submit" name="saveStatus" class="btn confirm-button" id="confirmHandler_${userId}">
								Confirm
							</button>
						</div>
					</div>
				</form>
			`;
		}

		// Render Status action comfirmation
		function confirmHandler(index, status) {
			// Get modal elements
			let modal = document.getElementById('statusModal_' + index);
			let modalMessage = document.getElementById('modalMessage_' + index);
			let confirmButton = document.getElementById('confirmHandler_' + index); // FIXED: Use unique ID
			let statusInput = document.getElementById('statusInput_' + index);

			// Ensure elements exist before modifying them
			if (!modal || !modalMessage || !confirmButton || !statusInput) {
				console.error("Modal elements not found for index:", index);
				return;
			}

			// Set modal message and button color dynamically
			if (status === 'shortlisted') {
				modalMessage.textContent = `Are you sure you want to shortlist this applicant?`;
				confirmButton.className = "btn btn-success";
			} else if (status === 'interviewed') {
				modalMessage.textContent = `Are you sure this applicant has been interviewed?`;
				confirmButton.className = "btn btn-warning";
			} else {
				modalMessage.textContent = `Are you sure you want to Reject this applicant?`;
				confirmButton.className = "btn btn-danger";
			}

			// Update hidden input field with status
			statusInput.value = status;

			// Show modal
			modal.style.display = "block";
		}

		// Close modal box
		function closeModal(index) {
			let modal = document.getElementById('statusModal_' + index);
			if (modal) {
				modal.style.display = "none";
			}
		}

		// Error display
		function showError(message) {
			const container = document.getElementById('applicants-table-container');
			if (container) {
				container.innerHTML = `
				<div class="alert alert-danger">
					${message}
					<button class="btn btn-sm btn-primary mt-2" onclick="loadApplicants()">Try Again</button>
				</div>
				`;
			}
		}

		// Toggle details visibility
		function toggleDetails(positionId, index) {
			var detailsRow = document.getElementById("details_" + positionId + "-" + index);
			var button = document.getElementById("btn_" + positionId + "-" + index);
			if (detailsRow.style.display === "none" || detailsRow.style.display === "") {
				detailsRow.style.display = "table-row";
				button.textContent = "Hide Details";
			} else {
				detailsRow.style.display = "none";
				button.textContent = "View Details";
			}
		};

		// Handle Status form submission
		const handleStatusUpdate = async (e) => {
			// Event delegation for all status forms
			document.addEventListener('submit', async function(e) {
			if (e.target.classList.contains('statusForm')) {
				e.preventDefault();
				
				const form = e.target;
				const userId = form.id.split('_')[1]; // Extract userId from form ID
				const formData = new FormData(form);

				try {
					// Convert FormData to JSON if your backend expects JSON
					const formDataObj = {};
					formData.forEach((value, key) => formDataObj[key] = value);
					
					const response = await fetch('/test/backend/admin/update_status', {
						method: 'POST',
						headers: {
						'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
						'Content-Type': 'application/json',
						},
						body: JSON.stringify(formDataObj),
					});

					const result = await response.json();

					console.log(result);

					if (result.success) {
						showAlert('dashboard_alert_con', 'Status updated successfully', 'success');
						closeModal(userId);
						// Refresh the applicant list - implement your refresh logic here
					} else {
						throw new Error(result.error || 'Failed to update status');
					}
				} catch (error) {
					console.error('Status update error:', error);
					showAlert('dashboard_alert_con', `Error updating status: ${error.message}`, 'danger');
				}
			}
			});
		}

		// Debounce function for better performance
		function debounce(func, timeout = 300) {
			let timer;
			return function() {
				const context = this;
				const args = arguments;
				clearTimeout(timer);
				timer = setTimeout(() => {
					func.apply(context, args);
				}, timeout);
			};
		};

		// AJAX call to fetch user data
		const fetchUserData = async (id) => {
			const user_id = localStorage.getItem('userID')
			try {
				const response = await fetch(`/test/backend/user/data?user_id=${user_id}`, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json',
						'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
					}
				});

				if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

				user_data = await response.json();
				populateUserData(user_data, user_names);

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
			}
		}

		function populateUserData(user_data, user_names) {
			// Position selects (you'll need to set these based on your data)
			document.getElementById('positionType').value = user_data.positionType || '';
			document.getElementById('supPosition').value = user_data.supPosition || '';
			document.getElementById('position').value = user_data.position || '';
			
			// Basic info
			document.querySelector('input[name="firstname"]').value = user_names.firstname || '';
			document.querySelector('input[name="middlename"]').value = user_data.middlename || '';
			document.querySelector('input[name="lastname"]').value = user_names.lastname || '';
			
			// Email and password (if applicable)
			if (user_names.email) {
				document.querySelector('input[name="email"]').value = user_names.email || '';
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
			
		}

		const setupFormHandlers = () => {
			// Set session form handler
			const setSessionForms = document.querySelectorAll('[id^="setSession_"]');
			setSessionForms.forEach(form => {
				form.addEventListener('submit', async (e) => {
					e.preventDefault();
					const userId = form.querySelector('input[name="setUserId"]').value;
					console.log(`Form submitted for userId: ${userId}`);
					const formData = new FormData(form);
					await setSession('session', formData);
				});
			});

			// Other form handlers like bio, education, etc.
			document.getElementById('bioForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('bio', new FormData(e.target));
			});

			document.getElementById('eduForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('education', new FormData(e.target));
			});

			document.getElementById('workForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('work', new FormData(e.target));
			});

			document.getElementById('pmcForm').addEventListener('submit', async (e) => {
				e.preventDefault();
				await submitForm('pmc', new FormData(e.target));
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
					localStorage.setItem('userID', data.user_id)
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

		const setSession = async (endpoint, formData) => {
			try {
				// Convert FormData to a plain object
				const formObject = {};
				formData.forEach((value, key) => {
					formObject[key] = value;
				});

				// Send the form data a`s JSON
				const response = await fetch(`/test/backend/admin/${endpoint}`, {
					method: 'POST',
					body: JSON.stringify(formObject),  // JSON stringified object
					headers: {
						'Content-Type': 'application/json'
					}
				});

				const data = await response.json();

				if (data.success) {
					showAlert('alert-container-application', data.message, 'success');
					localStorage.setItem('userID', data.user_id);
					fetchUserData(data.user_id);

					if (data.next) {
						setTimeout(() => {
							navigateToStep(data.next);
						}, 5200);
					}
				} else {
					showAlert('alert-container-application', data.error || 'Submission failed', 'danger');
				}
			} catch (error) {
				console.error('Form submission error:', error);
				showAlert('alert-container-application', 'Network error', 'danger');
			}
		};


		function renderUserLoginInput() {

			const userLoginTR = document.getElementById('user_login_form');
			// const form = ( user_data ? true : false );

			if(adminRole){
				userLoginTR.innerHTML = `
					<td>
						<div>
							<label for="email">Email</label>
						</div>
						<div>
							<input type="text" name="admin_role" id="admin_role"  value="${adminRole}" hidden >
							<input type="email" name="email" id="email"  value=""  >
						</div>
					</td>
					<td>
						<div>
							<label for="lname">Password</label>
						</div>
						<div>
							<input type="password" name="password" id="password"  value="" >
						</div>
					</td>            
				`;
			}


		}

		function renderNavListBtn() {
			const profTestBtn = document.getElementById('prof_test');
			const closeApplicationBtn = document.getElementById('close_apllication');

			if (adminRole) {
				profTestBtn.innerHTML = `
					 <button id="cpl-btn" class="all-bt-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                            <path fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" d="M38.5 5.5h-29c-2.2 0-4 1.8-4 4v29c0 2.2 1.8 4 4 4h29c2.2 0 4-1.8 4-4v-29c0-2.2-1.8-4-4-4" stroke-width="1"/><path fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" d="M34.3 35.9L24 30.5l-10.3 5.4V19L24 12.1L34.3 19zM24 12.1v18.4z" stroke-width="1"/>
                        </svg>
                        CPL Test
                    </button>
				`;
				closeApplicationBtn.innerHTML = `
					<form method="post" action="" style="all:unset">
						<button type="submit" name="new_applicant" id="cpl-btn" class="all-bt-bg">
							<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
								<path fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" d="M38.5 5.5h-29c-2.2 0-4 1.8-4 4v29c0 2.2 1.8 4 4 4h29c2.2 0 4-1.8 4-4v-29c0-2.2-1.8-4-4-4" stroke-width="1"/>
								<path fill="none" stroke="#e4b535" stroke-linecap="round" stroke-linejoin="round" d="M34.3 35.9L24 30.5l-10.3 5.4V19L24 12.1L34.3 19zM24 12.1v18.4z" stroke-width="1"/>
							</svg>
							${(form ? 'Close Form' : 'Add New Applicant')}
					</form>
				`
			}
		}

		// AJAX call to fetch user data
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
				console.log(status)
				populateUserStatus(status.data)

			} catch (error) {
				console.error("Error fetching user data:", error);
				throw error;
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

		function populateUserSum(sumData) {
			// Application Summary Section
			document.querySelector('#application-title h2 span').textContent = sumData.application.position || 'Position not provided';

			const passportImg = document.querySelector('#passport-photo');
			if (sumData.application.passportFilePath) {
				passportImg.innertHTML = `<img src="/Backend/config/uploads${sumData.application.passportFilePath}"`
			} else {
				passportImg.innertHTML = `<p>No passport found</p>`

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
			if (sumData.application.lgaFilePath) {
				lgaCert.href = `/Backend/config/uploads${sumData.application.lgaFilePath}`;
				lgaCert.style.display = 'inline';
			} else {
				lgaCert.href = '#';
				lgaCert.style.display = 'none';
			}

			const birthCert = document.querySelector('#sbirthCert');
			if (sumData.application.birthCertificateFilePath) {
				birthCert.href = `/Backend/config/uploads${sumData.application.birthCertificateFilePath}`;
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
			document.querySelector('#ssecEduCert').textContent = sumData.education.secondaryCertificate || 'N/A';
			
			document.querySelector('#shighName').textContent = sumData.education.institution || 'N/A';
			document.querySelector('#scertType').textContent = sumData.education.certificateType || 'N/A';
			document.querySelector('#scod').textContent = sumData.education.classOfDegree || 'N/A';
			document.querySelector('#scourse').textContent = sumData.education.course || 'N/A';
			document.querySelector('#shighCert').href = sumData.education.highCertificateFilePath || '#';
			document.querySelector('#shighGradYear').textContent = sumData.education.highGraduationYear || 'N/A';

			// NYSC Section
			document.querySelector('#snyscCertNo').textContent = sumData.education.nyscCertificateNumber || 'N/A';
			document.querySelector('#snyscYOS').textContent = sumData.education.yearOfService || 'N/A';
			document.querySelector('#snyscCert').href = sumData.education.nyscFilePath || '#';

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
			document.querySelector('#smemCert').href = sumData.pmc_details.pmcFilePath || '#';
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
				} else if(status.status === 'eejected') {
					statusButton.style.backgroundColor = 'red';
					statusButtoninnerTexts = status.status;  
				} else if(status.status === 'interviewed'){
					statusButton.style.backgroundColor = 'blue';
					statusButton.innerText = status.status; 
				} else {
					statusButton.style.backgroundColor = 'blue';
					statusButton.innerText = status.status; 
				}
				
				// Optionally, update the button or send an update request to the backend
				alert("Status updated to: " + status.status); // Notify the user of the status change
			});
		}

		// On page load, check if there's a stored section and show it
		window.addEventListener('DOMContentLoaded', function() {
			const activeSection = localStorage.getItem('activeSection') || 'sort_applicant';
			showSection(activeSection);
		});
		
		// Initialize when DOM is loaded
		document.addEventListener('DOMContentLoaded', () => {
			// Initialize functions
			checkSession();
			loadAdminData();
			loadStats();
			loadApplicants();
			handleStatusUpdate();
			// fetchUserData();
			fetchUserBio();
			fetchUserEducation();
			fetchUserWork();
			fetchUserPmc();
			fetchUserSum();
			fetchUserStatus();
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

		});

		
		


	</script>

</head>
<body>

	<style>
		/* General Styles */
		body {
			font-family: Arial, sans-serif;
			background-color: #f8f9fa;
			color: #333;
		}

		.container {
			margin: 20px auto;
			padding: 20px;
			max-width: 1200px;
		}

		/* Table Styles */
		table {
			width: 100%;
			border-collapse: collapse;
			background-color: #fff;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}

		th, td {
			padding: 12px 15px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		th {
			background-color: #00044B;
			color: #fff;
		}

		tr:hover {
			background-color: #f1f1f1;
		}

		.details-row {
			background-color: #f9f9f9;
		}

		.table-responsive {
			overflow-x: auto;
		}

		/* Image Styling */
		img {
			border-radius: 50%;
			width: 50px;
			height: 50px;
		}
		.statusForm{
			display:flex;
			justify-content: space-evenly;
			width:100%;
		}

		/* Button Styling */
		button {
			padding: 8px 16px;
			border-radius: 4px;
			font-size: 14px;
			cursor: pointer;
			transition: background-color 0.3s;
		}

		.btn-primary {
			background-color: #00044B;
			color: #fff;
			border: none;
		}

		.btn-primary:hover {
			background-color: #111683;
		}

		.btn-warning {
			background-color: #ffc107;
			color: #fff;
			border: none;
		}

		.btn-warning:hover {
			background-color: #e0a800;
		}

		.btn-danger {
			background-color: #dc3545;
			color: #fff;
			border: none;
		}

		.btn-danger:hover {
			background-color: #c82333;
		}

		.button-container {
			display: flex;
			gap: 10px;
		}

		/* Modal Styling */
		.modal {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			justify-content: center;
			align-items: center;
			z-index: 1000;
		}

		.modal-content {
			background-color: #fff;
			padding: 20px;
			border-radius: 8px;
			width: 400px;
			text-align: center;
			position: relative;
		}

		.modal .close {
			position: absolute;
			top: 10px;
			right: 10px;
			font-size: 20px;
			cursor: pointer;
		}

		/* Action Column */
		th.action-column, td.action-column {
			width: 120px;
			text-align: center;
		}
		.panel-btn{
			display:none;
		}

		/* Responsive Styles */
		@media (max-width: 768px) {
			table {
				font-size: 14px;
			}

			.details-row {
				font-size: 12px;
			}

			.button-container {
				align-items: stretch;
				justify-content: space-evenly;
			}

			.button {
				width: 100%;
				margin-bottom: 10px;
			}
			.panel-btn{
				display: block;
				position: absolute;
				top: 0;
				right: -40px;
				z-index: 9999;
				background-color: #00044B;
				color: #fff;
				padding: 10px;
				border-radius: 0 5px 5px 0;
			}
		}
		.pagination {
			justify-content: center;
			margin-top: 20px;
		}

		.pagination-info {
			text-align: center;
			margin-top: 10px;
			color: #666;
		}

	</style>
	<style>
		.container_ {
		width: 100%;
		max-width: 500px;
		margin: 50px auto;
		}

		.card_ {
			background: white;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
		}

		.form-group {
			margin-bottom: 15px;
		}

		label {
			display: block;
			font-weight: bold;
			margin-bottom: 5px;
		}

		.form-control, .form-select {
			width: 100%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}
		.sp{
			padding: 20px;
		}
		.btn-primary{
			width: 95%;
		}
	</style>

	<!--Topbar -->
	<div class="transition admin_top_nav" style="padding: 0 10px;">
		<div class="bars">
			<div class="hdd-text mx-4 mt-3 fs-2">
				<h4 class="" style="color: #00044B;">University of Ilorin Admin Dashboard</h4>
			</div>
		</div>

		<div class="bars flex-bar">
			<div class="menu mx-5">
				<ul class="mx-5">
					<li class="nav-item dropdown _flex" id="admin-id-display">
						<img src="./assets/images/avatar/avatar-1.png" alt="" id="admin-avatar">
						<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
					</li>
				</ul>
			</div>

			<div id="admin-controls">
				<!-- This will be populated by JavaScript -->
			</div>
		</div>
	</div>

	<div class="main">


		<!-- Sorted Applicant -->
		<div id="sort_applicant">
			<div id="dashboard_alert_con"></div>

			<div class="content-start transition">
				
				<!-- Done -->
				<div id="dashboard" class="row">
					<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
				</div>

				<!-- Search -->
				<div id="query-navbar" class="col-12">
					<form action="" method="post" id="filterForm">
						<div>
							<select name="position" id="filter_position">
								<option value="">--All Position--</option>
							</select>
						</div>
						<div>
							<select name="status" id="filter_status">
								<option value="">--All Status--</option>
								<option value="Pending">Pending</option>
								<option value="Interviewed">Interviewed</option>
								<option value="shortlisted">shortlisted</option>
								<option value="Rejected">Rejected</option>
							</select>
						</div>
						<div>
							<input type="text" id="filter_nin" name="nin" placeholder="1234567890" value="">
						</div>
						<!-- <div>
							<button style="padding:5px" name="search">
								<svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24"><path fill="#fff" fill-rule="evenodd" d="M10.44 2.75a7.69 7.69 0 1 0 4.615 13.842c.058.17.154.329.29.464l3.84 3.84a1.21 1.21 0 0 0 1.71-1.712l-3.84-3.84a1.2 1.2 0 0 0-.463-.289A7.69 7.69 0 0 0 10.44 2.75m-5.75 7.69a5.75 5.75 0 1 1 11.5 0a5.75 5.75 0 0 1-11.5 0" clip-rule="evenodd"/></svg>
							</button>
						</div> -->
						
					</form>
				</div>

				<div id="content">
					<div class="row" style="margin-top:20px">
						<div class="postion-body">
							<div class="col-md-12" id="applicants-table-container">
							<!-- Table will be loaded here via JavaScript -->

								<svg xmlns="http:/-/www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
							</div>
						</div>
					</div>
				</div>

				<!-- Pagnation -->
				<div id="pagination-container" class="mt-3"></div>
				
			</div>
		</div>

		<!-- Add Applicant -->
		<div id="add_applicant">
			<div class="db-winscroll">
				
				<div id="db-panel">
					<div class="panel-btn">
						<i id="toggle_panel" onclick="closePanelHandler()" class="fa fa-bars" style="cursor:pointer; margin-left: 10px"></i>
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
   					<div id="alert-container-application"></div>

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
		<div id="create_admin">
			<?php include_once('./include/createAdmin.php') ?>
		</div>
	
	</div>
	
	<!-- Footer -->
	<div id="footer">
		<div class="left-footer">
			<p>Copyright &copy; 2024 University Of Ilorin. All Rights Reserved</p>
		</div>
		<div class="right-footer">
			<button id="logoutBtn" name="logoutBtn" style="width:100px">
				Log out
			</button>
		</div>
	</div>

	<!-- <script src="./script/get_script.js"></script> -->
	<script>
		let openPanel = false;

		function closePanelHandler() {
			const panel = document.getElementById('toggle_panel');
			const dbPanel = document.getElementById('db-panel');

			if (!openPanel){
				dbPanel.style.transform = "translateX(0px)";
				openPanel = true;
			} else {
				dbPanel.style.transform = "translateX(-180px)";
				openPanel = false;
			}
		}
		
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
		const positionSelect = document.getElementById("filter_position");

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
	<!-- Template JS File -->
	<script src="assets/js/script.js"></script>
	<script type="module" src="../scripts/main.js"></script>
	<script src="./script/auth/register.js"></script>
	<script src="./script/auth/logout.js"></script>

</body>

</html>