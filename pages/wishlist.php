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
          <!-- <input type="text" placeholder="You Can Search Here." name="search" class="search"> -->
        </div>

        <button type="submit">
          <span class="material-icons md-48">search</span>
        </button>
      </div>

      <a href="addcouch.php">Add Couch</a>
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
      <h5>Wishlists </h5>


      <ul>
      <?php


        if(isset($_GET['country']) && isset($_GET['city']) ){
          $country=$_GET['country'];
          $city=$_GET['city'];
          // WHERE (CustomerName LIKE 'a%') AND (Address LIKE 'O%')
          $search="SELECT `id`, `city`, `country`, `username`, `title`, `timestamp` FROM `wishlists` 
                  WHERE (`country` LIKE '$country%') AND (`city` LIKE '$city%')";
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
          $query_statement="SELECT `id`, `city`, `country`, `username`, `title`, `timestamp` FROM `wishlists` ";
          $result = mysqli_query($con, $query_statement);
        }else{
          $result = $row;
        }

        $count = mysqli_num_rows($result);

        if($count > 0){
          foreach($result as $wishlist){
            echo '
            <li>
            <div class="listItem">
              <div class="details">
                  <h4 class="title">
                    <a href="wishlistdetail.php?id='.$wishlist['id'].'">
                      '.$wishlist['title'].'
                    </a>
                  </h4>
                <h4 class="title">Location: '.$wishlist['city'].", ".$wishlist['country'].'</h4>
                <span class="date">
                '.$wishlist['timestamp'].
                '</span>
                <div class="actions">';

                  echo
                '</div>
              </div>
            </div>';
                
            if($wishlist['username']==$_SESSION['username']){
              echo '
              <a href="?del='.$wishlist['id'].'" class="del">
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

  if(isset($_GET['del'])){
  $couchid=$_GET['del'];
  $username=$_SESSION['username'];

  $sql1="DELETE FROM `wishlists` WHERE `id`='$couchid' AND `username`='$username' ";
  $result=$conn->query($sql1);

  if($result){
    echo "
    <script>
      window.location.replace('wishlist.php');
      alert('Wishlist has been Deleted!!');
    </script>";
  }else{
    echo "
    <script>
      window.location.replace('wishlist.php');
      alert('Failed to Delete.');
    </script>";
  }

}


?>