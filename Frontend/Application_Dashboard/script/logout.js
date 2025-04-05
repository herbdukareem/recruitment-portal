document.getElementById('logout').addEventListener('click', async () => {
    try {
        // Call server-side logout
        const response = await fetch('/test/backend/auth/user/logout', {
          method: 'POST',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': `Bearer ${localStorage.getItem('user_token')}`
          }
        });
    
        // Clear all client-side storage regardless of server response
        localStorage.removeItem('user_token');
        localStorage.removeItem('csrf_token');
        sessionStorage.removeItem('session_valid');
        
        // Clear cookies by expiring them
        document.cookie = 'PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        
        // Redirect to login page with cache-busting
        window.location.href = './Auth/auth.php?display=login&t=' + Date.now();
      } catch (error) {
        console.error('Logout failed:', error);
        // Still clear client-side data and redirect
        localStorage.clear();
        sessionStorage.clear();
        window.location.href = './Auth/auth.php?display=login';
      }
});