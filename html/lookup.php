<?php

    if(!session_start()) {
        echo "ERROR";
        exit;
    }

	$username = empty($_SESSION['loggedin']) ? '' : $_SESSION['loggedin'];
	
	
	if (!$username) {
		header("Location: form.php");
		exit;
	}

    require("navbar.php");
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset = "utf-8">
    <title>Lookup Home</title>
    
    <!--make active tab on nav bar-->
    <script>
        var element = document.getElementById("lookuphome");
        element.classList.add("activeClass");
    </script>
    
    <link rel="stylesheet" type="text/css" href="lookup.css">
    <link rel="stylesheet" type="text/css" href="navbar.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <!--charts & maps javascript-->
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=final-274901" async="" defer="defer"></script>
            
    <!--javascript-->
    <script src="lookup.js"></script>

</head>
    
    
    
<body>
    
    <br>
    
<!--   something like this https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_search_menu -->
    <div class="Boxrow">
    
        <div class="Boxleft">

            <!--text-->
            <h2 align="center">Search for an information category!</h2>
            <h3 align="center">Click on a category to find data and download CSVs.</h3>

        </div>

    
          <div class="Boxright" style="background-color:#bbb;">
              
            <h2>Information Menu</h2>
              
            <input type="text" id="mySearch" onkeyup="myFunction()" placeholder="Search.." title="Type in a category">
              
            <ul id="myMenu">
              <li><a href="contact.php">Contacts</a></li>
              <li><a href="echo.php">ECHOs</a></li>
              <li><a href="organizations.php">Organizations</a></li>
              <li><a href="fqhc.php">FQHCs</a></li>
              <li><a href="MO_Counties.php">MO Counties</a></li>
              <li><a href="employees.php">Employees</a></li>
              <li><a href="outreach.php">Outreach</a></li>
            </ul>
              
          </div>
        
    </div>

    
    
<script>
    
    //function to search
    function myFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("mySearch");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myMenu");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
    
</script>
    
</body>
</html>
