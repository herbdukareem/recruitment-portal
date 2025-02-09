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
  
});
    
