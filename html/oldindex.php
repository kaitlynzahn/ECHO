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

require 'connection.php';
use dbObj;
$db = new dbObj();
$connString =  $db->getConnstring();
#$this->conn = $connString;
$sql = "SELECT name,number_of_clinics_participated FROM health_centres_raw LIMIT 10 OFFSET 15";
$queryRecords = pg_query($connString, $sql) or die("error to fetch employees data");
$data = pg_fetch_all($queryRecords);
	
?>
<!DOCTYPE HTML>
<html>
<head>  
<script>
</script>
</head>
<body>



<table id="grid" class="table" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>Name</th>
			<th>Participants</th>

		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $key => $item) :?>
		<tr>
			<td><?php echo $item['name'] ?></td>
			<td><?php echo $item['number_of_clinics_participated'] ?></td>
			<td><div class="btn-group" data-toggle="buttons"><a href="#" target="_blank" class="btn btn-warning btn-xs">Edit</a><a href="#" target="_blank" class="btn btn-danger btn-xs">Delete</a><a href="#" target="_blank" class="btn btn-primary btn-xs">View</a></div></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>





</body>
</html>   
<?php  pg_close($connString);
 ?>		  
