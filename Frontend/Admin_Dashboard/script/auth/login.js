document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = {
        admin_id: document.getElementById('admin_id').value,
        admin_password: document.getElementById('admin_password').value
    };

    try {
        const response = await fetch('/test/backend/auth/admin/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });

        console.log(response)
        // Get rate limit info from headers
        const limit = response.headers.get('X-RateLimit-Limit');
        const remaining = response.headers.get('X-RateLimit-Remaining');
        const reset = response.headers.get('X-RateLimit-Reset');
        
        console.log(`Requests: ${remaining}/${limit}`);
        console.log(`Window resets at: ${new Date(reset * 1000)}`);
        
        if (response.status === 429) {
            const retryAfter = response.headers.get('Retry-After');
            showAlert('admin_login', `Too many requests. Try again in ${retryAfter} seconds.`, 'danger');
        }

        const data = await response.json();

        if (response.ok) {
            showAlert('login_alert', 'Login Successful', 'sucess');
            // Store admin data and redirect
            localStorage.setItem('admin', JSON.stringify(data.admin));
            localStorage.setItem('admin_token', JSON.stringify(data.admin_token));
            window.location.href = 'admin.php';
        } else {
            showAlert('admin_login', data.error || 'Login failed', 'danger');
        }
    } catch (error) {
        showAlert('admin_login', 'Network error', 'danger');
    }
});

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

