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
			if (isset($_POST['key']))
			{
				//$user_name	= $_SESSION['username'];
				$imageurl	= $_POST['key'];
				$img		= preg_replace('#^data:image/\w+;base64,#i', '',$imageurl);
				
				$arr = array();

				//$dest = imagecreatefromstring(base64_decode($img));
				//$src = imagecreatefromstring(base64_decode(file_get_contents('bird.txt')));

				$index = 0;
				for ($x = 0; $x <= 7; $x++) 
				{
					if (isset($_SESSION['num'.$x]))
					{
						$arr[$index] = $_SESSION['num'.$x];
						$index++;
					}
				} 
								
				if (sizeof($arr) > 2)
				{
					$dest = imagecreatefromstring(base64_decode($img));
					$src = imagecreatefromstring(base64_decode($arr[0]));

					// 	$src = imagecreatefromstring(base64_decode($arr[$x + 1]));
					// for ($x = 0; $x + 1 < sizeof($arr) - 1; $x++)
					// {	
					// 	$dest = imagecreatefromstring(base64_decode($arr[$x]));
					// 	$src = imagecreatefromstring(base64_decode($arr[$x + 1]));

					imagecopy($dest, $src, 0, 0, 0, 0, 600, 450);
					header('Content-type: image/png');

						ob_start();
						imagepng($dest);
						$sticker = ob_get_contents();
						ob_end_clean();

						$sticker = base64_encode($sticker);
						$temp = base64_decode($sticker);
						file_put_contents('join.png', $temp);

					// 	$arr[$x + 1] = base64_encode($arr[$x + 1]);
					// 	file_put_contents('join'.$x.'.png', $arr[sizeof($arr) - 1]);
					// }
					// file_put_contents('join.png', $arr[sizeof($arr) - 1]);
					
				}

				// if ($index > 2)
				// {
				// 	for (var $i = 0; $i <= $index; $i++)
				// 	{
				// 		$dest = imagecreatefromstring(base64_decode($_SESSION['num'.$imagenum]));
				// 		$src = imagecreatefromstring(base64_decode($_SESSION['num'.$imagenum + 1]));
				// 	}
				// }
				// else if ($index == 1)
				// {

				// }
				// else if ($index == 0)
				// {

				// }

				// imagecopy($dest, $src, 0, 0, 0, 0, 600, 450);
				// header('Content-type: image/png');

				// //https://stackoverflow.com/questions/9370847/php-create-image-with-imagepng-and-convert-with-base64-encode-in-a-single-file
				// ob_start();
				// 	imagepng($dest);
				// 	// Capture the output
				// 	$img = ob_get_contents();

				// // Clear the output buffer
				// ob_end_clean();

				// $img = base64_encode($img);

				// $conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				// $sql = "USE ".$DB_NAME;
				// $stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:user_name");
				// $stmt->bindValue(':user_name', $user_name);
				// $stmt->execute();
				// $usernames = $stmt->fetch();

				// if (!$usernames)
				// 	die("username does not exist");

				// $user_id	= $usernames['user_id'];

				// $sql = "INSERT INTO images (user_id, content)
				// VALUES (:user_id, :content)";
				// $stmt = $conn->prepare($sql);
				// $stmt->bindParam(':user_id', $user_id);
				// $stmt->bindParam(':content', $img);
				// $stmt->execute();
			}
		}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
				
	$conn = null;
?>