<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Couche offers</title>
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
      <h1>Couche Offers</h1>
      <ul>

      <?php
      $username=$_SESSION['username'];
      if(isset($_GET['couch'])){
        $id=$_GET['couch'];
        $sql="SELECT * FROM `couchoffers` WHERE `couchid`='$id' AND `owner`='$username' ";
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
    <li class=\"$status\">
      <div class=\"offerbox\">
        <div class=\"details\">
          <h4>Cost: ".$offe['price']." Rupee</h4>
          <p>".$offe['details']."</p>";
          
          $sql1="SELECT `username`,`fname`,`lname` FROM `users` WHERE `username`='{$offe['personid']}'";
          $result1=$con->query($sql1);
          $name=mysqli_fetch_assoc($result1);
          echo "<span>Sent By: <a href=\"chat.php?touser=".$name['username']."\" style='background:transparent;color:#000'>";
          echo $name['fname'] ." ". $name['lname'];
          echo "</a></span>";

          echo "</div>
          <div class=\"actions\">";
          
          if($status=="accepted"){
            echo "
            <a href=\"?couch={$offe['couchid']}&status=accepted&id={$offe['id']}\">Accepted</a>";
          }else{
            echo "
            <a href=\"?couch={$offe['couchid']}&status=accepted&id={$offe['id']}\">Accept it</a>";
          }
          echo "<a href=\"?couch={$offe['couchid']}&status=reject&id={$offe['id']}\">Reject it</a>
        </div>
      </div>
    </li>
    ";
  }



  if( isset($_GET['status']) && isset($_GET['id'] )){
    $st=$_GET['status'];
    $id=$_GET['id'];
    $couchid=$_GET['couch'];
    $status=$conn->query("UPDATE `couchoffers` SET `status`='$st' WHERE `id`=$id ");
    if($status){
      if($st=="accepted"){
        $conn->query("UPDATE `couches` SET `status`='booked' WHERE `id`=$couchid");
      }
      echo "
      <script>
        window.location.replace('checkcouchoffers.php?couch=$couchid');
        alert('Offer {$st}!!');
      </script>";
    }else{
      echo "
      <script>
        window.location.replace('checkcouchoffers.php?couch=$couchid');
        alert('Failed to perform action!!');
      </script>";
    }

  }
?>