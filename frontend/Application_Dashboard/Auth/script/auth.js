// Email Validator
const validateHandler = (key, message) => {
        let emailValue = key.value.trim();

        if (emailValue === '') {
            showAlert('alert_container', 'Email is required. Please enter your email.', 'danger');
            return false
        }

        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(emailValue)) {
            showAlert('alert_container', 'Please enter a valid email address.', 'danger');
            return false
        }

        return true;
    };

// Login Script
document.getElementById('login_section').addEventListener('submit', async (e) => {
    e.preventDefault();
    const emailInput = document.getElementById('lemail');
    const ninInput = document.getElementById('lnin');
    const passwordInput = document.getElementById('lpass');

    // Initialize formData with password (if it exists)
    const formData = {
        password: passwordInput ? passwordInput.value : ''
    };

    // Add email or nin (whichever is available)
    if (emailInput && emailInput.value) {
        formData.email = emailInput.value;
    } else if (ninInput && ninInput.value) {
        formData.nin = ninInput.value;
    }

    try {
        const response = await fetch(`${API_URI}auth/user/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });

        // Get rate limit info from headers
        const limit = response.headers.get('X-RateLimit-Limit');
        const remaining = response.headers.get('X-RateLimit-Remaining');
        const reset = response.headers.get('X-RateLimit-Reset');
        
        console.log(`Requests: ${remaining}/${limit}`);
        console.log(`Window resets at: ${new Date(reset * 1000)}`);
        
        if (response.status === 429) {
            const retryAfter = response.headers.get('Retry-After');
            showAlert('alert_container', `Too many requests. Try again in ${retryAfter} seconds.`, 'danger');
        }

        const data = await response.json();
        console.log('finally')
        if (response.ok) {
            console.log(data)
            showAlert('alert_container', 'Login Successful', 'sucess');
            // Store admin data and redirect
            localStorage.setItem('csrf_token', JSON.stringify(data.csrf_token));
            localStorage.setItem('user', JSON.stringify(data.user));

            window.location.href = '../index.php';
        } else {
            showAlert('alert_container', data.error || 'Login failed', 'danger');
        }
    } catch (error) {
        showAlert('alert_container', 'Something went wrong', 'danger');
    }

});

function getCsrfToken() {
    return document.querySelector('meta[name="user-token"]').getAttribute('content');
}

// Sign Up Script
document.getElementById('signup_section').addEventListener('submit', async (e) => {
    e.preventDefault();
    let firstname =  document.getElementById('sfname');
    let lastname =  document.getElementById('slname');
    let email =  document.getElementById('semail');
    let nin =  document.getElementById('snin');
    let password =  document.getElementById('spass');
    let confirm_password =  document.getElementById('scpass');

    const formData = {
        firstname: firstname.value,
        lastname: lastname.value,
        email: email.value,
        nin: nin.value,
        password: password.value,
        confirm_password: confirm_password.value
    };

    try {
        const response = await fetch(`${API_URI}auth/user/signup`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (data.success) {
            showAlert('alert_container', 'Account created successfully!', 'success');
            localStorage.setItem('user_id', JSON.stringify(data.user));
            window.location.href = '../index.php';
            setTimeout(() => {
                lastname.value = '';
                firstname.value = '';
                email.value = '';
                nin.value = '';
                password.value = '';
                confirm_password    .value = '';
            }, 1500);
        } else {
            showAlert('alert_container', data.error || 'Registration failed', 'danger');
        }
    } catch (error) {
        showAlert('alert_container', 'Something went wrong', 'danger');
    }
});

// Forgot Password Script
document.getElementById('forgot_password_section').addEventListener('submit', async (e) => {
    e.preventDefault()
    const email  = document.getElementById('resetEmail');
    let emailValue = email.value.trim();


    try {
        if (emailValue === '') {
            showAlert('alert_container', 'Email is required. Please enter your email.', 'danger');
            return false
        }

        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(emailValue)) {
            showAlert('alert_container', 'Please enter a valid email address.', 'danger');
            return false
        }
        const response = await fetch(`${API_URI}auth/user/reset-request`, {
            method: 'POST',
            headers: {
                'content-type': 'application/json',
            },
            body: JSON.stringify(email.value)
        });
        const data = response.json()
        if(data.success){
            return showAlert('alert_container', 'Password resent link sent successfully', 'success');
        } else {
            return showAlert('alert_container', 'Unable to send password reset link.', 'danger');
        }
    } catch (error) {
        showAlert('alert_container', 'Something went wrong', 'danger');
    };
})

// Helper to get query params from URL
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// Password Reset Script
document.getElementById('password_reset_section').addEventListener('submit', async (e) => {
    e.preventDefault();

    const password = document.getElementById('reset_password');
    const confirmPassword = document.getElementById('reset_confirm_password');

    const passwordValue = password.value.trim();
    const confirmPasswordValue = confirmPassword.value.trim();

    // Extract token and email from URL
    const token = getQueryParam('token');
    const email = getQueryParam('email');

    // Basic validation
    if (!passwordValue || !confirmPasswordValue) {
        showAlert('alert_container', 'Both password fields are required.', 'danger');
        return;
    }
    if (passwordValue.length < 6) {
        showAlert('alert_container', 'Password must be at least 6 characters.', 'danger');
        return;
    }
    if (passwordValue !== confirmPasswordValue) {
        showAlert('alert_container', 'Passwords do not match.', 'danger');
        return;
    }
    if (!token || !email) {
        showAlert('alert_container', 'Invalid or missing reset token/email.', 'danger');
        return;
    }

    try {
        const response = await fetch(`${API_URI}auth/user/reset-password`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                password: passwordValue,
                confirm_password: confirmPasswordValue,
                token: token,
                email: email
            })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showAlert('alert_container', 'Password reset successful!', 'success');
            setTimeout(() => {
                password.value = '';
                confirmPassword.value = '';
                window.location.href = './Auth/auth?display=login';
            }, 1500);
        } else {
            showAlert('alert_container', data.error || 'Password reset failed.', 'danger');
        }
    } catch (error) {
        showAlert('alert_container', 'Something went wrong. Please try again.', 'danger');
    }
});
