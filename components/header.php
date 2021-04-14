<?php
  session_start();
?>

<div class="header">
    <nav>
      <div class="brand">
        <a href="mycouches.php">Online Couch Surfing</a>
      </div>

      <div class="menu">
        <ul>
          <!-- <li><a href="profile.php"> -->
            <?php 
            if( !(isset($_SESSION['name']) ) ){
              echo "<script>window.location.replace('../index.php')</script>";
            }
            ?>
          <!-- </a></li> -->
          <li><a href="mycouches.php">Dashboard</a></li>
          <li><a href="wishlist.php?show=active">Wishlists</a></li>
          <li><a href="couches.php?show=active">Couches</a></li>
          <li><a href="chat.php">Chat</a></li>
          <li><a href="../logout.php">Log out</a></li>
        </ul>
      </div>
    </nav>
</div>