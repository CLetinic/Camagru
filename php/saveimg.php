<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';
	$user_name		= $_SESSION['username'];
	//$time = value(NOW());
print_r($_SESSION);
//$imageurl = preg_replace('#^data:image/\w+;base64,#i', '',$_POST['key']);
$imageurl = $_POST['key'];
//$img = base64_encode(preg_replace('#^data:image/\w+;base64,#i', '',$imageurl)));
$img = preg_replace('#^data:image/\w+;base64,#i', '',$imageurl);
 //echo "<script>console.log( 'Debug Objects' );</script>";
 //echo "image working";
 // file_put_contents('test3.png', base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$imageurl)));
 // file_put_contents('testing.txt', preg_replace('#^data:image/\w+;base64,#i', '',$imageurl));
	$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$sql = "USE ".$DB_NAME;
	$sql = "INSERT INTO images (user_name, content)
	VALUES (:user_name, :content)";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':user_name', $user_name);
	$stmt->bindParam(':content', $img);
//		$stmt->bindParam(':date_added', CURRENT_TIMESTAMP);
	$stmt->execute();
				
	$conn = null;
?>