<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//  http://thisinterestsme.com/php-verifying-user-email/
include '../config/database.php';
	
	try
	{
		if(isset($_GET['token']) && isset($_GET['email']))
		{
			$token = htmlspecialchars($_GET['token']);
			$email = htmlspecialchars($_GET['email']);

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

				$stmt = $conn->prepare("UPDATE users SET activated = $active WHERE email = $email");
				$stmt->execute();
				header('Location: ../index.php?pop_up_login=true');
				exit;
			}
			else
				die ("token is invalid");
		}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
	$conn = null;
?>