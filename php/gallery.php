<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

$username		= $_SESSION['username'];
					// var_dump($username);

					$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
					$sql = "USE ".$DB_NAME;		
					$stmt = $conn->prepare("SELECT * FROM images WHERE user_name=:username");
					$stmt->bindValue(':username', $username);
					$stmt->execute();

					$index = 0;
					// var_dump()
					while ($image = $stmt->fetch()) 
					{ 						 	
						file_put_contents("image.$index.png", base64_decode($image['content']));
						if ($index % 5 == 0)
							echo"<tr>";

						$img = $image['content'];
						echo '<td><img src="data:image/png;base64,' . $img . '" /><td>';

						$index++;
						if ($index % 5 == 5)
							echo"<tr>";
					}						 
?>