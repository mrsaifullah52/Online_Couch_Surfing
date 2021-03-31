<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Couches</title>
  <link rel="stylesheet" href="resource/styling/style1.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<body>

<?php
  include 'components/header.php';
?> 

<div class="couches">
  <form action="search">  
      <div class="boxcontainer">
        <div class="elementcontainer" >
          <input type="text" placeholder="You Can Search Here." name="search" class="search"></td>
          <span class="material-icons md-48">search</span>
        </div>

        <a href="addcouch.php">Add Couch</a>
      </div>
  </form>

  <div class="couches">
    <div class="list">
      <h5>Couches (Ads)</h5>
      <ul>
      <?php
      include 'config/db.php';

      $query_statement="SELECT `id`, `username`, `title`, `timestamp` FROM `couches` ";
      $result = mysqli_query($conn, $query_statement);

      $count = mysqli_num_rows($result);

      if($count >= 1){
        foreach($result as $couch){
          echo '
          <li>
          <div class="listItem">
            <div class="thumbnail">
              <img src="resource/images/apartment1.jpg" alt="">
            </div>
            <div class="details">
              <h4 class="title">'.$couch['title'].'</h4>
              <span id="date">'.$couch['timestamp'].'</span>
  
              <div class="actions">
                <a href="couchdetail.php?id='.$couch['id'].'">View</a>';

                if($couch['username']==$_SESSION['username']){
                  echo '
                  <a href="#'.$couch['id'].'">Remove</a>';
                }else{
                  echo '
                  <a href="?id='.$couch['id'].'">Wishlist</a>';
                }
                echo
                '</div>
            </div>
          </div>
        </li>
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

if(isset($_GET['id'])){
  $couchid=$_GET['id'];
  $username=$_SESSION['username'];


  $sql1="SELECT `username`, `couchid` from `wishlist` where `username`='$username' AND `couchid`='$couchid' ";
  $result=$conn->query($sql1);
  $count=mysqli_num_rows($result);
  if($count>0){
    echo "
    <script>
      window.location.replace('couches.php');
      alert('Already Exists.');
    </script>";
  }else{
    $sql2="INSERT INTO `wishlist`(`username`, `couchid`) 
    VALUES ('$username', '$couchid')";
      if($conn->query($sql2)){
        echo "
          <script>
            window.location.replace('couches.php');
            alert('Added in wishlist');
          </script>";
      }else{  
        echo "
        <script>
          window.location.replace('couches.php');
          alert('Failed to Add.');
        </script>";
      }
  }


}

?>