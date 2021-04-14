<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Couches</title>
  <link rel="stylesheet" href="../resource/styling/style1.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

     <!-- jquery -->  
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
</head>
<body>

<?php
  include '../components/header.php';
  include '../config/db.php';
?> 

  <div class="couches">

    <div class="list">
      <h5>
        <a href="couches.php?show=active" class="active">Active</a>
      | <a href="couches.php?show=offers" class="offers">Sent offers</a>
      </h5>
    </div>
  </div>

  <div class="couches">
    <?php
    if(isset($_GET['show'])){
      if($_GET['show'] == "active"){
        include 'activecouches.php';
      }else if($_GET['show'] == "offers"){
        ?>

        <style>
          .active{
            color:rgb(83, 225, 230)
          }
          .offers{
            color:rgb(55, 132, 134)
          }
        </style>

        <div class="list">
          <ul>
            <?php
              $sql="SELECT * FROM `couchoffers` where `personid`='{$_SESSION['username']}'";
              $result=$conn->query($sql);

              $count=mysqli_fetch_row($result);
              if($count > 0){

                foreach($result as $offer){
                  echo "
                    <li>
                      <div class=\"offerslist\">
                        <div class=\"offer\">
                          <h5>Cost: ".$offer['price']." Rupee</h5>
                          <div>
                            <p>".$offer['details']."</p>
                          </div>
                        </div>
                        <div class=\"wish\">";

                        $result2=$conn->query("SELECT * FROM couches WHERE `id`= '{$offer['couchid']}' ");
                        $loca=mysqli_fetch_assoc($result2);
                        
                          echo "<h5>".$loca['title']."</h5>";

                          echo "
                          <h4 class=\"title\">Location: ".$loca['city'].", ".$loca['country']."</h4>";
                        
                        echo "</div>
                      </div>
                      <span class=\"date\">{$loca['timestamp']}</span>
                    </li>
                  ";
                }

              }else{
                echo "no result found!!";
              }
                
            ?>
          </ul>
        </div>

      <?php
      }
    }
    ?>
  </div>
</body>
</html>

<?php

// if(isset($_GET['wishlist'])){
  // $couchid=$_GET['wishlist'];
  // $username=$_SESSION['username'];

  // $sql1="SELECT `username`, `couchid` from `wishlist` where `username`='$username' AND `couchid`='$couchid' ";
  // $result=$conn->query($sql1);
  // $count=mysqli_num_rows($result);
  // if($count>0){
  //   echo "
  //   <script>
  //     window.location.replace('couches.php');
  //     alert('Already Exists.');
  //   </script>";
  // }else{
  //   $sql2="INSERT INTO `wishlist`(`username`, `couchid`) 
  //   VALUES ('$username', '$couchid')";
  //     if($conn->query($sql2)){
  //       echo "
  //         <script>
  //           window.location.replace('couches.php');
  //           alert('Added in wishlist');
  //         </script>";
  //     }else{  
  //       echo "
  //       <script>
  //         window.location.replace('couches.php');
  //         alert('Failed to Add.');
  //       </script>";
  //     }
  // }

// }else if(isset($_GET['del'])){
//   $couchid=$_GET['del'];
//   $username=$_SESSION['username'];

//   $sql1="UPDATE `couches` SET `status`='unavailable' WHERE `id`='$couchid' AND `username`='$username' ";
//   $result=$conn->query($sql1);

//   if($result){
//     echo "
//     <script>
//       window.location.replace('couches.php?show=active');
//       alert('Couch has been Deleted!!');
//     </script>";
//   }else{
//     echo "
//     <script>
//       window.location.replace('couches.php?show=active');
//       alert('Failed to Delete.');
//     </script>";
//   }

// }


?>