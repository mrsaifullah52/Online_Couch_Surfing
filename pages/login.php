<?php
// accessing database
include '../config/db.php';
session_start();

if( isset($_POST['Email']) && isset( $_POST['Password'] ) ){
    
    $email=$_POST['Email'];
    $password=$_POST['Password'];

    $query_statement="SELECT `username`, `lname`, `fname` FROM `users` WHERE `email`='$email' AND `password`='$password' ";

    $result = mysqli_query($conn, $query_statement);

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $count = mysqli_num_rows($result);

    if( $count == 1 ){

        $_SESSION['username'] = $row['username'];
        $_SESSION['name'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        
        echo "</br> user Logged in <script>window.location.replace('../pages/mycouches.php')</script>";
    
    }else{
        echo "<script>window.location.replace('../index.php'); alert('Authentication Failed, try again. ')</script>";
    }
}else{
    echo "failed to login try again";
}

?>