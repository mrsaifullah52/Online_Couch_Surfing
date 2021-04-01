<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist</title>
  
  <link rel="stylesheet" href="resource/styling/style1.css">
</head>
<body>

<?php
  include 'components/header.php';
?> 

<div class="wishlist">
<div class="list">
      <h5>My Wishlists</h5>
    <ul>


    <?php
      include 'config/db.php';

      $sql1="SELECT `couchid`, `timestamp` FROM `wishlist` WHERE `username`= '".$_SESSION['username']."' ";
      $result1 = mysqli_query($conn, $sql1);


        $count = mysqli_num_rows($result1);
        if($count >= 1){
          foreach($result1 as $wishlist){
            
            $sql2="SELECT `title` FROM `couches` WHERE `id`= '".$wishlist['couchid']."' ";
            $result2 = mysqli_query($conn, $sql2);
      
            $couches = mysqli_fetch_array($result2, MYSQLI_ASSOC);

              echo '
                <li>
                <div class="listItem">
                  <div class="thumbnail">
                    <img src="resource/images/apartment1.jpg" alt="">
                  </div>
                  <div class="details">
                    <h4 class="title">'.$couches['title'].'</h4>
                    <span id="date">'.$wishlist['timestamp'].'</span>
        
                    <div class="actions">
                      <a href="couchdetail.php?id='.$wishlist['couchid'].'">View</a>
                      <a href="#'.$wishlist['couchid'].'">Remove</a>
                    </div>
                  </div>
                </div>
              </li>
            ';

          }
        }else{
          echo "No result found!!";
        }

      ?>


    </ul>
  </div>
</div>

</body>
</html>