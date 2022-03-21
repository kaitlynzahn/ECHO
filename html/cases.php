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
require("connection.php");

use dbObj;
$db = new dbObj();
$connString =  $db->getConnstring();
$echo_name = $_GET['echo_name'];

$session_date= $_GET['session_date'];

$mysqltime = date("Y-m-d", $session_date);

$sql_didactics = "select * from didactics where echo_name = '$echo_name' and  date = '$session_date';";
$sql_cases = "select * from cases where echo_name = '$echo_name' and date = '$session_date';";
$sql_attendees = "select a.id,a.connection_type,a.attendee_type,at.full_name,at.health_center_name from attends a INNER JOIN attendee at
ON a.id = at.id 
where a.echo_name='$echo_name' and 
a.date='$session_date'";

$queryRecords1 = pg_query($connString, $sql_didactics) or die("error to fetch employees data");
$data_d = pg_fetch_all($queryRecords1);

$queryRecords2 = pg_query($connString, $sql_cases) or die("error to fetch employees data");
$data_c= pg_fetch_all($queryRecords2);

$queryRecords3 = pg_query($connString, $sql_attendees) or die("error to fetch employees data");
$data_a= pg_fetch_all($queryRecords3);

?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--make active tab on nav bar-->
    <script>
        var element = document.getElementById("lookuphome");
        element.classList.add("activeClass");
    </script>
      
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrapStyle.css">
    <link rel="stylesheet" type="text/css" href="navbar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>

<body>

<div class="container d-md-flex align-items-stretch">
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
     <div class="align-items-center"><h2 class="mb-4 r">Session Details</h2></div>
     
     

     <div class="default_tab">   
<h4 class="heading_default_tab">
<span><?php echo $echo_name ?>&nbsp;on&nbsp;
<?php echo $session_date ?></span>
</h4>

<h4 class="heading_default_tab">&nbsp; 
<span>Click on a category to view details</span>
</h4>
</div>     


     <div class="tab-content" id="v-pills-tabContent">

<div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
<h3>Didactics</h3>
     <table class="table">
        <thead class="thead-dark">
          <tr>
          <th scope="col">Name</th>
            <th scope="col">Title</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            <th scope="col">Notes</th>

          </tr>
        </thead>
        <tbody>
        <?php foreach($data_d as $key => $item) :?>
          

          <tr>
            <td><?php echo $item['full_name'] ?></td>
            <td><?php echo $item['title'] ?></td>
            <td><?php echo $item['didactic_start_time'] ?></td>
            <td><?php echo $item['didactic_end_time'] ?></td>
            <td><?php echo $item['notes'] ?></td>
          
            
          </tr>


          <?php endforeach;?>
          
          </tbody>
      </table>
      
</div>


<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
<h3>Case Presentations</h3>
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Presentor Name</th>
            <th scope="col">Health Center</th>
            <th scope="col">Patient ID</th>
            <th scope="col">Patient Type</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            

          </tr>
        </thead>
        <tbody>
        <?php foreach($data_c as $key => $item) :?>
          

          <tr>
            <td><?php echo $item['full_name'] ?></td>
            <td><?php echo $item['health_center_name'] ?></td>
            <td><?php echo $item['patient_id'] ?></td>
            <td><?php echo $item['patient_type'] ?></td>
            <td><?php echo $item['presentation_start_time'] ?></td>
            <td><?php echo $item['presentation_end_time'] ?></td>
            
          </tr>


          <?php endforeach;?>
          
          </tbody>
      </table>

</div>

<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">

<h3>Attendees</h3>
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Full Name</th>
            <th scope="col">Attendee Type</th>
            <th scope="col">Connection Type</th>
            <th scope="col">Health Center Name</th>
            

          </tr>
        </thead>
        <tbody>
        <?php foreach($data_a as $key => $item) :?>
          

          <tr>
            <td><?php echo $item['id'] ?></td>
            <td><?php echo $item['full_name'] ?></td>
            <td><?php echo $item['attendee_type'] ?></td>
            <td><?php echo $item['connection_type'] ?></td>
            <td><?php echo $item['health_center_name'] ?></td>
            
            
          </tr>


          <?php endforeach;?>
          
          </tbody>
      </table>

</div>




</div>
</div>
  
    <nav id="sidebar">
      <div class="p-4 pt-5">
        <h5>Categories</h5>
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        
  <a class="nav-link side-bar-text" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Didactics</a><br>
  <a class="nav-link side-bar-text" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Cases</a><br>
  <a class="nav-link side-bar-text" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Attendees</a><br>
  
</div> 

<br>
<br>
     
          
          <!-- Export to csv -->
          
          
      </div>


    </nav>

  
  </div>


</body>



</html>
<style>
     .sidebarBtn
     {
       height: 60px;
      font-size: 18px;
     }
     .list-group-item {
    position: relative;
    display: block;
    padding: .75rem 1.25rem;
    background-color: #fff;
    border: 3px solid #8080801c;
    border-left: 6px solid #F0B73E;
    border-right: 6px solid #F0B73E;
    margin-top: 5px;
    border-top: 0px;
    /* border-bottom: 3px; */
    height: 53px;
    border-block-start-color: 3px solid rgba(0,0,0,.125);
    border-block-start: 3px solid #8080801c;
     }

    .badge-primary {
    color: black;
    background: #f1a608;
  }

  .badge{
    font-size: 90%;}

    a {
    color:black;
    }
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: black;
    background-color: #ffc107;
  
}
.side-bar-text{
font-size: 18px;
}
.default_tab{
  background-color: #ddd;
  height: 84px;
}
.heading_default_tab{
padding: 8px;
}
</style>




