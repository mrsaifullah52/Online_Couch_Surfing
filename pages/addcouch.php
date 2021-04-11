<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Couch</title>

    <!-- <link rel="stylesheet" href="resource/styling/style.css"> -->
  <link rel="stylesheet" href="../resource/styling/style1.css">

<!-- leaflet.js map library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   
   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

   <!-- jquery -->  
   <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  </head>
<body>

<?php
  include '../config/db.php';
  include '../components/header.php';
?> 
  <div class="addcouch">
    <h1>Add Couch Details</h1>
    <form action="" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>"  required/>

        <label for="title">Title</label>
        <input type="text" name="title" placeholder="Write Title Here"  required maxlength="100" >

        <div class="dateP">
          <div>
            <label for="sdate">Starting Date</label>
            <input type="date" name="sdate" min="1997-01-01" max="2030-12-31" required>
          </div>
          
          <div>
            <label for="edate">Ending Date</label>
            <input type="date" name="edate" min="1997-01-01" max="2030-12-31" required>
          </div>
        </div>

        <div class="locationP">
          <div>
            <label for="country">Country</label>
            <select name="country" id="country">
            </select>
          </div>

          <div>
            <label for="city">City</label>
            <select name="city" id="city">
              <option>Select Country First</option>
            </select>
          </div>
        </div>

     <!-- jquery for dynamic city names -->
     <script>
      $(function () {
        $.ajax({
        type: 'GET',
        url: 'getcountry.php?req=country',
        dataType: 'json',
        success: function(result){
          if(result){
            result.forEach(item=>{
              $("#country").append(renderOp(item));
            });
          }
          }
        });
      });

      $("#country").on("change",function(e){
        $("#city").empty();
        console.log(e.target.value);
        country=e.target.value;
        $.ajax({
        type: 'GET',
        url: 'getcountry.php?req=city&country='+country,
        dataType: 'json',
        success: function(result){
          if(result){
            result.forEach(item=>{
              $("#city").append(renderOp(item));
            });
          }
          }
        });
      });

      function renderOp(item){
        return `
          <option value=\"${item}\">
              ${item}
          </option>
        `;
      }
      </script>

        <label for="description">Description:</label></br>
        <textarea id="description" maxlength="255" name="description" rows="4" cols="74" placeholder="Write Description About Your Couch" required></textarea>
    
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
        <div id="map">
          <span>Click here to set your Current Location</span>
          <input type="hidden" name="latitude" id="latitude"/>
          <input type="hidden" name="longitude" id="longitude"/>
        </div>

        <input type="submit" value="Add Couch Details"/>
    </form>

  </div>

<!-- jquery and map for map -->
<script>
let marker;
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);   
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}
getLocation();

function showPosition(position) {
  const lat=position.coords.latitude;
  const lng=position.coords.longitude;
  
  document.getElementById("latitude").value=lat;
  document.getElementById("longitude").value=lng;

  console.log(lat+" / "+lng);

  let mymap = L.map('map').setView([lat, lng], 10);
  const tiles='https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
  const attribution='Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>';
  L.tileLayer(tiles, {attribution}).addTo(mymap);
  marker = L.marker([lat, lng]).addTo(mymap);

// change latitude and longitude while click on map
  mymap.on('click', function(e){
    if(marker){
      mymap.removeLayer(marker);
    }
    console.log(e.latlng);
    marker = L.marker(e.latlng).addTo(mymap);
  });
}


</script>
</body>
</html>


<?php

$ind=$conn->query("SELECT `id` from `couches`");
$index=0;
foreach($ind as $i){
  $index=$i['id'];
}

if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['sdate']) && isset($_POST['edate']) && isset($_POST['terms']) 
          && isset($_POST['country']) && isset($_POST['city'])){
  $username =$_POST['username'];
  $title =$_POST['title'];
  $description =$_POST['description'];
  $terms =$_POST['terms'];
  $latitude =$_POST['latitude'];
  $longitude =$_POST['longitude'];
  $country =$_POST['country'];
  $city =$_POST['city'];
  $sdate =$_POST['sdate'];
  $edate =$_POST['edate'];

  $index++;
  mkdir("../public/images/".$index);
  $extension=array("jpeg","jpg","png", "JPEG", "JPG", "PNG");
  $files=count($_FILES['imageFiles']['tmp_name']);
  foreach($_FILES['imageFiles']['tmp_name'] as $key => $tmp_name){
    if($files>0){
      $file_name = $_FILES['imageFiles']['name'][$key];
      $file_tmp = $_FILES['imageFiles']['tmp_name'][$key];
      
      $exten=pathinfo($file_name, PATHINFO_EXTENSION);
      
      if(in_array($exten, $extension)){
        $location="public/images/".$index."/".$files.".".$exten;
        
        move_uploaded_file($file_tmp, '../'.$location);

        $conn->query("INSERT INTO `couchimages` (`couchid`, `imagelocation`)
                      VALUES ('$index', '$location') ");
      }else{
        echo array_push($error, "$file_name, ");
      }
      $files--;
    }
  }

  $sql="INSERT INTO `couches`(`username`, `startdate`, `enddate`, `title`, `description`, `term`, `latitude`, `longitude`, `country`, 
                    `city`)
        VALUES ('$username', '$sdate', '$edate','$title','$description', '$terms', '$latitude', '$longitude', '$country', '$city')";

  if($conn->query($sql)){
    echo "<script>alert('Couch has been added.')</script>
    ".mysqli_error($conn)."
    ";
  }else{
    echo "<script>alert('Failed to add, try again!!.')</script>";

    echo mysqli_error($conn);
  }

}

?>