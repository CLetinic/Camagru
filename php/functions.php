<?php

//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	
	function checkExist($user_name, $email, $conn)
	{
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email OR user_name=:user_name");
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':user_name', $user_name);
		$stmt->execute();
		$user = $stmt->fetch();

		if ($user)
		{
			$conn = null;
			return true;
		}
		else if (!$user)
		{
			$conn = null;
			return false;
		}
	}
?>