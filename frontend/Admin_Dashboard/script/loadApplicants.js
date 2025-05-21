function showLoading() {
if (this.tableContainer) {
    this.tableContainer.innerHTML = `
    <div class="text-center py-4">
        <div class="spinner-border" role="status">
			<svg xmlns="http:/-/www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="#00045c"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
        </div>
        <p>Loading applicants...</p>
    </div>
    `;
}
}

function renderTable(applicants) {
    if (!this.tableContainer) return;

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
                ${this.adminRole === 'sup_admin' ? '<th scope="col">Action</th>' : ''}
            </tr>
            </thead>
            <tbody>
    `;

    if (applicants.length === 0) {
        html += `
        <tr>
            <td colspan="${this.adminRole === 'sup_admin' ? '7' : '6'}">No applicants found</td>
        </tr>
        `;
    } else {
        applicants.forEach((applicant, index) => {
        html += this.renderApplicantRow(applicant, index);
        });
    }

    html += `
            </tbody>
        </table>
        </div>
    `;

    this.tableContainer.innerHTML = html;
}

function renderApplicantRow(applicant, index) {
    return `
        <tr>
        <td>${index + 1}</td>
        <td>
            <a href="../Application_Dashboard/${applicant.passport_file_path}" target="_blank">
            <img src="../Application_Dashboard/${applicant.passport_file_path}" 
                alt="${applicant.lastname}" 
                width="50" height="50" style="border-radius:50%">
            </a>
        </td>
        <td>${applicant.email}</td>
        <td>${applicant.score_percentage}</td>
        <td>${applicant.created_at}</td>
        <td>
            <button id="btn_${index}" 
            class="btn btn-primary" 
            onclick="applicantsModule.toggleDetails(${index})">
            View Details
            </button>
        </td>
        ${this.adminRole === 'sup_admin' ? `
        <td>
            <form action="" method="post" id="editSubmit_${applicant.user_id}" style="all:unset">
            <input type="hidden" id="edituser_${applicant.user_id}" 
                name="editUser" value="${applicant.user_id}">
            <button type="submit" name="saveEditUser" class="btn btn-primary">Edit</button>
            </form>
        </td>
        ` : ''}
        </tr>
        <tr class="details-row" id="details_${index}" style="display:none;">
        <td colspan="${this.adminRole === 'sup_admin' ? '7' : '6'}">
            ${this.renderApplicantDetails(applicant)}
        </td>
        </tr>
    `;
}

function renderApplicantDetails(applicant) {
    return `
        <table style="width: 100%;" class="table">
        <tbody>
            <tr>
            <td><strong>Position:</strong> ${applicant.position}</td>
            </tr>
            <tr>
            <td><strong>Firstname:</strong> ${applicant.firstname}</td>
            <td><strong>Middlename:</strong> ${applicant.middlename}</td>
            <td><strong>Lastname:</strong> ${applicant.lastname}</td>
            </tr>
            <tr>
            <td><strong>Gender:</strong> ${applicant.gender}</td>
            <td><strong>DOB:</strong> ${applicant.dateOfBirth}</td>
            <td><strong>MS:</strong> ${applicant.maritalStatus}</td>
            </tr>
            <!-- Continue with other details... -->
            <tr>
            <td>
                ${this.adminRole === 'sup_admin' ? this.renderStatusForm(applicant.user_id) : ''}
            </td>
            </tr>
        </tbody>
        </table>
    `;
}

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
            onclick="confirmHandler('${userId}', 'unemployed')">
            Unemployed
          </button>
        </div>
  
        <div id="statusModal_${userId}" class="modal" style="display: none;">
          <div class="modal-content">
            <span class="close" onclick="closeModal('${userId}')">&times;</span>
            <p id="modalMessage_${userId}"></p>
            <button type="submit" name="saveStatus" class="btn confirm-button">
              Confirm
            </button>
          </div>
        </div>
      </form>
    `;
}

function toggleDetails(index) {
    const detailsRow = document.getElementById(`details_${index}`);
    const button = document.getElementById(`btn_${index}`);

    if (detailsRow.style.display === "none" || detailsRow.style.display === "") {
        detailsRow.style.display = "table-row";
        button.textContent = "Hide Details";
    } else {
        detailsRow.style.display = "none";
        button.textContent = "View Details";
    }
}

function confirmHandler(userId, status) {
    const statusInput = document.getElementById(`statusInput_${userId}`);
    const modal = document.getElementById(`statusModal_${userId}`);
    const modalMessage = document.getElementById(`modalMessage_${userId}`);
    const confirmButton = modal.querySelector('.confirm-button');
  
    // Set the status value
    statusInput.value = status;
  
    // Update modal message and button style
    if (status === 'shortlisted') {
      modalMessage.textContent = 'Are you sure you want to shortlist this applicant?';
      confirmButton.className = 'btn btn-success confirm-button';
    } else if (status === 'interviewed') {
      modalMessage.textContent = 'Are you sure this applicant has been interviewed?';
      confirmButton.className = 'btn btn-warning confirm-button';
    } else {
      modalMessage.textContent = 'Are you sure you want to decline this applicant?';
      confirmButton.className = 'btn btn-danger confirm-button';
    }
  
    // Show the modal
    modal.style.display = 'block';
  }

function closeModal(userId) {
    const modal = document.getElementById(`statusModal_${userId}`);
    if (modal) modal.style.display = "none";
}

// setupEventListeners() {
//     // Handle form submissions via AJAX
//     document.addEventListener('submit', async (e) => {
//         if (e.target.classList.contains('statusForm')) {
//         e.preventDefault();
//         await this.handleStatusUpdate(e.target);
//         }
//     });
// }

// const handleStatusUpdate = async (form) => {
//     const formData = new FormData(form);
//     const userId = formData.get('user_id');

//     try {
//         const response = await fetch('/api/applicants/update-status', {
//         method: 'POST',
//         body: formData,
//         headers: {
//             'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
//         }
//         });

//         const result = await response.json();
        
//         if (result.success) {
//         alert('Status updated successfully');
//         this.closeModal(userId);
//         this.loadApplicants(); // Refresh the list
//         } else {
//         throw new Error(result.error || 'Failed to update status');
//         }
//     } catch (error) {
//         console.error('Status update error:', error);
//         alert('Error updating status: ' + error.message);
//     }
// }

// const loadApplicants = async () => {
//     try {
//       this.showLoading();
      
//       const response = await fetch(this.endpoint, {
//         credentials: 'include',
//         headers: {
//           'Authorization': `Bearer ${localStorage.getItem('admin_token')}`
//         }
//       });

//       if (!response.ok) throw new Error('Network response failed');

//       const { success, data, error } = await response.json();
      
//       if (!success) throw new Error(error || 'Failed to load applicants');
      
//       this.adminRole = data.adminRole;
//       this.renderTable(data.applicants);
//     } catch (error) {
//       console.error('Applicants load error:', error);
//       this.showError(error.message);
//     }
// }
