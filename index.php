<?php
session_start();
if(isset($_SESSION['username'])){
    echo "<script> window.location.replace('pages/dashboard.php')</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="resource/styling/style1.css">
    <title>Couch surfing</title>
</head>
<body>
    <div class="loginbox">

        <div class="form">
            <h1>Couch Surfing</h1>
        
            <form action="pages/login.php" method="POST">
                <label for="Email">Email</label>
                <input id="email" type="Email" name="Email" placeholder="example@gmail.com" required autocomplete="off">
        
                <label for="Password">Password</label>
                <input id="password" type="Password" name="Password" placeholder="********" required autocomplete="off">
        
                <a href="forgetpassword.html">Forget password?</a>
                <input type="submit" value="Sign-in">
                <input type="button" value="Create New Account" onclick="window.location.replace('pages/sign-up.html')">
            </form>    
        </div> 
    </div>
    
</body>
</html>