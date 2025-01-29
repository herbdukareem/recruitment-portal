<?php 
    session_start();
    include_once('../db_connect.php');
    
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
                header("Location: ../Application_Dashboard/af_form.php");
                exit(); // Ensure the script stops after redirecting
            } else {
                // Set error message in session
                $_SESSION['alert_message'] = "Invalid email or password!";
                $_SESSION['alert_type'] = "warning";
            }
        } else {
            // Set alert message in session
            $_SESSION['alert_message'] = "All fields are required.";
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

                header("Location: session.php?login");
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
    <title>Register | University Of Ilorin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../images/logo-plain.jpeg.jpg" type="image/x-icon">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6 space-y-4">
        <div class="text-center">
            <img src="../images/logo-plain.jpeg.jpg" alt="UNILORIN Logo" class="w-16 mx-auto">
            <h2 class="text-xl font-bold mt-2">University of Ilorin</h2>
        </div>
        
        <h2 class="text-2xl font-bold text-center">Create an Account</h2>
        
        <form action="session.php?signup" method="post" class="space-y-4">
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
            Already have an account? <a href="#" class="text-blue-500 font-semibold">Login</a>
        </div>
    </div>
</body>
</html>