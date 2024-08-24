document.addEventListener("DOMContentLoaded", function(){
//Help ID
const helpNav = document.getElementById("hover-nav");
const absolute = document.getElementById("absolute");


helpNav.addEventListener("mouseover", (e)=>{
    absolute.style.visibility = "visible";
    absolute.addEventListener("mouseover", (e)=>{
        absolute.style.visibility = "visible"
    });
    absolute.addEventListener("mouseout", (e)=>{
        absolute.style.visibility = "hidden"
    });
});

// Card Link IDs
const helpLink = document.getElementById("help-link");
const faqLink = document.getElementById("faq-link");
const htaLink = document.getElementById("hta-link");
const csLink = document.getElementById("cs-link");

helpLink.addEventListener("click", (e)=>{
    window.location = ""
});
faqLink.addEventListener("click", (e)=>{
    window.location = "../FAQ/faq.html"
});
htaLink.addEventListener("click", (e)=>{
    window.location = "../How to Apply\hta.html"
});
csLink.addEventListener("click", (e)=>{
    window.location = "../Candidate support/can_support.html"
});

//Theme IDs
const darkMode = document.getElementById("dark-theme");
const lightMode = document.getElementById("light-theme");
   

lightMode.addEventListener("click", (e)=>{
    e.preventDefault();
    lightMode.style.display = "none";
    darkMode.style.display = "block";
    darkMode.parentElement.style.background = "#002908";
    document.documentElement.style.setProperty('--main-bg', '#030c01');
    document.documentElement.style.setProperty('--main-color', '#fff');
});

darkMode.addEventListener("click", (e)=>{
    e.preventDefault();
    darkMode.style.display = "none";
    lightMode.style.display = "block";
    lightMode.parentElement.style.background = "#01871c";
    document.documentElement.style.setProperty('--main-bg', '#fff');
    document.documentElement.style.setProperty('--main-color', '#000');
});


//Mobile And tablet 
const openMenu = document.getElementById("open");
const closeMenu = document.getElementById("close");
const mobileMiddle = document.getElementById("mo-cen");
const mobileBottom = document.getElementById("mo-rig");

openMenu.addEventListener("click", (e)=>{
    openMenu.style.display = "none";
    mobileMiddle.style.display = "block";
    mobileBottom.style.display = "block";
    closeMenu.style.display = "block";
});
closeMenu.addEventListener("click", (e)=>{
    closeMenu.style.display = "none";
    mobileMiddle.style.display = "none";
    mobileBottom.style.display = "none";
    openMenu.style.display = "block";
});

})