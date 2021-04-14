<style>
  .active{
    color:rgb(55, 132, 134)
  }
  .offers{
    color:rgb(83, 225, 230)
  }
</style>

  <form action="" Method="GET">
    <div class="boxcontainer">
      <div class="elementcontainer" >
        <div>
          <div>
            <input type="hidden" name="show" value="active">
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

      <a href="addwishlist.php">Add Wishlist</a>
    </div>
  </form>

  <div class="list">
  <ul>
  <?php

        // search query
        if(isset($_GET['country']) && isset($_GET['city']) && isset($_GET['q'])){
          $country=$_GET['country'];
          $city=$_GET['city'];
          $query=$_GET['q'];

          $search="SELECT `id`, `city`, `country`, `username`, `title`, `timestamp` FROM `wishlists` 
                  WHERE ( (`country` LIKE '$country%') AND (`city` LIKE '$city%') ) 
                  AND ( (`status`='available') AND ( `title` LIKE '%$query%' ) ) ";
          $res=$conn->query($search);
          $cou=mysqli_fetch_row($res);
          if($cou>0){
            // if user search something
            showdata($res, $conn);
          }else{
            echo "No Result Found, try again with different query.".mysqli_error($conn);
          }
        }else{
          // if user didnt search
          showdata(null, $conn);
        }

        function showdata($row, $con){
          if($row == null){
            $query_statement="SELECT `id`, `city`, `country`, `username`, `title`, `timestamp` FROM `wishlists`
                              WHERE (`status`='available') OR (NOT `status`='available' AND `username`='{$_SESSION['username']}' ) ";
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
                  <div class="actions"></div>
                </div>
              </div>';
                  
              if($wishlist['username']==$_SESSION['username']){
                echo '
                <a href="?show=active&del='.$wishlist['id'].'" class="del">
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



<?php
if(isset($_GET['del'])){
  $couchid=$_GET['del'];
  $username=$_SESSION['username'];

  $sql1="UPDATE `wishlists` SET `status`='unavailable' WHERE `id`=$couchid AND `username`='$username' ";
  $result=$conn->query($sql1);

  if($result){
    echo "
    <script>
      window.location.replace('wishlist.php?show=active');
      alert('Wishlist has been Removed!!');
    </script>";
  }else{
    echo "
    <script>
      window.location.replace('wishlist.php?show=active');
      alert('Failed to Removed.');
    </script>";
  }

}

?>