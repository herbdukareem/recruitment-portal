export function openPanelHandler() {
    document.getElementById('db-panel').style.transform = "translateX(0)";
    document.getElementById('close_panel').style.display = 'block';
}

export function closePanelHandler() {
    document.getElementById('db-panel').style.transform = "translateX(-180px)";
    document.getElementById('close_panel').style.display = 'none';
}

export function toggleButtonHandler() {
    const sidebar = document.getElementById('all_applicant_sidebar');
    const toggleButton = document.getElementById('sidebar-toggle');
    let sidebarOpen = sidebar.style.left === '0px';

    if (!sidebarOpen) {
        sidebar.style.left = '0';
        toggleButton.style.zIndex = 98;
        toggleButton.style.transform = 'translateX(250px)';
    } else {
        sidebar.style.left = '-275px';
        toggleButton.style.zIndex = 0;
        toggleButton.style.transform = 'translateX(0)';
    }
}

export function adminSidebarToggleHandler() {
    document.getElementById('admin_sidebar').style.right = "0";
    console.log('clicked')
}
