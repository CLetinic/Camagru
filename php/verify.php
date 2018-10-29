<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//  http://thisinterestsme.com/php-verifying-user-email/
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

			$active	= true;

			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "USE ".$DB_NAME;
			$sql = "UPDATE users SET activated = $active WHERE email = $email";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$_SESSION['pop_up_login'] = true;
			header('Location: ../index.php?t=true');
			exit;

		}
		else
		{
			echo "token is invalid";
		}
	}

	$conn = null;
?>