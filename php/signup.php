<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// https://www.formget.com/php-data-object/
include '../config/database.php';
  
  	$user_name 		= $_POST['username'];
    $email 			= $_POST['email'];
	$passw 			= $_POST['psw'];
	$passw_repeat	= $_POST['psw_repeat'];
	$active 		= false;
	$token			= bin2hex(openssl_random_pseudo_bytes(16));

	////if ($email && $passw && (filter_var($email, FILTER_VALIDATE_EMAIL)) && ($passw === $passw_repeat))
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
			$sql = "INSERT INTO users (user_name, email, password, token, activated)
			VALUES (:user_name, :email, :passw, :token, :activated)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':user_name', $user_name);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':passw', $enc_passw);
			$stmt->bindParam(':token', $token);
			$stmt->bindParam(':activated', $active, PDO::PARAM_BOOL);
			//$stmt->bindParam(':activated', 0, PDO::PARAM_INT);
			$stmt->execute();
			//$msg = "Are you awesome or not?";
			//mail("chanelletinic@gmail.com", "My subject", $msg);
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

			/*
			<html> 
				<body >
					<input align="center" style="background-color: rgb(249, 35, 112); color: white; text-align: center; " type=\"button\" value=\"Download Report\" onclick=\"location.href='http://127.0.0.1:8080/camagru/verify.php?email='.$email.'&token='.$token.'';\">
				</body> 
			</html>
			*/
			// $from = "From: chanelletinic@gmail.com" . "\r\n";
			//var_dump($to, $subject, $message);
			
			//if (mail("chanelletinic@gmail.com", "hi", "ho", "chanelletinic@gmail.com"));

			if (mail($to, $subject, $message))
			{
				echo "email sent\n";
			}
			else
			{
				echo "email failed to send\n";
			}
		}

		catch(PDOException $e)
		{
			//echo $e->getMessage();
			echo $sql . "<br>" . $e->getMessage();
		}
	}
		$conn = null;
	
?>