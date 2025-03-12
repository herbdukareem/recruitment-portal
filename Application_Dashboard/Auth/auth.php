<?php 
    session_start();
    include_once('../../db_connect.php');

    $display = $_GET['display'];
    
    if (in_array($display, ['login', 'signup', 'forget_password'])) {
        // Dynamically inject the JavaScript for each section
        echo '
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var logIn = document.getElementById("login_section");
                    var forgotPass = document.getElementById("forgot_password_section");
                    var signUp = document.getElementById("signup_section");
                    
                    // Hide all sections initially
                    logIn.style.display = "none";
                    forgotPass.style.display = "none";
                    signUp.style.display = "none";
    
                    // Show the relevant section based on the "display" parameter
                    if ("' . $display . '" === "login") {
                        logIn.style.display = "block";
                    } else if ("' . $display . '" === "signup") {
                        signUp.style.display = "block";
                    } else if ("' . $display . '" === "forget_password") {
                        forgotPass.style.display = "block";
                    }
                });
            </script>
        ';
    } else {
       // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page if not logged in
            header("Location: ./Auth/auth?display=login");
            exit();
        }
    }
    
    
    // Check if the Login form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare and execute the SQL statement
        $sql = "SELECT id, firstname, lastname, password FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($user)) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_firstname'] = $user['firstname'];
                $_SESSION['user_lastname'] = $user['lastname'];
                $_SESSION['user_email'] = $email; // Store email in session

                // Set success message in session
                $_SESSION['alert_message'] = "Login successful!";
                $_SESSION['alert_type'] = "success";

                // Redirect to the dashboard page
                header("Location: ../index.php");
                exit(); // Ensure the script stops after redirecting
            } else {
                // Set error message in session
                $_SESSION['alert_message'] = "Invalid email or password!";
                $_SESSION['alert_type'] = "warning";
            }
        } else {
            // Set alert message in session
            $_SESSION['alert_message'] = "User does not exist, create an account.";
            $_SESSION['alert_type'] = "alert";
        }
    }

    // Signup form check
    if (isset($_POST['Signup'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate input
        if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password)) {
            // Set alert message in session
            $_SESSION['alert_message'] = "All fields are required.";
            $_SESSION['alert_type'] = "alert";
        } elseif ($password !== $confirm_password) {
            // Set alert message in session
            $_SESSION['alert_message'] = "Password doesn't match.";
            $_SESSION['alert_type'] = "alert";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set warning message in session
            $_SESSION['alert_message'] = "Incorrect email format.";
            $_SESSION['alert_type'] = "warning";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare an SQL statement
            $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
            $stmt = $pdo->prepare($sql);

            try {
                // Execute the statement
                $stmt->execute([
                    ':firstname' => $firstname,
                    ':lastname' => $lastname,
                    ':email' => $email,
                    ':password' => $hashed_password,
                ]);

                // Set success message in session
                $_SESSION['alert_message'] = "Signup successful!";
                $_SESSION['alert_type'] = "success";

                header("Location: ../index.php");
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    // Set error message in session
                    $_SESSION['alert_message'] = "Email already exists.";
                    $_SESSION['alert_type'] = "warning";
                } else {
                    // Set error message in session
                    $_SESSION['alert_message'] = "Error signing up.";
                    $_SESSION['alert_type'] = "alert";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Authentication | UNILORIN</title>
    <link rel="stylesheet" href="./session_style.css">
    <link rel="stylesheet" href="../../style/alert.css">
    <link rel="shortcut icon" href="../../images/logo-plain.jpeg.jpg" type="image/x-icon">
</head>
<body>
    <div class="winscroll">
        <div>
            <section  class="auth" >
                <div class="logo">
                    <a href="../../index.php"><img src="../../images/logo-plain.jpg" alt="UNILORIN Logo"></a>
                    <p>
                        Go to Career Page
                    </p>
                </div>
                <!-- login  -->
                <form action="" method='post' id="login_section"  style="display: none;">
                    <input type="hidden" name="login" value="1">
                    <div id="alert-container-login"></div>
                    <div class="input-set">
                        <input type="email" name="email" id="lemail" value="" placeholder="Email">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="var(--main-bg)" d="M12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2M7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.5.88 4.93 1.78A7.9 7.9 0 0 1 12 20c-1.86 0-3.57-.64-4.93-1.72m11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33A7.93 7.93 0 0 1 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.5-1.64 4.83M12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6m0 5a1.5 1.5 0 0 1-1.5-1.5A1.5 1.5 0 0 1 12 8a1.5 1.5 0 0 1 1.5 1.5A1.5 1.5 0 0 1 12 11"/></svg>
                    </div>
                    <div class="input-set">
                        <input type="password" name="password" id="lpass" value="" placeholder="Password">
                        <svg id="hide-lpass" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 14 14"><g fill="none" stroke="var(--main-bg)" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5.5H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1m-.5 0V4a3.5 3.5 0 1 0-7 0v1.5"/><path d="M7 10a.5.5 0 1 0 0-1a.5.5 0 0 0 0 1"/></g></svg>
                        <svg id="show-lpass" style="visibility:hidden;" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="-5 -2 24 24"><path fill="var(--main-bg)" d="M12 5h-2a3 3 0 1 0-6 0v5h8a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2V5a5 5 0 1 1 10 0M7 17a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/></svg>
                    </div>
                    <div class="intel-prop">
                        <input type="checkbox" name="" id="lcheck-box">
                        I agree to the <a href="#">Terms of Use</a> and the <a href="#">Privacy Policy</a>.
                    </div>
                    <div>
                        <input type="submit" value="Login" name='Login'>
                    </div>
                    <div class="intel-prop">
                        <a href="auth.php?display=forget_password">I forgot my password</a> 
                        <br>
                        <a href="auth.php?display=signup">Create an account</a>
                    </div>
                </form>
                <!-- sign up  -->
                <form action="" method="post" id="signup_section" style="display: none;">
                    <input type="hidden" name="Signup" value="1">
                    <div id="alert-container-signup"></div>
                    <div class="input-set">
                        <input type="text"  name="firstname" id="sfname" placeholder="Firstname">
                    </div>
                    <div class="input-set">
                        <input type="text" name="lastname" id="slname" placeholder="Lastname">
                    </div>
                    <div class="input-set">
                        <input type="email"  name="email"  id="semail" placeholder="Email">
                    </div>
                    <div class="input-set">
                        <input type="password" name="password"  id="spass" placeholder="Password">
                        <svg id="hide-spass" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 14 14"><g fill="none" stroke="var(--main-bg)" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5.5H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1m-.5 0V4a3.5 3.5 0 1 0-7 0v1.5"/><path d="M7 10a.5.5 0 1 0 0-1a.5.5 0 0 0 0 1"/></g></svg>
                        <svg id="show-spass" style="visibility:hidden;" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="-5 -2 24 24"><path fill="var(--main-bg)" d="M12 5h-2a3 3 0 1 0-6 0v5h8a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2V5a5 5 0 1 1 10 0M7 17a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/></svg>
                    
                    </div>
                    <div class="input-set">
                        <input type="password" name="confirm_password"  id="scpass" placeholder="Confirm Password">
                        <svg id="hide-spass-sec" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 14 14"><g fill="none" stroke="var(--main-bg)" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5.5H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1m-.5 0V4a3.5 3.5 0 1 0-7 0v1.5"/><path d="M7 10a.5.5 0 1 0 0-1a.5.5 0 0 0 0 1"/></g></svg>
                        <svg id="show-spass-sec" style="visibility:hidden;" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="-5 -2 24 24"><path fill="var(--main-bg)" d="M12 5h-2a3 3 0 1 0-6 0v5h8a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2V5a5 5 0 1 1 10 0M7 17a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/></svg>
                    </div>
                    <div class="intel-prop">
                        <input type="checkbox" name="" id="scheck-box">
                        I agree to the <a href="#">Terms of Use</a> and the <a href="#">Privacy Policy</a>.
                    </div>
                    <div>
                        <input type="submit" value="Signup" name="Signup" id="signup-btn">
                    </div>
                    <div class="intel-prop">
                        <a href="auth.php?display=login">
                            <input type="button" value="Login" id="login-btn" >
                        </a>
                    </div>
                </form>
                <!-- Password -->
                <form action="" method='post' id="forgot_password_section" style="display: none;">
                    <div class="input-set">
                        <input type="email" name="email" id="Email" placeholder="Enter your register email">
                    </div>
                    <div class="input-set" style="display: none;">
                        <input type="email" name="password" id="text" placeholder="Enter confirmation code">
                    </div>
                    <div>
                        <input type="button" value="Send confirmation code">
                        <input type="submit" value="Confirm code" style="display: none;">
                    </div>
                    <div class="intel-prop">
                        <a href="#">Resend code</a>
                    </div>
                    <div class="intel-prop">
                        <a href="auth.php?display=login">
                            <input type="button" value="Login" id="login-btn" >
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <script src="./action.js"></script>
    <script>
        // Check for the alert message and type from the PHP session
        <?php if (isset($_SESSION['alert_message'])): ?>
            var alertMessage = "<?php echo $_SESSION['alert_message']; ?>";
            var alertType = "<?php echo $_SESSION['alert_type']; ?>";

            // Display alert for login form
            document.getElementById('alert-container-login').innerHTML =
                `<div class='alert ${alertType}'>
                    ${alertMessage}
                    <span class='close-btn' onclick='this.parentElement.style.display="none";'>&times;</span>
                </div>`;

            // Display alert for signup form
            document.getElementById('alert-container-signup').innerHTML =
                `<div class='alert ${alertType}'>
                    ${alertMessage}
                    <span class='close-btn' onclick='this.parentElement.style.display="none";'>&times;</span>
                </div>`;

            document.querySelector('.alert').style.display = 'block';

            // Automatically hide the alert after 5 seconds
            setTimeout(function() {
                document.querySelector('.alert').style.display = 'none';
            }, 5000);

            // Clear the session message after displaying it
            <?php unset($_SESSION['alert_message']); ?>
            <?php unset($_SESSION['alert_type']); ?>
        <?php endif; ?>
        
    </script>

</body>
</html>