
<?php
session_start();
// https://www.formget.com/php-data-object/
include 'config/database.php';

/*	//if(isset($_POST["submit"]))
	//{
	if ($_POST['login'] && $_POST['password'] && $_POST['submit'] && $_POST['submit'] === "OK") 
	{
		//$Password = hash('whirlpool', $_POST['passwd']);
		$Password = password_hash($_POST['password'], PASSWORD_BCRYPT);

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


<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>Camagru</TITLE>
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
	</HEAD>
	<BODY>
		<header>
			<p id="info"> ! change</p>
		</header>
		<div class="banner">
			<a href="index.html">
				<img id= "logo" src="img/logo.svg">
			</a>				
		</div>
		<nav>
			<a class="active" href="index.html">Home</a>
			<a href="">Photo Booth</a>
			<a href="">Gallery</a>
			<a class="right" onclick="document.getElementById('signup').style.display='block'">Sign Up</a>
			<a class="right" onclick="document.getElementById('login').style.display='block'">Login</a>
		</nav>
		<!-- LOGIN -->
		<div id="login" class="modal">
			<form class="login_content" action="php/login.php" method="POST">
				<div id="login_header"> 
					<h1 style="float:left;">Camagru</h1>
					<span style="float:right;" onclick="document.getElementById('login').style.display='none'" class="close" title="Close Modal">&times;</span>
				</div>					
				<div class="container">
					<label for="email"><b>Email</b></label>
					<input type="email" placeholder="Enter Email" name="email" required>
					<label for="password"><b>Password</b></label>
					<input type="password" placeholder="Enter Password" name="password" required>
					<button id="loginbtn" type="submit" name="submit">Login</button>
					<label>
						<input type="checkbox" checked="checked" name="remember"> Remember me
					</label>
				</div>
				<div class="container" id="login_bottom">
					<button type="button" onclick="document.getElementById('login').style.display='none'" class="cancelbtn">Cancel</button>
					<span class="psw">Forgot <a href="#">password?</a></span>
				</div>
			</form>
		</div>
		<!-- Sign Up -->
		<div id="signup" class="modal_signup">
			<form action="/action_page.php">
				<div class="signup_container">
					<h1>Register</h1>
					<p>Please fill in this form to create an account.</p>
					<hr>
						<label for="email"><b>Email</b></label>
						<input type="text" placeholder="Enter Email" name="email" required>
						<label for="psw"><b>Password</b></label>
						<input type="password" placeholder="Enter Password" name="psw" required>
						<label for="psw-repeat"><b>Repeat Password</b></label>
						<input type="password" placeholder="Repeat Password" name="psw-repeat" required>
					<hr> 
					<button type="submit" class="registerbtn">Register</button>
				</div>
				<div class="signup_container signin">
					<p>Already have an account? <a href="#">Sign in</a>.</p>
				</div>
			</form>
		</div>
			<script>
			var modal = document.getElementById('login');
			var signup_modal = document.getElementById('signup');
			window.onclick = function(event)  // close popup if clcik outside
			{
				if (event.target == modal) 
					modal.style.display = "none";
				if (event.target == signup_modal) 
					signup_modal.style.display = "none";
			}
			</script>
			<footer>
				<i align="right" style="font-family:'Courier New'"> &copy cletinic 2018</i>
			</footer>
	</BODY>
</HTML>