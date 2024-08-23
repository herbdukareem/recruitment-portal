document.addEventListener("DOMContentLoaded", function() {

//Navigation Function
const logIn = document.getElementById("login-section");
const signUp = document.getElementById("signup-section");
const forgotPass = document.getElementById("forget-password-section");
const forgotButton = document.getElementById("forgot-btn");
const signupButton = document.getElementById("signup-btn");
const loginButton = document.getElementById("login-btn");
const loginButtonSec = document.getElementById("login-btnn");


forgotButton.addEventListener("click", (e)=>{
    e.preventDefault();
    forgotPass.style.display = "block";
    logIn.style.display = "none";
    signUp.style.display = "none"
})
signupButton.addEventListener("click", (e)=>{
    e.preventDefault();
    signUp.style.display = "block";
    logIn.style.display = "none";
    forgotPass.style.display = "none"
})
loginButton.addEventListener("click", (e)=>{
    e.preventDefault();
    logIn.style.display = "block";
    forgotPass.style.display = "none";
    signUp.style.display = "none"
})
loginButtonSec.addEventListener("click", (e)=>{
    e.preventDefault();
    logIn.style.display = "block";
    forgotPass.style.display = "none";
    signUp.style.display = "none"
})


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

// Login Function
loginForm.addEventListener("submit", (e)=>{
    e.preventDefault();

    // Input validation function
    if (validateEmail(lEmail.value)){
        if(validateInput(lPassword.value)){
            if(lCheckBox.checked){
                alert("Congrat, You just successfully login")
            }else{
                alert("You need to agree to the ")
            }
        }else{
            alert("Password can not be empty")
        }

    }else{
        alert("Invalid email")
    }
})


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


signupForm.addEventListener("submit", (e)=>{
    e.preventDefault();

    // Input validation function
    if (validateEmail(sEmail.value) && validateInput(firstName.value) && validateInput(lastName.value)){
        if(validateInput(sPassword.value)){
            if(sConPassword.value === sPassword.value){
                if(sCheckBox.checked){
                    alert("Congrat, You just successfully signup")
                    window.location = "access.htm#signup-section"
                }else{
                    alert("You need to agree to the Terms and Privacy")
                }
            }else{
                alert("Password does't match")
            }
        }else{
            alert("Password can not be empty")
        }
    }else{
        alert("Field can't be empty")
    }
})





function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
    
};
function validateInput(val){
    return val =! "";
}
});