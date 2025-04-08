import { initializeScreens } from "./screenHandler.js";
import { initializeNavigation } from "./navigation.js";
import { adminInitializeNavigation } from "./admin.js";
import { toggleButtonHandler, adminSidebarToggleHandler } from "./ui.js";

document.addEventListener("DOMContentLoaded", function () {
    initializeScreens();
    initializeNavigation();
    adminInitializeNavigation();

    // document.getElementById('open_panel')?.addEventListener("click", openPanelHandler);
    // document.getElementById('close_panel')?.addEventListener("click", closePanelHandler);
    document.getElementById('sidebar-toggle')?.addEventListener("click", toggleButtonHandler);
    document.getElementById('admin_sidebar_toggle')?.addEventListener("click", adminSidebarToggleHandler);
});
