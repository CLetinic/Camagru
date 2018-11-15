<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

	try
	{
		print_r($_SESSION);
		if (isset($_SESSION['loggedin']) === true)
		{
			$user_name	= $_SESSION['username'];
			$imageurl	= $_POST['key'];
			$img		= preg_replace('#^data:image/\w+;base64,#i', '',$imageurl);

			$dest = imagecreatefromstring(base64_decode($img));
			$src = imagecreatefromstring(base64_decode(file_get_contents('bird.txt')));

			imagecopy($dest, $src, 0, 0, 0, 0, 600, 450);
			header('Content-type: image/png');

			//https://stackoverflow.com/questions/9370847/php-create-image-with-imagepng-and-convert-with-base64-encode-in-a-single-file
			ob_start();
				imagepng($dest);
				// Capture the output
				$img = ob_get_contents();

			// Clear the output buffer
			ob_end_clean();

			$img = base64_encode($img);

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

			$sql = "INSERT INTO images (user_id, content)
			VALUES (:user_id, :content)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':user_id', $user_id);
			$stmt->bindParam(':content', $img);
			$stmt->execute();
		}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
				
	$conn = null;
?>