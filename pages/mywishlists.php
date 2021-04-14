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
  <h5><a href="mycouches.php" style="color:rgb(83, 225, 230)">My Couches</a> | <a href="mywishlists.php" style="color:rgb(55, 132, 134)">My Wishlists</a></h5>

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
if(isset($_GET['del'])){
  $couchid=$_GET['del'];
  $username=$_SESSION['username'];

  $sql1="UPDATE `wishlists` SET `status`='unavailable' WHERE `id`=$couchid AND `username`='$username' ";
  $result=$conn->query($sql1);

  if($result){
    echo "
    <script>
      window.location.replace('mywishlists.php?show=active');
      alert('Wishlist has been Removed!!');
    </script>";
  }else{
    echo "
    <script>
      window.location.replace('mywishlists.php?show=active');
      alert('Failed to Removed.');
    </script>";
  }

}

?>