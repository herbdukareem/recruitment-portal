<?php 
    session_start();
    include_once('../db_connect.php');
    
    // Check if Login form is submitted
    if (isset($_POST['Login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare and execute the SQL statement
        $sql = "SELECT id, password FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email; // Optional, store additional data if needed
            
            header("Location: ../Application_Dashboard/af_form.php");
            exit(); // Ensure the script stops after redirecting

            // Redirect to dashboard
            header("Location: ../Application_Dashboard/af_form.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    }

    // SignUp form check 
    if (isset($_POST['Signup'])) {
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate input
        if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password)) {
            echo "All fields are required.";
        } elseif ($password !== $confirm_password) {
            echo "Passwords do not match.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class='alert alert-dangegr'>Invalid email format.</div>";
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

                echo "Registration successful!";
                // Redirect to the login page or dashboard
                header("Location: session.php?login");
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    // Duplicate entry error (email or username already exists)
                    echo "Email already registered.";
                } else {
                    echo "Error: " . $e->getMessage();
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
    <title>auth | NNPC Limited</title>
    <link rel="stylesheet" href="./session_style.css">
    <link rel="shortcut icon" href="../nnpc.svg" type="image/x-icon">
</head>
<body>
    <div class="winscroll">
        <div>
            <!-- Login Section -->
            <section id="login-section" style="display: block;">
                <div class="logo">
                    <a href="../index.html"><img src="../images/nnpc.svg" alt="NNPC Logo"></a>
                    <p>
                        Go to Career Page
                    </p>
                </div>
                <form action="session.php?login" method='post' id='login-section'>
                    <div class="input-set">
                        <input type="email" name="email" id="lemail" value="" placeholder="Email">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#046f42" d="M12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2M7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.5.88 4.93 1.78A7.9 7.9 0 0 1 12 20c-1.86 0-3.57-.64-4.93-1.72m11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33A7.93 7.93 0 0 1 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.5-1.64 4.83M12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6m0 5a1.5 1.5 0 0 1-1.5-1.5A1.5 1.5 0 0 1 12 8a1.5 1.5 0 0 1 1.5 1.5A1.5 1.5 0 0 1 12 11"/></svg>
                    </div>
                    <div class="input-set">
                        <input type="password" name="password" id="lpass" value="" placeholder="Password">
                        <svg id="hide-lpass" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 14 14"><g fill="none" stroke="#046f42" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5.5H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1m-.5 0V4a3.5 3.5 0 1 0-7 0v1.5"/><path d="M7 10a.5.5 0 1 0 0-1a.5.5 0 0 0 0 1"/></g></svg>
                        <svg id="show-lpass" style="visibility:hidden;" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="-5 -2 24 24"><path fill="#046f42" d="M12 5h-2a3 3 0 1 0-6 0v5h8a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2V5a5 5 0 1 1 10 0M7 17a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/></svg>
                    </div>
                    <div class="intel-prop">
                        <input type="checkbox" name="" id="lcheck-box">
                        I agree to the <a href="#">Terms of Use</a> and the <a href="#">Privacy Policy</a>.
                    </div>
                    <div>
                        <input type="submit" value="Login" name='Login'>
                    </div>
                    <div class="intel-prop">
                        <a href="#" id="forgot-btn">I forgot my password</a> <br><a href="#" id="signup-btn">Create an account</a>

                    </div>
                </form>
            </section>
            <!-- Signup section -->
            <section id="signup-section" action="" method="post" style="display: none;">
                <div class="logo">
                    <img src="../nnpc.svg" alt="NNPC Logo">
                    <p>
                        Go to Career Page
                    </p>
                </div>
                <form action="" id="signup-form" method="post">
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
                        <svg id="hide-spass" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 14 14"><g fill="none" stroke="#046f42" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5.5H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1m-.5 0V4a3.5 3.5 0 1 0-7 0v1.5"/><path d="M7 10a.5.5 0 1 0 0-1a.5.5 0 0 0 0 1"/></g></svg>
                        <svg id="show-spass" style="visibility:hidden;" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="-5 -2 24 24"><path fill="#046f42" d="M12 5h-2a3 3 0 1 0-6 0v5h8a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2V5a5 5 0 1 1 10 0M7 17a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/></svg>
                    
                    </div>
                    <div class="input-set">
                        <input type="password" name="confirm_password"  id="scpass" placeholder="Confirm Password">
                        <svg id="hide-spass-sec" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 14 14"><g fill="none" stroke="#046f42" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5.5H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1m-.5 0V4a3.5 3.5 0 1 0-7 0v1.5"/><path d="M7 10a.5.5 0 1 0 0-1a.5.5 0 0 0 0 1"/></g></svg>
                        <svg id="show-spass-sec" style="visibility:hidden;" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="-5 -2 24 24"><path fill="#046f42" d="M12 5h-2a3 3 0 1 0-6 0v5h8a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2V5a5 5 0 1 1 10 0M7 17a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/></svg>
                    </div>
                    <div class="intel-prop">
                        <input type="checkbox" name="" id="scheck-box">
                        I agree to the <a href="#">Terms of Use</a> and the <a href="#">Privacy Policy</a>.
                    </div>
                    <div>
                        <input type="submit" value="Signup" name="Signup">
                    </div>
                    <div class="intel-prop">
                        <input type="button" value="Login" id="login-btn" >
                    </div>
                </form>
            </section>
            <!-- Forgot password section -->
            <section id="forget-password-section" style="display: none;">
                <div class="logo">
                    <img src="../nnpc.svg" alt="NNPC Logo">
                    <p>
                        Go to Career Page
                    </p>
                </div>
                <form method='post'>
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
                        <input type="button" name="forgotpasswods" value="Login" id="login-btnn" >
                    </div>
                </form>
            </section>
        </div>
    </div>
    <script src="./sesstion_action.js"></script>
</body>
</html>