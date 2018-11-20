<?php

session_start();
//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

	include '../config/database.php';
	include_once './functions.php';

	try
	{
		$email			= trim(htmlspecialchars($_POST['email']));
		$email_repeat	= trim(htmlspecialchars($_POST['email_repeat']));

		if (isset($_SESSION['loggedin']) === true)
			$username		= $_SESSION['username'];
		else
			die ('no session variables have been set');

		if (!isset($email) || empty($email) || !(filter_var($email, FILTER_VALIDATE_EMAIL)) || !isset($email_repeat) || empty($email_repeat) || !($email === $email_repeat))
		{
			echo "! Email input is invalid<br>";
		}
		else if (isset($email) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) 
			&& isset($email_repeat) && !empty($email_repeat) && filter_var($email_repeat, FILTER_VALIDATE_EMAIL)
			&& ($email === $email_repeat))
		{

			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$exist = checkExist(NULL, $email, $conn);

			if (!$exist)
			{
				$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

						$to			= $email;
						$redirect	= "http://127.0.0.1:8080/camagru/php/verify.php?email=". $email . "&token=" . $token;
						$subject	= 'Email Change';
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
		<h2>Seems You have modified your email address!</h2><br>
		<p>
		to log in with your new credentials<p>
		<p>
			Please click this button to activate your account:
			<br>
		<p>
		<a href=". $redirect .">
			<button>
				Reset Password
			</button>
		</a>
		<p>
		Should the button above not work, please use the link provided below
		<br>
		" . $redirect . "
		</p>	
	</body>
</html>
";
						if (mail($to, $subject, $message, $headers))
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