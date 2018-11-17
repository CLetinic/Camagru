<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';
	

		
		// $img1 = file_put_contents('img1.png', base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',file_get_contents('img1.txt'))));
		// $img2 = file_put_contents('img2.png', base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',file_get_contents('img2.txt'))));
		// // $img1 = base64_decode();// what to add
		// $img1 = file_put_contents('img1.png', $src);

		// $img1 = base64_decode(file_get_contents('img1.txt'));// what to add
		// $img1 = file_put_contents('img1.png', $src);
		
		$img1 = base64_decode(file_get_contents('img1.txt'));
		file_put_contents('img1.png', $img1);

		$img2 = base64_decode(file_get_contents('img2.txt'));
		file_put_contents('img2.png', $img1);

	
?>