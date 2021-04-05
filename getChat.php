<?php
include 'config/db.php';
session_start();

// getting values from POST method
$messageP = isset($_POST['message']) ? $_POST['message'] : null;
$fromuserP = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$touserP = isset($_POST['touser']) ? $_POST['touser'] : null;

if(!empty($_POST['message']) && !empty($_SESSION['username']) && !empty($_POST['touser']) ){
  $sqlP="INSERT INTO `messages`(`fromuser`, `touser`, `message`) VALUES  ('$fromuserP', '$touserP', '$messageP')";
  if($conn->query($sqlP)===true){
    echo "message sent!";
  }
}

// throwing data
$fromuserG=$_SESSION['username'];
$touserG=$_GET['touser'];
$start=$_GET['start'];

$sqlG="SELECT * FROM `messages` WHERE ( `fromuser`='$fromuserG' AND `touser`='$touserG' AND `id` > $start)  
      OR  ( `touser`='$fromuserG' AND `fromuser`='$touserG' AND `id` > $start)";
$result=$conn->query($sqlG);
while($row=mysqli_fetch_array($result)){
  $data['items'][]=$row;
}

echo json_encode($data);

if(isset($_GET['read'])  && $_GET['user']){
  if($_SESSION['username'] != $_GET['user']){
    $id=$_GET['read'];
    $conn->query("UPDATE `messages` SET `status`='read' WHERE `id`='$id' ");
  }
}

?>