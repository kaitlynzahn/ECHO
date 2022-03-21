<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn_string="host=Echodb.c2beu4bog88n.us-east-2.rds.amazonaws.com port=5432 dbname=postgres user=echoUser password=mypass1234";
$dbconn=pg_connect($conn_string) or die("Could not connect");


$result = pg_query($dbconn, "SELECT id FROM test");

if (!$result) {
  echo "An error occurred.\n";
  exit;
}

while ($row = pg_fetch_row($result)) {
  echo "id: $row[0]";
  echo "<br />\n";
}

pg_close($dbconn);
?>
