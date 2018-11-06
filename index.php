<?php

/*

I want to add - 
- esc key to exit out of pop up pages - ie login, sign up
- add alert boxes when something fails, otherwise just redirect 
- add pop ups if user tries to use logged in features without being logged in. 
- if account is not verfied, propt ask to resend verfication email


*/
session_start();
print_r($_SESSION);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
		<nav id="nav">
			<a class="nav_button active" id="home">Home</a>
			<a class="nav_button" id="photo_booth">Photo Booth</a>
			<a class="nav_button" id="gallery">Gallery</a>
			<?php if(isset($_SESSION['loggedin']) !== true):?>
			<a class="right" onclick="document.getElementById('signup').style.display='block'">Sign Up</a>
			<a class="right" onclick="document.getElementById('login').style.display='block'">Login</a>
			<?php else:?>
			<a class="right" href="php/logout.php">Logout</a>
			<a class="right" onclick="document.getElementById('prefs').style.display='block'" >Preferences</a>
			<?php endif;?>
		</nav>

		<!-- PAGES -->

		<div id="pages">
			<!-- HOME -->
			<div id="home_page" class="page active_page" >	
				
			</div>
			<!-- PhotoBooth -->
			<div id="photo_booth_page" class="page">
				<a href="#" id="capture">Take photo</a>
				<div id-"photobooth">
					<div id="picture">
						<video id="cam" width="600" height="450" autoplay="true"></video>
						<div class="overlay">
							<img id="sticker" src="heart.png">
						</div>					
					</div>
					<div id="photo_option" >
						<button>
							<svg version="1.1" id="upload" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="40px" height="40px" viewBox="0 0 482.322 482.322" style="enable-background:new 0 0 482.322 482.322;"
							xml:space="preserve">
							<g>
							<g>
							<path d="M479.342,48.389c5.367-7.414,2.036-21.007-10.05-21.276c-119.18-2.641-332.17-4.992-451.086,5.2
							c-2.45,0.208-4.497,1.003-6.228,2.123c-3.7,1.935-6.523,5.553-6.771,10.877c-3.662,78.82-2.778,256.537-5.2,335.393
							c-0.041,1.341,0.14,2.534,0.412,3.661c0.208,4.946,2.978,9.704,9.13,11.477c45.27,12.994,105.396,17.529,169.079,17.788
							c-0.48-8.576-0.526-17.158-0.531-25.756c-57.64-0.254-111.624-4.036-151.902-14.462c1.439-51.038,1.612-166.306,2.62-235.829
							c140.937-1.374,281.858-4.946,422.812-3.89c-0.432,70.868,1.046,187.588,4.118,239.921c-36.841,2.529-84.589,6.465-135.901,9.567
							c0.178,8.617,1.102,17.128,2.315,25.618c54.177-3.301,104.789-7.485,144.534-9.892c3.945-0.239,6.932-1.909,9.019-4.266
							c4.001-1.757,6.946-5.5,6.581-11.334C477.376,304.601,476.051,131.035,479.342,48.389z M451.875,107.689
							c-140.889-1.062-281.752,2.506-422.625,3.885c0.368-19.588,0.838-37.976,1.45-54.172c109.42-8.582,312.827-7.015,422.48-4.634
							C452.57,69.247,452.144,87.878,451.875,107.689z"/>
							<path d="M62.404,70.011c-16.765,0-16.765,26,0,26C79.174,96.01,79.174,70.011,62.404,70.011z"/>
							<path d="M107.903,68.711c-16.765,0-16.765,25.999,0,25.999C124.673,94.71,124.673,68.711,107.903,68.711z"/>
							<path d="M156.001,66.111c-16.765,0-16.765,25.999,0,25.999C172.771,92.11,172.771,66.111,156.001,66.111z"/>
							<path d="M369.002,322.231c3.372-3.626,4.616-8.912,1.011-14.381c-29.564-44.884-65.019-84.787-104.729-120.932
							c-7.794-7.092-17.983-2.433-21.357,4.811c-35,40.896-66.532,84.672-104.929,122.585c-9.557,9.435,0.307,23.043,10.747,22.089
							c0.355,0.025,0.678,0.106,1.046,0.106h42.259c-0.62,11.136-1.013,24.379-1.216,38.182c-0.063,4.356-0.109,8.754-0.134,13.177
							c-0.053,8.688-0.033,17.388,0.056,25.766c0.084,7.876,0.218,15.463,0.417,22.43c-0.094,0.162-0.163,0.335-0.244,0.498
							c-4.108,7.911-0.541,19.728,10.862,19.108c0.713-0.036,1.429-0.046,2.143-0.087c1.123,0.071,2.245,0.062,3.344-0.122
							c28.854-1.34,57.603-1.016,86.374,1.94c7.622,0.782,11.685-4.24,12.314-10.075c0.843-1.574,1.396-3.412,1.549-5.524
							c0.035-0.508,0.071-1.052,0.106-1.564c0.63-9.227,1.107-19.702,1.487-30.727c0.285-8.419,0.519-17.123,0.711-25.796
							c0.102-4.55,0.193-9.074,0.279-13.548c0.26-13.609,0.457-26.665,0.691-37.745c15.396-0.335,30.767-1.133,46.128-2.417
							C363.492,329.539,367.164,326.278,369.002,322.231z M298.124,306.606c-9.867,0.03-13.884,9.044-12.132,16.453
							c0,0.005,0,0.01,0,0.015c-0.324,14.193-0.563,31.067-0.898,48.378c-0.086,4.55-0.183,9.1-0.284,13.675
							c-0.198,8.745-0.442,17.388-0.747,25.791c-0.127,3.692-0.273,7.308-0.432,10.857c-0.127,2.939-0.254,5.91-0.406,8.719
							c-15.183-1.209-30.366-1.722-45.564-1.701c-2.953,0.005-5.913,0.04-8.871,0.086c-3.593,0.056-7.19,0.102-10.791,0.214
							c-0.025-1.199-0.041-2.488-0.066-3.713c-0.079-3.939-0.147-7.962-0.193-12.09c-0.094-8.374-0.124-17.026-0.073-25.766
							c0.043-6.982,0.137-13.955,0.282-20.84c0.312-15.011,0.868-29.483,1.747-41.884c0.229-3.214-0.561-5.794-1.97-7.77
							c-1.899-3.737-5.553-6.53-11.029-6.53h-28.198c27.73-30.549,52.638-63.52,79.277-95.067
							c29.168,27.596,55.857,57.292,79.125,89.989C323.991,306.149,311.072,306.565,298.124,306.606z"/>
							</svg>
						</button>
						<button>
							<svg version="1.1" id="upload" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="40px" height="40px" viewBox="0 0 482.322 482.322" style="enable-background:new 0 0 482.322 482.322;"
							xml:space="preserve">
							<g>
							<g>
							<path d="M479.342,48.389c5.367-7.414,2.036-21.007-10.05-21.276c-119.18-2.641-332.17-4.992-451.086,5.2
							c-2.45,0.208-4.497,1.003-6.228,2.123c-3.7,1.935-6.523,5.553-6.771,10.877c-3.662,78.82-2.778,256.537-5.2,335.393
							c-0.041,1.341,0.14,2.534,0.412,3.661c0.208,4.946,2.978,9.704,9.13,11.477c45.27,12.994,105.396,17.529,169.079,17.788
							c-0.48-8.576-0.526-17.158-0.531-25.756c-57.64-0.254-111.624-4.036-151.902-14.462c1.439-51.038,1.612-166.306,2.62-235.829
							c140.937-1.374,281.858-4.946,422.812-3.89c-0.432,70.868,1.046,187.588,4.118,239.921c-36.841,2.529-84.589,6.465-135.901,9.567
							c0.178,8.617,1.102,17.128,2.315,25.618c54.177-3.301,104.789-7.485,144.534-9.892c3.945-0.239,6.932-1.909,9.019-4.266
							c4.001-1.757,6.946-5.5,6.581-11.334C477.376,304.601,476.051,131.035,479.342,48.389z M451.875,107.689
							c-140.889-1.062-281.752,2.506-422.625,3.885c0.368-19.588,0.838-37.976,1.45-54.172c109.42-8.582,312.827-7.015,422.48-4.634
							C452.57,69.247,452.144,87.878,451.875,107.689z"/>
							<path d="M62.404,70.011c-16.765,0-16.765,26,0,26C79.174,96.01,79.174,70.011,62.404,70.011z"/>
							<path d="M107.903,68.711c-16.765,0-16.765,25.999,0,25.999C124.673,94.71,124.673,68.711,107.903,68.711z"/>
							<path d="M156.001,66.111c-16.765,0-16.765,25.999,0,25.999C172.771,92.11,172.771,66.111,156.001,66.111z"/>
							<path d="M369.002,322.231c3.372-3.626,4.616-8.912,1.011-14.381c-29.564-44.884-65.019-84.787-104.729-120.932
							c-7.794-7.092-17.983-2.433-21.357,4.811c-35,40.896-66.532,84.672-104.929,122.585c-9.557,9.435,0.307,23.043,10.747,22.089
							c0.355,0.025,0.678,0.106,1.046,0.106h42.259c-0.62,11.136-1.013,24.379-1.216,38.182c-0.063,4.356-0.109,8.754-0.134,13.177
							c-0.053,8.688-0.033,17.388,0.056,25.766c0.084,7.876,0.218,15.463,0.417,22.43c-0.094,0.162-0.163,0.335-0.244,0.498
							c-4.108,7.911-0.541,19.728,10.862,19.108c0.713-0.036,1.429-0.046,2.143-0.087c1.123,0.071,2.245,0.062,3.344-0.122
							c28.854-1.34,57.603-1.016,86.374,1.94c7.622,0.782,11.685-4.24,12.314-10.075c0.843-1.574,1.396-3.412,1.549-5.524
							c0.035-0.508,0.071-1.052,0.106-1.564c0.63-9.227,1.107-19.702,1.487-30.727c0.285-8.419,0.519-17.123,0.711-25.796
							c0.102-4.55,0.193-9.074,0.279-13.548c0.26-13.609,0.457-26.665,0.691-37.745c15.396-0.335,30.767-1.133,46.128-2.417
							C363.492,329.539,367.164,326.278,369.002,322.231z M298.124,306.606c-9.867,0.03-13.884,9.044-12.132,16.453
							c0,0.005,0,0.01,0,0.015c-0.324,14.193-0.563,31.067-0.898,48.378c-0.086,4.55-0.183,9.1-0.284,13.675
							c-0.198,8.745-0.442,17.388-0.747,25.791c-0.127,3.692-0.273,7.308-0.432,10.857c-0.127,2.939-0.254,5.91-0.406,8.719
							c-15.183-1.209-30.366-1.722-45.564-1.701c-2.953,0.005-5.913,0.04-8.871,0.086c-3.593,0.056-7.19,0.102-10.791,0.214
							c-0.025-1.199-0.041-2.488-0.066-3.713c-0.079-3.939-0.147-7.962-0.193-12.09c-0.094-8.374-0.124-17.026-0.073-25.766
							c0.043-6.982,0.137-13.955,0.282-20.84c0.312-15.011,0.868-29.483,1.747-41.884c0.229-3.214-0.561-5.794-1.97-7.77
							c-1.899-3.737-5.553-6.53-11.029-6.53h-28.198c27.73-30.549,52.638-63.52,79.277-95.067
							c29.168,27.596,55.857,57.292,79.125,89.989C323.991,306.149,311.072,306.565,298.124,306.606z"/>
							</svg>
						</button>
						<button>
							<svg version="1.1" id="upload" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							width="40px" height="40px" viewBox="0 0 482.322 482.322" style="enable-background:new 0 0 482.322 482.322;"
							xml:space="preserve">
							<g>
							<g>
							<path d="M479.342,48.389c5.367-7.414,2.036-21.007-10.05-21.276c-119.18-2.641-332.17-4.992-451.086,5.2
							c-2.45,0.208-4.497,1.003-6.228,2.123c-3.7,1.935-6.523,5.553-6.771,10.877c-3.662,78.82-2.778,256.537-5.2,335.393
							c-0.041,1.341,0.14,2.534,0.412,3.661c0.208,4.946,2.978,9.704,9.13,11.477c45.27,12.994,105.396,17.529,169.079,17.788
							c-0.48-8.576-0.526-17.158-0.531-25.756c-57.64-0.254-111.624-4.036-151.902-14.462c1.439-51.038,1.612-166.306,2.62-235.829
							c140.937-1.374,281.858-4.946,422.812-3.89c-0.432,70.868,1.046,187.588,4.118,239.921c-36.841,2.529-84.589,6.465-135.901,9.567
							c0.178,8.617,1.102,17.128,2.315,25.618c54.177-3.301,104.789-7.485,144.534-9.892c3.945-0.239,6.932-1.909,9.019-4.266
							c4.001-1.757,6.946-5.5,6.581-11.334C477.376,304.601,476.051,131.035,479.342,48.389z M451.875,107.689
							c-140.889-1.062-281.752,2.506-422.625,3.885c0.368-19.588,0.838-37.976,1.45-54.172c109.42-8.582,312.827-7.015,422.48-4.634
							C452.57,69.247,452.144,87.878,451.875,107.689z"/>
							<path d="M62.404,70.011c-16.765,0-16.765,26,0,26C79.174,96.01,79.174,70.011,62.404,70.011z"/>
							<path d="M107.903,68.711c-16.765,0-16.765,25.999,0,25.999C124.673,94.71,124.673,68.711,107.903,68.711z"/>
							<path d="M156.001,66.111c-16.765,0-16.765,25.999,0,25.999C172.771,92.11,172.771,66.111,156.001,66.111z"/>
							<path d="M369.002,322.231c3.372-3.626,4.616-8.912,1.011-14.381c-29.564-44.884-65.019-84.787-104.729-120.932
							c-7.794-7.092-17.983-2.433-21.357,4.811c-35,40.896-66.532,84.672-104.929,122.585c-9.557,9.435,0.307,23.043,10.747,22.089
							c0.355,0.025,0.678,0.106,1.046,0.106h42.259c-0.62,11.136-1.013,24.379-1.216,38.182c-0.063,4.356-0.109,8.754-0.134,13.177
							c-0.053,8.688-0.033,17.388,0.056,25.766c0.084,7.876,0.218,15.463,0.417,22.43c-0.094,0.162-0.163,0.335-0.244,0.498
							c-4.108,7.911-0.541,19.728,10.862,19.108c0.713-0.036,1.429-0.046,2.143-0.087c1.123,0.071,2.245,0.062,3.344-0.122
							c28.854-1.34,57.603-1.016,86.374,1.94c7.622,0.782,11.685-4.24,12.314-10.075c0.843-1.574,1.396-3.412,1.549-5.524
							c0.035-0.508,0.071-1.052,0.106-1.564c0.63-9.227,1.107-19.702,1.487-30.727c0.285-8.419,0.519-17.123,0.711-25.796
							c0.102-4.55,0.193-9.074,0.279-13.548c0.26-13.609,0.457-26.665,0.691-37.745c15.396-0.335,30.767-1.133,46.128-2.417
							C363.492,329.539,367.164,326.278,369.002,322.231z M298.124,306.606c-9.867,0.03-13.884,9.044-12.132,16.453
							c0,0.005,0,0.01,0,0.015c-0.324,14.193-0.563,31.067-0.898,48.378c-0.086,4.55-0.183,9.1-0.284,13.675
							c-0.198,8.745-0.442,17.388-0.747,25.791c-0.127,3.692-0.273,7.308-0.432,10.857c-0.127,2.939-0.254,5.91-0.406,8.719
							c-15.183-1.209-30.366-1.722-45.564-1.701c-2.953,0.005-5.913,0.04-8.871,0.086c-3.593,0.056-7.19,0.102-10.791,0.214
							c-0.025-1.199-0.041-2.488-0.066-3.713c-0.079-3.939-0.147-7.962-0.193-12.09c-0.094-8.374-0.124-17.026-0.073-25.766
							c0.043-6.982,0.137-13.955,0.282-20.84c0.312-15.011,0.868-29.483,1.747-41.884c0.229-3.214-0.561-5.794-1.97-7.77
							c-1.899-3.737-5.553-6.53-11.029-6.53h-28.198c27.73-30.549,52.638-63.52,79.277-95.067
							c29.168,27.596,55.857,57.292,79.125,89.989C323.991,306.149,311.072,306.565,298.124,306.606z"/>
							</svg>
						</button>
					</div>
				</div>	
				<canvas id="canvas" width="600" height="450"></canvas>
				<script type="text/javascript">
				//https://www.kirupa.com/html5/accessing_your_webcam_in_html5.htm
				var video = document.getElementById('cam');
				const mediaSource = new MediaSource(); //https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/srcObject

				if (navigator.mediaDevices.getUserMedia) 
				{
					navigator.mediaDevices.getUserMedia
					(
						{
							video: true
						}
					)
					.then(function(mediaSource) 
					{
						
						try 
						{
							video.srcObject = mediaSource;
						} catch (error) 
						{
							video.src = URL.createObjectURL(mediaSource); //video.src = window.URL.createObjectURL(stream);
						}
						

						/*
						// Play the video element to start the stream.
						video.play();
						video.onplay = function() 
						{
							showVideo();
						}
						*/
					})
				}
				context = document.getElementById('canvas').getContext("2d");
				//var img = document.creaElement("image");
				//img.src = 'heart.svg';

				/*
				video.addEventListener('play', function()
				{
					draw(this, context, 600, 450);
				}, false);

				function draw (video, context, width, height)
				{
					context.drawImage(video, 0, 0, 600, 450);
					setTimeout(draw, 10, video, context, width);
				}
				*/

				
				document.getElementById('capture').addEventListener('click', function()
				{
					///context = document.getElementById('canvas').getContext("2d");
					context.drawImage(video, 0, 0, 600, 450);
					const imgUrl = canvas.toDataURL('image/png');
					console.log(encodeURIComponent(imgUrl));

					var xhttp = new XMLHttpRequest(); //AJAX to communicate js to php
					xhttp.open('POST', 'php/saveimg.php', true);
					xhttp.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
					xhttp.send('key='+encodeURIComponent(imgUrl));
				});
			</script>
			</div>
			<!-- GALLERY -->
			<div id="gallery_page" class="page">
				<script type="text/javascript">
					
				</script>
			</div>
		</div>
		
		<!-- NAVIGATION OPTIONS -->

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
					<button type="submit" name="submit">Send Email</button>
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

		<!-- MOD PREFEREVCES -->

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
				<!-- MODIFY USER -->
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
				<!-- MODIFY EMAIL-->
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
				<!-- MODIFY PASSWORD -->
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
				<!-- MODIFY NOTIFCATIONS -->
				<div id="not_mod" class="modal_pref page_popup">
					<form id="not_mod_form" method="POST">
						<div class="modal_container">
							<h1>Notifications</h1>
							<p>Please toggle switch to be emailed notifications.</p>
								<hr>
									<label><b>Receive Email Notifications?</b><br/></label>
									<label class="switch">
										<!-- this toggle is not working -->
										<?php if(isset($_SESSION['not_email']) === true):?>
											<input type="checkbox" checked id="notify_mod" onclick="checkBox(this)">
										<?php else:?>
											<input type="checkbox" id="notify_mod" onclick="checkBox(this)">
										<?php endif;?>
										<span class="slider"></span>
									</label>
								<hr>
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
						</div>
					</form>
				</div>
			<script>

				// SCRIPT TO HANDLE NAVIGATION AND PAGE POP UPS

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

				var nav_button = document.getElementsByClassName("nav_button");
				console.log(nav_button);

				for (var i = 0; i < nav_button.length; i++) 
				{
					nav_button[i].addEventListener("click", function() 
					{
						var current = document.getElementsByClassName("active");
						current[0].className = current[0].className.replace(" active", "");
						this.className += " active";
						var pages = document.getElementsByClassName("page");
						console.log(pages);

						for (var j = 0; j < pages.length; j++) 
						{
							pages[j].classList.remove("active_page");
						}

						if (this == document.getElementById("photo_booth"))
							document.getElementById("photo_booth_page").classList.add("active_page");
						else if (this == document.getElementById("home"))
							document.getElementById("home_page").classList.add("active_page");
						else if (this == document.getElementById("gallery"))
							document.getElementById("gallery_page").classList.add("active_page");
					});
				}
			</script>
			<footer>
				<i align="right" style="font-family:'Courier New'"> &copy cletinic 2018</i>
			</footer>
	</BODY>
</HTML>
<?php
	//print_r($_SESSION);
	if (isset($_GET['pop_up_login']))
		echo "<script> document.getElementById('login').style.display='block'; </script>";
	if (isset($_GET['pop_up_login']))
		echo "<script> document.getElementById('login').style.display='block'; </script>";
/*
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
	*/
?>