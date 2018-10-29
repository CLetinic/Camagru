<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

	$passw 			= $_POST['psw'];
	$passw_new		= $_POST['psw_new'];
	$passw_repeat	= $_POST['psw_repeat'];

if ((isset($passw) && !empty($passw))
	&& (isset($passw_new) && !empty($passw_new))
	&& (isset($passw_repeat) && !empty($passw_repeat) && ($passw_new === $passw_repeat)))
	{
		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;
		$stmt = $conn->prepare("UPDATE users SET password = :password_new where password = $passw");
		$stmt->bindParam(':password_new', $passw_new);
		$stmt->execute();
		echo "password changed\n";
		//header('Location: ../index.php?t=true');
		//exit;
	}

$conn = null;

?>