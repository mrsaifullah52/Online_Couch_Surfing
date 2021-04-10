<?php

// accessing database
include '../config/db.php';
session_start();


if( empty($_POST["fname"]) ){
  echo "Enter First Name!! </br>";
}else{
  $fname=$_POST["fname"];
}

if( empty($_POST["lname"]) ){
  echo "Enter Last Name!! </br>";
}else{
  $lname=$_POST["lname"];
}

if( empty($_POST["username"]) ){
  echo "Enter Userame!! </br>";
}else{
  $username=$_POST["username"];
}

if( empty($_POST["email"]) ){
  echo "Enter Email!! </br>";
}else{
  $email=$_POST["email"];
}

if( empty($_POST["password"]) ){
  echo "Enter Password!! </br>";
}else{
  $password=$_POST["password"];
}

if( empty($_POST["telphone"]) ){
  echo "Enter Telephone!! </br>";
}else{
  $telphone=$_POST["telphone"];
}

if( empty($_POST["address"]) ){
  echo "Enter Address!! </br>";
}else{
  $address=$_POST["address"];
}

if( empty($_POST["city"]) ){
  echo "Enter City!! </br>";
}else{
  $city=$_POST["city"];
}

if( empty($_POST["gender"]) ){
  echo "Enter Gender!! </br>";
}else{
  $gender=$_POST["gender"];
}

if( !empty($username) && !empty($fname) && !empty($lname) && !empty($email) && !empty($password) && !empty($telphone) 
&& !empty($address) && !empty($city) &&  !empty($gender) ){

  $sql="INSERT INTO `users`(`username`, `fname`, `lname`, `email`, `password`, `telephone`, `address`, `city`, `gender`) 
  VALUES ('$username', '$fname', '$lname', '$email', '$password', '$telphone', '$address', '$city', '$gender')";

  $result=mysqli_query($conn, $sql);

  if($result){
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['name'] = $fname;
    $_SESSION['lname'] = $lname;

    echo "Account Created Successfully</br>";
    echo "<script> window.location.replace('dashboard.php') </script>";
  }else{
    echo "Failed to Sign up, Try again!!</br></br>";
    echo "Something Went Wrong</br>" . mysqli_error($conn);
  }
}

mysqli_close($conn);

?>