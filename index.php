<?php

session_start();

if(isset($_SESSION['username'])){
    echo "<script> window.location.replace('dashboard.php')</script>";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="style1.css">
    <title>Couch surfing</title>
    <style>
h1{
    text-align: center;
    margin: 0px;
    padding-bottom: 20px;
    font-size: 22px;
}
.loginbox .form{
    padding: 100px 15px 15px;
    color: white;
    width: 40%;
    margin: 0px auto;

}
input{
    display: block;
}
.loginbox{
    background-color: rgb(96, 97, 102);
    width: 100vw;
}
.loginbox div{
     height: 100vh;
}
.loginbox input{
    margin: 0px;
    padding: 10px;
    font-weight: bold;
}
.loginbox label{
    margin: 0px;
    padding: 0px;
    color: #fff;
    font-weight: bold;
}
.loginbox input{
    width: 100%;
    margin-bottom: 20px;
    border: none;
    border-bottom: 1px solid #fff;
    background: transparent;
    outline: none;
    height: 30px;
    color: #fff;
    font-size: 16px;
}
.loginbox input[ type="submit"], .loginbox input[type="button"]
{
    border: none;
    outline: none;
    height: 40px;
    color: #fff;
    background: rgb(83, 225, 230);
    font-size: 18px;
    border-radius: 20px;
    margin-top: 10px;
    transition: .5s ease-in-out;
}

.loginbox input[type="submit"]:hover{
    background: rgb(63, 185, 189);
    cursor: pointer;
    transform: scale(1.03,1.03);

}
.loginbox input[type="button"]:hover{
    background: rgb(63, 185, 189);
    cursor: pointer;
    transform: scale(1.03,1.03);

}
.loginbox a {
    text-decoration: none;
    font-size: 15px;
    line-height: 20px;
    color: #fff;
    font-weight: bold;
}
.loginbox a:hover {
    color: rgb(63, 185, 189);
}
    
    </style>
</head>
<body>
    <div class="loginbox">

        <div class="form">
                <h1>Couch Surfing</h1>    
        
            <form action="login.php" method="POST">
                
                    <label for="Email">Email</label>
                    <input id="email" type="Email" name="Email" placeholder="example@gmail.com" required autocomplete="off">
            
                    <label for="Password">Password</label>
                    <input id="password" type="Password" name="Password" placeholder="********" required autocomplete="off">
            
                    <a href="forgetpassword.html">Forget password?</a>
                    <input type="submit" value="Sign-in">
                    <input type="button" value="Create New Account" onclick="window.location.replace('sign-up.html')">
            </form>    
        </div> 
    </div>
    
</body>
</html>