<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// https://www.formget.com/php-data-object/
include '../config/database.php';
  
	$user_name 		= trim($_POST['username']);
	$email 			= trim($_POST['email']);
	$passw 			= trim($_POST['psw']);
	$passw_repeat	= trim($_POST['psw_repeat']);
	$active 		= false;
	$notifications	= true;
	$token			= bin2hex(openssl_random_pseudo_bytes(16));

	if ((isset($user_name) && !empty($user_name)) 
		&& (isset($email) && !empty($email) && (filter_var($email, FILTER_VALIDATE_EMAIL))) 
		&& (isset($passw) && !empty($passw) && ($passw === $passw_repeat)))
	{
		try
		{
			$enc_passw = password_hash($passw, PASSWORD_BCRYPT);

			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "USE ".$DB_NAME;
			$sql = "INSERT INTO users (user_name, email, password, token, activated, notifications)
			VALUES (:user_name, :email, :passw, :token, :activated, :notifications)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':user_name', $user_name);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':passw', $enc_passw);
			$stmt->bindParam(':token', $token);
			$stmt->bindParam(':activated', $active, PDO::PARAM_BOOL);
			$stmt->bindParam(':notifications', $notifications, PDO::PARAM_BOOL);
			$stmt->execute();
			echo "New record created successfully\n";

			$to			= $email; 
			$subject	= 'Signup | Verification';
			$message	= 
			"
Thanks for signing up!
Your account has been created, you can login with your credentials
after you have activated your account by pressing the url below.


Please click this link to activate your account:

http://127.0.0.1:8080/camagru/php/verify.php?email='$email'&token='$token'

			";
			if (mail($to, $subject, $message))
			{
				echo "email sent\n";
				header('Location: ../index.php?');
				exit;
			}
			else
			{
				echo "email failed to send\n";
			}
		}

		catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}
		$conn = null;
	
?>