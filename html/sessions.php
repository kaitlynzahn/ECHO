<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("navbar.php");
require("connection.php");


use dbObj;
$db = new dbObj();
$connString =  $db->getConnstring();
$echo_name = $_GET['echo_name'];



$sql_all = "select * from sessions where echo_name = '$echo_name' order by date DESC";
$sql_scheduled = "select * from sessions where echo_name = '$echo_name' and clinic_status = 'Scheduled' order by date DESC ";
$sql_completed = "select * from sessions where echo_name = '$echo_name' and clinic_status = 'Completed' order by date DESC ";
$sql_last_session = "select * from sessions where echo_name='$echo_name' and clinic_status = 'Completed' order by date DESC LIMIT 1;";

$query_all  = pg_query($connString, $sql_all) or die("error to fetch employees data");
$data_all = pg_fetch_all($query_all);

$query_scheduled= pg_query($connString, $sql_scheduled) or die("error to fetch employees data");
$data_scheduled = pg_fetch_all($query_scheduled);

$query_completed  = pg_query($connString, $sql_completed) or die("error to fetch employees data");
$data_completed = pg_fetch_all($query_completed);

$query_last_session  = pg_query($connString, $sql_last_session) or die("error to fetch employees data");
$data_last_session = pg_fetch_all($query_last_session );



if(isset($_POST['send']))
{
$year = $_POST["year"];
echo "the year selected is ".$year;
$sql_year= "select * from sessions where echo_name = '$echo_name' and EXTRACT(year FROM date) = $year";

$query_year  = pg_query($connString, $sql_year) or die("error to fetch employees data");
$data_year = pg_fetch_all($query_year);
//foreach ($data_year as $result) {
//  echo implode($result); 
//  echo "<br>";
//} ;
}


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
    <div class="align-items-center"><h2 class="mb-4 r">Sessions</h2></div>
    <h3><?php echo $echo_name?></h5>

<div class="default_tab">   
<h4 class="heading_default_tab">
<span>Last Session completed on :&nbsp; <?php foreach($data_last_session as $key => $item) :?></span>
<?php echo $item['date'] ?>
  <?php endforeach;?>
</h4>

<h4 class="heading_default_tab">Upcoming sessions :&nbsp; 
<span>No sessions</span>
</h4>
</div>      
      

<div class="tab-content" id="v-pills-tabContent">


<div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
<h3> All Sessions</h3> 


     
     <table class="table table-hover all">
        <thead class="thead-dark">
	  <tr>
          
            <th scope="col">Date</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            <th scope="col">clinic Status</th>
            <th scope="col">clinic Location</th>
	          <th scope="col">clinic Type</th>
            <th scope="col"></th>
            

          </tr>
        </thead>
        <tbody>
        <?php 
      
        foreach($data_all as $key => $item) :?>
           <tr>

          
            <td><?php echo $item['date'] ?></td>
            <td><?php echo $item['start_time'] ?></td>
            <td><?php echo $item['end_time'] ?></td>
            <td><?php echo $item['clinic_status'] ?></td>
            <td><?php echo $item['clinic_location'] ?></td>
            <td><?php echo $item['clinic_type'] ?></td>
       <td><a class="btn btn-info btn-lg" href="cases.php?session_date=<?php echo $item['date'];?>&echo_name=<?php echo $item['echo_name'];?>" >
       <span class="glyphicon glyphicon-menu-right"></span>
       </a></td> 
          </tr>

       
          <?php endforeach;?>
          
          </tbody>
      </table>
</div>

<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
<h3>Completed Sessions</h3>  



     <table class="table table-hover ">
        <thead class="thead-dark">
	  <tr>
          
            <th scope="col">Date</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            <th scope="col">clinic Status</th>
            <th scope="col">clinic Location</th>
	    <th scope="col">clinic Type</th>
            <th scope="col"></th>
            

          </tr>
        </thead>
        <tbody>
        <?php foreach($data_all as $key => $item) :?>
           <tr>

          
            <td><?php echo $item['date'] ?></td>
            <td><?php echo $item['start_time'] ?></td>
            <td><?php echo $item['end_time'] ?></td>
            <td><?php echo $item['clinic_status'] ?></td>
            <td><?php echo $item['clinic_location'] ?></td>
            <td><?php echo $item['clinic_type'] ?></td>
       <td><a class="btn btn-info btn-lg" href="cases.php?session_date=<?php echo $item['date'];?>&echo_name=<?php echo $item['echo_name'];?>">
       <span class="glyphicon glyphicon-menu-right"></span></a></td> 
          </tr>
         
       
          <?php endforeach;?>
          
          </tbody>
      </table>
</div>

<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
<h3>Scheduled Sessions</h3> 
<?php if (!$data_scheduled) {
          echo "No scheduled Sessions";
        }
        else{
          ?> 



     <table class="table table-hover ">
        <thead class="thead-dark">
	  <tr>
          
            <th scope="col">Date</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            <th scope="col">clinic Status</th>
            <th scope="col">clinic Location</th>
	          <th scope="col">clinic Type</th>
        
            

          </tr>
        </thead>
        <tbody>
        <?php
        foreach($data_scheduled as $key => $item) :?>
           <tr>

          
            <td><?php echo $item['date'] ?></td>
            <td><?php echo $item['start_time'] ?></td>
            <td><?php echo $item['end_time'] ?></td>
            <td><?php echo $item['clinic_status'] ?></td>
            <td><?php echo $item['clinic_location'] ?></td>
            <td><?php echo $item['clinic_type'] ?></td>
          </tr>

       
          <?php endforeach ;
          }?>
          
          </tbody>
      </table>
</div>
      </div>
      </div>

      <nav id="sidebar">
      <div class="p-4 pt-5">
        <h5>Categories</h5>
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link side-bar-text" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">All Sessions</a><br>
  <a class="nav-link side-bar-text" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Completed Sessions</a><br>
  <a class="nav-link side-bar-text" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Scheduled Sessions</a><br>
 
</div> 

    
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

.page_heading{
  font-weight: bold;
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
.btn-info {
    color: black;
    background-color: #ffc107;
    border-color: bisque;


</style>


