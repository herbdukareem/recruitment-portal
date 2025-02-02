<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth | University Of Ilorin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../images/logo-plain.jpeg.jpg" type="image/x-icon">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6 space-y-4">
        <div class="text-center">
            <img src="../images/logo-plain.jpeg.jpg" alt="UNILORIN Logo" class="w-16 mx-auto">
            <h2 class="text-xl font-bold mt-2">University of Ilorin</h2>
        </div>
        
        <!-- Sign-up Form -->
        <form action="session.php?signup" method="post" id="signup-form" class="space-y-4">
            <input type="hidden" name="Signup" value="1">
            <div>
                <input type="text" name="firstname" id="sfname" placeholder="Firstname" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-400">
            </div>
            <div>
                <input type="text" name="surname" id="slname" placeholder="Surname" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-400">
            </div>
            <div>
                <input type="email" name="email" id="semail" placeholder="Email" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-400">
            </div>
            <div>
                <input type="password" name="password" id="spass" placeholder="Password" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-400">
            </div>
            <div>
                <input type="password" name="confirm_password" id="scpass" placeholder="Confirm Password" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-400">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="scheck-box" class="w-4 h-4">
                <label for="scheck-box" class="text-gray-600 text-sm">I agree to the <a href="#" class="text-blue-500">Terms of Use</a> and <a href="#" class="text-blue-500">Privacy Policy</a>.</label>
            </div>
            <div>
                <input type="submit" value="Sign Up" class="w-full bg-blue-600 text-white p-3 rounded-md font-bold cursor-pointer hover:bg-blue-700">
            </div>
        </form>

        <div class="text-center text-sm text-gray-600">
            Already have an account? <a href="#" id="login-toggle" class="text-blue-500 font-semibold">Login</a>
        </div>

        <!-- Login Form -->
        <form action="session.php?login" method="post" id="login-form" class="space-y-4 hidden">
            <div>
                <input type="email" name="email" id="lemail" placeholder="Email" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-400">
            </div>
            <div>
                <input type="password" name="password" id="lpass" placeholder="Password" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-400">
            </div>
            <div>
                <input type="submit" value="Login" class="w-full bg-blue-600 text-white p-3 rounded-md font-bold cursor-pointer hover:bg-blue-700">
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loginForm = document.getElementById("login-form");
            const signupForm = document.getElementById("signup-form");
            const loginToggle = document.getElementById("login-toggle");

            loginToggle.addEventListener("click", function(e) {
                e.preventDefault();
                loginForm.classList.remove("hidden");
                signupForm.classList.add("hidden");
            });

            // Toggle password visibility
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

            // Sign-up form password visibility toggle
            const showPass = document.getElementById("hide-spass");
            const hidePass = document.getElementById("show-spass");
            togglePasswordVisibility(document.getElementById("spass"), showPass, hidePass);

            const showCpass = document.getElementById("hide-scpass");
            const hideCpass = document.getElementById("show-scpass");
            togglePasswordVisibility(document.getElementById("scpass"), showCpass, hideCpass);

            // Login form password visibility toggle
            const showLpass = document.getElementById("hide-lpass");
            const hideLpass = document.getElementById("show-lpass");
            togglePasswordVisibility(document.getElementById("lpass"), showLpass, hideLpass);
        });
    </script>
</body>
</html>
