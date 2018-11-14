<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

	try
	{
		$email	= trim(htmlspecialchars($_POST['email']));
		$token	= bin2hex(openssl_random_pseudo_bytes(16));

		if (!isset($email) || empty($email) || !(filter_var($email, FILTER_VALIDATE_EMAIL)))
		{
			echo "! Email input is invalid<br>";
		}
		else if ((isset($_POST["submit"])) && (isset($email)) && (!empty($email)) && (filter_var($email, FILTER_VALIDATE_EMAIL)))
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

				$to			= $email; 
				$subject	= 'Password Reset';
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
		<h2>Seems you have forgotten your password!</h2><br>
		<p>
		You can create a new password after pressing the url below.<p>
		<p>
			Please click this button to reset your password:
			<br>
		<p>

		<a href="."http://127.0.0.1:8080/camagru/php/forgot_password_verify.php?email='$email'&token='$token'".">
			<button>
				Reset Password
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
					echo "email failed to send\n";
			}			
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