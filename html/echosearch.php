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

//require("navbar.php");
require("connection.php");
use dbObj;
$db = new dbObj();
$connString =  $db->getConnstring();

$sql = "SELECT * FROM ECHOS WHERE echo_name LIKE '%" . $_POST['search'] . "%'";

$queryRecords = pg_query($connString, $sql) or die("error to fetch echo data");

$results = pg_fetch_all($queryRecords);

//
//$stmt = $pdo->prepare("SELECT * FROM `ECHOs` WHERE `echo_name` LIKE ?");
//
//$stmt->execute(["%" . $_POST['search'] . "%"]);
//
//$results = $stmt->fetchAll();
//
//if (isset($_POST['ajax'])) { echo json_encode($results); }

?>