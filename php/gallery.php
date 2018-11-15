<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

	try
	{
		if (isset($_SESSION['loggedin']) === true)
		{
			$username	= $_SESSION['username'];
			$user_id	= isset($_SESSION['user_id']);
			$loggedin	= isset($_SESSION['loggedin']);

			if (!isset($_GET['user_name']))
			{
				$user_name	= $username;
			}
			else if (isset($_GET['user_name']))

				$user_name	= htmlspecialchars($_GET['user_name']);	
		}
		else if (isset($_GET['user_name']))
			$user_name	= htmlspecialchars($_GET['user_name']);	
		else if (!isset($_GET['user_name']))
			die("either log in or put in a user name");
		else
			die("Something went wrong...");

		$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;
		$stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:user_name");
		$stmt->bindValue(':user_name', $user_name);
		$stmt->execute();
		$usernames = $stmt->fetch();
		if (!$usernames)
			die("username does not exist");

		$user_id	= $usernames['user_id'];

		// $conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		// $sql = "USE ".$DB_NAME;		
		// $stmt = $conn->prepare("SELECT * FROM users WHERE user_id=:user_id");
		// $stmt->bindValue(':user_id', $user_id);
		// $stmt->execute();
		// $userids = $stmt->fetch();		
		
		$stmt = $conn->prepare("SELECT * FROM images WHERE user_id=:user_id");
		$stmt->bindValue(':user_id', $user_id);
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


		$stmt = $conn->prepare("SELECT * FROM images WHERE user_id=:user_id LIMIT " . $page_first_result . "," .  $results_per_page);
		$stmt->bindValue(':user_id', $user_id);
		$stmt->execute();
		$image = $stmt->fetchAll();

		$url = htmlspecialchars(strchr($_SERVER['REQUEST_URI'], "gallery"));

		// Images per page
		for ($i = 0; $i < sizeof($image) ; $i++) 
		{ 
			$img = $image[$i]['content'];
			$img_id = $image[$i]['image_id'];
			$img_user = $image[$i]['user_id'];

			$stmt = $conn->prepare("SELECT * FROM comments WHERE image_id=:image_id");
			$stmt->bindValue(':image_id', $img_id);
			$stmt->execute();
			$comments = $stmt->fetchAll();

			$stmt = $conn->prepare("SELECT * FROM likes WHERE image_id=:image_id");
			$stmt->bindValue(':image_id', $img_id);
			$stmt->execute();
			$likes = $stmt->fetchAll();
			$no_likes = sizeof($likes);

			echo '
			<td>
				<img src="data:image/png;base64,' . $img . '" />';
			if (isset($_SESSION['loggedin']) === true)
			{
				echo '<br><div>';
				echo '			
					<form action="like_image.php" id="like_imageform'.$img_id.'" method="POST">
					<input type="hidden" name="url" value="' . $url . '"> 
					<input type="hidden" name="image_id" value="' . $img_id . '"> 
					<input type="hidden" name="liked_by" value="' . $user_id . '">
						<button type="submit">Like | '. $no_likes .' </button>
					</form>';
						// <button>Comment</button>';
				if (isset($_SESSION['loggedin']) === true && ($username == $user_name))
				{
					echo '			
					<form action="delete_image.php" id="delete_imageform'.$img_id.'" method="POST">
					<input type="hidden" name="image_id" value="' . $img_id . '"> 
					<input type="hidden" name="image_user" value="' . $img_user . '">
						<button type="submit">Delete</button>
					</form>';
				}
				echo '</div>';
				echo '
					<form action="comment.php" id="commentform'.$img_id.'" method="POST">
						<input type="hidden" name="url" value="' . $url . '"> 
						<input type="hidden" name="image_id" value="' . $img_id . '"> 
						<input type="hidden" name="image_user" value="' . $img_user . '">
						<textarea name="commet_txt" form="commentform'.$img_id.'"></textarea>
						<br>
							<input type="submit">
					</form>
					';
				}
				echo '
					<br>
					<table>';
					
				for ($j=0; $j < sizeof($comments); $j++) 
				{ 
					$comment = $comments[$j]['comment'];
					$comment_by = $comments[$j]['user_id'];

					$stmt = $conn->prepare("SELECT * FROM users WHERE user_id=:user_id");
					$stmt->bindValue(':user_id', $comment_by);
					$stmt->execute();
					$com_user = $stmt->fetch();

					$by = $com_user['user_name'];

					echo'
						<tr>
							<td>'
								. $by . 
								'<td>'
								. $comment . 
								'</td>' .
							'</td>
						</tr>
						';
				}
			echo '
				</table>
				 ';
			}

			echo "<br>";

			// Pages Links
			for ($page = 1; $page <= $number_of_pages; $page++) 
			{
				echo '<a href="gallery.php?user_name=' . $user_name .'&page=' . $page . '">' . $page . '</a> ';
			}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}

	$conn = null;
?>
