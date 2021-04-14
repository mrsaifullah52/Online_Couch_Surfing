<style>
  .active{
    color:rgb(55, 132, 134)
  }
  .offers{
    color:rgb(83, 225, 230)
  }
</style>

<form action="?show=active&" Method="GET">
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

<div class="list">
  <ul>
    <?php

    if(isset($_GET['country']) && isset($_GET['city']) && isset($_GET['q'])){
      $country=$_GET['country'];
      $city=$_GET['city'];
      $query=$_GET['q'];
      $search="SELECT * FROM `couches` 
              WHERE ( (`country` LIKE '$country%') AND (`city` LIKE '$city%') ) 
              AND ( (`status`='available') AND ( `title` LIKE '%$query%' ) ) ";
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
        $query_statement="SELECT `id`, `country`,`city`,`username`, `title`, `timestamp` FROM `couches`
                          WHERE (`status`='available') OR (NOT `status`='available' AND `username`='{$_SESSION['username']}' ) ";
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

<?php

if(isset($_GET['del'])){
  $couchid=$_GET['del'];
  $username=$_SESSION['username'];

  $sql1="UPDATE `couches` SET `status`='unavailable' WHERE `id`='$couchid' AND `username`='$username' ";
  $result=$conn->query($sql1);

  if($result){
    echo "
    <script>
      window.location.replace('mycouches.php?show=active');
      alert('Couch has been Deleted!!');
    </script>";
  }else{
    echo "
    <script>
      window.location.replace('mycouches.php?show=active');
      alert('Failed to Delete.');
    </script>";
  }

}

?>