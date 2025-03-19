<?php
    session_start();
	include_once('../db_connect.php');

	error_reporting(E_ERROR | E_PARSE); // Only show critical errors
	ini_set('display_errors', 0);

	$admin_unid = $_SESSION['admin_unid'];
	$adminRole = $_SESSION['admin_role'];
	$user_id = $_SESSION['user_id'];

	//Check if the user is logged in
	if (!isset($_SESSION['admin_unid'])) {
		// Redirect to login page if not logged in
		header("Location: ./auth.php");
		exit();
	}

?>