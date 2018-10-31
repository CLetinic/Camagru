<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	include '../config/database.php';

	$email	= $_POST['email'];
	$token	= bin2hex(openssl_random_pseudo_bytes(16));
	var_dump($email);

	if (isset($email) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
		$stmt->bindValue(':email', $email);
		$stmt->execute();
		$user = $stmt->fetch();
		if (!$user)
			die('email does not exist');
		else
		{

			var_dump($token);
			
			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "USE ".$DB_NAME;

			$stmt = $conn->prepare("UPDATE users SET token = :token");
			$stmt->bindParam(':token', $token);
			$stmt->execute();
			echo "added token\n";
			echo "$email";
			
			$to			= $email; 
			$subject	= 'Password Reset';
			$message	= 
			"
Seems you have forgotten your password!
You can create a new password after pressing the url below.


Please click this link to reset your password:

http://127.0.0.1:8080/camagru/php/forgot_password_verify.php?email='$email'&token='$token'

			";
			if (mail($to, $subject, $message))
			{
				echo "email sent\n";
				header('Location: ../index.php?');
				exit;
			}
			else
				echo "email failed to send\n";
		}			
	}
	$conn = null;
?>