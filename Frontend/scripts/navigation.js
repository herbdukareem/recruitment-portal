export function initializeNavigation() {
    const formScreens = {
        "cpl-btn": "cpl-screen",
        "bio-btn": "biodata-screen",
        "edu-btn": "education-screen",
        "work-btn": "work-screen",
        "pmc-btn": "pmc-screen",
        "sum-btn": "summary-screen",
        "app-status-btn": "application-status_screen",
    };

    function getVisibleButtons() {
        return Object.keys(formScreens)
            .map(id => document.getElementById(id))
            .filter(btn => btn && getComputedStyle(btn).display !== "none");
    }

    function getExistingScreens() {
        return Object.values(formScreens)
            .map(id => document.getElementById(id))
            .filter(screen => screen);
    }

    function attachEventListeners() {
        const buttons = getVisibleButtons();
        const screensElements = getExistingScreens();

        buttons.forEach(button => {
            button.addEventListener("click", (e) => {
                buttons.forEach(btn => btn.style.background = "none");
                screensElements.forEach(screen => screen.style.display = "none");

                e.target.style.background = "#bd911985";
                const targetScreen = formScreens[e.target.id];
                if (targetScreen) {
                    document.getElementById(targetScreen).style.display = "block";
                }
            });
        });
    }

     if (window.location.hash) {
        const step = window.location.hash.replace('#', '').replace('-screen', '');
        navigateToStep(step);
    }

    const observer = new MutationObserver(() => {
        attachEventListeners();
    });

    observer.observe(document.body, { subtree: true, attributes: true, attributeFilter: ["style"] });
}
