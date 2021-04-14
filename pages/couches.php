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
  <form action="" Method="GET">  
      <div class="boxcontainer">
        <div class="elementcontainer" >

          <div>
            <div>
              <select name="country" id="country">
                <option>Select Country</option>
              </select>

              <select name="city" id="city">
                <option>Select City</option>
              </select>
            </div>

            <input type="text" placeholder="You Can Search Here." name="q" class="search">
          </div>

          <button type="submit">
            <span class="material-icons md-48">search</span>
          </button>
        </div>

        <a href="addcouch.php">Add New Couch</a>
      </div>
  </form>
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

  <div class="couches">
    <div class="list">
      <h5>Couches (Ads)</h5>
      <ul>
      <?php

    if(isset($_GET['country']) && isset($_GET['city']) && isset($_GET['q'])){
      $country=$_GET['country'];
      $city=$_GET['city'];
      $query=$_GET['q'];
      $search="SELECT `id`, `username`, `title`, `timestamp` FROM `couches` 
              WHERE ( (`country` LIKE '$country%') AND (`city` LIKE '$city%') ) AND ( `title` LIKE '%$query%' ) ";
      $res=$conn->query($search);
      $cou=mysqli_fetch_row($res);
      if($cou>0){
        // if user search something
        showdata($res, $conn);
          
      }else{
        echo "No Result Found, try again with different query.";
      }
    }else{
      // if user didnt search
      showdata(null, $conn);
    }
      

    function showdata($row, $con){
      if($row == null){
        $query_statement="SELECT `id`, `country`,`city`,`username`, `title`, `timestamp` FROM `couches` ";
        $result = $con->query($query_statement);
      }else{
        $result = $row;
      }
      
      $count = mysqli_num_rows($result);

      if($count > 0){
        foreach($result as $couch){

          $sql2="SELECT `imagelocation` FROM `couchimages` WHERE `couchid`='".$couch['id']."' ";
          $result2 = $con->query($sql2);

          echo '
          <li>
          <div class="listItem">
            <div class="thumbnail">';
              $imgLocation=" ";
              foreach($result2 as $imag){
                $imgLocation=$imag['imagelocation'];
              }
              echo '<img src="../'.$imgLocation.'" alt="">';

              echo '
            </div>
            <div class="details">
              <h4 class="title"><a href="couchdetail.php?id='.$couch['id'].'">'.$couch['title'].'</a></h4>
              <h4 class="title">Location: '.$couch['city'].", ".$couch['country'].'</h4>
              <span id="date">'.$couch['timestamp'].'</span>
            </div>
          </div>';

          if($couch['username'] == $_SESSION['username']){
            echo '
            <a href="?del='.$couch['id'].'" class="del">
              <span class="material-icons">
                delete_forever
              </span>
            </a>';
          } 
          
        echo '</li>
        ';
        }
      }else{
        echo "Result not found.";
      }
    }
      ?>
      </ul>
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
      window.location.replace('couches.php');
      alert('Already Exists.');
    </script>";
  }else{
    $sql2="INSERT INTO `wishlist`(`username`, `couchid`) 
    VALUES ('$username', '$couchid')";
      if($conn->query($sql2)){
        echo "
          <script>
            window.location.replace('couches.php');
            alert('Added in wishlist');
          </script>";
      }else{  
        echo "
        <script>
          window.location.replace('couches.php');
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
      window.location.replace('couches.php');
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