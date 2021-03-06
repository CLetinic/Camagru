<?php

session_start();
//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include '../config/database.php';

	try
	{
		$notify		= $_POST['notifi'];

		if (isset($_SESSION['loggedin']) === true)
		{
			$username	= $_SESSION['username'];
			$_SESSION['email_notify'] = $notify;
		}
		else
			die('No session variables have been set');

		if ($notify === "true" || $notify === "false")
		{
				$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "USE ".$DB_NAME;		
				$stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:username");
				$stmt->bindValue(':username', $username);
				$stmt->execute();
				$user = $stmt->fetch();
				if (!$user)
					die('email notifications change failed.');
				else
				{
					if ($notify === "true")
					{
						//file_put_contents("test.txt","notify is true\n");					
						$notifications 		= 1;

						$stmt = $conn->prepare("UPDATE users SET notifications  = :notifications  WHERE user_name = :username");
						$stmt->bindParam(':notifications', $notifications);
						$stmt->bindParam(':username', $username);
						$stmt->execute();
					}
					else if ($notify === "false")
					{
						//file_put_contents("test.txt","notify is false\n");
						$notifications = 0;

						$stmt = $conn->prepare("UPDATE users SET notifications  = :notifications  WHERE user_name = :username");
						$stmt->bindParam(':notifications', $notifications);
						$stmt->bindParam(':username', $username);
						$stmt->execute();
					}
					else
						die('email notifications change failed.');
				}		
		}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
	
	$conn = null;
	exit;
?>