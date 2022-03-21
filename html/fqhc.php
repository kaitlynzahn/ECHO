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

$sql = "SELECT * FROM OrgsMO WHERE fqhc='TRUE'";

$queryRecords = pg_query($connString, $sql) or die("error to fetch employees data");
$data = pg_fetch_all($queryRecords);

?>

<!DOCTYPE html>
<html>
    <head>
    <title>FQHCs</title>
            <!--make active tab on nav bar-->
    <script>
        var element = document.getElementById("lookuphome");
        element.classList.add("activeClass");
    </script>
        
 <link rel="stylesheet" type="text/css" href="navbar.css">

<!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrapStyle.css">
    <link rel="stylesheet" type="text/css" href="navbar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
<body>

<div class="container d-md-flex align-items-stretch">
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
     <div class="align-items-center"><h2 class="mb-4 r">FQHCs</h2></div>
        
        <!-- Export to csv -->
            <form method='post' action='downloadfqhc.php'>
                <input type='submit' value='Export To CSV' name='Export' class="btn btn-warning" style='color:black'>
                
                <?php 
                 $query = "SELECT name, streetaddress, city, zipcode, county FROM orgsmo";
                 $result = pg_query($connString, $query);
                 $fqhc_arr=array();
                 $fqhc_arr[0]=array("name", "streetaddress", "city", "zipcode", "county");
                 while ($row = pg_fetch_row($result)) {
                    $name=$row[0];
                    $streetaddress=$row[1];
                    $city=$row[2];
                    $zipcode=$row[3];
                    $county=$row[4];
                    $fqhc_arr[]=array($name, $streetaddress, $city, $zipcode, $county);
                 }
                     ?>
                <?php
                  $serialize_fqhc_arr = serialize($fqhc_arr);
               ?>
                <textarea name='export_data' style='display: none'><?php echo $serialize_fqhc_arr; ?></textarea>
          </form>

     <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Organization</th>
            <th scope="col">Address</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($data as $key => $item) :?>
          <tr>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['streetaddress'] ?></td>
          </tr>
          <?php endforeach;?>
          
          </tbody>
        </table>
    </div>
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


</style>


