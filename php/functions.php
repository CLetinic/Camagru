<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	include '../config/database.php';
	
	function checkExist($user_name, $email, $conn)
	{
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email OR user_name=:user_name");
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':user_name', $user_name);
		$stmt->execute();
		$user = $stmt->fetch();

		if ($user)
			return true;
		else if (!$user)
			return false;
	}

?>