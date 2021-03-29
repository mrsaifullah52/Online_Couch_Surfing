<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>

  <link rel="stylesheet" href="resource/styling/style1.css">
</head>
<body>
  
<?php
  include 'components/header.php';
?> 
  
  <div class="profile">

    <div class="image">
      <div class="img">
        <img src="resource/user.png" alt="">
        <button type="submit">Upload Image</button>
      </div>
    </div>


    <div class="form">
      <form action="">

        <div>
          <label for="name">Full Name:</label>
          <input type="text" name="name" id="name" placeholder="John Doe">
        </div>
        
        <div>
          <label for="email">Email Address:</label>
          <input type="email" name="email" id="email" placeholder="johndoe@example.com">
        </div>

        <p>Change Password</p>
        <div>
          <label for="nPassword">New Password:</label>
          <input type="password" name="nPassword" id="nPassword" placeholder="******">
        </div>

        <div>
          <label for="cPassword">Re-enter New Password:</label>
          <input type="password" name="cPassword" id="cPassword" placeholder="******">
        </div>

        <button type="submit">
          Update Profile
        </button>
      
        <button type="submit">
          Delete Account
        </button>
      </form>
    </div>
  </div>

</body>
</html>