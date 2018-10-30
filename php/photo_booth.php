<!DOCTYPE html>
<HTML>
  <HEAD>
    <TITLE>Camagru</TITLE>
    <link rel="stylesheet" type="text/css" href="../css/index.css">
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
      <a href="../index.php">Home</a>
      <a class="active" href="photo_booth.php">Photo Booth</a>
      <a href="">Gallery</a>
      <?php if($_SESSION['loggedin'] !== true):?>
      <a class="right" onclick="document.getElementById('signup').style.display='block'">Sign Up</a>
      <a class="right" onclick="document.getElementById('login').style.display='block'">Login</a>
      <?php else:?>
      <a class="right" href="php/logout.php">Logout</a>
      <a class="right" onclick="document.getElementById('prefs').style.display='block'" >Preferences</a>
      <?php endif;?>
    </nav>
          <footer>
        <i align="right" style="font-family:'Courier New'"> &copy cletinic 2018</i>
      </footer>
  </BODY>
</HTML>