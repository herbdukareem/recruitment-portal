<?php

   function generateNewToken($length = 32) {
		return bin2hex(random_bytes($length));
	}

	function redirectToLoginPage() {
		header('Location: login.php');
		exit();
	}