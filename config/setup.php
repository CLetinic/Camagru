<?php
// REF: https://www.w3schools.com/php/php_mysql_connect.asp
include 'database.php';

	try 
	{
		$conn = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
		$conn->exec($sql);
		echo "Database created successfully<br/>";
		$sql = "USE $DB_NAME;";
		$conn->exec($sql);

		// lets create tables for users, images, likes and comments
		$sql = "CREATE TABLE IF NOT EXISTS users 
		(
			user_id INT(255) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			user_name VARCHAR(255) UNIQUE NOT NULL,
			email VARCHAR(255) UNIQUE NOT NULL,
			password TEXT NOT NULL,
			token VARCHAR(32) NOT NULL,
			activated BOOLEAN NOT NULL,
			notifications BOOLEAN NOT NULL	
		)";
		$conn->exec($sql);
		echo "Table 'users' created successfully<br/>";

		// create table images that references user with a foreign key
		//https://www.w3schools.com/sql/sql_foreignkey.asp
		$sql = "CREATE TABLE IF NOT EXISTS images 
		(
			image_id INT(255) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			user_id INT(255) NOT NULL,
			FOREIGN KEY (user_id) REFERENCES users(user_id), 
			content LONGTEXT CHARACTER SET utf8 NOT NULL,
			date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL	
		)";
		$conn->exec($sql);
		echo "Table 'images' created successfully<br/>";

// create table comments that references user and images with a foreign key. if the image is deleted, so are the comments.
//http://www.mysqltutorial.org/mysql-on-delete-cascade/
		$sql = "CREATE TABLE IF NOT EXISTS comments 
		(
			comment_id INT(255) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			user_id INT(255) NOT NULL,
			FOREIGN KEY (user_id) REFERENCES users(user_id),
			comment TEXT NOT NULL,
			image_id INT(255) NOT NULL,
			FOREIGN KEY (image_id) REFERENCES images(image_id) ON DELETE CASCADE,
			date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL	
		)";
		$conn->exec($sql);
		echo "Table 'comments' created successfully<br/>";

		$sql = "CREATE TABLE IF NOT EXISTS likes 
		(
			like_id INT(255) AUTO_INCREMENT PRIMARY KEY NOT NULL,
			user_id INT(255) NOT NULL,
			FOREIGN KEY (user_id) REFERENCES users(user_id),
			image_id INT(255) NOT NULL,
			FOREIGN KEY (image_id) REFERENCES images(image_id) ON DELETE CASCADE
		)";
		$conn->exec($sql);
		echo "Table 'likes' created successfully<br/>";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;

?>

