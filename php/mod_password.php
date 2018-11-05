<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

	$passw 			= trim($_POST['psw']);
	$passw_new		= trim($_POST['psw_new']);
	$passw_repeat	= trim($_POST['psw_repeat']);
	$username		= $_SESSION['username'];

	if ((isset($passw) && !empty($passw))
	&& (isset($passw_new) && !empty($passw_new))
	&& (isset($passw_repeat) && !empty($passw_repeat) && ($passw_new === $passw_repeat))
	&& ($passw != $passw_new))
	{
		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;		
		$conn->exec($sql);
		$stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:username");
		$stmt->bindValue(':username', $username);
		$stmt->execute();
		$user = $stmt->fetch();
		if (!$user)
			die('password change failed');
		else
		{
			$validpassword = password_verify($passw, $user['password']);

				if ($validpassword)
				{
					$stmt = $conn->prepare("UPDATE users SET password = :password_new WHERE user_name=:username");
					$passw_new = password_hash($passw_new, PASSWORD_BCRYPT);
					$stmt->bindParam(':password_new', $passw_new);
					$stmt->bindParam(':username', $username);
					$stmt->execute();
					
					echo "password changed\n";
					header('Location: ../index.php?');
					exit;
				}
		}
	}
	$conn = null;
?>