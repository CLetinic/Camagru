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
			if (isset($_POST['base']) && isset($_POST['stickerArray']))
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
				$imageurl	= $_POST['base'];
				$img		= preg_replace('#^data:image/\w+;base64,#i', '',$imageurl);				
				$arr = array();
				$index = 0;

				$file = 'people.txt';
				// Open the file to get existing content
				$current = file_get_contents($file);
				// Append a new person to the file
				$current .= $_POST['base'];
				// Write the contents back to the file
				file_put_contents($file, $current);


				$file = 'peopleARRR.txt';

				$stickerArray = json_decode($_POST['stickerArray']);
				$max = sizeof($stickerArray);

				// Open the file to get existing content
				$current = file_get_contents($file);
				// Append a new person to the file

				if (isset($_POST['stickerArray']))
				{
					for ($i=0; $i < $max; $i++) { 
					
						$current .= $max;
						$current .= "_____";
						$current .= $i;
						$current .= "\n______________________________________________\n";
	
						// Open the file to get existing content
						
						// Append a new person to the file
						$current .= $stickerArray[$i];
						// Write the contents back to the file
						$stickerImg = preg_replace('#^data:image/\w+;base64,#i', '', ($stickerArray[$i]));	
						$arr[$i] = $stickerImg;
					}
	
					file_put_contents($file, $current);
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

					file_put_contents('join'.$x.'.png', $temp);
				}
				// $temp = base64_decode($img);
				// file_put_contents('join.png', $temp);
			
				$sql = "INSERT INTO images (user_id, content)
				VALUES (:user_id, :content)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':user_id', $user_id);
				$stmt->bindParam(':content', $img);
				$stmt->execute();

				header('Location: ..index.php?activepage=photobooth/');
			}
		}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
				
	$conn = null;
?>