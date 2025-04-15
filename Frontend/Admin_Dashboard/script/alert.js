function showAlert(id, message, type = 'info', duration = 2000) {
    const alertCon = document.getElementById(id);
    
    // Create alert element
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    // Add message content
    const messageSpan = document.createElement('span');
    messageSpan.textContent = message;
    alert.appendChild(messageSpan);
    
    // Add close button
    const closeBtn = document.createElement('button');
    closeBtn.className = 'alert-close';
    closeBtn.innerHTML = '&times;';
    closeBtn.addEventListener('click', () => removeAlert(alert));
    alert.appendChild(closeBtn);
    
    // Add progress bar if duration > 0
    if (duration > 0) {
        const progress = document.createElement('div');
        progress.className = 'alert-progress';
        const progressBar = document.createElement('div');
        progressBar.className = 'alert-progress-bar';
        progressBar.style.animationDuration = `${duration}ms`;
        progress.appendChild(progressBar);
        alert.appendChild(progress);
        
        // Auto-remove after duration
        setTimeout(() => removeAlert(alert), duration);
    }
    
    // Add to container
    alertCon.appendChild(alert);
    
    // Remove alert function
    function removeAlert(alertElement) {
        alertElement.style.animation = 'slideIn 0.3s ease-out reverse forwards';
        setTimeout(() => {
            if (alertElement.parentNode === alertCon) {
                alertCon.removeChild(alertElement);
            }
        }, 300);
    }
    
    // Return remove function in case caller wants to dismiss manually
    return () => removeAlert(alert);
}
