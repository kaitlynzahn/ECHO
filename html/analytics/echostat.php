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
    <title>Echo Analytics</title>
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

    <h1>ECHO Analytics</h1>
    
    <br>

    <div class="Top">
        
        <div class="TopLeft">
            <div class="Left">
                <p class="BigLetters" id="echostotal"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters" style="margin-top: 40px">ECHO Categories</p>
            </div>
        </div>

        <div class="TopMiddle">
            <div class="Left">
                <p class="BigLetters" id="sessionstotal"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters" style="margin-top: 40px">Total Sessions</p>
            </div>
        </div>

        <div class="TopRight">
            <div class="Left">
                <p class="BigLetters" id="casestotal"></p>
            </div>
            <div class="Right">
                <p class="LittleLetters1" style="margin-top: 30px">Total Cases Presented</p>
            </div>
        </div>

    </div>
    
    
    <div class="Boxrow">
        <div class="BoxLeft">
            
            
        
            <div id="topTenCasePresenters" class="graphdiv" style="height: 370px; width: 100%;"></div>
            
            <div id="sessionsMonth" class="graphdiv" style="height: 370px; width: 100%;"></div>
            
            <div id="attendeesMonth" class="graphdiv" style="height: 370px; width: 100%;"></div>
            
        </div>
        
        <div class="Boxright">
            
            <div id="topSessionAttenders" class="graphdiv" style="height: 370px; width: 100%;"></div>
            
            <div id="topTenTypePresenters" class="graphdiv" style="height: 370px; width: 100%;"></div>
            
            <div id="typeOverTime" class="graphdiv" style="height: 370px; width: 100%;"></div>
            
            <div id="percentAttended" class="graphdiv" style="height: 370px; width: 100%;"></div>
            
        </div>
    </div>
    
