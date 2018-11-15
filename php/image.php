<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

	try
	{

		$dest = imagecreatefromstring(base64_decode(file_get_contents('image.txt')));
		$src = imagecreatefromstring(base64_decode(file_get_contents('bird.txt')));

		imagecopy($dest, $src, 0, 0, 0, 0, 600, 450);
		header('Content-type: image/png');
		imagepng($dest);

		// imagedestroy($dest);
		// imagedestroy($src);
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
				
	$conn = null;
?>