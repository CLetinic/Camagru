<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

	try
	{
		if (isset($_SESSION['loggedin']) === true)
		{
			if (isset($_POST['key']) && isset($_POST['num']))
			{

				$imagenum	= $_POST['num'];
				$imageurl	= $_POST['key'];
				$img		= preg_replace('#^data:image/\w+;base64,#i', '',$imageurl);

				$_SESSION['num'.$imagenum] = $img;
			}
		}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
				
	$conn = null;
?>