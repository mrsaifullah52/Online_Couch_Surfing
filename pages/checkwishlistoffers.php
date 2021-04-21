<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist offers</title>
<!-- style sheets -->
  <link rel="stylesheet" href="../resource/styling/style1.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

      <style>
        .looking{
          border: 5px solid skyblue;
        }
        .accepted{
          border: 5px solid green;
        }
        .reject{
          border: 5px solid red;
        }
      </style>

</head>
<body>

<?php
  include '../config/db.php';
  include '../components/header.php';
?>

  <div class="wishlistoffers">
    <div class="container">
      <h1>Wishlist Offers</h1>
      <ul>

      <?php
      $username=$_SESSION['username'];
      if(isset($_GET['wishlist'])){
        $id=$_GET['wishlist'];
        $sql="SELECT * FROM `wishlistoffers` WHERE `id`={$id} AND `owner`='{$username}' ";
        $result=$conn->query($sql);
        $count=mysqli_fetch_row($result);
        if($count>0){
          foreach($result as $offer){
            if($offer['status'] == "looking"){
              showlist($offer, "looking",$conn);
            }else if($offer['status'] == "accepted"){
              showlist($offer, "accepted",$conn);
            }else if($offer['status'] == "reject"){
              showlist($offer, "reject",$conn);
            }
          }
        }else{  
          echo "no result found!!";
        }
      }
    ?>
      </ul>
    </div>
  </div>

</body>
</html>


<?php
  function showlist($offe, $status, $con){
    echo "
    <li>
      <div class=\"offerbox $status\">
        <div class=\"details\">
          <h4>Cost: ".$offe['price']." Rupee</h4>
          <p>".$offe['details']."</p>";
          
          $sql1="SELECT `fname`,`lname`, `username` FROM `users` WHERE `username`='{$offe['personid']}'";
          $result1=$con->query($sql1);
          $name=mysqli_fetch_assoc($result1);
          echo "<span>Sent By: <a href=\"chat.php?touser=".$name['username']."\" style='background:transparent;color:#000'>";
          echo $name['fname'] ." ". $name['lname'];
          echo "</a></span>";

        echo "</div>
        <div class=\"actions\">
          <a href=\"?wishlist=3&status=accepted&id={$offe['id']}\">Accept it</a>
          <a href=\"?wishlist=3&status=reject&id={$offe['id']}\">Reject it</a>
        </div>
      </div>
    </li>
    ";
  }



  if( isset($_GET['status']) && isset($_GET['id'] )){
    $st=$_GET['status'];
    $id=$_GET['id'];
    $wishlistid=$_GET['wishlist'];
    $status=$conn->query("UPDATE `wishlistoffers` SET `status`='$st' WHERE `id`=$id ");
    if($status){
      if($st=="accepted"){
        $conn->query("UPDATE `wishlists` SET `status`='booked' WHERE `id`=$wishlistid");
      }
      echo "
      <script>
        window.location.replace('checkwishlistoffers.php?wishlist=$wishlistid');
        alert('Offer {$st}!!');
      </script>";
    }else{
      echo "
      <script>
        window.location.replace('checkwishlistoffers.php?wishlist=$wishlistid');
        alert('Failed to perform action!!');
      </script>";
    }

  }
?>