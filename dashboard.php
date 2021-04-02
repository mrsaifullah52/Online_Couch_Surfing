<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashbaord</title>

  <link rel="stylesheet" href="resource/styling/style1.css">
</head>
<body>

<?php
  include 'config/db.php';
  include 'components/header.php';
?> 

<div class="dashboard">
    <div class="list">
      <h5>My Ads</h5>
      <ul>

      <?php
      $sql1="SELECT `id`, `title`, `timestamp` FROM `couches` WHERE `username`='".$_SESSION['username']."' ";
      $result1 = mysqli_query($conn, $sql1);

      $count = mysqli_num_rows($result1);

      if($count >= 1){
        foreach($result1 as $couch){
          
          $sql2="SELECT `imagelocation` FROM `couchimages` WHERE `couchid`='".$couch['id']."' ";
          $result2 = mysqli_query($conn, $sql2);

          echo '
          <li>
          <div class="listItem">
            <div class="thumbnail">';
            $imgLocation=" ";
            foreach($result2 as $imag){
              $imgLocation=$imag['imagelocation'];
            }
              echo '<img src="'.$imgLocation.'" alt="">';
            echo
            '</div>
            <div class="details">
              <h4 class="title">'.$couch['title'].'</h4>
              <span id="date">'.$couch['timestamp'].'</span>
  
              <div class="actions">
                <a href="couchdetail.php?id='.$couch['id'].'">View</a>
                <a href="?del='.$couch['id'].'">Remove</a>
              </div>
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
  
</body>
</html>


<?php

if(isset($_GET['del'])){
  $couchid=$_GET['del'];
  $username=$_SESSION['username'];


  $sql1="DELETE FROM `couches` WHERE `id`='$couchid' AND `username`='$username' ";
  $result=$conn->query($sql1);

  if($result){
    echo "
    <script>
      window.location.replace('dashboard.php');
      alert('Couch has been Deleted!!');
    </script>";
  }else{
    echo "
    <script>
      window.location.replace('dashboard.php');
      alert('Failed to Delete.');
    </script>";
  }


}

?>