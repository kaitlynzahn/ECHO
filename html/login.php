<?php
    //connect to the database
    require("connection.php");
    use dbObj;
    $db = new dbObj();
    $connString =  $db->getConnstring();

    session_start();

    // start a session, if the session couldn't start, present an error
	if(!session_start()) {
		$error = 'Error: Session could not start';
        print $error;
		exit;
	}

    //if the user has never logged in before (session empty), false and if they have, true
    $loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	
    //if the user has logged in before, bring them straight to the homePage
	if ($loggedIn) {
		header("Location: lookup.php");
		exit;
	}
	
    //is the user trying to URL hack?
	$action = empty($_POST['action']) ? '' : $_POST['action'];
	
    //if the user has the correct "action" from hidden input, handle_login function
	if ($action == 'do_login') {       
        //empty user's input
        $username = empty($_POST['username']) ? '' : $_POST['username'];
		$password = empty($_POST['password']) ? '' : $_POST['password'];
        
        //allow characters in query to be used 
        $username = pg_escape_string($username);
        $password = pg_escape_string($password);
        
        //more secure password storing for website
        $password = md5($password); 
        
        // Build query with encoding
		$query = "SELECT COUNT(*)
                FROM login_credentials
                WHERE username='$username' AND password='$password'";

        //run query
        $result=pg_query($connString, $query);
        
        //get the results of the query
        while($row = pg_fetch_array($result)){
            $returnValue = $row['count'];
        }

        // If query result is one user
        if ($returnValue == 1) {

            $_SESSION['loggedin'] = $username;
            header("Location: lookup.php");
            exit;
        }
            
        //if the login does not match credentials
        else {
            $error = 'Error: Incorrect username or password';
            require "form.php";
            exit;
        }
    }

else {
        $username = "";
		$error = "";
		require "form.php";
        exit;
}

?>
