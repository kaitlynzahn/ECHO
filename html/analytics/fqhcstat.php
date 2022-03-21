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
    <title>FQHC Analytics</title>
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
      
    <!--make active tab on nav bar-->
    <script>
        var element = document.getElementById("stat");
        element.classList.add("activeClass");
    </script>
      
      <link rel="stylesheet" href="outreachstat.css">
  </head>

<body>
    
    <h1>FQHC Analytics</h1>
    
    <br>

    <div class="Top">
        
        <div class="TopLeft">
            <div class="Left">
                <p class="BigLetters" id="fqhcsinMO"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters">FQHCs in Missouri</p>
            </div>
        </div>

        <div class="TopMiddle">
            <div class="Left">
                <p class="BigLetters" id="numParticipate"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters" style="margin-top: 20px">Number of FQHCs Participating in Show-Me ECHO</p>
            </div>
        </div>

        <div class="TopRight">
            <div class="Left">
                <p class="BigLetters" id="notAttend"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters1" style="margin-top: 40px">FQHCs Participating</p>
            </div>
        </div>

    </div>
    <div id="barchart1" style="margin-bottom:50px"></div>
    <center><h3>Percent of FQHC that Participate in Each County</h3></center>
    <div style="padding:10 width: 700px; height: 500px;" id="county_div"></div>
    

    
<script>
    
    //queries for top data bar
    
    <?php
        $query = "SELECT COUNT(*) AS Total FROM OrgsMO WHERE fqhc='true'";
        $result=pg_query($connString, $query);
                while($row = pg_fetch_array($result)){
                    $total = $row['total'];
                } 
    ?>
    var testing= <?php echo json_encode($total); ?>;
        document.getElementById("fqhcsinMO").innerHTML = testing;
   
    
    <?php
        $query = "SELECT COUNT(DISTINCT (m.name, m.streetaddress)) FROM OrgsMO m, organizations o, contact c, attends a WHERE o.name=c.health_center_name AND o.streetaddress=c.street_address AND c.id=a.id AND m.name = o.name AND o.streetaddress=m.streetaddress AND m.fqhc = 'TRUE'";
        $result=pg_query($connString, $query);
                while($row = pg_fetch_array($result)){
                    $total = $row['count'];
                } 
    ?>
    var testing= <?php echo json_encode($total); ?>;
        document.getElementById("numParticipate").innerHTML = testing;
    
    var next = Math.round((testing/233) * 100);
    document.getElementById("notAttend").innerHTML = next + "%";
    
     google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);


      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        <?php
                $query="SELECT m.name, COUNT(DISTINCT (c.id)) FROM OrgsMO m, organizations o, contact c, attends a WHERE o.name=c.health_center_name AND o.streetaddress=c.street_address AND c.id=a.id AND m.name = o.name AND o.streetaddress=m.streetaddress AND m.fqhc = 'TRUE' GROUP BY m.name, m.streetaddress";
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
        
        var options = {'title':'Number of Attendees per FQHC',
//                       'width': 1000,
                       'height': 800,
                      'legend': { position: "none" },
                      'colors': [ '#D79900']};
        
        var chart = new google.visualization.ColumnChart(document.getElementById('barchart1'));
        chart.draw(data, options);
    }
    
    
    
    //county map
     <?php
            $query =    "Select cd.county, cd.fips, COUNT(o.name)
                        FROM countydata cd LEFT JOIN orgsmo o ON cd.county=o.county AND fqhc=true
                        GROUP BY cd.county, cd.fips";
            $result = pg_query($connString, $query);
            $county_arr=array();
    
            while ($row = pg_fetch_row($result)) {
                $county=$row[0];
                $fips=$row[1];
                $count=$row[2];
                $county_arr[]=array($county, $fips, $count);
            }
            $query2 =    "SELECT cd.county, cd.fips, COUNT(DISTINCT(om.name))
                        FROM countydata cd 
                        LEFT JOIN orgsmo om ON cd.county=om.county AND FQHC=true
                        WHERE om.name IN(
                            SELECT DISTINCT(o.name)
                            FROM Organizations o, contact c, attends a
                            WHERE o.name=c.health_center_name AND o.streetaddress=c.street_address AND c.id=a.id)
                        GROUP BY cd.county, cd.fips";
            $result = pg_query($connString, $query2);
            $county2_arr=array();
    
            while ($row = pg_fetch_row($result)) {
                $county=$row[0];
                $fips=$row[1];
                $count=$row[2];
                $county2_arr[]=array($county, $fips, $count);
            }
        ?>
        var countyArray=<?php echo json_encode($county_arr); ?>;
        var countyArray2=<?php echo json_encode($county2_arr); ?>;
//        var maxColor="#D4AC0D";
        
        for(var i=0; i<countyArray.length; i++){
            countyArray[i][2]=parseInt(countyArray[i][2]);
            
        }
        for(var i=0; i<countyArray2.length; i++){
            countyArray2[i][2]=parseInt(countyArray2[i][2]);
            
        }    
        var countyArrayFinal=countyArray;
        var k=0;
        var exists=false;
        for(var i=0; i<countyArray.length; i++){
            for(var j=0; j<countyArray2.length; j++){
                if(countyArray[i][0]==countyArray2[j][0]){
                    countyArrayFinal[i][2]=countyArray2[j][2]/countyArray[i][2]*100
                    exists=true
                }
            }
            if(exists==false)
                countyArrayFinal[i][2]=0;
            exists=false;
        }
        var newCountyArray=[];
        for(var i=0; i<countyArray.length; i++){
            var obj={name: countyArrayFinal[i][0], id: countyArrayFinal[i][1], STATE: "MO", TYPE: "County", CNTRY: "USA", value: countyArray[i][2]}
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
        "max": am4core.color("#D4AC0D")
    });
    // Configure series
    var polygonTemplate = polygonSeries.mapPolygons.template;
    polygonTemplate.tooltipText = "{name} \nParticipation: {value}%";
    polygonTemplate.fill = am4core.color("#F4D03F");
   
</script>
</body>  
<style>
    
</style>
    
</html>