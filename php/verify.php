<?php
/*
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//  http://thisinterestsme.com/php-verifying-user-email/

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
			echo "New record created successfully";
		}
		else
		{
			echo "token is invalid";
		}
	}
	*/
?>