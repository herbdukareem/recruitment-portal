document.getElementById('logoutBtn').addEventListener('click', async () => {
    try {
        const response = await fetch('/test/backend/auth/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        });
        console.log("clicked")

        const data = await response.json();

        if (response.ok) {
            // Clear client-side storage and redirect
            localStorage.removeItem('admin');
            window.location.href = './auth.php';
        } else {
            showAlert(data.error || 'Logout failed', 'danger');
        }
    } catch (error) {
        showAlert('Network error', 'danger');
    }
});