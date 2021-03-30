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
      $query_statement="SELECT `id`, `title`, `timestamp` FROM `couches` WHERE `username`='".$_SESSION['username']."' ";
      $result = mysqli_query($conn, $query_statement);
      $couches = mysqli_fetch_array($result, MYSQLI_ASSOC);


      $count = mysqli_num_rows($result);
      if($count >= 1){
        foreach($couches as $couch){
          // echo $couch->title;
        }
      }else{
        echo "Result not found.";
      }
      
      ?>
        <li>
          <div class="listItem">
            <div class="thumbnail">
              <img src="resource/apartment1.jpg" alt="">
            </div>
            <div class="details">
              <h4 class="title">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</h4>
              <span id="date">19 Jan</span>
  
              <div class="actions">
                <a href="couchdetail.html">View</a>
                <a href="#">Remove</a>
              </div>
            </div>
          </div>
        </li>


        <!-- <li>
          <div class="listItem">
            <div class="thumbnail">
              <img src="resource/apartment2.jpg" alt="">
            </div>
            <div class="details">
              <h4 class="title">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</h4>
              <span id="date">24 Jan</span>
  
              <div class="actions">
                <a href="#">View</a>
                <a href="">Remove</a>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div class="listItem">
            <div class="thumbnail">
              <img src="resource/apartment3.jpg" alt="">
            </div>
            <div class="details">
              <h4 class="title">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</h4>
              <span id="date">20 Jan</span>
  
              <div class="actions">
                <a href="#">View</a>
                <a href="">Remove</a>
              </div>
            </div>
          </div>
        </li> -->
      </ul>
    </div>
  </div>
  
</body>
</html>