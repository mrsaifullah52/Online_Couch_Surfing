<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashbaord</title>

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
    <h5>My Couches</h5>
    <ul>

    <?php
    $couches1="SELECT `id`, `username`, `title`, `status`, `timestamp` FROM `couches` WHERE `username`='".$_SESSION['username']."' ";
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

  <div class="list">
    <h5>My Wishlists</h5>
    <ul>
      <?php
          $wishlist1="SELECT `id`, `city`, `country`, `username`, `title`, `timestamp` FROM `wishlists` WHERE `username`='{$_SESSION['username']}' ";
          $wishlistresult1 = $conn->query($wishlist1);
          $wishlistcount = mysqli_num_rows($wishlistresult1);
          if($wishlistcount > 0){
            foreach($wishlistresult1 as $wishlist){
              echo '
              <li>
              <div class="listItem">
                <div class="details">
                    <h4 class="title">
                      <a href="wishlistdetail.php?id='.$wishlist['id'].'">
                        '.$wishlist['title'].'
                      </a>
                    </h4>
                    <h4 class="title">Location: '.$wishlist['city'].", ".$wishlist['country'].'</h4>
                  <span class="date">
                  '.$wishlist['timestamp'].
                  '</span>
                </div>
              </div>';
                  
              if($wishlist['username']==$_SESSION['username']){
                echo '
                <a href="?del='.$wishlist['id'].'" class="del">
                  <span class="material-icons">
                    delete_forever
                  </span>
                </a>';
              } 
  
            echo '</li>
            ';
            }
          }else{
            echo "Result not found.";
          }

      ?>
    </ul>
  </div>
</div>
  
</body>
</html>


<?php

if(isset($_GET['book'])){
  $couchid=$_GET['book'];
  $username=$_SESSION['username'];


  $status=$conn->query("SELECT `status` FROM `couches` WHERE `id`='". $couchid ."'");
  $status=mysqli_fetch_assoc($status);

  if($status['status'] == "available"){
      $sql1="UPDATE `couches` SET `status`='unavailable' WHERE `id`='$couchid' AND `username`='$username' ";
      $result=$conn->query($sql1);
      echo "
      <script>
        window.location.replace('dashboard.php');
        alert('Couch has been Sold!!');
      </script>";
    }else{
      echo "
      <script>
        window.location.replace('dashboard.php');
        alert('Already Booked.');
      </script>";
  }


}

?>