<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

	try
	{
		$user_name	= $_SESSION['username'];
		$imageurl	= $_POST['key'];
		$img		= preg_replace('#^data:image/\w+;base64,#i', '',$imageurl);

		$dest = base64_decode($img);// base
		$dest = file_put_contents('image.png', $dest);
		$src = base64_decode(file_get_contents('bird.txt'));// what to add
		$src = file_put_contents('bird.png', $src);
		$merge = imagecopymerge('image.png', 'bird.png', 0, 0, 0, 0, 0, 600, 450);
		file_put_contents("merge.png",$merge);

		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;
		$sql = "INSERT INTO images (user_name, content)
		VALUES (:user_name, :content)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':user_name', $user_name);
		$stmt->bindParam(':content', $img);
		$stmt->execute();
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
				
	$conn = null;
?>