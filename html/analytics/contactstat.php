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
      
      <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
      
     <!-- <script src="contactstat.js"></script> -->
    <!--make active tab on nav bar-->
    <script>
        var element = document.getElementById("stat");
        element.classList.add("activeClass");
    </script>
      
      <link rel="stylesheet" href="outreachstat.css">
      
  </head>

<body>

<h1>Contact Analytics</h1>
    
     <br>

    <div class="Top">
        
        <div class="TopLeft">
            <div class="Left">
                <p class="BigLetters" id="attendee"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters" style="margin-top: 40px">Total Contacts</p>
            </div>
        </div>

        <div class="TopMiddle">
            <div class="Left">
                <p class="BigLetters" id="facilitator"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters" style="margin-top: 40px">Total Attendees</p>
            </div>
        </div>

        <div class="TopRight">
            <div class="Left">
                <p class="BigLetters" id="staff"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters1" style="margin-top: 40px">Contacts Attending</p>
            </div>
        </div>

    </div>
    
    <div class="Boxrow">
        <div class="BoxLeft">
            <!-- Map of contacts by county in missouri -->
            <h3>Contacts By County Location In Missouri</h3>
            <div style="padding:10 width: 700px; height: 500px;" id="county_div"></div>
            
            <!-- Map of contacts organization location -->
            <h3>Contacts By State Excluding Missouri</h3>
            <div style="padding:10 width: 700px; height: 500px;" id="regions_div"></div>
            
        </div>
        
        <div class="Boxright">
            <!--Top 10 Organizations By Amount of Contacts -->
            <div id="topOrgCount" class="graphdiv" style="height: 600px; width: 100%;"></div>
            
            <!-- top ten credentials -->
            <div id="piechartcred"></div>
            
            <!-- look up credentials of a Person -->
            <form action="" method="post">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Look Up Credentials By Name</label>
                  <input type="text" class="form-control" name="full_name" placeholder="Enter a Name" required>
                </div>
                </div>
                <button type="submit" name="search_person" id="person_btn" class="btn btn-primary" >Search</button>
                <?php
                if(isset($_POST['search_person'])){ 
                     $full_name = $_POST['full_name'];

                    $query="SELECT full_name, o.name, UPPER(credential_name) AS Credential
                            FROM contact c FULL OUTER JOIN has_credential h ON h.id=c.id, Organizations o
                            WHERE o.name=c.health_center_name AND o.streetaddress=c.street_address AND h.credential_name!='None' AND LOWER(c.full_name)~LOWER('$full_name')";
                    $result=pg_query($connString, $query);
                    $credential_arr=[];
                    while($row = pg_fetch_row($result)){
                        $name=$row[0];
                        $org=$row[1];
                        $cred=$row[2];
                        $credential_arr[]=array($name, $org, $cred);
                    }
                    echo "<table>";
                    echo "<tr><th>Name</th><th>Organization</th><th>Credential</th></tr>";
                    foreach($credential_arr as $c){
                        echo "<tr><td>".$c[0]. "</td><td>".$c[1]."</td><td>".$c[2]."</td></tr>";
                    }
                    echo "</table>";
                }
                ?>
            </form>
        </div>
    </div>
    
</body>
    
    
    
<!--Top 10 Orgs By Contact Count   -->
     <?php
            $query =    "select count(*) as count,health_center_name from contact where health_center_name != 'None' group by health_center_name order by count DESC limit 10;";
            $result = pg_query($connString, $query);
            $org_count_arr=array();
    
            while ($row = pg_fetch_row($result)) {
                $org_name=$row[1];
                $count=$row[0];
                $org_count_arr[]=array("label"=> $org_name, "y"=> $count);
            }
    
    ?>
    
