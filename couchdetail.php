<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Couch</title>
    <link rel="stylesheet" href="resource/styling/style1.css">
</head>
<body>

<?php

  include 'config/db.php';
  include 'components/header.php';

//   if(isset($_GET['id'])){
        $sql1="SELECT `id`, `title`, `description`, `username`, `term`, `location`, `timestamp` FROM `couches` 
                    WHERE `id`='".$_GET['id']."'";
        $result1 = mysqli_query($conn, $sql1);
        $row = mysqli_fetch_array($result1);
//   }else{
//     echo "
//     <script>
//       window.location.replace('dashboard.php');
//       alert('Link to this Couch has been Broken!!');
//     </script>";
//   }

?> 
    <!-- slider -->
    <div class="parent">

  
    <div class="slider">
        <div class="header">
            <div>
                <figure>
                    <?php
                        $sql2="SELECT `imagelocation` FROM `couchimages` WHERE `couchid`='".$_GET['id']."'";
                        $result2 = mysqli_query($conn, $sql2);
                        foreach($result2 as $imag){
                            echo '
                                <div class="slider">
                                    <img src="'.$imag['imagelocation'].'" alt="Couch '.$imag['imagelocation'].'">
                                </div>';
                        }
                    ?>
                </figure>
            </div>
    
            <div class="buttons">
                
                <?php 
                    if($row['username']==$_SESSION['username']){
                        echo '<span><a href="?del='.$row['id'].'">Remove Couch</a></span>';
                    }else{
                        echo '<span><a href="?wishlist='.$row['id'].'">Add to Wishlist</a></span>';
                    }
                ?>
            </div>
        </div>

        <div class="details">                      
            <div class="title"> 
                <h3> <?php echo $row['title'] ?> </h3>
            </div>
            <div class="description">
                <h4>Couch Details</h4>
                <P> <?php echo $row['description'] ?> </p>
            </div>
        </div>
    
    </div>

    <div class="right">
        <div class="top">
            <div class="owner_profile">
                <div class="dp">
                    <img src="resource/images/user.png" alt="userprofile">
                </div>
                <div class="details">
                    <h5>
                    <?php
                        $sql3="SELECT `fname`,`lname` FROM `users` WHERE `username`='".$row['username']."'";
                        $result3=mysqli_query($conn, $sql3);
                        $name=mysqli_fetch_assoc($result3);
                        echo $name['fname']." ".$name['lname'];
                    ?>
                    </h5>
                </div>
            </div>
            <span>Category: <?php echo $row['term']?></span>
            <a href='chat.php?userid=<?php echo $row['username'] ?> '>Chat with Owner</a>
        </div>
        <div class="bottom">
            <h4>Location</h4>
            <div class="map">
                <?php echo $row['location']?>
            </div>
        </div>
    </div>

    </div>
</body>
</html> 


<?php

if(isset($_GET['wishlist'])){
  $couchid=$_GET['wishlist'];
  $username=$_SESSION['username'];

  $sql1="SELECT `username`, `couchid` from `wishlist` where `username`='$username' AND `couchid`='$couchid' ";
  $result=$conn->query($sql1);
  $count=mysqli_num_rows($result);
  if($count>0){
    echo "
    <script>
      window.location.replace('wishlist.php');
      alert('Already Exists.');
    </script>";
  }else{
    $sql2="INSERT INTO `wishlist`(`username`, `couchid`) 
    VALUES ('$username', '$couchid')";
      if($conn->query($sql2)){
        echo "
          <script>
            window.location.replace('wishlist.php');
            alert('Added in wishlist');
          </script>";
      }else{  
        echo "
        <script>
          window.location.replace('wishlist.php');
          alert('Failed to Add.');
        </script>";
      }
  }

}else if(isset($_GET['del'])){
  $couchid=$_GET['del'];
  $username=$_SESSION['username'];

  $sql1="DELETE FROM `couches` WHERE `id`='$couchid' AND `username`='$username' ";
  $result=$conn->query($sql1);

  if($result){
    echo "
    <script>
      window.location.replace('couchdetail.php?id=".$_GET['id']."');
      alert('Couch has been Deleted!!');
    </script>";
  }else{
    echo "
    <script>
      window.location.replace('couches.php');
      alert('Failed to Delete.');
    </script>";
  }

}


?>