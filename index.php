
<?php

/*

I want to add - 
- esc key to exit out of pop up pages - ie login, sign up
- add alert boxes when something fails, otherwise just redirect 
- add pop ups if user tries to use logged in features without being logged in. 
- if account is not verfied, propt ask to resend verfication email


*/


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
			<a class="active">Home</a>
			<a >Photo Booth</a>
			<a >Gallery</a>
			<?php if($_SESSION['loggedin'] !== true):?>
			<a class="right" onclick="document.getElementById('signup').style.display='block'">Sign Up</a>
			<a class="right" onclick="document.getElementById('login').style.display='block'">Login</a>
			<?php else:?>
			<a class="right" href="php/logout.php">Logout</a>
			<a class="right" onclick="document.getElementById('prefs').style.display='block'" >Preferences</a>
			<?php endif;?>
		</nav>
		<div id="home_page" class="active_page">			
		</div>
		<div id="photo_booth">			
		</div>
		<div id="gallery">			
		</div>
		<!-- LOGIN -->
		<div id="login" class="modal page_popup">
			<form class="login_content" action="php/login.php" method="POST">
				<div class="modal_container">
					<h1>Login</h1>
					<p>Please fill in this form to log into your account.</p>
					<hr>
						<label for="email"><b>Email</b></label>
						<input type="email" placeholder="Enter Email" name="email" required>
						<label for="psw"><b>Password</b></label>
						<input type="password" placeholder="Enter Password" name="psw" required>
						<hr>
						<button id="loginbtn" type="submit" name="submit">Login</button>
					</div>
					<div class="container modal_container base" id="login_bottom">
				<p>Forgot <a href="#" onclick="document.getElementById('forgot_pass').style.display='block'; document.getElementById('login').style.display='none'">password</a>?</p>
			</div>
			</form>
		</div>
		<!-- FORGOT PASSWORD Send email-->
		<div id="forgot_pass" class="modal page_popup">
			<form class="forgot_content" action="php/forgot_password_email.php" method="POST">
				<div class="modal_container">
				<h1>Login</h1>
				<p>Please fill in your email to reset your password.</p>
				<hr>
					<label for="email"><b>Email</b></label>
					<input type="email" placeholder="Enter Email" name="email" required>
					<hr>
					<button id="loginbtn" type="submit" name="submit">Send Email</button>
				</div>
			</form>
		</div>
		<!-- FORGOT PASSWORD verify-->
		<div id="forgot_pass_set" class="modal page_popup">
			<form class="forgot_content" action="php/forgot_password_reset.php" method="POST">
				<div class="modal_container">
				<h1>Reset Password</h1>
						<p>Please fill in this form to reset your password.</p>
						<hr>
							<label for="new psw"><b>New Password</b></label>
							<input type="password" placeholder="New Password" name="psw_new" required>
							<label for="psw_repeat"><b>Confirm Password</b></label>
							<input type="password" placeholder="Confirm New Password" name="psw_repeat" required>
						<hr> 
						<button type="submit" class="reset_password">Reset Password</button>
				</div>
			</form>
		</div>
		<!-- SIGN UP -->
		<div id="signup" class="modal_signup page_popup">
			<form action="php/signup.php" method="POST">
				<div class="signup_container modal_container">
					<h1>Register</h1>
					<p>Please fill in this form to create an account.</p>
					<hr>
						<label for="username"><b>Username</b></label>
						<input type="username" placeholder="Enter Username" name="username" required>
						<label for="email"><b>Email</b></label>
						<input type="text" placeholder="Enter Email" name="email" required>
						<label for="psw"><b>Password</b></label>
						<input type="password" placeholder="Enter Password" name="psw" required>
						<label for="psw_repeat"><b>Repeat Password</b></label>
						<input type="password" placeholder="Repeat Password" name="psw_repeat" required>
					<hr> 
					<button type="submit" class="registerbtn">Register</button>
				</div>
				<div class="signup_container modal_container base">
					<p>Already have an account? <a href="#" onclick="document.getElementById('login').style.display='block'; document.getElementById('signup').style.display='none'">Sign in</a>.</p>
				</div>
			</form>
		</div>
		<!-- PREFEREVCES -->
		<div id="prefs" class="modal_pref page_popup">
			<div class="modal_container">
				<h1>Modify Account</h1>
				<p>Make changes to your account</p>
				<hr>
					<div class="pref_buttons">
						<!-- <a class="right" onclick="document.getElementById('prefs').style.display='block'" >preferences</a> -->
						<a onclick="document.getElementById('users_mod').style.display='block'; document.getElementById('prefs').style.display='none'" >
							<button>Username</button>
						</a>
						<a onclick="document.getElementById('email_mod').style.display='block'; document.getElementById('prefs').style.display='none'" >
							<button>Email</button>
						</a>
						<a onclick="document.getElementById('psw_mod').style.display='block'; document.getElementById('prefs').style.display='none'" >
							<button>Password</button>
						</a>
						<a onclick="document.getElementById('not_mod').style.display='block'; document.getElementById('prefs').style.display='none'" >
							<button>Notifications</button>
						</a>
					</div>
				<hr>
				</div>
			</div>
				<!-- Modify user -->
				<div id="users_mod" class="page_popup">
					<form action="php/mod_username.php" method="POST">
						<div class="modal_container">
							<h1>Modify Username</h1>
							<p>Please fill in this form to modify your username.</p>
								<hr>
									<label for="username"><b>Username</b></label>
									<input type="username" placeholder="Enter Username" name="username" required>
								<hr>
								<button type="submit" class="reset_usernmse">Reset Username</button>
						</div>
					</form>
				</div>
				<!-- Modify email-->
				<div id="email_mod" class="page_popup">
					<form action="php/mod_email.php" method="POST">
					<div class="modal_container">
						<h1>Modify Email</h1>
						<p>Please fill in this form to modify your email.</p>
							<hr>
								<div class="pref_buttons">
									<label for="email"><b>New Email</b></label>
									<input type="text" placeholder="Enter New Email" name="email" required>
									<label for="email"><b>Confirm Email</b></label>
									<input type="text" placeholder="Confirm New Email" name="email_repeat" required>
								</div>
								<hr>
								<button type="submit" class="reset_email">Reset Email</button>
							
					</div>
					</form>
				</div>
				<!-- Modify password -->
				<div id="psw_mod" class="page_popup">
					<form action="php/mod_password.php" method="POST">
					<div class="modal_container">
						<h1>Modify Password</h1>
						<p>Please fill in this form to modify your password.</p>
						<hr>
							<label for="old psw"><b>Current Password</b></label>
							<input type="password" placeholder="Enter Password" name="psw" required>
							<label for="new psw"><b>New Password</b></label>
							<input type="password" placeholder="New Password" name="psw_new" required>
							<label for="psw_repeat"><b>Confirm Password</b></label>
							<input type="password" placeholder="Confirm New Password" name="psw_repeat" required>
						<hr> 
						<button type="submit" class="reset_password">Reset Password</button>
					</div>
					</form>
				</div>
				<!-- Modify notifications -->
				<div id="not_mod" class="modal_pref page_popup">
					<div class="modal_container">
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
				</div>
			<script>
				var modal_pop = document.getElementsByClassName('page_popup');
				console.log(modal_pop);
				console.log(modal_pop.length);

				window.onclick = function(event)  // close popup if clcik outside
				{
					for(var i = 0; i < modal_pop.length; i++)
					{
						if (event.target == modal_pop[i]) 
							modal_pop[i].style.display = "none";
					}
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
	if ($_SESSION['pop_up_psw_reset'] === true)
	{
		echo "<script> document.getElementById('forgot_pass_set').style.display='block'; </script>";
		$_SESSION['pop_up_psw_reset'] = false;
	}
?>