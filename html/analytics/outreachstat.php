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
    <title>Outreach Analytics</title>
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

    <h1>Outreach Analytics</h1>
    <br>

    <div class="Top">
        
        <div class="TopLeft">
            <div class="Left">
                <p class="BigLetters" id="avgAttendees"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters">average event attendees at outreach events</p>
            </div>
        </div>

        <div class="TopMiddle">
            <div class="Left">
                <p class="BigLetters" id="avgTouches"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters">average touches at outreach events</p>
            </div>
        </div>

        <div class="TopRight">
            <div class="Left">
                <p class="BigLetters" id="percent"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters1">average touch to event attendee ratio</p>
            </div>
        </div>

    </div>

    <div class="Bottom">
        <div id="barChart">
        </div>

        <div id="pieChart">
        </div>
    </div>

    
    
    
    <script>

        //queries to pull up data- average attendance, average touches, ratio
        <?php
                $query="SELECT round(avg(attendees))
                        FROM outreach_events";
    
                $result=pg_query($connString, $query);
                while($row = pg_fetch_array($result)){
                    $total = $row['round'];
                }

        ?>
        var testing= <?php echo json_encode($total); ?>;
        document.getElementById("avgAttendees").innerHTML = testing;

    
    
        <?php
                $query="SELECT round(avg(touches))
                        FROM outreach_events";
    
                $result=pg_query($connString, $query);
                while($row = pg_fetch_array($result)){
                    $total = $row['round'];
                }

        ?>
        var testing= <?php echo json_encode($total); ?>;
        document.getElementById("avgTouches").innerHTML = testing;
    
    
        <?php
                $query="SELECT round(((avg(touches) / avg(attendees)) *100)) AS rate
                        FROM outreach_events";
    
                $result=pg_query($connString, $query);
                while($row = pg_fetch_array($result)){
                    $total = $row['rate'];
                }
 
        ?>
        var testing= <?php echo json_encode($total); ?>;
        document.getElementById("percent").innerHTML = testing + "%";
    </script>
    
    
    
    <script>
        
        //load barchart for events with the most attendees
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);


        function drawChart() {

        <?php
                $query="SELECT event_name, attendees
                        FROM outreach_events 
                        WHERE attendees < 1099
                        ORDER BY attendees DESC
                        LIMIT 20;";
            
                $result=pg_query($connString, $query);
                $count_cred_arr=[];
                $county_cred_arr[0]=array("Event", "Count");
            
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
        
        var options = {'title':'Top 20 Events with the Most Attendees',
                    'height': 600,
                    'legend': { position: "none" },
                    'colors': [ '#D79900']};
        
        var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
        chart.draw(data, options);
    }
    
    
    </script>

    
    
    <script>

        google.charts.load('current', {'packages':['corechart']});

          google.charts.setOnLoadCallback(drawChart1);

          function drawChart1() {

            <?php
                    $query1="SELECT who_exhibiting, count(*)
                            FROM outreach_events
                            WHERE who_exhibiting != 'None'
                            GROUP BY who_exhibiting
                            ORDER BY count(*) DESC
                            LIMIT 10";
              
                    $result1=pg_query($connString, $query1);
                    $count_cred_arr1=[];
                    $county_cred_arr1[0]=array("Coordinator", "Count");
                    while($row1 = pg_fetch_row($result1)){
                        $cred1=$row1[0];
                        $count1=$row1[1];
                        $county_cred_arr1[]=array($cred1, $count1);
                    }

            ?>
              
            var credArray1=<?php echo json_encode($county_cred_arr1); ?>;
            for(var i=1; i<credArray1.length; i++){
                credArray1[i][1]=parseInt(credArray1[i][1]);
            }

            console.log(credArray1);
            var data = google.visualization.arrayToDataTable(credArray1);

            var options = {'title':'Coordinators who Presented the Most Outreach Events',
                           'height': 400,
                          'legend': { position: "none" },
                          'colors': ['#F1B82D', '#D79900', '#F4D03F']};

            var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
            chart.draw(data, options);
        }
    
    
</script>


</body>
</html>