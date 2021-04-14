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

     <!-- jquery -->  
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>

<?php
  include '../components/header.php';
  include '../config/db.php';
?> 

<div class="wishlists">
  <div class="couches">
  
  <div class="list">
    <h5>
       <a href="wishlist.php?show=active" class="active">Active</a>
     | <a href="wishlist.php?show=offers" class="offers">Sent offers</a>
    </h5>
  
  </div>
  
<?php
  if(isset($_GET['show'])){
    if($_GET['show'] == "active"){
      include 'activewishlist.php';
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
            $sql="SELECT * FROM `wishlistoffers` where `personid`='{$_SESSION['username']}'";
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

                      $result2=$conn->query("SELECT * FROM wishlists WHERE `id`= '{$offer['wishlistid']}' ");
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

            }
              
          ?>
        </ul>
      </div>

    <?php
    }
  }
?>

  </div>
</div>
</body>
</html>
