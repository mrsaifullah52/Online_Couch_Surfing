<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Couches</title>
  <link rel="stylesheet" href="resource/styling/style1.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<body>

<?php
  include 'components/header.php';
?> 

  <form action="search">  
      <div class="boxcontainer">
        <div class="elementcontainer" >
          <input type="text" placeholder="You Can Search Here." name="search" class="search"></td>
          <span class="material-icons md-48">search</span>
        </div>

        <a href="addcouch.php">Add Couch</a>
      </div>
  </form>

  <div class="couches">
    <div class="list">
      <h5>My Ads</h5>
      <ul>
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
        <li>
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
        </li>
      </ul>
    </div>
  </div>
  
</body>
</html>