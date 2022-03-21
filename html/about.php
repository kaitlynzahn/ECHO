<?php
    require("homePageNavBar.php");
?>

<!DOCTYPE html>

<html lang="en">
    
<head>
    <meta charset = "utf-8">
    <title>About Page</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    
    <script>
        var element = document.getElementById("about");
        element.classList.add("activeClass");
    </script>
    
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="navbar.css">
    
    <style>
        #text{
            padding: 20px;
        }
        
        #myButton {
            border: none;
            color: white;
            background-color: #D79900;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
/*            margin: 4px 2px;*/
            margin-top: 15px;
            cursor: pointer;
        }
        
        .center {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        
    </style>
</head>
    
    
    
<body>
    
    <br>
    <h1 align="center">About Show Me ECHO</h1>
    
    <div class = center id="container">
        <div id="text">
            <p><br>"Show-Me ECHO (Extension for Community Healthcare Outcomes) uses videoconferencing technology to connect a team of interdisciplinary experts with primary care providers. The discussions with, and mentoring from, specialists help equip primary care providers to give their patients the right care, in the right place, at the right time.<br><br>Primary clinicians who participate in Show-Me ECHO collaborate with specialists in a case-based learning environment in order to develop advanced clinical skills and best practices. The ECHO sessions are approved for AMA PRA Category 1 Credit(s)™.<br><br><br>Show-Me ECHO is a state-funded telehealth project operated by the Missouri Telehealth Network at the University of Missouri School of Medicine. Show-Me ECHO began in 2015 and was created using a process developed by the University of New Mexico to educate and train participating providers in specific disease states or conditions.<br><br>Now, the University of New Mexico’s Project ECHO has designated Show-Me ECHO as a Super Hub training organization, one of only seven global sites. As a Super Hub, Show-Me ECHO provides immersion training for new ECHO expert panels and staff in Missouri and beyond.<br><br>The first Show-Me ECHO Immersion Training took place September 2016. The next training is to be determined. Attendance is dependent on preliminary information being provided."<br><br></p>
        </div>
          </div>
  
        
    <center><button id="myButton">Click here for the Official Page</button></center>
        
<!--        <img id="map" src="pic2.jpg" alt="Map">-->
    <br>
 
    <script type="text/javascript">
    document.getElementById("myButton").onclick = function () {
        window.open('https://showmeecho.org/', '_blank');
    };
    </script>
    
</body>
</html>