<?php
    require("homePageNavBar.php");
?>

<!DOCTYPE html>

<html lang="en">
    
<head>
    <meta charset = "utf-8">
    <title>Home Page</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    
    <script>
        var element = document.getElementById("home");
        element.classList.add("activeClass");
    </script>
    
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="navbar.css">
</head>
    
    
    
<body>
    
    <br>
    <h1 align="center">Welcome to ECHOing Around the World!</h1>
    <br>
    
    <div class="container">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
          
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            
          <div class="item active">
            <img src="graphic.png" alt="Los Angeles" style="width:100%; height: 500px;">
          </div>

          <div class="item">
            <img src="pic1.jpg" alt="Chicago" style="width:100%; height: 500px;">
          </div>

          <div class="item">
            <img src="dermEcho.jpg" alt="New york" style="width:100%; height: 500px;">
          </div>
            
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span> 
        </a>
          
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
          
      </div>
    </div>
    
    <br>
 
</body>
</html>
