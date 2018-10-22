<?php

session_start();
// https://www.formget.com/php-data-object/
include '../config/database.php';


	$email = $_POST['email'];
	$passw = $_POST['psw'];

	if(isset($_POST["submit"]))
	{	
		$sql = "USE ".$DB_NAME;
		$conn = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$conn->exec($sql);

		$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
		$stmt->exec($email);  //execute([$email])
		$newstuff = $stmt->fetch();
		//var_dump($newstuff);
	}

	/*if ($_POST['login'] && $_POST['password'] && $_POST['submit'] && $_POST['submit'] === "OK") 
	{
		//$Password = hash('whirlpool', $_POST['passwd']);
		$Password = password_hash($passw, PASSWORD_BCRYPT);

		try 
		{
			$conn = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "INSERT INTO users (email, password, reg_date)
			VALUES ('".$_POST['login']."','".$Password."','".now()."')";
			if ($conn->query($sql))
				echo "<script type= 'text/javascript'>alert('New Record Inserted Successfully');</script>";
			else
				echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
			$conn = null;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}*/
?>