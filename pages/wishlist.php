<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wish Lists</title>
  <link rel="stylesheet" href="../resource/styling/style1.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<body>

<?php
  include '../components/header.php';
  include '../config/db.php';
?> 

<div class="wishlists">
  <form action="search">  
      <div class="boxcontainer">
        <div class="elementcontainer" >
          <input type="text" placeholder="You Can Search Here." name="search" class="search"></td>
          <span class="material-icons md-48">search</span>
        </div>

        <a href="addwishlist.php">Add New</a>
      </div>
  </form>

  <div class="couches">
    <div class="list">
      <h5>Wishlists</h5>
      <ul>
      <?php

      $query_statement="SELECT `id`, `city`, `country`, `username`, `title`, `timestamp` FROM `wishlists` ";
      $result = mysqli_query($conn, $query_statement);

      $count = mysqli_num_rows($result);

      if($count >= 1){
        foreach($result as $wishlist){
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
              <div class="actions">';

                echo
              '</div>
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
  
  </div>
</body>
</html>

<?php

  if(isset($_GET['del'])){
  $couchid=$_GET['del'];
  $username=$_SESSION['username'];

  $sql1="DELETE FROM `wishlists` WHERE `id`='$couchid' AND `username`='$username' ";
  $result=$conn->query($sql1);

  if($result){
    echo "
    <script>
      window.location.replace('wishlist.php');
      alert('Wishlist has been Deleted!!');
    </script>";
  }else{
    echo "
    <script>
      window.location.replace('wishlist.php');
      alert('Failed to Delete.');
    </script>";
  }

}


?>