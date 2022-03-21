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

$sql = "SELECT * FROM countydata ORDER BY county";

$queryRecords = pg_query($connString, $sql) or die("error to fetch employees data");
$data = pg_fetch_all($queryRecords);

?>

<!DOCTYPE html>
<html>
    <head>
            <!--make active tab on nav bar-->
    <script>
        var element = document.getElementById("lookuphome");
        element.classList.add("activeClass");
    </script>
        
    <title>Missouri Counties</title>
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
     <div class="align-items-center"><h2 class="mb-4 r">Missouri Counties</h2></div>
        
         <!-- Export to csv -->
            <form method='post' action='downloadcounty.php'>
                <input type='submit' value='Export To CSV' name='Export' class="btn btn-warning" style='color:black'>
                
                <?php 
                 $query = "SELECT * FROM countydata";
                 $result = pg_query($connString, $query);
                 $county_arr=array();
                 $county_arr[0]=array("fips", "state", "county", "brfss_id", "landsqmi", "areasqmi", "totalpop2010", "pctover62", "pctmales",
                                     "pctfemales", "pctwhite1", "pctblack1", "pctindian1", "pctasian1", "pcthawnpi1", "pctother1", "avghhinc",
                                     "avghhsocsec", "pctpoort", "pctpublictrans", "pctbachelorsormore", "pctbroadbandint", "pctnointernet",
                                     "pctnovehicles", "sef_rank", "ho_rank", "hf_rank", "pctuninsured", "numofpcp", "pctfluvacc",
                                     "pctsomecollege", "pctunemployed", "lifeexpect", "pctnohealthyfood", "pctrural");
                 while ($row = pg_fetch_row($result)) {
                    $fips=$row[0];
                    $state=$row[1];
                    $county=$row[2];
                    $brfss_id=$row[3];
                    $landsqmi=$row[4];
                    $areasqmi=$row[5];
                    $totalpop2010=$row[6];
                    $pctover62=$row[7];
                    $pctmales=$row[8];
                    $pctfemales=$row[9];
                    $pctwhite1=$row[10];
                    $pctblack1=$row[11];
                    $pctindian1=$row[12];
                    $pctasian1=$row[13];
                    $pcthawnpi1=$row[14];
                    $pctother1=$row[15];
                    $avghhinc=$row[16];
                    $avghhsocsec=$row[17];
                    $pctpoort=$row[18];
                    $pctpublictrans=$row[19];
                    $pctbachelorsormore=$row[20];
                    $pctbroadbandint=$row[21];
                    $pctnointernet=$row[22];
                    $pctnovehicles=$row[23];
                    $sef_rank=$row[24];
                    $ho_rank=$row[25];
                    $hf_rank=$row[26];
                    $pctuninsured=$row[27];
                    $numofpcp=$row[28];
                    $pctfluvacc=$row[29];
                    $pctsomecollege=$row[30];
                    $pctunemployed=$row[31];
                    $lifeexpect=$row[32];
                    $pctnohealthyfood=$row[33];
                    $pctrural=$row[34];
                    $county_arr[]=array($fips,$state, $county,$brfss_id,$landsqmi, $areasqmi, $totalpop2010,$pctover62,$pctmales, $pctfemales,$pctwhite1, $pctblack1, $pctindian1,$pctasian1,$pcthawnpi1, $pctother1, $avghhinc, $avghhsocsec, $pctpoort,  $pctpublictrans,$pctbachelorsormore, $pctbroadbandint,$pctnointernet,  $pctnovehicles, $sef_rank, $ho_rank,$hf_rank, $pctuninsured,$numofpcp,$pctfluvacc, $pctsomecollege,$pctunemployed,$lifeexpect,$pctnohealthyfood, $pctrural);
                 }
                     ?>
                <?php
                  $serialize_county_arr = serialize($county_arr);
               ?>
                <textarea name='export_data' style='display: none'><?php echo $serialize_county_arr; ?></textarea>
          </form>

     <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">County</th>
            <th scope="col">FIPS Code</th>
            <th scope="col">Health Outcomes Rank</th>
            <th scope="col">Uninsured</th>
            <th scope="col">Life Expectancy</th>
            <th scope="col">% Rural</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($data as $key => $item) :?>
          <tr>
              <td><?php echo $item['county'] ?></td>
              <td><?php echo $item['fips'] ?></td>
              <td><?php echo $item['ho_rank'] ?></td>
              <td><?php echo $item['pctuninsured'] ?></td>
              <td><?php echo $item['lifeexpect'] ?></td>
              <td><?php echo $item['pctrural'] ?></td>
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

