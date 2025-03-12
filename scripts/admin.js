export function adminInitializeNavigation() {
    const screens = {
        "btn-all": "sort_applicant",
        "btn-add": "add_applicant",
        "btn-create": "create_admin"
    };

    function getVisibleButtons() {
        return Object.keys(screens)
            .map(id => document.getElementById(id))
            .filter(btn => btn && getComputedStyle(btn).display !== "none");
    }

    function getExistingScreens() {
        return Object.values(screens)
            .map(id => document.getElementById(id))
            .filter(screen => screen);
    }

    function attachEventListeners() {
        const buttons = getVisibleButtons();
        const screensElements = getExistingScreens();

        buttons.forEach(button => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                buttons.forEach(btn => btn.style.background = "none");
                screensElements.forEach(screen => screen.style.display = "none");

                e.target.style.background = "#ffffff5f";
                e.target.style.borderRadius = "8px";
                const targetScreen = screens[e.target.id];
                if (targetScreen) {
                    document.getElementById(targetScreen).style.display = "block";
                }
                document.getElementById('admin_sidebar').style.right = "-350px";
            });
        });
    }

    attachEventListeners();

    const observer = new MutationObserver(() => {
        attachEventListeners();
    });

    observer.observe(document.body, { subtree: true, attributes: true, attributeFilter: ["style"] });
}
