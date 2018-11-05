<?php

$imageurl = $_POST['key'];
 //echo "<script>console.log( 'Debug Objects' );</script>";
 //echo "image working";
file_put_contents('test3.png', base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$imageurl)));
//echo $_POST['overlay'];

?>