<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

	if(isset($_GET['token']) && isset($_GET['email']))
	{
		$token = $_GET['token'];
		$email = $_GET['email'];
		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;		
		$stmt = $conn->prepare("SELECT email = :email AND token = :token FROM users");
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':token', $token);
		$stmt->execute();
		$user = $stmt->fetch();
		if ($user)
		{
			echo "token is valid";

			//$_SESSION['pop_up_psw_reset'] = true;
			$_SESSION['token'] = $token;
			$_SESSION['email'] = $email;
			header('Location: ../index.php?pop_up_psw_reset=true');
			exit;
		}
		else
			echo "token is invalid";
	}
	$conn = null;
?>