<?php
			//echo "<script language='javascript' type='text/javascript'> document.getElementById('login').style.display='block'; </script>";
session_start();
//	https://www.formget.com/php-data-object/
//	http://thisinterestsme.com/php-user-registration-form/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

	$email = $_POST['email'];
	$passw = $_POST['psw'];

	if (isset($_POST["submit"]) 
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
			die('Incorrect username / password combination!');
		else
		{
			if ($user['activated'] == true)
			{
				$validpassword = password_verify($passw, $user['password']);

				if ($validpassword)
				{
					$_SESSION['user_id'] = $user['id'];
    				$_SESSION['username'] = $username;
    				$_SESSION['loggedin'] = true;
					$_SESSION['logged_in'] = time();
					header('Location: ../index.php');
					exit;

				} 
				else
					die('Incorrect username / password combination!');
			}
			else
				die('You have not verified your account, check your email!');
		}
	}
?>