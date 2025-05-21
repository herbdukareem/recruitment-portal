// Application state management
const AppState = {
    currentUser: null,
    formData: {},
    
    init() {
        // Check for existing session
        this.checkSession();
        // Set up form handlers
        this.setupFormHandlers();
    },

    showAddApplicantForm() {
        // Implementation for showing add applicant form
    },

    showCreateAdminForm() {
        // Implementation for showing create admin form
    },

    toggleSidebar() {
        const sidebar = document.getElementById('admin_sidebar');
        sidebar.classList.toggle('active');
    },

    async checkSession() {
        try {
            console.log('Initiating session check...');
            
            const response = await fetch(`${API_URI}admin/session`, {
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
            
            showAlert('Session verification failed. Please login again.', 'danger');
            
            // For network errors, don't redirect immediately - might be temporary
            if (error.name !== 'TypeError') {
                localStorage.removeItem('admin_token');
                window.location.href = 'auth.php';
            }
            
            return false;
        }
    },
    
    setupFormHandlers() {
        // Biodata form
        document.getElementById('bioForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.submitForm('bio', new FormData(e.target));
        });
        
        // Education form
        document.getElementById('eduForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.submitForm('education', new FormData(e.target));
        });
        
        // Work history form
        document.getElementById('workForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.submitForm('work', new FormData(e.target));
        });
        
        // PMC form
        document.getElementById('pmcForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.submitForm('pmc', new FormData(e.target));
        });
        
        // File upload form
        document.getElementById('fileForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.uploadFiles(new FormData(e.target));
        });
    },
    
    async submitForm(endpoint, formData) {
        try {
            const response = await fetch(`/backend/${endpoint}`, {
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showSuccess(data.message);
                if (data.next) {
                    this.navigateToStep(data.next);
                }
            } else {
                this.showError(data.error || 'Submission failed');
            }
        } catch (error) {
            console.error('Form submission error:', error);
            this.showError('Network error');
        }
    },
    
    async uploadFiles(formData) {
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
    },
    
    navigateToStep(step) {
        window.location.href = `#${step}`;
        document.getElementById(`${step}-section`).scrollIntoView();
    },
    
    showSuccess(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success';
        alert.textContent = message;
        document.body.prepend(alert);
        setTimeout(() => alert.remove(), 5000);
    },
    
    showError(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger';
        alert.textContent = message;
        document.body.prepend(alert);
        setTimeout(() => alert.remove(), 5000);
    },
    
    updateUI() {
        // Update UI based on current user state
        if (this.currentUser) {
            document.getElementById('user-name').textContent = 
                `${this.currentUser.firstname} ${this.currentUser.lastname}`;
        }
    },

   // Fetch basic user info
    async fetchUserData() {
        try {
            const response = await fetch(`${API_URI}user/data`);
            const data = await response.json();
            
            if (data.success) {
                displayUserInfo(data.data);
            } else {
                showError(data.error);
            }
        } catch (error) {
            showError('Failed to fetch user data');
        }
    },

    // Fetch all user data for profile view
    async fetchFullProfile() {
        try {
            const response = await fetch('/backend/user/full');
            const data = await response.json();
            
            if (data.success) {
                renderProfilePage(data.data);
            } else {
                showError(data.error);
            }
        } catch (error) {
            showError('Failed to load profile');
        }
    },

    // Example display function
    displayUserInfo(user) {
        document.getElementById('user-name').textContent = 
            `${user.firstname} ${user.lastname}`;
        document.getElementById('user-email').textContent = user.email;
        // ... other fields
    },

    async loadFullProfile() {
        try {
            const response = await fetch('/backend/api/user/full.php', {
                headers: {
                    'Authorization': `Bearer ${getAuthToken()}`,
                    'X-CSRF-Token': getCsrfToken()
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Access organized data
                console.log('User email:', data.data.basic.email);
                console.log('Work history:', data.data.work_history);
                
                // Display profile photo if available
                if (data.data.files.passport) {
                    document.getElementById('profile-photo').src = data.data.files.passport;
                }
            } else {
                showError(data.error);
            }
            
            // Check rate limits
            console.log('API calls remaining:', 
                response.headers.get('X-RateLimit-Remaining'));
            
        } catch (error) {
            showError('Failed to load profile');
        }
    },

    // Fetch basic user info
    async getUserBasicInfo() {
        try {
            const response = await fetch('/backend/user/data', {
                headers: {
                    'Authorization': `Bearer ${getAuthToken()}`,
                    'X-CSRF-Token': getCsrfToken()
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                updateUserProfile(data.data);
                displayRateLimitInfo(response.headers);
            } else {
                showError(data.error);
            }
        } catch (error) {
            showError('Failed to load user data');
        }
    },

    // User profile
    // Fetch complete profile
    async getFullProfile() {
        try {
            const response = await fetch('/backend/user/data?full=true', {
                headers: {
                    'Authorization': `Bearer ${getAuthToken()}`,
                    'X-CSRF-Token': getCsrfToken()
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                renderCompleteProfile(data.data);
                displayRateLimitInfo(response.headers);
            } else {
                showError(data.error);
            }
        } catch (error) {
            showError('Failed to load profile');
        }
    },

    // Display rate limit info from headers
    displayRateLimitInfo(headers) {
        const limit = headers.get('X-RateLimit-Limit');
        const remaining = headers.get('X-RateLimit-Remaining');
        console.log(`API calls: ${remaining}/${limit} remaining`);
    },

    async loadPositionOptions() {
        try {
            const response = await fetch('/backend/api/public/positions.php');
            const data = await response.json();
            
            if (data.success) {
                // Example: Populate a dropdown
                const select = document.getElementById('position-select');
                for (const [type, positions] of Object.entries(data.data)) {
                    const optgroup = document.createElement('optgroup');
                    optgroup.label = type;
                    positions.forEach(position => {
                        const option = document.createElement('option');
                        option.value = position;
                        option.textContent = position;
                        optgroup.appendChild(option);
                    });
                    select.appendChild(optgroup);
                }
            }
        } catch (error) {
            console.error('Failed to load positions:', error);
        }
    },

    async loadStatusOptions() {
        try {
            const response = await fetch('/backend/api/public/statuses.php?with_counts=true');
            const data = await response.json();
            
            if (data.success) {
                // Example: Create status filter chips
                const container = document.getElementById('status-filters');
                data.data.forEach(status => {
                    const chip = document.createElement('div');
                    chip.className = `status-chip ${status.value}`;
                    chip.innerHTML = `
                        <span class="status-label">${status.label}</span>
                        <span class="status-count">(${status.count})</span>
                        <span class="status-tooltip">${status.description}</span>
                    `;
                    container.appendChild(chip);
                });
            }
        } catch (error) {
            console.error('Failed to load statuses:', error);
        }
    },

};

// Initialize application when DOM is loaded
document.addEventListener('DOMContentLoaded', () => AppState.init());