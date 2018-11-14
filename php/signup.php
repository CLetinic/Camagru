<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// https://www.formget.com/php-data-object/
	include '../config/database.php';
	include_once './functions.php';
  


	try
	{
		$user_name 		= trim(htmlspecialchars($_POST['username']));
		$email 			= trim(htmlspecialchars($_POST['email']));
		$passw 			= htmlspecialchars($_POST['psw']);
		$passw_repeat	= htmlspecialchars($_POST['psw_repeat']);
		$active 		= false;
		$notifications	= true;
		$token			= bin2hex(openssl_random_pseudo_bytes(16));

		// Check for errors
		if (!isset($user_name) || empty($user_name) || strlen($user_name) < 4)
		{
			echo "! Username input is invalid - *also check to see if username is more than 4 characters long<br>";
		}
		else if (!isset($email) || empty($email) || !(filter_var($email, FILTER_VALIDATE_EMAIL)))
		{
			echo "! Email input is invalid<br>";
		}
		else if (!isset($passw) || empty($passw) || !($passw === $passw_repeat) || !(strlen($passw) > 6) || (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw)))
		{
			echo "! Password input is invalid<br>";
			if (!($passw === $passw_repeat))
			{
				echo "! Password fields do not match<br>";
			}
			if (!(strlen($passw) > 6))
			{
				echo "! Password length is too short, must be atleast 6 characters long<br>";
			}
			if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw))
			{
				echo "! Password must contain letters and digits<br>";
			}
		}
		else if ((isset($user_name) && !empty($user_name) && !(strlen($user_name) < 4)) 
			&& (isset($email) && !empty($email) && (filter_var($email, FILTER_VALIDATE_EMAIL))) 
			&& (isset($passw) && !empty($passw) && ($passw === $passw_repeat) && (strlen($passw) > 6) || (preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw))))
		{
			// Now for the actual sign up
			// firstly check if the username or email already exists in this database

			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$user = checkExist($user_name, $email, $conn);

			if (!$user)
			{
				// Username and passowrd do not exist, 
				// so let's make an account
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

				echo "New record created successfully<br>";

				// Send out a verification email

				$to			= $email; 
				$subject	= 'Signup | Verification';
				$headers 	= "MIME-Version: 1.0\r\n";
				$headers 	.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$message 	= 
"
<html>
  <head>
    <style>
		button
		{
			background-color: rgb(40, 41, 35);
			color: white;
			border: none;
			outline: none;
			cursor: pointer;
			width: 100%;
			display: inline-block;
			font-size: 18px;
			font-weight: bold;
			padding: 16px 31px;
			text-decoration: none;
		}

		button:hover 
		{
			background-color: rgb(249, 35, 112);
		}
		p
		{
			color: black;
		}
		h1
		{
			color: black;
		}
		</style>
	</head>
	<body>
		<h2>Thanks for signing up!</h2><br>
		<p>Your account has been created, you can login with your credentials
		<br>
		after you have activated your account by pressing the button below.<p>
		<p>
			Please click below to activate your account:
			<br>
		<p>

		<a href="."http://127.0.0.1:8080/camagru/php/verify.php?email='$email'&token='$token'".">
			<button>
				Activate
			</button>
		</a>		
	</body>
</html>
";
				if (mail($to, $subject, $message, $headers))
				{
					echo "email sent\n";
					header('Location: ../index.php?');
					exit;
				}
				else
					die ('email failed to send.');
			}
			else
				die('Username/Email Already Exists');		
		}
		else
			die ('Something went wrong...');
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
	
	$conn = null;	
?>