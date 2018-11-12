<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

	$username		= $_SESSION['username'];

	$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$sql = "USE ".$DB_NAME;		
	$stmt = $conn->prepare("SELECT * FROM images WHERE user_name=:username");
	$stmt->bindValue(':username', $username);
	$stmt->execute();
	$image = $stmt->fetchAll();

	//REF: https://www.youtube.com/watch?v=gdEpUPMh63s Create Pagination in PHP and MySQL
	$results_per_page = 5;
	$number_of_results = sizeof($image);

	$number_of_pages = ceil($number_of_results / $results_per_page);

	if (!isset($_GET['page'])) 
		$page = 1;
	else
		$page = $_GET['page'];

	$page_first_result = ($page - 1) * $results_per_page;

	$stmt = $conn->prepare("SELECT * FROM images WHERE user_name=:username LIMIT " . $page_first_result . "," .  $results_per_page);
	$stmt->bindValue(':username', $username);
	$stmt->execute();
	$image = $stmt->fetchAll();

	// Images per page
	for ($i = 0; $i < sizeof($image) ; $i++) 
	{ 
		$img = $image[$i]['content'];
		$img_id = $image[$i]['image_id'];
		$img_user = $image[$i]['user_name'];
		echo '
		<td>
			<img src="data:image/png;base64,' . $img . '" />';
		echo '
			<div>
				<a>Likes</a>
				<a>Comment</a>
				<a>delete</a>
			<div>';
		echo '
			<form action="comment.php" id="commentform">
				<input type="hidden" id="image_id" name="image_id" value="' . $img_id . '"> 
				<input type="hidden" id="image_user" name="image_user" value="' . $img_user . '">
				<textarea name="comment" form="commentform">Enter text here...</textarea>
				<br/>
  				<input type="submit">
			</form>
		</td>';
	}
	
	echo "<br/>";

	// Pages Links
	for ($page = 1; $page <= $number_of_pages; $page++) 
	{
		echo '<a href="gallery.php?page=' . $page . '">' . $page . '</a> ';
	}

	$conn = null;
?>

<script>

</script>
