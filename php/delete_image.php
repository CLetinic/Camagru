<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

	try
	{
		if (isset($_SESSION['loggedin']) === true)
		{
			$user_name		= $_SESSION['username'];
			$image_user		= trim(htmlspecialchars($_POST['image_user']));
			$image_id 		= trim(htmlspecialchars($_POST['image_id']));

			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "USE ".$DB_NAME;
			$stmt = $conn->prepare("SELECT * FROM users WHERE user_id=:user_id");
			$stmt->bindValue(':user_id', $image_user);
			$stmt->execute();
			$usernames = $stmt->fetch();

			if (!$usernames)
				die("username does not exist");

			
			if ($user_name == $usernames['user_name'])
			{
				$stmt = $conn->prepare("DELETE FROM images WHERE image_id=:image_id");
				$stmt->bindValue(':image_id', $image_id);
				$stmt->execute();

				//http://127.0.0.1:8080/camagru/php/index.php?activepage=gallery&user_name=nelly&page=1
				//http://127.0.0.1:8080/camagru/index.php?activepage=gallery&user_name=nelly&page=1
				header('Location: ../index.php?activepage=gallery&user_name=' . $user_name . '&page=1');
			}
			else
				die("you are unauthorised to delete this image");
		}
		else
			die ("You're not logged in!");
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
	
	$conn = null;

?>