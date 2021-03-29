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
  include 'components/header.php';
?> 
        <div class="addcouch">
            <h1>Add Couch Details</h1>
            <form action="">
                <label for="title">Title</label><input type="text" name="Text" placeholder="Write Title Here">
        
                <form action="">
                    <label for="description">Description:</label></br>
                    <textarea id="description" name="description" rows="4" cols="80" placeholder="Write Description About Your Couch"></textarea>
                
                    <input type="file" id="imageFile" name="imagefile">
                
                    <label for="Terms">Select Term:</label>
                      <select name="Select terms" id="Terms">
                        <option value="free">Free</option>
                        <option value="paid">Paid</option>
                        <option value="exchang">Exchange</option>
                      </select>
                     
                      <p>Map bnana h yha</p>

                      <input type="submit" value="Add Couch Details"/>
            </form>

    </div>
</body>
</html>