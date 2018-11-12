<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';

	$user_name		= $_SESSION['username'];
	$image_user		= trim(htmlspecialchars($_POST['image_user']));
	$image_id 		= trim(htmlspecialchars($_POST['image_id']));
	$comment 		= htmlspecialchars($_POST['commet_txt']);

	print_r($_SESSION);
	print_r($_POST);

	try
	{
		// Check for errors
		if (!isset($user_name) || empty($user_name))
		{
			echo "! Username is invalid <br>";
		}
		else if (!isset($comment) || empty($comment))
		{
			echo "! Comment is invalid <br>";
		}
		else if ((isset($user_name) && !empty($user_name)) 
			&& (isset($image_user) && !empty($image_user))
			&& (isset($image_id) && !empty($image_id)) 
			&& (isset($comment) && !empty($comment)))
		{
				$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				$sql = "USE ".$DB_NAME;
				$sql = "INSERT INTO comments (user_name, comment, image_id)
				VALUES (:user_name, :comment, :image_id)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':user_name', $user_name);
				$stmt->bindParam(':comment', $comment);
				$stmt->bindParam(':image_id', $image_id);
				$stmt->execute();

				echo "New record created successfully<br>";


// 				// Send out a verification email

// 				$to			= $email; 
// 				$subject	= 'Signup | Verification';
// 				$headers 	= "MIME-Version: 1.0\r\n";
// 				$headers 	.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
// 				$message 	= 
// "
// <html>
//   <head>
//     <style>
// 		button
// 		{
// 			background-color: rgb(40, 41, 35);
// 			color: white;
// 			border: none;
// 			outline: none;
// 			cursor: pointer;
// 			width: 100%;
// 			display: inline-block;
// 			font-size: 18px;
// 			font-weight: bold;
// 			padding: 16px 31px;
// 			text-decoration: none;
// 		}

// 		button:hover 
// 		{
// 			background-color: rgb(249, 35, 112);
// 		}
// 		p
// 		{
// 			color: black;
// 		}
// 		h1
// 		{
// 			color: black;
// 		}
// 		</style>
// 	</head>
// 	<body>
// 		<h2>Thanks for signing up!</h2><br>
// 		<p>Your account has been created, you can login with your credentials
// 		<br>
// 		after you have activated your account by pressing the button below.<p>
// 		<p>
// 			Please click below to activate your account:
// 			<br>
// 		<p>

// 		<a href="."http://127.0.0.1:8080/camagru/php/verify.php?email='$email'&token='$token'".">
// 			<button>
// 				Activate
// 			</button>
// 		</a>		
// 	</body>
// </html>
// ";
// 				if (mail($to, $subject, $message, $headers))
// 				{
// 					echo "email sent\n";
// 					header('Location: ../index.php?');
// 					exit;
// 				}
// 				else
// 					die ('email failed to send.');
// 			}
// 			else
// 				die('Username/Email Already Exists');		
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