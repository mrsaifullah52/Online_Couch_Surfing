<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Couch</title>

    <!-- <link rel="stylesheet" href="resource/styling/style.css"> -->
    <link rel="stylesheet" href="resource/styling/style1.css">


  </head>
<body>


<?php
  include 'config/db.php';
  include 'components/header.php';
?> 
  <div class="addcouch">
    <h1>Add Couch Details</h1>
    <form action="" method="POST">

        <input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>" />

        <label for="title">Title</label>
        <input type="text" name="title" placeholder="Write Title Here" >

        <label for="description">Description:</label></br>
        <textarea id="description" name="description" rows="4" cols="74" placeholder="Write Description About Your Couch"></textarea>
    
        <input type="file" id="imageFiles" name="imagefiles" value="resource/apartment1.jpg">
    
        <label for="Terms">Select Term:</label>
        <select name="terms" id="Terms">
          <option value="free">Free</option>
          <option value="paid">Paid</option>
          <option value="exchang">Exchange</option>
        </select>
          
        <div id="googleMap" style="width:100%;height:300px;background-color:yellow;margin:15px 0px">
          google map
        </div>
        <input type="hidden" name="latlng" value="51.508742,-0.120850">

        <input type="submit" value="Add Couch Details"/>
    </form>

  </div>


    <!-- <script>
function myMap() {
var mapProp= {
  center:new google.maps.LatLng(51.508742,-0.120850),
  zoom:5,
};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_6-kYEtJliZDcM9iFCyUPpwinM7Gu9mA&callback=myMap"></script> -->

</body>
</html>


<?php

if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['terms']) ){
  $username =$_POST['username'];
  $title =$_POST['title'];
  $description =$_POST['description'];
  $terms =$_POST['terms'];
  $latlng =$_POST['latlng'];
  $imagefiles =$_POST['imagefiles'];

  $sql="INSERT INTO `couches`(`username`, `title`, `description`, `term`, `location`) 
        VALUES ('$username','$title','$description', '$terms', '$latlng')";

  if($conn->query($sql)){
    echo "<script>alert('Couch has been added.')</script>";
  }else{
    echo "<script>alert('Failed to add, try again!!.')</script>";

    echo mysqli_error($conn);
  }

}

?>