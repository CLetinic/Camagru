<?php

// remember to remove this
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';
include_once './functions.php';

	try
	{
		$new_username	= trim(htmlspecialchars($_POST['username']));
		$username		= $_SESSION['username'];

		if (!isset($new_username) || empty($new_username) || strlen($new_username) < 4)
		{
			echo "! Username input is invalid - *also check to see if username is more than 4 characters long<br>";
		}
			else if (isset($new_username) && !empty($new_username) && !(strlen($new_username) < 4))
			{

				$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				$exist = checkExist($new_username, NULL, $conn);

				if (!$exist)
				{
					$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // remember to replace to PDO::ERRMODE_EXCEPTION
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