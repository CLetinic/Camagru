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
			$image_id 		= trim(htmlspecialchars($_POST['image_id']));
			$url			= $_POST['url'];
			$user_id	= $usernames['user_id'];
		}
		else 
			die("no session variables are set");
		
		if (!isset($user_name) || empty($user_name))
		{
			echo "! Username is invalid <br>";
		}
		else if ((isset($user_name) && !empty($user_name)) 
			&& (isset($image_id) && !empty($image_id)))
		{
			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "USE ".$DB_NAME;
			$stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:user_name");
			$stmt->bindValue(':user_name', $user_name);
			$stmt->execute();
			$usernames = $stmt->fetch();

			if (!$usernames)
				die("username does not exist");

			$user_id	= $usernames['user_id'];

			$stmt = $conn->prepare("SELECT * FROM likes WHERE image_id=:image_id AND user_id=:user_id");
			$stmt->bindValue(':image_id', $image_id);
			$stmt->bindValue(':user_id', $user_id);
			$stmt->execute();
			$liked = $stmt->fetch();

			if (!$liked)
			{
					$sql = "INSERT INTO likes (user_id, image_id)
					VALUES (:user_id, :image_id)";
					$stmt = $conn->prepare($sql);
					$stmt->bindParam(':user_id', $user_id);
					$stmt->bindParam(':image_id', $image_id);
					$stmt->execute();
			}
			else if ($liked)
			{
				// die ('you have already liked this image');
				$stmt = $conn->prepare("DELETE FROM likes WHERE image_id=:image_id AND user_id=:user_id");
				$stmt->bindValue(':image_id', $image_id);
				$stmt->bindValue(':user_id', $user_id);
				$stmt->execute();
			}
			else
				die ('Something went wrong');
			header('Location: ../' . $url . '');
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