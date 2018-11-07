<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	include '../config/database.php';
	include_once './functions.php';

	$email			= trim(htmlspecialchars($_POST['email']));
	$email_repeat	= trim(htmlspecialchars($_POST['email_repeat']));
	$username		= $_SESSION['username'];

	try
	{
		if (!isset($email) || empty($email) || !(filter_var($email, FILTER_VALIDATE_EMAIL)) || !isset($email_repeat) || empty($email_repeat) || !($email === $email_repeat))
		{
			echo "! Email input is invalid<br>";
		}
		else if (isset($email) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) 
			&& isset($email_repeat) && !empty($email_repeat) && filter_var($email_repeat, FILTER_VALIDATE_EMAIL)
			&& ($email === $email_repeat))
		{

			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$exist = checkExist(NULL, $email, $conn);

			if (!$exist)
			{
				$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				$sql = "USE ".$DB_NAME;		
				$stmt = $conn->prepare("SELECT * FROM users WHERE user_name = :username");
				$stmt->bindParam(':username', $username);
				$stmt->execute();
				$user = $stmt->fetch();
				if (!$user)
					die('email change failed');
				else
				{
					$active 		= false;
					$token			= bin2hex(openssl_random_pseudo_bytes(16));
					$stmt = $conn->prepare("UPDATE users SET email = :email, token = :token, activated = :activated WHERE user_name = :username");
					$stmt->bindParam(':email', $email);
					$stmt->bindParam(':token', $token);
					$stmt->bindParam(':activated', $active, PDO::PARAM_BOOL);
					$stmt->bindParam(':username', $username);
					if ($stmt->execute())
					{					
						echo "email changed\n";

						$to			= $email; 
						$subject	= 'Email Change';
						$message	= 
"
Seems You have modified your email address, to log in with your new credentials
Please click this link to activate your account:

http://127.0.0.1:8080/camagru/php/verify.php?email='$email'&token='$token'

";
						if (mail($to, $subject, $message))
						{
							echo "email sent\n";
							header('Location: ../index.php?');
							session_unset();   
							session_destroy(); 
							header('Location: ../index.php?');
							exit; 
						}
						else
						{
							echo "email failed to send\n";
						}
					}
				}
			}
			else
				die('Email Already Exists');
		}
		else 
				die('Something went wrong...');
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
	$conn = null;
?>