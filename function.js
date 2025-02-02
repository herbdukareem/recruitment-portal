document.addEventListener("DOMContentLoaded", function () {
    // Help Dropdown (Desktop)
    const helpNav = document.getElementById("hover-nav");
    const absolute = document.getElementById("absolute");
  
    if (helpNav && absolute) {
      // Although the Tailwind "group-hover" classes handle the basic hover,
      // we add JS to ensure the dropdown remains visible when the mouse is over it.
      helpNav.addEventListener("mouseover", () => {
        absolute.classList.remove("opacity-0");
        absolute.classList.add("opacity-100");
      });
      helpNav.addEventListener("mouseout", () => {
        setTimeout(() => {
          if (!absolute.matches(":hover")) {
            absolute.classList.remove("opacity-100");
            absolute.classList.add("opacity-0");
          }
        }, 150);
      });
      absolute.addEventListener("mouseover", () => {
        absolute.classList.remove("opacity-0");
        absolute.classList.add("opacity-100");
      });
      absolute.addEventListener("mouseout", () => {
        absolute.classList.remove("opacity-100");
        absolute.classList.add("opacity-0");
      });
    }
  
    // Card Link Navigation
    const faqLink = document.getElementById("faq-link");
    const htaLink = document.getElementById("hta-link");
    const csLink = document.getElementById("cs-link");
  
    if (faqLink) {
      faqLink.addEventListener("click", () => {
        window.location = "faq.php";
      });
    }
    if (htaLink) {
      htaLink.addEventListener("click", () => {
        window.location = "hta.php";
      });
    }
    if (csLink) {
      csLink.addEventListener("click", () => {
        window.location = "can_support.php";
      });
    }
  
    // Theme Toggle (if applicable)
    const darkMode = document.getElementById("dark-theme");
    const lightMode = document.getElementById("light-theme");
  
    if (lightMode && darkMode) {
      lightMode.addEventListener("click", (e) => {
        e.preventDefault();
        lightMode.style.display = "none";
        darkMode.style.display = "block";
        // Example: switching background colors using Tailwind's color classes could be done by toggling classes.
        document.documentElement.style.setProperty("--main-bg", "#111e27");
        document.documentElement.style.setProperty("--main-color", "#fff");
      });
  
      darkMode.addEventListener("click", (e) => {
        e.preventDefault();
        darkMode.style.display = "none";
        lightMode.style.display = "block";
        document.documentElement.style.setProperty("--main-bg", "#fff");
        document.documentElement.style.setProperty("--main-color", "#000");
      });
    }
  
    // Mobile Menu Toggle
    const openMenu = document.getElementById("open");
    const closeMenu = document.getElementById("close");
    const mobileMenu = document.getElementById("mobile-menu");
  
    if (openMenu && closeMenu && mobileMenu) {
      openMenu.addEventListener("click", () => {
        mobileMenu.classList.remove("hidden");
        openMenu.classList.add("hidden");
        closeMenu.classList.remove("hidden");
      });
      closeMenu.addEventListener("click", () => {
        mobileMenu.classList.add("hidden");
        closeMenu.classList.add("hidden");
        openMenu.classList.remove("hidden");
      });
    }
  });
  