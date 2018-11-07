<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

	$passw 			= htmlspecialchars($_POST['psw']);
	$passw_new		= htmlspecialchars($_POST['psw_new']);
	$passw_repeat	= htmlspecialchars($_POST['psw_repeat']);
	$username		= $_SESSION['username'];

	try
	{
		if (!isset($passw) || empty($passw) || !isset($passw_new) || empty($passw_new) || !isset($passw_repeat) || empty($passw_repeat) || !($passw_new === $passw_repeat) || !(strlen($passw) > 6) || (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw)) || !(strlen($passw_new) > 6) || (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw_new)))
		{
			echo "! Password input is invalid<br>";
			if (!($passw_new === $passw_repeat))
			{
				echo "! Password fields do not match<br>";
			}
			if (!(strlen($passw) > 6))
			{
				echo "! Password length is too short, must be atleast 6 characters long<br>";
			}
			if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw_repeat))
			{
				echo "! Password must contain letters and digits<br>";
			}
			if ($passw === $passw_new)
			{
				echo "! Password is the same as old<br>";
			}
		}
		else if ((isset($passw) && !empty($passw))
		&& (isset($passw_new) && !empty($passw_new))
		&& (isset($passw_repeat) && !empty($passw_repeat) && ($passw_new === $passw_repeat))
		&& (strlen($passw) > 6) && (preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw)) && (strlen($passw_new) > 6) && (preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw_new)))
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
		else
			die ('Something went wrong...');
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
	$conn = null;
?>