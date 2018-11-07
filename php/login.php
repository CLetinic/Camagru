<?php
			//echo "<script language='javascript' type='text/javascript'> document.getElementById('login').style.display='block'; </script>";
session_start();
//	https://www.formget.com/php-data-object/
//	http://thisinterestsme.com/php-user-registration-form/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

	$email = trim(htmlspecialchars($_POST['email']));
	$passw = htmlspecialchars($_POST['psw']);

	try
	{
		// Check for errors
		if (!isset($email) || empty($email) || !(filter_var($email, FILTER_VALIDATE_EMAIL)))
		{
			echo "! Email input is invalid<br>";
		}
		else if (!isset($passw) || empty($passw) || !(strlen($passw) > 6) || (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw)))
		{
			echo "! Password input is invalid<br>";
			if (!(strlen($passw) > 6))
			{
				echo "! Password length is too short, must be atleast 6 characters long<br>";
			}
			if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw))
			{
				echo "! Passowrd must contain letters and digits<br>";
			}
		}
		else if ((isset($_POST["submit"])) 
			&& (isset($email) && !empty($email) && (filter_var($email, FILTER_VALIDATE_EMAIL)))
			&& (isset($passw) && !empty($passw)))
		{	
			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "USE ".$DB_NAME;		
			$conn->exec($sql);
			$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
			$stmt->bindValue(':email', $email);
			$stmt->execute();
			$user = $stmt->fetch();
			if (!$user)
				die('Could not access credentials through database!');
			else
			{
				if ($user['activated'] == true)
				{
					$validpassword = password_verify($passw, $user['password']);

					if ($validpassword)
					{
						$_SESSION['user_id'] = $user['user_id'];
						$_SESSION['username'] = $user['user_name'];
						$_SESSION['loggedin'] = true;
						$_SESSION['logged_in'] = time();
						$_SESSION['email_notify'] = $user['notifications'];
						header('Location: ../index.php?');
						exit;
					} 
					else
						die('Incorrect username / password combination!');
				}
				else
					die('You have not verified your account, check your email!');
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