<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

	//$notifications	= true;
	$notify = $_POST['notifi'];

	file_put_contents("test.txt","Hello World. Testing!\n");

	if ($notify === "true")
	{
		file_put_contents("test.txt","notify is true\n");
		
		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;		
		//$conn->exec($sql);
		$stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:username");
		$stmt->bindValue(':username', $username);
		$stmt->execute();
		$user = $stmt->fetch();
		if (!$user)
			die('Incorrect password combination!');
		{
			$validpassword = password_verify($passw, $user['password']);

				if ($validpassword)
				{
					$stmt = $conn->prepare("UPDATE users SET password = :password_new");
					$passw_new = password_hash($passw_new, PASSWORD_BCRYPT);
					$stmt->bindParam(':password_new', $passw_new);
					$stmt->execute();
					
					echo "password changed\n";
					header('Location: ../index.php?t=true');
					exit;
				}
		}
		
	}
	else if ($notify === "false")
	{
		//file_put_contents("test.txt","notify is false\n");
	}
	$conn = null;

/*
$imageurl = $_POST['key'];
// echo $imageurl;
file_put_contents('test3.png', base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$imageurl)));
echo $_POST['overlay'];
*/

?>