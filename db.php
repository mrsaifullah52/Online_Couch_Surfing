<?php

$servername = "localhost";
$username ="root";
$password ="";
$db = "online_couch_surfing";

$conn = mysqli_connect($servername, $username, $password, $db);
if(!$conn) {
  die("Connection Failed</br>" . mysqli_connect_error());
}else{
  echo "DB Successfully</br>";
}
?>