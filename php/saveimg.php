<?php

session_start();
//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include '../config/database.php';

	try
	{
		
		if (isset($_SESSION['loggedin']) === true)
		{
			if (isset($_POST['key']))
			{
				$user_name	= $_SESSION['username'];

				$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "USE ".$DB_NAME;
				$stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:user_name");
				$stmt->bindValue(':user_name', $user_name);
				$stmt->execute();
				$usernames = $stmt->fetch();

				if (!$usernames)
					die("username does not exist");

				$user_id	= $usernames['user_id'];				
				$imageurl	= $_POST['key'];
				$img		= preg_replace('#^data:image/\w+;base64,#i', '',$imageurl);				
				$arr = array();
				
				$index = 0;
				for ($x = 0; $x <= 7; $x++) 
				{
					if (isset($_SESSION['num'.$x]))
					{
						$arr[$index] = $_SESSION['num'.$x];
						$index++;
					}
				} 
								
				for ($x = 0; $x < sizeof($arr); $x++)
				{	
					$dest = imagecreatefromstring(base64_decode($img));
					$src = imagecreatefromstring(base64_decode($arr[$x]));

					imagecopy($dest, $src, 0, 0, 0, 0, 600, 450);
					header('Content-type: image/png');

					//https://stackoverflow.com/questions/9370847/php-create-image-with-imagepng-and-convert-with-base64-encode-in-a-single-file
					ob_start();
					
						imagepng($dest);					
						$img = ob_get_contents(); // Capture the output

					ob_end_clean(); // Clear the output buffer

					$img = base64_encode($img);
					$temp = base64_decode($img);					

					//file_put_contents('join'.$x.'.png', $temp);
				}
				// $temp = base64_decode($img);
				// file_put_contents('join.png', $temp);
			
				$sql = "INSERT INTO images (user_id, content)
				VALUES (:user_id, :content)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':user_id', $user_id);
				$stmt->bindParam(':content', $img);
				$stmt->execute();

				for ($x = 0; $x < sizeof($arr); $x++)
				{
					if (isset($_SESSION['num'.$x]))
						unset($_SESSION['num'.$x]);
				} 
			}
		}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
				
	$conn = null;
?>