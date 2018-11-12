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

		$stmt = $conn->prepare("SELECT * FROM comments WHERE image_id=:image_id");
		$stmt->bindValue(':image_id', $img_id);
		$stmt->execute();
		$comments = $stmt->fetchAll();

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
			<form action="comment.php" id="commentform'.$img_id.'" method="POST">
				<input type="hidden" name="image_id" value="' . $img_id . '"> 
				<input type="hidden" name="image_user" value="' . $img_user . '">
				<textarea name="commet_txt" form="commentform'.$img_id.'"></textarea>
				<br/>
  				<input type="submit">
			</form>
			<br/>
			<table>
			';

			for ($j=0; $j < sizeof($comments); $j++) 
			{ 
				$comment = $comments[$j]['comment'];
				$comment_by = $comments[$j]['user_name'];
				
				echo'
					<tr>
						<td>'
							. '<p>' . $comment_by . ' : ' . $comment . '</p>' .
						'</td>
					</tr>
					';
			}
		echo '
			</table>
			 ';
	}
	
	echo "<br/>";

	// Pages Links
	for ($page = 1; $page <= $number_of_pages; $page++) 
	{
		echo '<a href="gallery.php?page=' . $page . '">' . $page . '</a> ';
	}

	$conn = null;
?>
<!-- 
	<script>
									function checkBox(d)
									{
										var xml = new XMLHttpRequest();
										xml.open("POST", "php/mod_emailnotifications.php", true);
										var toggle_true = "true";
										var toggle_false = "false";
										xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

										if (d.checked == true)
											xml.send("notifi=true");
										else if (d.checked == false)
											xml.send("notifi=false");
									};
								</script>
 -->