<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	include '../config/database.php';

	$email	= $_POST['email'];
	$email_repeat = $_POST['email_repeat'];

	if (isset($email) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && ($email === $email_repeat))
	{
		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;
		$stmt = $conn->prepare("UPDATE users SET email = :email");
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		echo "name changed\n";
		header('Location: ../index.php?t=true');
		exit;
	}

	$conn = null;
?>