</body>
<script>
    
    <?php
        $query1 = "SELECT COUNT(*) FROM echos";
        $result1=pg_query($connString, $query1);
                while($row = pg_fetch_array($result1)){
                    $total1 = $row['count'];
                } 
    ?>
    var testing1= <?php echo json_encode($total1); ?>;
        document.getElementById("echostotal").innerHTML = testing1;
   
    <?php
        $query2 = "SELECT COUNT(*) FROM sessions";
        $result2 =pg_query($connString, $query2);
                while($row = pg_fetch_array($result2)){
                    $total2 = $row['count'];
                } 
    ?>
    var testing2= <?php echo json_encode($total2); ?>;
        document.getElementById("sessionstotal").innerHTML = testing2;
    
    <?php
        $query3 = "SELECT COUNT(*) FROM cases";
        $result3=pg_query($connString, $query3);
                while($row = pg_fetch_array($result3)){
                    $total3 = $row['count'];
                } 
    ?>
    var testing3= <?php echo json_encode($total3); ?>;
        document.getElementById("casestotal").innerHTML = testing3;
    
    
    
    <?php
    //Top 10 People That Presented Cases 
    // can use full_name instead of contact_id
            $query =    "SELECT  contact_id, count(*)
                        FROM CASES
                        GROUP BY contact_id
                        ORDER BY count(*) DESC
                        limit 10
                        ";
            $result = pg_query($connString, $query);
            $cases_presented_arr=array();
    
            while ($row = pg_fetch_row($result)) {
                $contact_id=$row[0];
                $count=$row[1];
                $cases_presented_arr[]=array("label"=> $contact_id, "y"=> $count);
            }
    //Which Type Has Presented the Most Cases
    $query =    "SELECT attendee_type, count(*)
                FROM cases c, attends a, sessions s
                WHERE c.date=s.date AND s.echo_name=a.echo_name AND s.date=a.date AND c.contact_id=a.id
                GROUP BY attendee_type
                ORDER BY COUNT(*) DESC";

            $result = pg_query($connString, $query);
            $type_presented_arr=array();
            
            $i=0;
            while ($row = pg_fetch_row($result)) {
                $type=$row[0];
                $count=$row[1];
                if($i==0){
                    $type_presented_arr[]=array("label"=> $type, "y"=> $count, "color"=> "#F1B82D");
                }
                else{
                    $type_presented_arr[]=array("label"=> $type, "y"=> $count, "color"=> "#000000");
                }
                $i++;
            }
    //sessions By Month Over Time
    $query =    "SELECT TO_CHAR(date,'Mon') as mon,
                EXTRACT(year from date) as yyyy,
                date_trunc('month',date) as month,
                count(*)
                FROM SESSIONS
                GROUP BY month, mon, yyyy
                ORDER BY month ASC";
        
            $result = pg_query($connString, $query);
            $sessions_month_arr=array();
    
            while ($row = pg_fetch_row($result)) {
                $month=$row[0];
                $year=$row[1];
                $count=$row[3];
                $sessions_month_arr[]=array("y"=> $count, "label"=> $month." ".$year);
            }
    //attendees By Month
    $query =    "SELECT TO_CHAR(s.date,'Mon') as mon,
       EXTRACT(year from s.date) as yyyy,
        date_trunc('month',s.date) as month,
       count(*)
        FROM SESSIONS s, Attends a
        WHERE s.echo_name=a.echo_name AND s.date=a.date
        GROUP BY month, mon, yyyy
        ORDER BY month ASC";
        
            $result = pg_query($connString, $query);
            $attendees_month_arr=array();
    
            while ($row = pg_fetch_row($result)) {
                $month=$row[0];
                $year=$row[1];
                $count=$row[3];
                $attendees_month_arr[]=array("y"=> $count, "label"=> $month." ".$year);
            }
    //percent attended
    $query =    "SELECT (
                (SELECT 1.0*count(DISTINCT a.id)
                FROM attends a)
                /
                (SELECT count(*)
                FROM contact)
                )AS Percent";
        
            $result = pg_query($connString, $query);
            $percent_attended_arr=array();
    
            while ($row = pg_fetch_row($result)) {
                $percent=100*$row[0];
                $percent_attended_arr[]=array("label"=> "Attended", "y"=> $percent, "color"=> "#F1B82D");
            }
            $percent_attended_arr[]=array("label"=> "Never Attended", "y"=> 100-$percent, "color"=> "#D79900");
    
    //hub vs participant over time
    
    $query =    "SELECT TO_CHAR(s.date,'Mon') as mon,
                EXTRACT(year from s.date) as yyyy,
                date_trunc('month',s.date) as month,
                count(*)
                FROM cases c, attends a, sessions s
                WHERE c.date=s.date AND s.echo_name=a.echo_name AND s.date=a.date AND c.contact_id=a.id AND attendee_type='Attendee'
                GROUP BY month, mon, yyyy
                ORDER BY month ASC";
    
    
            $result = pg_query($connString, $query);
            $participant_month_arr=array();
    
    $query2 =   "SELECT TO_CHAR(s.date,'Mon') as mon,
                EXTRACT(year from s.date) as yyyy,
                date_trunc('month',s.date) as month,
                count(*)
                FROM cases c, attends a, sessions s
                WHERE c.date=s.date AND s.echo_name=a.echo_name AND s.date=a.date AND c.contact_id=a.id AND attendee_type='Facilitator'
                GROUP BY month, mon, yyyy
                ORDER BY month ASC";
            $result2 = pg_query($connString, $query2);
            $facilitator_month_arr=array();
    
            $row2=pg_fetch_row($result2);
            while ($row = pg_fetch_row($result)) {
                $month=$row[0];
                $year=$row[1];
                $count=$row[3];
                
                $month2=$row2[0];
                $year2=$row2[1];
                $count2=$row2[3];
                
                $participant_month_arr[]=array("label"=> $month." ".$year, "y"=> $count);
                if($month==$month2 && $year==$year2){
                    $facilitator_month_arr[]=array("label"=> $month2." ".$year2, "y"=> $count2);
                    $row2=pg_fetch_row($result2);
                }
                else{
                    $facilitator_month_arr[]=array("label"=> $month." ".$year, "y"=> 0);
                }
            }
    
    //top Session Attenders
        $query =    "select at.health_center_name,c.count,c.id,c.full_name from(select count(*) as count,at.id as id,at.full_name as full_name
                        from attendee at,attends a where at.id=a.id
                        group by at.id,at.full_name
                        order by count DESC) as c,attendee at where at.id = c.id limit 10";
            $result = pg_query($connString, $query);
            $sessions_attended_arr=array();
    //to get full name, replace contact_id with full_name
            while ($row = pg_fetch_row($result)) {
                //$full_name=$row[3];
                $contact_id = $row[2];
                $count=$row[1];
                $sessions_attended_arr[]=array("label"=> $contact_id, "y"=> $count);
            }
    ?>
    window.onload = function () {
        //Top 10 People That Presented Cases
         var chart = new CanvasJS.Chart("topTenCasePresenters", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Top Ten People (Contact ID) That Presented the Most Cases"
            },
            axisY: {
                title: "Number of Cases",
                includeZero: false
            },
            data: [{
                type: "column",
                color: "#F1B82D",
                dataPoints: <?php echo json_encode($cases_presented_arr, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
         //Which Type Has Presented the Most Cases
        var chart = new CanvasJS.Chart("topTenTypePresenters", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Type That Has Presented the Most Cases"
            },
            axisY: {
                title: "Number of Cases",
                includeZero: false
            },
            data: [{
                type: "column",
                dataPoints: <?php echo json_encode($type_presented_arr, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        //Top 10 People That Attended session
         var chart = new CanvasJS.Chart("topSessionAttenders", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Top Ten Attendees (by ID) to Sessions"
            },
            axisY: {
                title: "Number of Sessions",
                includeZero: false
            },
            data: [{
                type: "column",
                color: "#F1B82D",
                dataPoints: <?php echo json_encode($sessions_attended_arr, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        
         //Which Type Has Presented the Most Cases
        var chart = new CanvasJS.Chart("topTenTypePresenters", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Type That Has Presented the Most Cases"
            },
            axisY: {
                title: "Number of Cases",
                includeZero: false
            },
            data: [{
                type: "column",
                dataPoints: <?php echo json_encode($type_presented_arr, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    
        //sessions By Month Over Time
        var chart = new CanvasJS.Chart("sessionsMonth", {
            title: {
                text: "Amount Sessions Every Month"
            },
            axisY: {
                title: "Number of Sessions"
            },
            data: [{
                type: "line",
                color: "#F1B82D",
                dataPoints: <?php echo json_encode($sessions_month_arr, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        //Attendees By Month
        var chart = new CanvasJS.Chart("attendeesMonth", {
            title: {
                text: "Amount Attendees Every Month"
            },
            axisY: {
                title: "Number of Attendeess"
            },
            data: [{
                type: "line",
                color: "#F1B82D",
                dataPoints: <?php echo json_encode($attendees_month_arr, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        //percent Attended
    var chart = new CanvasJS.Chart("percentAttended", {
        theme: "light2",
        animationEnabled: true,
        title: {
            text: "Percent of Contacts Who Have Attended At Least 1 Session"
        },
        data: [{
            type: "pie",
            indexLabel: "{y}",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabelPlacement: "inside",
            indexLabelFontColor: "#36454F",
            indexLabelFontSize: 18,
            indexLabelFontWeight: "bolder",
            showInLegend: true,
            legendText: "{label}",
            dataPoints: <?php echo json_encode($percent_attended_arr, JSON_NUMERIC_CHECK); ?>
        }]
            });
    chart.render();
               
    //typeOverTime
   var chart = new CanvasJS.Chart("typeOverTime", { 
	theme: "light2",
	title: {
		text: "Attendees vs Facilitators Cases Presented Over Time"
	},
	subtitles: [{
		text: ""
	}],
	axisY: {
		includeZero: false
	},
	legend:{
		cursor: "pointer"
	},
	toolTip: {
        content: "{label}<br>{name}: {y}"
	},
	data: [{
                type: "stackedArea",
                color: "#000000",
                name: "Facilitator",
                showInLegend: true,
                dataPoints: <?php echo json_encode($facilitator_month_arr, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "stackedArea",
                color: "#F1B82D",
                name: "Attendee",
                showInLegend: true,
                dataPoints: <?php echo json_encode($participant_month_arr, JSON_NUMERIC_CHECK); ?>
        
            }]
    });
 
    chart.render();
 
}
</script>
<style>
    .Boxleft {
        flex: 50%;
        padding: 15px 0;
        margin-right: 40px;
    }
    .Boxright {
        flex: 50%;
        padding: 15px;
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
    .graphdiv{
        margin: 30px;
    }

</style>

</html>
