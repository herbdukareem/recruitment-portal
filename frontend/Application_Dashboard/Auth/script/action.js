document.addEventListener("DOMContentLoaded", function() {

//Setting ID as variable for login
const lCheckBox = document.getElementById("lcheck-box");
const lEmail = document.getElementById("lemail");
const lPassword = document.getElementById("lpass");
const loginForm = document.getElementById("login-form");


// Show/hide password function
const showlPass = document.getElementById("hide-lpass");
const hidelPass = document.getElementById("show-lpass");

// show function
showlPass.addEventListener("click", (e)=>{
    e.preventDefault();
    e.target.style.visibility = "hidden"
    lPassword.type = "text"
    hidelPass.style.visibility = "visible"
});
// hide function
hidelPass.addEventListener("click", (e)=>{
    e.preventDefault();
    e.target.style.visibility = "hidden"
    lPassword.type = "password"
    showlPass.style.visibility = "visible"
});

//signup function
//Setting ID as variable for signup
const sCheckBox = document.getElementById("scheck-box");
const sEmail = document.getElementById("semail");
const firstName = document.getElementById("sfname");
const lastName = document.getElementById("slname");
const sPassword = document.getElementById("spass");
const sConPassword = document.getElementById("scpass");
const signupForm = document.getElementById("signup-form");


// Show/hide password function
const sshowlPass = document.getElementById("hide-spass");
const shidelPass = document.getElementById("show-spass");
const shidelPassSec = document.getElementById("show-spass-sec");
const sshowlPassSec = document.getElementById("hide-spass-sec");

// show function
sshowlPass.addEventListener("click", (e)=>{
    e.preventDefault();
    e.target.style.visibility = "hidden"
    sPassword.type = "text"
    shidelPass.style.visibility = "visible"
});
// hide function
shidelPass.addEventListener("click", (e)=>{
    e.preventDefault();
    e.target.style.visibility = "hidden"
    sPassword.type = "password"
    sshowlPass.style.visibility = "visible"
});
// show function for confirm password
sshowlPassSec.addEventListener("click", (e)=>{
    e.preventDefault();
    e.target.style.visibility = "hidden"
    sConPassword.type = "text"
    shidelPassSec.style.visibility = "visible"
});
// hide function for confirm password
shidelPassSec.addEventListener("click", (e)=>{
    e.preventDefault();
    e.target.style.visibility = "hidden"
    sConPassword.type = "password"
    sshowlPassSec.style.visibility = "visible"
});
})