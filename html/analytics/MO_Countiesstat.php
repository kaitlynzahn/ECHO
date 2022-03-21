<?php
require("../navbar2.php");
require("../connection.php");


use dbObj;
$db = new dbObj();
$connString =  $db->getConnstring();

$sql = "SELECT county FROM countydata EXCEPT SELECT cd.county FROM countydata cd, organizations o, contact c, attends a WHERE cd.county = o.county AND o.name=c.health_center_name AND o.streetaddress=c.street_address AND c.id=a.id";

$queryRecords = pg_query($connString, $sql) or die("error to fetch county data");
$data = pg_fetch_all($queryRecords);

?>



<!doctype html>
<html lang="en">
  <head>
    <title>Contact Analytics</title>
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

    <h1>Missouri County Analytics</h1>
    
    <div class="Top">
        
        <div class="TopLeft">
            <div class="Left">
                <p class="BigLetters" id="countiesinMO"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters">Counties in Missouri</p>
            </div>
        </div>

        <div class="TopMiddle">
            <div class="Left">
                <p class="BigLetters" id="numParticipate"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters">Counties with Attendees</p>
            </div>
        </div>

        <div class="TopRight">
            <div class="Left">
                <p style="font-weight:bold; margin-top:5px;font-size:30px" class="LittleLetters">
                <?php foreach($data as $key => $item) :?>
                    <tr>
                        <td><?php echo $item['county'] ?></td>
                        <br>
                    </tr>
                <?php endforeach;?>
                </p>
            </div>
            <div class="Right">
                <p class="LittleLetters1">Counties without Attendees</p>
            </div>
        </div>

    </div>
    <div class="Bottom">
        <div class="Left1">
            <div id="barchart1">
            </div>
            <div id="barchart3">
            </div>
        </div>

        <div class="Right1">
            <div id="barchart2">
            </div>
            <div id="barchart4">
            </div>
        </div>
    </div>
    
<!--
    <div class="Boxrow">
    </div>
-->
    
</body>
    
    <script>
        
         <?php
        $query = "SELECT COUNT(*) FROM countydata";
        $result=pg_query($connString, $query);
                while($row = pg_fetch_array($result)){
                    $total = $row['count'];
                } 
        ?>
        var testing= <?php echo json_encode($total); ?>;
        document.getElementById("countiesinMO").innerHTML = testing;
        
        <?php
        $query = "SELECT COUNT(DISTINCT cd.county) FROM countydata cd, organizations o, contact c, attends a WHERE cd.county = o.county AND o.name=c.health_center_name AND o.streetaddress=c.street_address AND c.id=a.id";
        $result=pg_query($connString, $query);
                while($row = pg_fetch_array($result)){
                    $total = $row['count'];
                } 
        ?>
        var testing= <?php echo json_encode($total); ?>;
        document.getElementById("numParticipate").innerHTML = testing;
   
        
        
        
        
        google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);
        google.charts.setOnLoadCallback(drawChart3);
        google.charts.setOnLoadCallback(drawChart4);
        
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        <?php
                    $query="SELECT A.county, 100.0*B.countAttendees/A.totalpop2010 AS Percent
                            FROM 
                            (SELECT county, totalpop2010
                            FROM countydata
                            ORDER BY totalpop2010 DESC) A
                            JOIN
                            (SELECT cd.county, count(DISTINCT(at.id)) AS countAttendees 
                            FROM countydata cd
                            LEFT JOIN organizations o ON cd.county=o.county
                            LEFT JOIN contact c ON  o.name=c.health_center_name AND o.streetaddress=c.street_address
                            LEFT JOIN attendee at ON at.id=c.id
                            LEFT JOIN attends a ON a.id=at.id
                            GROUP BY cd.county 
                            ORDER BY count(DISTINCT(at.id)) DESC) B ON A.county=B.county
                            ORDER BY Percent DESC LIMIT 15";
