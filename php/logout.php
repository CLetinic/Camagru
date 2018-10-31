<?php

	session_start();

	if ($_SESSION['loggedin'] === true)
	{
		$_SESSION['loggedin'] == false;
		session_unset();   
		session_destroy(); 
		header('Location: ../index.php?');
		exit; 
	}
?>