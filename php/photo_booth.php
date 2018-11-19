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

				if (isset($_SESSION['num'.$imagenum]))
					unset($_SESSION['num'.$imagenum]);
				
				$_SESSION['num'.$imagenum] = $img;
				$image = base64_decode($img);
				file_put_contents('img'.$imagenum.'.png', $image);
			}
		}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
				
	$conn = null;
?>