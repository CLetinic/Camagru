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

			if ($user_name == $image_user)
			{
				$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				$sql = "USE ".$DB_NAME;		
				$stmt = $conn->prepare("DELETE FROM images WHERE image_id=:image_id");
				$stmt->bindValue(':image_id', $image_id);
				$stmt->execute();

				header('Location:' . $url . '');
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