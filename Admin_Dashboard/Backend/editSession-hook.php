<?php   
     session_start();
     include_once('../db_connect.php');
 
     if (empty($_SESSION['user_id'])) {
         die("No user selected for editing.");
     }
 
     $user_id = $_SESSION['user_id'];
     $adminRole = $_SESSION['admin_role'];
?>