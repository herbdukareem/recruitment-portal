<?php

    function generateNewString($len = 32) {
        return bin2hex(random_bytes($len / 2));
    };

	function redirectToLoginPage() {
		header('Location: login.php');
		exit();
	}