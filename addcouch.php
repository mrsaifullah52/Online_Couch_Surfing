<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Couch</title>

    <!-- <link rel="stylesheet" href="resource/styling/style.css"> -->
    <link rel="stylesheet" href="resource/styling/style1.css">

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
  include 'config/db.php';
  include 'components/header.php';
?> 
  <div class="addcouch">
    <h1>Add Couch Details</h1>
    <form action="" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>"  required/>

        <label for="title">Title</label>
        <input type="text" name="title" placeholder="Write Title Here"  required>

        <label for="description">Description:</label></br>
        <textarea id="description" name="description" rows="4" cols="74" placeholder="Write Description About Your Couch" required></textarea>
    
        <label for="description">Select Picture(one or multiple):</label></br>
        <input type="file" id="imageFiles" name="imageFiles[]" multiple required>
    
        <div class="termbox">
          <label for="Terms">Select Term:</label>
          <select name="terms" id="Terms" required>
            <option value="Free">Free</option>
            <option value="Paid">Paid</option>
            <option value="Exchang">Exchange</option>
          </select>
        </div>
        
        <label for="map">Set Your Location:</label>


        <div onclick="getLocation()"  id="map">
          <span>Click here to set your Current Location</span>
          <input type="hidden" name="latitude" id="latitude"/>
          <input type="hidden" name="longitude" id="longitude"/>
        </div>



        <input type="submit" value="Add Couch Details"/>
    </form>

  </div>


<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);   
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  const lat=position.coords.latitude;
  const lng=position.coords.longitude;
  
  document.getElementById("latitude").value=lat;
  document.getElementById("longitude").value=lng;

  console.log(lat+" / "+lng);

  const mymap = L.map('map').setView([lat, lng], 10);
  const tiles='https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
  const attribution='Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>';
  L.tileLayer(tiles, {attribution}).addTo(mymap);
  const marker = L.marker([lat, lng]).addTo(mymap);
  

}
</script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_6-kYEtJliZDcM9iFCyUPpwinM7Gu9mA&callback=myMap"></script> -->

</body>
</html>


<?php

$ind=$conn->query("SELECT `id` from `couches`");
$index=0;
foreach($ind as $i){
  $index=$i['id'];
}

if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['terms']) ){
  $username =$_POST['username'];
  $title =$_POST['title'];
  $description =$_POST['description'];
  $terms =$_POST['terms'];
  $latitude =$_POST['latitude'];
  $longitude =$_POST['longitude'];

  $index++;
  mkdir("public/images/".$index);
  $extension=array("jpeg","jpg","png", "JPEG", "JPG", "PNG");
  $files=count($_FILES['imageFiles']['tmp_name']);
  foreach($_FILES['imageFiles']['tmp_name'] as $key => $tmp_name){
    if($files>0){
      $file_name = $_FILES['imageFiles']['name'][$key];
      $file_tmp = $_FILES['imageFiles']['tmp_name'][$key];
      
      $exten=pathinfo($file_name, PATHINFO_EXTENSION);
      
      if(in_array($exten, $extension)){
        $location="public/images/".$index."/".$files.".".$exten;
        
        move_uploaded_file($file_tmp, $location);

        $conn->query("INSERT INTO `couchimages` (`couchid`, `imagelocation`)
                      VALUES ('$index', '$location') ");
      }else{
        echo array_push($error, "$file_name, ");
      }
      $files--;
    }
  }

  $sql="INSERT INTO `couches`(`username`, `title`, `description`, `term`, `latitude`, `longitude`) 
        VALUES ('$username','$title','$description', '$terms', '$latitude', '$longitude')";

  if($conn->query($sql)){
    echo "<script>alert('Couch has been added.')</script>";
  }else{
    echo "<script>alert('Failed to add, try again!!.')</script>";

    echo mysqli_error($conn);
  }

}

?>