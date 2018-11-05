<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

	$new_username	= trim($_POST['username']);
	$username		= $_SESSION['username'];

	if (isset($new_username) && !empty($new_username))
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
			die('username change failed.');
		else
		{
			$stmt = $conn->prepare("UPDATE users SET user_name = :new_username WHERE user_name = :username");
			$stmt->bindParam(':new_username', $new_username);
			$stmt->bindParam(':username', $username);
			$stmt->execute();
			
			echo "password changed\n";
			$_SESSION['username'] = $new_username;
			header('Location: ../index.php?t=true');
			exit;
		}
	}
	$conn = null;
?>