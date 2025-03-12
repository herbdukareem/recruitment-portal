export function initializeScreens() {
    window.onload = function () {
        const sections = [
            'biodata-screen', 
            'education-screen', 
            'work-screen', 
            'pmc-screen', 
            'summary-screen', 
            'cpl-screen', 
            'application-status_screen'
        ];

        // Hide all sections by default
        sections.forEach(id => {
            const section = document.getElementById(id);
            if (section) {
                section.style.display = 'none';
            }
        });

        // Show the correct section based on the hash
        const hash = window.location.hash.replace("#", "");
        const activeSection = sections.includes(hash) ? hash : "biodata-screen";

        const sectionToShow = document.getElementById(activeSection);
        if (sectionToShow) {
            sectionToShow.style.display = "block";
        }
    };
}
