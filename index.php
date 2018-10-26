
<?php
session_start();
// https://www.formget.com/php-data-object/
include 'config/database.php';
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
			<a class="active" href="index.php">Home</a>
			<a href="">Photo Booth</a>
			<a href="">Gallery</a>
			<?php if($_SESSION['loggedin'] !== true):?>
			<a class="right" onclick="document.getElementById('signup').style.display='block'">Sign Up</a>
			<a class="right" onclick="document.getElementById('login').style.display='block'">Login</a>
			<?php else:?>
			<a class="right" onclick="document.getElementById('prefs').style.display='block'" >preferences</a>
			<a class="right" href="php/logout.php">logout</a>
			<?php endif;?>
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
					<label for="psw"><b>Password</b></label>
					<input type="password" placeholder="Enter Password" name="psw" required>
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
			<form action="php/signup.php" method="POST">
				<div class="signup_container">
					<h1>Register</h1>
					<p>Please fill in this form to create an account.</p>
					<hr>
						<label for="username"><b>User-Name</b></label>
						<input type="username" placeholder="Enter User-Name" name="username" required>
						<label for="email"><b>Email</b></label>
						<input type="text" placeholder="Enter Email" name="email" required>
						<label for="psw"><b>Password</b></label>
						<input type="password" placeholder="Enter Password" name="psw" required>
						<label for="psw_repeat"><b>Repeat Password</b></label>
						<input type="password" placeholder="Repeat Password" name="psw_repeat" required>
					<hr> 
					<button type="submit" class="registerbtn">Register</button>
				</div>
				<div class="signup_container signin">
					<p>Already have an account? <a href="#">Sign in</a>.</p>
				</div>
			</form>
		</div>
		<!-- Preferences -->
		<div id="prefs" class="modal_pref">
			<h1>Modify / Change</h1>
				<hr>
					<div class="pref_buttons">
						<button>Username</button>
						<button>Email</button>
						<button>Password</button>
						<button>Notifications</button>
					</div>
				<hr>
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
<?php
	print_r($_SESSION);
	//if ($_GET['t'] == 'true')
		//echo "<script> document.getElementById('login').style.display='block'; </script>";
	if ($_SESSION['pop_up_login'] === true)
	{
		echo "<script> document.getElementById('login').style.display='block'; </script>";
		$_SESSION['pop_up_login'] = false;
	}
?>