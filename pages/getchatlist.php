<?php

include '../config/db.php';
session_start();


$sql="SELECT `touser`, `fromuser` FROM `chatlist` WHERE (`fromuser`='".$_SESSION['username']."') OR
(`touser`='".$_SESSION['username']."')";
$list = $conn->query($sql);

$listcount=mysqli_num_rows($list);
if($listcount>0){
  foreach($list as $chatlist){
    if($_SESSION['username'] != $chatlist['touser']){
      $user=$conn->query("SELECT `fname`, `lname` FROM `users` WHERE `username`='".$chatlist['touser']."'");
      $name=mysqli_fetch_assoc($user);
      
      echo "
        <li><a href='?touser=".$chatlist['touser']."'>".$name['fname']." ".$name['lname']."</a></li>
      ";
    }
  }
}else{
  echo "No History found!!";
}

?>












$sql="SELECT `touser`, `fromuser` FROM `chatlist` WHERE (`fromuser`='".$_SESSION['username']."') OR
          (`touser`='".$_SESSION['username']."')";
          $list = $conn->query($sql);

          $listcount=mysqli_num_rows($list);
          if($listcount>0){
            foreach($list as $chatlist){
              $status=true;
              $listofchats=array();
              if($_SESSION['username'] == $chatlist['touser']){
                if($status){
                  $user=$conn->query("SELECT `fname`, `lname` FROM `users` WHERE `username`='".$chatlist['fromuser']."'");
                  $name=mysqli_fetch_assoc($user);
                  
                  array_push($listofchats, $chatlist['fromuser']);

                  echo "
                    <li><a href='?touser=".$chatlist['touser']."'>".$name['fname']." ".$name['lname']."</a></li>
                  ";
                  $status=false;
                }
              }else{
                $user=$conn->query("SELECT `fname`, `lname` FROM `users` WHERE `username`='".$chatlist['touser']."'");
                $name=mysqli_fetch_assoc($user);
                
                echo "
                  <li><a href='?touser=".$chatlist['touser']."'>".$name['fname']." ".$name['lname']."</a></li>
                ";
              }
            }
          }else{
            echo "No History found!!";
          }