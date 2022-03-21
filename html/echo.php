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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ("navbar.php");
require ("connection.php");
use dbObj;
$db = new dbObj();
$connString =  $db->getConnstring();

$sql_all = "select * from echos;";
$sql_sessions = "select count(*) as session_count,echo_name from sessions group by echo_name order by count(*) DESC;";
$sql_without_sessions = "select * from echos WHERE echo_name not in(select echo_name from sessions);";
$sql_ideas = "select * from echo_ideas;";

$query_sql_all = pg_query($connString, $sql_all) or die("error to fetch employees data");
$data_all = pg_fetch_all($query_sql_all);

$query_sql_sessions = pg_query($connString, $sql_sessions) or die("error to fetch employees data");
$data_sessions = pg_fetch_all($query_sql_sessions);

$query_sql_without_sessions = pg_query($connString, $sql_without_sessions) or die("error to fetch employees data");
$data_w_sessions = pg_fetch_all($query_sql_without_sessions);

$query_ideas= pg_query($connString, $sql_ideas) or die("error to fetch employees data");
$data_ideas = pg_fetch_all($query_ideas);


?>


<!doctype html>
<html lang="en">
  <head>
    <title>ECHOs</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrapStyle.css">
      <link rel="stylesheet" type="text/css" href="navbar.css">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

      
    
    <!--make active tab on nav bar-->
    <script>
        var element = document.getElementById("lookuphome");
        element.classList.add("activeClass");
    </script>
      

      
<!--      <link rel="stylesheet" type="text/css" href="style.css">-->
  </head>

<body>

     

  <div class="container d-md-flex align-items-stretch">
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
     <div class="align-items-center"><h2 class="mb-4 r page_heading">ECHOs</h2></div>
     <div class="tab-content" id="v-pills-tabContent">

<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
<h3> All ECHOs</h3>        
<ul class="list-group">
<?php foreach ($data_all as $key => $item): ?>
<li  class="nav-item list-group-item d-flex justify-content-between align-items-center">
<a class="nav-link" href="sessions.php?echo_name=<?php echo $item['echo_name']; ?>"><u>
<?php echo $item['echo_name'] ?>
</u></a>
</li>
<?php endforeach; ?>
</ul>
      
</div>


<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
<h3>ECHOs without Sessions/New Sessions</h3> 
<ul class="list-group">
<?php 
if (!$data_w_sessions) {
  echo "No new echos. Navigate to Echo Ideas to create new sessions";
}
else{
foreach ($data_w_sessions as $key => $item): ?>
<li  class="nav-item list-group-item d-flex justify-content-between align-items-center">
<?php echo $item['echo_name'] ?>
</li>
<?php endforeach;
} ?>
</ul>
      
</div>

<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
<h3>ECHOs with Sessions</h3>        
<ul class="list-group">
<?php foreach ($data_sessions as $key => $item): ?>
<li  class="nav-item list-group-item d-flex justify-content-between align-items-center">
<a class="nav-link" href="sessions.php?echo_name=<?php echo $item['echo_name']; ?>"><u>
<?php echo $item['echo_name'] ?>
<span class="badge badge-primary badge-pill">
<?php echo $item['session_count'] ?></span>
</u></a>
</li>
<?php endforeach; ?>
</ul>

</div>


<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
 <h3>Echo Ideas</h3>     
<table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Date Created</th>
            <th scope="col">Idea Name</th>
            <th scope="col">Description</th>
           
            

          </tr>
        </thead>
        <tbody>
        <?php foreach($data_ideas as $key => $item) :?>
          

          <tr>
          
            <td><?php echo $item['idea_id'] ?></td>
            <td><?php echo $item['date_created'] ?></td>
            <td><?php echo $item['idea_name'] ?></td>
            <td><?php echo $item['description'] ?></td>
         

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
  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">All ECHOs</a>
  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">ECHOs without Sessions</a>
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">ECHOs with Sessions</a>
  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">ECHO Ideas</a>
</div> 

<br>
<br>
     
          
          <!-- Export to csv -->
            <form method='post' action='downloadecho.php'>
                <button type='submit' value='Export To CSV' class="btn btn-warning" name='Export'><span class="glyphicon glyphicon-save"></span>Export to CSV</button>
                <?php
$query = "select echo_name, date, start_time, end_time, clinic_status, clinic_type from sessions";
$result = pg_query($connString, $query);
$echo_arr = array();
$echo_arr[0] = array(
    "echo_name",
    "date",
    "start_time",
    "end_time",
    "clinic_status",
    "clinic_type"
);
while ($row = pg_fetch_row($result))
{
    $echo_name = $row[0];
    $date = $row[1];
    $start_time = $row[2];
    $end_time = $row[3];
    $clinic_status = $row[4];
    $clinic_type = $row[5];
    $echo_arr[] = array(
        $echo_name,
        $date,
        $start_time,
        $end_time,
        $clinic_status,
        $clinic_type
    );
}
?>
                <?php
$serialize_echo_arr = serialize($echo_arr);
?>
                <textarea name='export_data' style='display: none;'><?php echo $serialize_echo_arr; ?></textarea>
          </form>
          
          
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
  </style>



