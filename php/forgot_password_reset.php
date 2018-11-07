<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

	$token 			= $_SESSION['token'];
	$email 			= $_SESSION['email'];
	$passw_new		= $_POST['psw_new'];
	$passw_repeat	= $_POST['psw_repeat'];

	if (!isset($passw_new) || empty($passw_new) || !(strlen($passw_new) > 6) || (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw_new)) 
		|| (!isset($passw_repeat) || empty($passw_repeat) && !($passw_new === $passw_repeat)))
		{
			echo "! Password input is invalid<br>";
			if (!(strlen($passw_new) > 6))
			{
				echo "! Password length is too short, must be atleast 6 characters long<br>";
			}
			if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw_new))
			{
				echo "! Passowrd must contain letters and digits<br>";
			}
		}
	else if ((isset($passw_new) && !empty($passw_new) && (strlen($passw_new) > 6) && (preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw_new))) 
		&& (isset($passw_repeat) && !empty($passw_repeat) && ($passw_new === $passw_repeat)))
	{
		echo $email;
		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;		
		$conn->exec($sql);
		$stmt = $conn->prepare("SELECT email = :email AND token = :token FROM users");
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':token', $token);
		$stmt->execute();
		$user = $stmt->fetch();
		if (!$user)
			die('Could not access credentials through database!');
		else
		{
		
			$stmt = $conn->prepare("UPDATE users SET password = :password_new");
			$passw_new = password_hash($passw_new, PASSWORD_BCRYPT);
			$stmt->bindParam(':password_new', $passw_new);
			$stmt->execute();
			
			session_unset($_SESSION['token']);
			session_unset($_SESSION['email']);
			header('Location: ../index.php?');
			exit;		
		}
	 }
	else 
		die('Something went wrong...');
	$conn = null;
?>