<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Wishlist</title>
  <link rel="stylesheet" href="../resource/styling/style1.css">

    <!-- leaflet.js map library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   
   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   
</head>
<body>
<?php
  include '../config/db.php';
  include '../components/header.php';

  // if(isset($_GET['id'])){
    $sql1="SELECT `username`, `title`, `startdate`, `enddate`, `description`,
                `city`, `country`, `latitude`, `longitude`, `timestamp` 
                FROM `wishlists` WHERE `id`='".$_GET['id']."'";
    $result1 = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_array($result1);
  // }else{
  //   echo "
  //   <script>
  //     window.location.replace('dashboard.php');
  //     alert('Link to this Couch has been Broken!!');
  //   </script>";
  // }
?>


<div class="wishlistdetail">

  <div class="left">
    <!-- map -->
    <div class="bigmap" id="map" >
      <span onclick="locateit(<?php echo $row['latitude'].','.$row['longitude'] ?>)">Locate it</span>
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
                  <img src="../resource/images/user.png" alt="userprofile">
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
          <a href='chat.php?touser=<?php echo $row['username'] ?> '>Chat with Owner</a>
          <p>
            <b>Duration</b><br/>
            <b>From:</b> <?php echo $row['startdate']?><br/>
            <b>To:</b> <?php echo $row['enddate']?>
          </p>
      </div>
      <?php
        if($_SESSION['username'] != $row['username']){?>
      <!-- start condition -->
        <!-- <div class="bottom">
            <h4>Want to Offer?</h4>
            <form action="" method="POST">
              <label for="price">Cost:</label>
              <input type="text" name="price" placeholder="Enter your Charges" id="price">

              <label for="details">Details:</label>
              <textarea name="details" id="details" rows="5" cols="22" placeholder="Enter Extra Details if you have any"></textarea>

              <input type="submit" value="Send Offer">
            </form>
        </div> -->
      <!-- end condition -->
      <?php
        }
      ?>
  </div>

</div>


<script>
      function showPosition(lat, lng) {
        const mymap = L.map('map').setView([lat, lng], 12);
        const tiles='https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        const attribution='Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>';
        L.tileLayer(tiles, {attribution}).addTo(mymap);
        const marker = L.marker([lat, lng]).addTo(mymap);
      }
      showPosition( <?php echo $row['latitude'].','.$row['longitude'] ?> );

      function locateit(lat,lng){
        const loca=lat+","+lng;
        window.open('https://www.google.com/maps/search/?api=1&query='+loca);
      }
    </script>
</body>
</html>

<?php
if(isset($_POST['price']) && isset($_POST['details']) ){
  $price=$_POST['price'];
  $details=$_POST['details'];

  $sql="INSERT INTO `wishlistoffers` (`personid`,`wishlistid`, `price`, `details`) 
        VALUES( '{$_SESSION['username']}', '{$_GET['id']}', '$price', '$details')";

  $result=$conn->query($sql);
  if($result){
    echo "
    <script>
      alert('Your offer has been sent!!');
    </script>";
  }

}

?>

