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

require("../navbar2.php");
require("../connection.php");


use dbObj;
$db = new dbObj();
$connString =  $db->getConnstring();

?>



<!doctype html>
<html lang="en">
  <head>
    <title>Organization Analytics</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../bootstrapStyle.css">
    <link rel="stylesheet" type="text/css" href="../navbar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      
    <!--charts & maps javascript-->
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=final-274901" async="" defer="defer"></script>
      
      <!-- County Map -->
      <script src="https://www.amcharts.com/lib/4/core.js"></script>
      <script src="https://www.amcharts.com/lib/4/maps.js"></script>
      <script src="https://www.amcharts.com/lib/4/geodata/region/usa/moLow.js"></script>
      
     <!-- <script src="contactstat.js"></script> -->
    <!--make active tab on nav bar-->
    <script>
        var element = document.getElementById("stat");
        element.classList.add("activeClass");
    </script>
      
      <link rel="stylesheet" href="outreachstat.css">
      
  </head>

<body>

    <h1>Organization Analytics</h1>
    
        <div class="Top">
        
        <div class="TopLeft">
            <div class="Left">
                <p class="BigLetters" id="totalorgs"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters">Total Organizations</p>
            </div>
        </div>

        <div class="TopMiddle">
            <div class="Left">
                <p class="BigLetters" id="orgsattend"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters">Organizations with Attendees</p>
            </div>
        </div>

        <div class="TopRight">
            <div class="Left">
                <p class="BigLetters" id="attending"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters1" style="margin-top: 30px">Organizations Participating</p>
            </div>
        </div>

    </div>
    
    <div id="barchart1">
    </div>
    
    <div id="barchart2">
    </div>
    
</body>
    
    <script>
        <?php
        $query = "SELECT COUNT(*) AS Total FROM Organizations";
        $result=pg_query($connString, $query);
                while($row = pg_fetch_array($result)){
                    $total = $row['total'];
                } 
    ?>
    var testing= <?php echo json_encode($total); ?>;
        document.getElementById("totalorgs").innerHTML = testing;
   
        
         <?php
        $query = "SELECT COUNT(DISTINCT(o.name, o.streetaddress)) FROM Organizations o, contact c, attends a WHERE o.name=c.health_center_name AND o.streetaddress=c.street_address AND c.id=a.id";
        $result=pg_query($connString, $query);
                while($row = pg_fetch_array($result)){
                    $total = $row['count'];
                } 
    ?>
    var testing2= <?php echo json_encode($total); ?>;
        document.getElementById("orgsattend").innerHTML = testing2;
        
        var attending = Math.round((testing2/testing) * 100);
        document.getElementById("attending").innerHTML = attending + "%";
    
        google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        <?php
                $query="SELECT  o.name, COUNT(*) FROM Organizations o, contact c WHERE o.name = c.health_center_name AND o.streetaddress = c.street_address AND o.name != 'None' GROUP BY o.name ORDER BY COUNT(*) DESC LIMIT 20;";
                $result=pg_query($connString, $query);
                $count_cred_arr=[];
                $county_cred_arr[0]=array("Name", "Count");
                while($row = pg_fetch_row($result)){
                    $cred=$row[0];
                    $count=$row[1];
                    $county_cred_arr[]=array($cred, $count);
                }

        ?>
        var credArray=<?php echo json_encode($county_cred_arr); ?>;
        for(var i=1; i<credArray.length; i++){
            credArray[i][1]=parseInt(credArray[i][1]);
        }
        
        console.log(credArray);
        var data = google.visualization.arrayToDataTable(credArray);
        
        var options = {'title':'Contacts per Organization (Top 20)',
//                       'width': 1000,
                       'height': 800,
                      'legend': { position: "none" },
                      'colors': [ '#D79900']};
        
        var chart = new google.visualization.ColumnChart(document.getElementById('barchart1'));
        chart.draw(data, options);
    }
        
         function drawChart2() {

        <?php
                $query2="SELECT  o.name, COUNT(*) FROM sessions, organizations o WHERE o.name = clinic_location GROUP BY o.name ORDER BY count DESC LIMIT 20;";
                $result2=pg_query($connString, $query2);
                $count_cred_arr=[];
                $county_cred_arr2[0]=array("Name", "Count");
                while($row = pg_fetch_row($result2)){
                    $cred=$row[0];
                    $count=$row[1];
                    $county_cred_arr2[]=array($cred, $count);
                }

        ?>
        var credArray2=<?php echo json_encode($county_cred_arr2); ?>;
        for(var i=1; i<credArray2.length; i++){
            credArray2[i][1]=parseInt(credArray2[i][1]);
        }
        
        console.log(credArray2);
        var data2 = google.visualization.arrayToDataTable(credArray2);
        
        var options2 = {'title':'Top 20 Hosting Session Locations',
//                       'width': 1000,
                       'height': 800,
                      'legend': { position: "none" },
                      'colors': [ '#D79900']};
        
        var chart = new google.visualization.ColumnChart(document.getElementById('barchart2'));
        chart.draw(data2, options2);
    }
        
    </script>

        
</html>