//                $query="SELECT cd.county, count(DISTINCT(c.id)) AS Number_Of_People FROM attends a, attendee at, contact c, organizations o, countydata cd WHERE a.id=at.id AND c.id=at.id AND o.name=c.health_center_name AND o.streetaddress=c.street_address AND cd.county = o.county GROUP BY cd.county ORDER BY count(DISTINCT(c.id)) DESC LIMIT 20;";
                $result=pg_query($connString, $query);
                $count_cred_arr=[];
                $county_cred_arr[0]=array("County", "Percent");
                while($row = pg_fetch_row($result)){
                    $cred=$row[0];
                    $count=$row[1];
                    $county_cred_arr[]=array($cred, $count);
                }

        ?>
        var credArray=<?php echo json_encode($county_cred_arr); ?>;
        for(var i=1; i<credArray.length; i++){
            credArray[i][1]=parseFloat(credArray[i][1]);
        }
        
        console.log(credArray);
        var data = google.visualization.arrayToDataTable(credArray);
        var options = {'title':'Percent of Population With Attendees By County (Top 15)',
                       hAxis : { textStyle : {fontSize: 8} },
//                       width: 1000,
                       'height': 800,
                      'legend': { position: "none" },
                      'colors': [ '#D79900']};
        
        var chart = new google.visualization.ColumnChart(document.getElementById('barchart1'));
        chart.draw(data, options);
    }
        
        function drawChart2() {

        <?php
                $query="SELECT A.county, A.pctpoort, A.pctuninsured, A.pctrural, 100.0*B.countAttendees/A.totalpop2010 AS Percent
                            FROM 
                            (SELECT county, pctpoort, pctuninsured, pctrural, totalpop2010
                            FROM countydata
                            ORDER BY totalpop2010 DESC) A
                            JOIN
                            (SELECT cd.county, count(DISTINCT(at.id)) AS countAttendees 
                            FROM countydata cd
                            LEFT JOIN organizations o ON cd.county=o.county
                            LEFT JOIN contact c ON  o.name=c.health_center_name AND o.streetaddress=c.street_address
                            LEFT JOIN attendee at ON at.id=c.id
                            LEFT JOIN attends a ON a.id=at.id
                            GROUP BY cd.county 
                            ORDER BY count(DISTINCT(at.id)) DESC) B ON A.county=B.county
                            ORDER BY Percent DESC LIMIT 15";
//                $query="SELECT cd.county, cd.pctpoort, cd.pctuninsured, cd.pctrural FROM attends a, attendee at, contact c, organizations o, countydata cd WHERE a.id=at.id AND c.id=at.id AND o.name=c.health_center_name AND o.streetaddress=c.street_address AND cd.county = o.county GROUP BY cd.county ORDER BY count(DISTINCT(c.id)) DESC LIMIT 20;";
                $result=pg_query($connString, $query);
                $count_cred_arr=[];
                $county_data_arr[0]=array("County", "% Poor", "% Uninsured", "% Rural");
                while($row = pg_fetch_row($result)){
                    $county=$row[0];
                    $poor=$row[1];
                    $uninsured=$row[2];
                    $rural=$row[3];
                    $county_data_arr[]=array($county, $poor, $uninsured, $rural);
                }

        ?>
        var credArray=<?php echo json_encode($county_data_arr); ?>;
        for(var i=1; i<credArray.length; i++){
            credArray[i][1]=parseInt(credArray[i][1]);
            credArray[i][2]=parseInt(credArray[i][2]);
            credArray[i][3]=parseInt(credArray[i][3]);
        }
        
        console.log(credArray);
        var data = google.visualization.arrayToDataTable(credArray);
        
        var options = {'title':'Top 15 Counties Data',
//                       'width': 1000,
                       'height': 800,
                       'legend': {position: 'bottom'},
                       hAxis : { textStyle : {fontSize: 10 } },
//                      'legend': { position: "none" },
                      'colors': [ '#FBD986', '#D79900', '#AF7C00']
                      };
        
        var chart = new google.visualization.ColumnChart(document.getElementById('barchart2'));
        chart.draw(data, options);
    }
    
        function drawChart3() {

        <?php
                    $query="SELECT A.county, 100.0*B.countAttendees/A.totalpop2010 AS Percent
                            FROM 
                            (SELECT county, totalpop2010
                            FROM countydata
                            ORDER BY totalpop2010 DESC) A
                            JOIN
                            (SELECT cd.county, count(DISTINCT(at.id)) AS countAttendees 
                            FROM countydata cd
                            LEFT JOIN organizations o ON cd.county=o.county
                            LEFT JOIN contact c ON  o.name=c.health_center_name AND o.streetaddress=c.street_address
                            LEFT JOIN attendee at ON at.id=c.id
                            LEFT JOIN attends a ON a.id=at.id
                            GROUP BY cd.county 
                            ORDER BY count(DISTINCT(at.id)) DESC) B ON A.county=B.county
                            ORDER BY Percent ASC LIMIT 15";
//                $query="SELECT cd.county, count(DISTINCT(c.id)) AS Number_Of_People FROM attends a, attendee at, contact c, organizations o, countydata cd WHERE a.id=at.id AND c.id=at.id AND o.name=c.health_center_name AND o.streetaddress=c.street_address AND cd.county = o.county GROUP BY cd.county ORDER BY count(DISTINCT(c.id)) ASC LIMIT 20;";
                $result=pg_query($connString, $query);
                $count_cred_arr=[];
                $county_cred_arr2[0]=array("County", "Percent");
                while($row = pg_fetch_row($result)){
                    $cred=$row[0];
                    $count=$row[1];
                    $county_cred_arr2[]=array($cred, $count);
                }

        ?>
        var credArray2=<?php echo json_encode($county_cred_arr2); ?>;
        for(var i=1; i<credArray2.length; i++){
            credArray2[i][1]=parseFloat(credArray2[i][1]);
        }
        
        console.log(credArray2);
        var data2 = google.visualization.arrayToDataTable(credArray2);
        
        var options = {'title':'Percent of Population With Attendees By County (Bottom 15)',
//                       'width': 1000,
                       'height': 800,
                      'legend': { position: "none" },
                       hAxis : { textStyle : {fontSize: 8 } },
                      'colors': [ '#D79900']};
        
        var chart2 = new google.visualization.ColumnChart(document.getElementById('barchart3'));
        chart2.draw(data2, options);
    }
        
        function drawChart4() {

        <?php
                $query="SELECT A.county, A.pctpoort, A.pctuninsured, A.pctrural, 100.0*B.countAttendees/A.totalpop2010 AS Percent
                            FROM 
                            (SELECT county, pctpoort, pctuninsured, pctrural, totalpop2010
                            FROM countydata
                            ORDER BY totalpop2010 DESC) A
                            JOIN
                            (SELECT cd.county, count(DISTINCT(at.id)) AS countAttendees 
                            FROM countydata cd
                            LEFT JOIN organizations o ON cd.county=o.county
                            LEFT JOIN contact c ON  o.name=c.health_center_name AND o.streetaddress=c.street_address
                            LEFT JOIN attendee at ON at.id=c.id
                            LEFT JOIN attends a ON a.id=at.id
                            GROUP BY cd.county 
                            ORDER BY count(DISTINCT(at.id)) DESC) B ON A.county=B.county
                            ORDER BY Percent ASC LIMIT 15";
//                $query="SELECT cd.county, cd.pctpoort, cd.pctuninsured, cd.pctrural FROM attends a, attendee at, contact c, organizations o, countydata cd WHERE a.id=at.id AND c.id=at.id AND o.name=c.health_center_name AND o.streetaddress=c.street_address AND cd.county = o.county GROUP BY cd.county ORDER BY count(DISTINCT(c.id)) ASC LIMIT 20;";
                $result=pg_query($connString, $query);
                $count_cred_arr=[];
                $county_data_arr4[0]=array("County", "% Poor", "% Uninsured", "% Rural");
                while($row = pg_fetch_row($result)){
                    $county=$row[0];
                    $poor=$row[1];
                    $uninsured=$row[2];
                    $rural=$row[3];
                    $county_data_arr4[]=array($county, $poor, $uninsured, $rural);
                }

        ?>
        var credArray4=<?php echo json_encode($county_data_arr4); ?>;
        for(var i=1; i<credArray4.length; i++){
            credArray4[i][1]=parseInt(credArray4[i][1]);
            credArray4[i][2]=parseInt(credArray4[i][2]);
            credArray4[i][3]=parseInt(credArray4[i][3]);
        }
        
        console.log(credArray4);
        var data4 = google.visualization.arrayToDataTable(credArray4);
        
        var options4 = {'title':'Bottom 15 Counties Data',
//                       'width': 1000,
                       'height': 800,
                        hAxis : { textStyle : {fontSize: 10 } },
                      'legend': { position: "bottom" },
                      'colors': [ '#FBD986', '#D79900', '#AF7C00']};
        
        var chart4 = new google.visualization.ColumnChart(document.getElementById('barchart4'));
        chart4.draw(data4, options4);
    }
    
    </script>
        
</html>