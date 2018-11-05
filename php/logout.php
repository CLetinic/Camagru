<?php

	session_start();

	if ($_SESSION['loggedin'] === true)
	{
		$_SESSION['loggedin'] == false;
		session_unset();   
		session_destroy();

		$_SESSION['pop_up_login'] = NULL;
		$_SESSION['pop_up_psw_reset'] = NULL;
		$_SESSION['loggedin'] = NULL;
		$_SESSION['logged_in'] = NULL;

		$_SESSION['user_id'] = NULL;
		$_SESSION['username'] = NULL;
		$_SESSION['token'] = NULL;
		$_SESSION['email'] = NULL;
		header('Location: ../index.php?');
		exit; 
	}
?>