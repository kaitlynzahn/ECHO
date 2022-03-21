<?php

	if(!session_start()) {
//		header("Location: error.php");
        echo "ERROR";
		exit;
	}
	
	
	$_SESSION = array();
	
	// If the session was propagated using a cookie, remove that cookie
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', 1,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

//I don't know how to get the logout to work
    unset($_SESSION['logged_in']);
	
	// Destroy the session
	session_destroy();
	
	
	// Redirect to login
	header("Location: index.php");
	exit;
?>