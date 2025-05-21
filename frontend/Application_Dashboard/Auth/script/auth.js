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
        const response = await fetch('/test/backend/auth/user/login', {
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
        const response = await fetch('/test/backend/auth/user/signup', {
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
