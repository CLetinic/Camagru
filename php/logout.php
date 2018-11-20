<?php

	session_start();

	if ($_SESSION['loggedin'] === true)
	{	
		session_unset();   
		session_destroy();
		header('Location: ../index.php?');
		exit; 
	}
?>