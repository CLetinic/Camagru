<?php
// REF: https://www.w3schools.com/php/php_mysql_connect.asp
include 'database.php';

	try 
	{
		$conn = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
		$conn->exec($sql);
		echo "Database created successfully<br>";
		$sql = "USE $DB_NAME;";
		$conn->exec($sql);

		// lets create tables for users, images, likes and comments
		$sql = "CREATE TABLE IF NOT EXISTS users 
		(
			user_id INT(255) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			user_name VARCHAR(255) UNIQUE NOT NULL ,
			email VARCHAR(255) UNIQUE NOT NULL ,
			password TEXT NOT NULL,
			token VARCHAR(32) NOT NULL,
			activated BOOLEAN			
		)";
		//reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		$conn->exec($sql);
		echo "Table users created successfully";

/*
	$sql = "CREATE TABLE `camagru`.`images` ( `img_id` INT(255) NOT NULL AUTO_INCREMENT , `img_name` VARCHAR(255) NOT NULL , `user_id` INT(255) NOT NULL , `img_path` VARCHAR(255) NOT NULL , PRIMARY KEY (`img_id`), INDEX (`user_id`)) ENGINE = InnoDB";
		$conn->exec($sql);
			echo "Table images created successfully";
			*/

	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;




/*
http://php.net/manual/en/pdo.setattribute.php

<?php
// Create a new database connection.
$dbConnection = new PDO($dsn, $user, $pass);

// Set the case in which to return column_names.
$dbConnection->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
?>

*/
?>

