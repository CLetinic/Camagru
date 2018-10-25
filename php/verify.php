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
		//$stmt = $conn->prepare("SELECT FROM users WHERE email = :email AND token = :token");
		//$stmt = $conn->prepare("SELECT COUNT(*) AS getuser FROM users WHERE email = :email AND token = :token");
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
			$sql = "UPDATE users SET activated = $active WHERE email=$email";
			$stmt = $conn->prepare($sql);
			//$stmt->bindParam(':activated', $active, PDO::PARAM_BOOL);
			//$stmt->bindValue(':email', $email);
			$stmt->execute();
			echo "User is now activated";

			/*
			$sql = $conn->prepare("UPDATE users SET activated = :activate where email = :email");
			//$stmt->bindParam(':activated', $active, PDO::PARAM_BOOL);
			$stmt->bindParam(':activated', $active, PDO::PARAM_BOOL);
			$stmt->bindValue(':email', $email);
			$stmt->execute();
			echo "User is now activated";
			*/
		}
		else
		{
			echo "token is invalid";
		}
	}

/*
	if(isset($_GET['token']) && isset($_GET['email']))
	{
		$token = trim($_GET['token']);
		$email = trim($_GET['email']);
		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;			
		//$sql = "SELECT COUNT(*) AS num FROM users WHERE email = :email AND token = :token";
		$sql = "SELECT email, token FROM users WHERE email = :email AND token = :token";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':token', $token);
		$stmt->execute();

		$result = $stmt->fetch(); //PDO::FETCH_ASSOC
		if ($user)
		{
			echo "token is valid";
			$active	= true;

			$sql = "UPDATE users SET activated = $active where email = $email";
			$stmt->bindParam(':activated', $active, PDO::PARAM_BOOL);
			$stmt->execute();
			echo "User is now activated";
		}
		else
		{
			echo "token is invalid";
		}
	}
	*/
	$conn = null;
?>