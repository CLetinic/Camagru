<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';
  
	$user_name	= $_POST['username'];

	if (isset($user_name) && !empty($user_name))
	{
		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;
		$stmt = $conn->prepare("UPDATE users SET user_name = :user_name");
		$stmt->bindParam(':user_name', $user_name);
		$stmt->execute();
		echo "name changed\n";
		header('Location: ../index.php?t=true');
		exit;
	}
/*

$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "USE ".$DB_NAME;
			$sql = "UPDATE users SET activated = $active WHERE email=$email";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			header('Location: ../index.php?t=true');
			exit;
			*/
			$conn = null;
?>