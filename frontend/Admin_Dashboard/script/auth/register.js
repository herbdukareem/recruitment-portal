document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    let adminIdValue =  document.getElementById('admin_id');
    let adminRoleValue =  document.getElementById('admin_role');
    let adminPasswordValue =  document.getElementById('password');
    let adminCPasswordValue =  document.getElementById('confirm_password');

    const formData = {
        admin_id: adminIdValue.value,
        admin_role: adminRoleValue.value,
        password: adminPasswordValue.value,
        confirm_password: adminCPasswordValue.value
    };

    try {
        const response = await fetch(`${API_URI}auth/admin/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok) {
            showAlert('register_alert_con', 'Admin created successfully!', 'success');
            setTimeout(() => {
                adminIdValue.value = '';
                adminRoleValue.value = '';
                adminPasswordValue.value = '';
                adminCPasswordValue.value = '';
            }, 1500);
        } else {
            showAlert('register_alert_con', data.error || 'Registration failed', 'danger');
        }
    } catch (error) {
        showAlert('register_alert_con', 'Network error', 'danger');
    }
});
