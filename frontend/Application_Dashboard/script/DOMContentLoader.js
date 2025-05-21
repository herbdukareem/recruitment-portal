document.addEventListener("DOMContentLoaded", function(){
    // Buttons and Screens Mapping
    const screens = {
        "cbt-btn": "cbt-screen",
        "bio-btn": "biodata-screen",
        "edu-btn": "education-screen",
        "work-btn": "work-screen",
        "pmc-btn": "pmc-screen",
        "sum-btn": "summary-screen",
        "app-status-btn": "application-screen"
    };

    // Get all buttons and screens
    const buttons = Object.keys(screens).map(id => document.getElementById(id));
    const screensElements = Object.values(screens).map(id => document.getElementById(id));

    // Add event listeners to all buttons
    buttons.forEach(button => {
        button.addEventListener("click", (e) => {
            // Reset all button backgrounds and hide all screens
            buttons.forEach(btn => btn.style.background = "none");
            screensElements.forEach(screen => screen.style.display = "none");

            // Highlight the clicked button and display the corresponding screen
            e.target.style.background = "#ffffff50";
            document.getElementById(screens[e.target.id]).style.display = "block";
        });
    });

    
    // Button and Screen Mapping
    const educationSections = {
        "pri-btn": "primary",
        "sec-btn": "secondary",
        "higher-btn": "higher",
        "nysc-btn": "nysc"
    };

    // Get all buttons and screens
    const eduButtons = Object.keys(educationSections).map(id => document.getElementById(id));
    const eduScreens = Object.values(educationSections).map(id => document.getElementById(id));

    // Add event listeners to all buttons
    eduButtons.forEach(button => {
        button.addEventListener("click", (e) => {
            // Reset all buttons' styles
            eduButtons.forEach(btn => {
                btn.style.color = "blue"; 
                btn.style.borderStyle = "none";
            });

            // Hide all screens
            eduScreens.forEach(screen => screen.style.display = "none");

            // Apply styles to the active button and show the corresponding screen
            e.target.style.color = "black";
            e.target.style.borderStyle = "solid";
            document.getElementById(educationSections[e.target.id]).style.display = "block";
        });
    });

    // JavaScript to display the correct section based on the URL hash
    window.onload = function () {
        // Hide all sections by default
        document.getElementById('biodata-screen').style.display = 'none';
        document.getElementById('education-screen').style.display = 'none';
        document.getElementById('work-screen').style.display = 'none';
        document.getElementById('pmc-screen').style.display = 'none';
        document.getElementById('summary-screen').style.display = 'none';
        document.getElementById('cpl-screen').style.display = 'none';

        // Check which section to display based on the URL hash
        if (window.location.hash === "#application-status_screen") {
            document.getElementById('application-status_screen').style.display = 'block';
        } else if (window.location.hash === "#education-screen") {
            document.getElementById('education-screen').style.display = 'block';
        } else if (window.location.hash === "#work-screen") {
            document.getElementById('work-screen').style.display = 'block';
        } else if (window.location.hash === "#pmc-screen") {
            document.getElementById('pmc-screen').style.display = 'block';
        } else if (window.location.hash === "#summary-screen") {
            document.getElementById('summary-screen').style.display = 'block';
        } else if (window.location.hash === "#cpl-screen") {
            document.getElementById('cpl-screen').style.display = 'block';
        } else {
            document.getElementById('biodata-screen').style.display = 'block';
        }
    };

      //db-pannel control
    const openPanel = document.getElementById('open_panel');
    const closePanel = document.getElementById('close_panel');
    const dbPanel = document.getElementById('db-panel');

    
    openPanel.addEventListener('click', (e)=>{
        dbPanel.style.transform = "translateX(0)"
        closePanel.style.display = 'block'
    });
    closePanel.addEventListener('click', (e)=>{
        dbPanel.style.transform = "translateX(-180px)"
        closePanel.style.display = 'none'

    });

    function initializeNavigation() {
        // Buttons and Screens Mapping
        const screens = {
            "cpl-btn": "cpl-screen",
            "bio-btn": "biodata-screen",
            "edu-btn": "education-screen",
            "work-btn": "work-screen",
            "pmc-btn": "pmc-screen",
            "sum-btn": "summary-screen",
            "app-status-btn": "application-status_screen",
        };

        function getVisibleButtons() {
            return Object.keys(screens)
                .map(id => document.getElementById(id))
                .filter(btn => btn && getComputedStyle(btn).display !== "none"); // Only visible buttons
        }

        function getExistingScreens() {
            return Object.values(screens)
                .map(id => document.getElementById(id))
                .filter(screen => screen); // Ignore missing screens
        }

        function attachEventListeners() {
            const buttons = getVisibleButtons();
            const screensElements = getExistingScreens();

            buttons.forEach(button => {
                button.addEventListener("click", (e) => {
                    // Reset all button backgrounds and hide all screens
                    buttons.forEach(btn => btn.style.background = "none");
                    screensElements.forEach(screen => screen.style.display = "none");

                    // Highlight the clicked button and display the corresponding screen
                    e.target.style.background = "#bd911985";
                    const targetScreen = screens[e.target.id];
                    if (targetScreen) {
                        document.getElementById(targetScreen).style.display = "block";
                    }
                });
            });
        }

        // Run function to attach listeners only to visible buttons
        attachEventListeners();

        // Observe DOM changes (like hiding "cpl-btn") and reinitialize
        const observer = new MutationObserver(() => {
            attachEventListeners();
        });

        observer.observe(document.body, { subtree: true, attributes: true, attributeFilter: ["style"] });
    }

    initializeNavigation();

    // Check for the alert message and type from the PHP session
    <?php if (isset($_SESSION['alert_message'])): ?>
        var alertMessage = "<?php echo $_SESSION['alert_message']; ?>";
        var alertType = "<?php echo $_SESSION['alert_type']; ?>";

        // Display alert for login form
        document.getElementById('alert-con').innerHTML =
            `<div class='alert ${alertType}'>
                ${alertMessage}
                <span class='close-btn' onclick='this.parentElement.style.display="none";'>&times;</span>
            </div>`;

        document.querySelector('.alert').style.display = 'block';

        // Automatically hide the alert after 5 seconds
        setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
        }, 3000);

        // Clear the session message after displaying it
        <?php unset($_SESSION['alert_message']); ?>
        <?php unset($_SESSION['alert_type']); ?>
    <?php endif; ?>

});