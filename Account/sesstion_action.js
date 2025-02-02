document.addEventListener("DOMContentLoaded", function() {

    // Navigation Function
    const logIn = document.getElementById("login-section");
    const signUp = document.getElementById("signup-section");
    const forgotPass = document.getElementById("forget-password-section");
    const forgotButton = document.getElementById("forgot-btn");
    const signupButton = document.getElementById("signup-btn");
    const loginButton = document.getElementById("login-btn");
    const loginButtonSec = document.getElementById("login-btnn");

    forgotButton.addEventListener("click", (e) => {
        e.preventDefault();
        forgotPass.style.display = "block";
        logIn.style.display = "none";
        signUp.style.display = "none";
    });

    signupButton.addEventListener("click", (e) => {
        e.preventDefault();
        signUp.style.display = "block";
        logIn.style.display = "none";
        forgotPass.style.display = "none";
    });

    loginButton.addEventListener("click", (e) => {
        e.preventDefault();
        logIn.style.display = "block";
        forgotPass.style.display = "none";
        signUp.style.display = "none";
    });

    loginButtonSec.addEventListener("click", (e) => {
        e.preventDefault();
        logIn.style.display = "block";
        forgotPass.style.display = "none";
        signUp.style.display = "none";
    });


    // Reusable Show/Hide Password Function
    function togglePasswordVisibility(inputField, showBtn, hideBtn) {
        showBtn.addEventListener("click", (e) => {
            e.preventDefault();
            inputField.type = "text";
            showBtn.style.visibility = "hidden";
            hideBtn.style.visibility = "visible";
        });

        hideBtn.addEventListener("click", (e) => {
            e.preventDefault();
            inputField.type = "password";
            hideBtn.style.visibility = "hidden";
            showBtn.style.visibility = "visible";
        });
    }

    // Login Section
    const lCheckBox = document.getElementById("lcheck-box");
    const lEmail = document.getElementById("lemail");
    const lPassword = document.getElementById("lpass");
    const loginForm = document.getElementById("login-form");

    // Show/Hide Password for Login
    const showlPass = document.getElementById("hide-lpass");
    const hidelPass = document.getElementById("show-lpass");
    togglePasswordVisibility(lPassword, showlPass, hidelPass);

    // Login Form Submission
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();
        if (validateEmail(lEmail.value)) {
            if (validateInput(lPassword.value)) {
                if (lCheckBox.checked) {
                    alert("Congratulations, You have successfully logged in!");
                    loginForm.submit();
                    // window.location = "../Application_Dashboard/af_form.htm"; // Uncomment for redirection
                } else {
                    alert("You need to agree to the terms.");
                }
            } else {
                alert("Password cannot be empty.");
            }
        } else {
            alert("Invalid email.");
        }
    });


    // Signup Section
    const sCheckBox = document.getElementById("scheck-box");
    const sEmail = document.getElementById("semail");
    const firstName = document.getElementById("sfname");
    const lastName = document.getElementById("slname");
    const sPassword = document.getElementById("spass");
    const sConPassword = document.getElementById("scpass");
    const signupForm = document.getElementById("signup-form");

    // Show/Hide Password for Signup
    const sshowlPass = document.getElementById("hide-spass");
    const shidelPass = document.getElementById("show-spass");
    const shidelPassSec = document.getElementById("show-spass-sec");
    const sshowlPassSec = document.getElementById("hide-spass-sec");
    togglePasswordVisibility(sPassword, sshowlPass, shidelPass);
    togglePasswordVisibility(sConPassword, sshowlPassSec, shidelPassSec);

    // Signup Form Submission
    signupForm.addEventListener("submit", (e) => {
        e.preventDefault();

        // Validate inputs
        if (validateEmail(sEmail.value) && validateInput(firstName.value) && validateInput(lastName.value)) {
            if (validateInput(sPassword.value)) {
                if (sConPassword.value === sPassword.value) {
                    if (sCheckBox.checked) {
                        signupForm.submit();
                        logIn.style.display = "block";
                        forgotPass.style.display = "none";
                        signUp.style.display = "none";
                    } else {
                        alert("You need to agree to the Terms and Privacy.");
                    }
                } else {
                    alert("Passwords do not match.");
                }
            } else {
                alert("Password cannot be empty.");
            }
        } else {
            alert("Fields can't be empty.");
        }
    });


    // Validation Functions
    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function validateInput(val) {
        return val.trim() !== "";
    }
});