<script>
     window.onload = function () {
        //Top 10 People That Presented Cases
         var chart = new CanvasJS.Chart("topOrgCount", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Top Organizations By Amount of Contacts",
                fontSize: 20
            },
            axisY: {
                title: "Number of Contacts",
                includeZero: false
            },
            axisX: {
                labelFontSize: 8.4
            },
            data: [{
                type: "column",
                color: "#D4AC0D",
                dataPoints: <?php echo json_encode($org_count_arr, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
            }
    
    <?php
        $query1 = "SELECT COUNT(*) FROM contact";
        $result1=pg_query($connString, $query1);
                while($row = pg_fetch_array($result1)){
                    $total1 = $row['count'];
                } 
    ?>
    var testing1= <?php echo json_encode($total1); ?>;
        document.getElementById("attendee").innerHTML = testing1;
   
    <?php
        $query2 = "SELECT COUNT(*) FROM has_type WHERE type='Attendee'";
        $result2 =pg_query($connString, $query2);
                while($row = pg_fetch_array($result2)){
                    $total2 = $row['count'];
                } 
    ?>
    var testing2= <?php echo json_encode($total2); ?>;
        document.getElementById("facilitator").innerHTML = testing2;
    
    
                   
        var testing3 = Math.round((testing2/testing1) * 100);
        document.getElementById("staff").innerHTML = testing3 + "%";
    
    
    google.charts.load('current', {
            'packages':['geochart'], 
            // Note: you will need to get a mapsApiKey for your project.
            // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
            'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
    });
         
         
         
//State Map
google.charts.setOnLoadCallback(drawRegionsMap);
    function drawRegionsMap() {
        <?php
            $query = "SELECT state, count(*)
                      FROM contact c, organizations o
                      WHERE  o.name=c.health_center_name AND o.streetaddress=c.street_address AND LENGTH(state)<3 AND LENGTH(state)>0
                      GROUP BY o.state";
            $result = pg_query($connString, $query);
            $state_arr=array();
            $state_arr[0]=array("State", "Count");
            while ($row = pg_fetch_row($result)) {
                $state=$row[0];
                $count=$row[1];
                $state_arr[]=array($state, $count);
            }
        ?>
        var stateArray=<?php echo json_encode($state_arr); ?>;
        for(var i=1; i<stateArray.length; i++){
            stateArray[i][1]=parseInt(stateArray[i][1]);
            if(stateArray[i][0]=="MO")
                stateArray[i][1]=null;
        }
        
        var data = google.visualization.arrayToDataTable(stateArray);
          

        var options = {
            resolution: 'provinces',
            region: 'US',
            defaultColor: '#f5f5f5',
            colors: ['#f5f5f5','#D4AC0D']
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }

         
         
//Missouri County Map
    <?php
            $query =    "SELECT o.county, cd.fips, count(*)
                        FROM countydata cd LEFT JOIN organizations o ON  cd.county=o.county AND o.state='MO' LEFT JOIN contact c ON
                        o.name=c.health_center_name AND o.streetaddress=c.street_address
                        GROUP BY o.county, fips";
            $result = pg_query($connString, $query);
            $county_arr=array();
    
            while ($row = pg_fetch_row($result)) {
                $county=$row[0];
                $fips=$row[1];
                $count=$row[2];
                $county_arr[]=array($county, $fips, $count);
            }
        ?>
        var countyArray=<?php echo json_encode($county_arr); ?>;
        var total;
        var max=0
        var maxColor="#D4AC0D"
        
        for(var i=0; i<countyArray.length; i++){
            countyArray[i][2]=parseInt(countyArray[i][2]);
            total=total+countyArray[i][1];
            if(countyArray[i][2]>max){
                max=countyArray[i][2];
            }
        }
        var newCountyArray=[];
        for(var i=0; i<countyArray.length; i++){
            var obj={name: countyArray[i][0], id: countyArray[i][1], STATE: "MO", TYPE: "County", CNTRY: "USA", value: countyArray[i][2]}
            newCountyArray[i]=obj;
        }
    countyJSON=JSON.stringify(newCountyArray);
    //console.log(countyJSON);
        
     // Create map instance
    var chart = am4core.create("county_div", am4maps.MapChart);

    // Set map definition
    chart.geodata = am4geodata_region_usa_moLow;

    // Set projection
    chart.projection = new am4maps.projections.Miller();
    chart.maxZoomLevel = 1;

    // Create map polygon series
    var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
     polygonSeries.data=JSON.parse(countyJSON);

    // Make map load polygon (like country names) data from GeoJSON
    polygonSeries.useGeodata = true;
    
    polygonSeries.heatRules.push({
        "property": "fill",
        "target": polygonSeries.mapPolygons.template,
        "min": am4core.color("#E0E0E0"),
        "max": am4core.color(maxColor)
    });
    // Configure series
    var polygonTemplate = polygonSeries.mapPolygons.template;
    polygonTemplate.tooltipText = "{name} \nCount: {value}";
    polygonTemplate.fill = am4core.color("#F4D03F");

    // Create hover state and set alternative fill color
//    var hs = polygonTemplate.states.create("hover");
//    hs.properties.fill = am4core.color("#367B25");   
    
    //county pie chart
    
    
         
//top credentials chart
     google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        <?php
                $query="SELECT UPPER(credential_name) AS Credential, COUNT(*)
                        FROM contact c FULL OUTER JOIN has_credential h ON h.id=c.id, Organizations o
                        WHERE o.name=c.health_center_name AND o.streetaddress=c.street_address AND h.credential_name!='None'
                        GROUP BY UPPER(credential_name)
                        ORDER BY COUNT(*) DESC
                        LIMIT 10";
                $result=pg_query($connString, $query);
                $count_cred_arr=[];
                $county_cred_arr[0]=array("County", "Count");
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
        
        var options = {'title':'Top 10 Credentials In Contacts',
                       'width': 500,
                       'height': 400,
                      'legend': { position: "none" },
                      'colors': ['black']};
        
        var chart = new google.visualization.ColumnChart(document.getElementById('piechartcred'));
        chart.draw(data, options);
        
    }

</script>
<style>
    .Boxleft {
        flex: 45%;
        padding: 15px 0;
        width: 45%;
    }
    .Boxright {
        flex: 45%;
        padding: 15px;
        width: 45%;
/*    background-color: white;*/
    }
    /* Create a column layout with Flexbox */
    .Boxrow {
        display: flex;
        /*    border: 10px solid black;*/
        padding: 20px;
    }
    .Boxleft h2 {
        padding-left: 8px;
    }
    #county_btn{
        background-color:#F0B73E;
        border-color: #F0B73E;
    }
    #county_btn:hover{
        background-color: #F0B73E;
    }
    #person_btn{
        background-color:#F0B73E;
        border-color: #F0B73E;
    }
    #person_btn:hover{
        background-color: #F0B73E;
    }
    table, th, td {
        border: 1px solid black;
        padding: 5px;
    }
    table{
        margin-top: 10px;
    }
    

</style>

</html>