<?php   
     session_start();
     include_once('../db_connect.php');
 
     if (empty($_SESSION['user_id'])) {
         die("No user selected for editing.");
     }
     if (!isset($_SESSION['user_id'])) {
        die("User ID is not set in session.");
    }
 
     $user_id = $_SESSION['user_id'];
     $adminRole = $_SESSION['admin_role'];
?>