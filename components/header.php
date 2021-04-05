<?php
  session_start();
?>

<div class="header">
    <nav>
      <div class="brand">
        <a href="dashboard.php">Online Couch Surfing</a>
      </div>

      <div class="menu">
        <ul>
          <li><a href="profile.php">
          <?php
            if(isset($_SESSION['name'])){
              echo $_SESSION["name"]." ".$_SESSION["lname"];
            }else{
              echo "<script>window.location.replace('index.php')</script>";
            }?>
          </a></li>
          <li><a href="wishlist.php">Wishlists</a></li>
          <li><a href="couches.php">Couches</a></li>
          <li><a href="chat.php">Chat</a></li>
          <li><a href="logout.php">Log out</a></li>
        </ul>
      </div>
    </nav>
</div>