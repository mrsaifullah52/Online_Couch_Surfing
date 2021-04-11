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

        <!-- scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<?php
  include '../config/db.php';
  include '../components/header.php';
?> 


<section class="chat">

  <div class="container">
    <div class="left">
    <h5>Users</h5>

    <hr/>

      <ul>
        <?php
          $userslist=array();

          $to="SELECT DISTINCT `touser` FROM `messages` WHERE `fromuser`='".$_SESSION['username']."'";
          $from="SELECT DISTINCT `fromuser` FROM `messages` WHERE `touser`='".$_SESSION['username']."'";

          $tolist = $conn->query($to);
          $fromlist = $conn->query($from);

          $tolistcount=mysqli_num_rows($tolist);
          $fromlistcount=mysqli_num_rows($fromlist);

          if($tolistcount>0){

            foreach($tolist as $chatlist){

              $user=$conn->query("SELECT `fname`, `lname` FROM `users` WHERE `username`='".$chatlist['touser']."'");
              $unread=$conn->query("SELECT COUNT(id) FROM `messages` WHERE `status`='unread' AND `fromuser`='".$chatlist['touser']."'");
              
              $name=mysqli_fetch_assoc($user);
              $unreadcount=mysqli_fetch_array($unread);
              $count=$unreadcount[0];
              
              array_push($userslist, "
              <li><a href='?touser=".$chatlist['touser']."'>".$name['fname']." ".$name['lname']."</a><span id=read>(".$count.")</span></li>
            ");
            }
          }

          if($fromlistcount>0){
            foreach($fromlist as $chatlist){
              $user=$conn->query("SELECT `fname`, `lname` FROM `users` WHERE `username`='".$chatlist['fromuser']."'");

              $unread=$conn->query("SELECT COUNT(id) FROM `messages` WHERE `status`='unread' AND `fromuser`='".$chatlist['fromuser']."'");
              $name=mysqli_fetch_assoc($user);
              $unreadcount=mysqli_fetch_array($unread);
              $count=$unreadcount[0];

              array_push($userslist, "
              <li><a href='?touser=".$chatlist['fromuser']."'>".$name['fname']." ".$name['lname']."</a><span id=read>(".$count.")</span></li>
            ");
            }
          }

          foreach(array_unique($userslist) as $u){
            echo $u;
          }
          
        ?>

      </ul>
    </div>

    <div class="right">
        <?php
        if(isset($_GET['touser'])){
          $data=$conn->query("SELECT `fname`, `lname` FROM `users` WHERE `username`='".$_GET['touser']."'");
          $names=mysqli_fetch_assoc($data);
          echo "<h5>Chatting with (".$names['fname']. " " .$names['lname']. ")</h5>";
        ?>
    <hr/>
    <div class="chatbox">
      <div class="messages">
          <ul>

          </ul>
      </div>
      <div class="inputfields">

        <form>
          <input type="hidden" name="touser" value="<?php echo $_GET['touser'] ?>">
          <input type="text" id="message" name="message" placeholder="Enter your message!!"  autocomplete="off"/>
          <input type="submit" value="Send">

        </form>
      </div>
    </div>
    <?php
      }else{
        echo "<h5>Select user to whom you want to chat</h5>";
      }
    ?>
    </div>
  </div>

</section>


  <!-- jquery -->
  <script>
    const chatbox=document.querySelector(".messages ul");
    let start=0;
      $(function () {
        $('form').on('submit', function (value) {
          value.preventDefault();
          // ajax
          $.ajax({
            type: 'POST',
            url: 'getChat.php',
            data: $('form').serialize(),
            success: function () {
              // do update after message sent
              $('#message').val("");
              messagesent();
            }});
        });
      });

      messagesent();
      function messagesent(){
        let url="getChat.php?touser=<?php echo $_GET['touser']?>&start=";
        $.ajax({
          type: 'GET',
          url: url + start,
          dataType: 'json',
          success: function(result){
            if(result.items){
              result.items.forEach(item=>{
                start=item['id'];
                $(".messages ul").append(renderData(item));
              });
            }
          }
        });

      }
      setInterval(() => {
        messagesent();
      }, 1000);

      function renderData(item){
        const user="<?php echo $_SESSION['username'] ?>";
        if(item.fromuser == user ){

          chatbox.scrollIntoView(false,{behavior: "smooth"});
          msgRead(item.id, item.fromuser);
          return `
          <li class="fromuser">
            <div>
              <h6>
                ${item.fromuser}
              </h6>
              <span id="date">
                ${item.timestamp}
              </span>
            </div>

            <div>
              <p>
                ${item.message}
              </p>
            </div>
          </li>
        `;
        }else{
          chatbox.scrollIntoView(false,{behavior: "smooth"});
          msgRead(item.id, item.fromuser);
          return `
          <li class="touser">

            <div>
              <p>
                ${item.message}
              </p>
            </div>


            <div>
              <h6>
                ${item.fromuser}
              </h6>
              <span id="date">
                ${item.timestamp}
              </span>
            </div>


          </li>
        `;
        }

      }

      function msgRead(id, user){
        const url=`getChat.php?read=${id}&user=${user}`;
        $(function () {
          $.ajax({
            type: 'GET',
            url: url,
            success: function () {
              // do update after message sent
              // console.log("message read: "+id);
            }});
        });
      }
      
  </script>


</body>
</html>



<!-- <?php
if(isset($_GET['userid'])){
  $fromuser=$_SESSION['username'];
  $touser=$_GET['userid'];

  $sql1="SELECT id FROM `chatlist` WHERE (`fromuser`=
  '$fromuser') AND (`touser`='$touser')";
  $result1=$conn->query($sql1);
  $count=mysqli_num_rows($result1);  
  if($count>0){
    echo '
    <script>
      window.location.replace("chat.php?touser='.$touser.'");
    </script>
    ';
  }else{
    $sql2="INSERT INTO `chatlist` (`fromuser`, `touser`)
    VALUES ('$fromuser', '$touser')";
    $result2=$conn->query($sql2);
    if($result2){
      echo '
      <script>
        window.location.replace("chat.php?touser='.$touser.'");
      </script>
      ';
    }
  }
}

?> -->