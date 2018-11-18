
<table>
	<tr>
		<td>
							<img src="data:image/png;base64,' . $img . '" style="width:60px; height:45px;"/>
						</td>
		<?php
		session_start();
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		var_dump($_SESSION);
		include '../config/database.php';

		try
		{
			if (isset($_SESSION['loggedin']) === true)
			{
				$user_name	= $_SESSION['username'];
				$user_id	= isset($_SESSION['user_id']);

				if (isset($user_name))
				{
					$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
					$sql = "USE ".$DB_NAME;
					$stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:user_name");
					$stmt->bindValue(':user_name', $user_name);
					$stmt->execute();
					$usernames = $stmt->fetch();
					if (!$usernames)
						echo ("username does not exist");

					$user_id	= $usernames['user_id'];
					
					$stmt = $conn->prepare("SELECT * FROM images WHERE user_id=:user_id");
					$stmt->bindValue(':user_id', $user_id);
					$stmt->execute();
					$image = $stmt->fetchAll();

					$image = $stmt->fetchAll();

					for ($i = 0; $i < sizeof($image) ; $i++) 
					{ 
						$img = $image[$i]['content'];

						echo '
						<td>
							<img src="data:image/png;base64,' . $img . '" style="width:60px; height:45px;"/>
						</td>';													
					}
				}
			}
		}
		catch(PDOException $e)
		{
			echo $stmt . "<br>" . $e->getMessage();
		}

		$conn = null;
		?>						
	</tr>
</table>
