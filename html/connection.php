<?php
Class dbObj{
	/* Database connection start */
        var $servername, $username, $password, $dbname, $port, $conn;

	function __construct()
	{
	  $this->servername = "echodb.c2beu4bog88n.us-east-2.rds.amazonaws.com";
	  $this->username = "echoUser";
	  $this->password = "mypass1234";
	  $this->port = "5432";
	  $this->dbname = "postgres";
	}
	function getConnstring() {
	$con = pg_connect("host=".$this->servername." port=".$this->port." dbname=".$this->dbname." user=".$this->username." password=".$this->password."") or die("Connection failed: ".pg_last_error());


		/* check connection */
		if (pg_last_error()) {
			printf("Connect failed: %s\n", pg_last_error());
			exit();
		} else {
			$this->conn = $con;
		}

	return $this->conn;

	}
}
?>
