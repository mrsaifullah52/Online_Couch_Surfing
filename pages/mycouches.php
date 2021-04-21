<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Couches</title>

  <link rel="stylesheet" href="../resource/styling/style1.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<body>

<?php
  include '../config/db.php';
  include '../components/header.php';
?> 
  

<div class="dashboard">
  <div class="list">
    <h5><a href="mycouches.php" style="color:rgb(55, 132, 134)">My Couches</a> | <a href="mywishlists.php" style="color:rgb(83, 225, 230)">My Wishlists</a></h5>
      
    <div class="containerr">
    <ul>
      <?php
      $couches1="SELECT `id`, `username`, `city`, `country`, `title`, `status`, `timestamp` FROM `couches` WHERE `username`='".$_SESSION['username']."' ";
      $couchesres1 = $conn->query($couches1);
      $couchcount = mysqli_num_rows($couchesres1);
      if($couchcount > 0){
        foreach($couchesres1 as $couch){
          $sql2="SELECT `imagelocation` FROM `couchimages` WHERE `couchid`='".$couch['id']."' ";
          $result2 = $conn->query($sql2);
          echo '
          <li>
          <div class="listItem">
            <div class="thumbnail">';
              $imgLocation=" ";
              foreach($result2 as $imag){
                $imgLocation=$imag['imagelocation'];
              }
              echo '<img src="../'.$imgLocation.'" alt="">
            </div>
            <div class="details">
              <h4 class="title"><a href="couchdetail.php?id='.$couch['id'].'">'.$couch['title'].'</a></h4>
              <h4 class="title">Location: '.$couch['city'].", ".$couch['country'].'</h4>
              <span id="date">'.$couch['timestamp'].'</span>
            </div>
          </div>';
          if($couch['username'] == $_SESSION['username']){
            echo '
            <a href="?del='.$couch['id'].'" class="del">
              <span class="material-icons">
                delete_forever
              </span>
            </a>';
          } 
        echo '</li>';
        }
      }else{
        echo "Result not found.";
      }

      ?>
    </ul>
    </div>

  </div>
</div>


</body>
</html>

<?php

if(isset($_GET['del'])){
  $couchid=$_GET['del'];
  $username=$_SESSION['username'];

  $sql1="UPDATE `couches` SET `status`='unavailable' WHERE `id`='$couchid' AND `username`='$username' ";
  $result=$conn->query($sql1);

  if($result){
    echo "
    <script>
      window.location.replace('mycouches.php?show=active');
      alert('Couch has been Deleted!!');
    </script>";
  }else{
    echo "
    <script>
      window.location.replace('mycouches.php?show=active');
      alert('Failed to Delete.');
    </script>";
  }

}

?>