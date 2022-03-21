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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message="";
if(isset($_POST['submit'])){ //check if form was submitted
    $first_name = $_POST['first_name']; //get input text
    $last_name = $_POST['last_name'];
    $job_title = $_POST['job_title'];
    $credentials = $_POST['credentials'];
    $specialty = $_POST['specialty'];
    $health_center_name = $_POST['health_center_name'];
    $street_address = $_POST['street_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];
    $county = $_POST['county'];
    $phone= $_POST['phone'];
    $mobile = $_POST['mobile'];
    $fax = $_POST['fax'];
    $other_phone = $_POST['other_phone'];
    $email = $_POST['email'];
    $other_email = $_POST['other_email'];
    $website = $_POST['website'];
    $notes = $_POST['notes'];
    
    $credential_arr=explode(",", $credentials);
    $full_name=$first_name." ".$last_name;
    
    $ID=0;
    $query = "select MAX(ID) AS ID from contact";
    $result = pg_query($connString, $query);
    if($row = pg_fetch_row($result)){
        $ID=(int)$row[0]+1;
    }
    
    $query="INSERT INTO contact VALUES('$ID', '$full_name', '$first_name', '$last_name', '$job_title', '$specialty', '$health_center_name', '$street_address', '$mobile', '$fax', '$other_phone', '$email', '$other_email', '$website', '$notes')";
    pg_query($connString, $query);
    
    foreach ($credential_arr as $cred){
        $query="INSERT INTO credentials(credential_name) SELECT '$cred' WHERE NOT EXISTS(SELECT credential_name FROM credentials WHERE credential_name='$cred')";
        pg_query($connString, $query);
        $query2="INSERT INTO has_credential(credential_name, ID) SELECT '$cred', '$ID' FROM has_credential WHERE NOT EXISTS(SELECT credential_name, ID FROM has_credential WHERE credential_name='$cred' AND ID='$ID') ON CONFLICT (credential_name, ID) DO NOTHING ";
        pg_query($connString, $query2);
    }
    
    
} 
?>

<!DOCTYPE html>
<html>
    <head>
        
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../navbar.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>
<body>
    
<h1>Add A New Contact</h1>
<h3>Contact Info</h3>
<form action="" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label>First Name</label>
      <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
    </div>
    <div class="form-group">
        <div class="form-group col-md-6">
      <label>Last Name</label>
      <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
    </div>
    </div>
</div>
    
    <div class="form-group" style="padding-left:15px">
      <label>Job Title</label>
      <input type="text" class="form-control" name="job_title" placeholder="Job Title">
    </div>
    
    <div class="form-group" style="padding-left:15px" >
      <label>Credentials</label>
      <input type="text" class="form-control" name="credentials" placeholder="Credentials (comma separated)">
    </div>
    
    <div class="form-group" style="padding-left:15px" >
      <label>Specialty</label>
      <input type="text" class="form-control" name="specialty" placeholder="Specialty">
    </div>
    
    <div class="form-group col-md-6">
      <label>Phone</label>
      <input type="text" class="form-control" name="phone" placeholder="Phone">
    </div>
    <div class="form-group col-md-6">
      <label>Other Phone</label>
      <input type="text" class="form-control" name="other_phone" placeholder="Other Phone">
    </div>
    
    <div class="form-group" style="padding-left:15px" >
      <label>Mobile</label>
      <input type="text" class="form-control" name="mobile" placeholder="Mobile">
    </div>
    
    <div class="form-group col-md-6">
      <label>Email</label>
      <input type="email" class="form-control" name="email" placeholder="Email">
    </div>
    <div class="form-group col-md-6">
      <label>Other Email</label>
      <input type="email" class="form-control" name="other_email" placeholder="Other Email">
    </div>
    
    <div class="form-group" style="padding-left:15px" >
      <label>Fax</label>
      <input type="text" class="form-control" name="fax" placeholder="Fax">
    </div>
    
    <div class="form-group" style="padding-left:15px" >
      <label>Website</label>
      <input type="text" class="form-control" name="website" placeholder="Website">
    </div>
    
    <div class="form-group" style="padding-left:15px">
        <label>Notes</label>
        <textarea class="form-control" name="notes" placeholder="Notes" rows="3"></textarea>
    </div>
    
    
    <h3>Contact Health Center Information</h3>
    <div class="form-group" style="padding-left:15px" >
      <label>Health Center Name</label>
      <input type="text" class="form-control" name="health_center_name" placeholder="Health Center or Organization Name" required>
    </div>
    
  <div class="form-group" style="padding-left:15px">
    <label for="inputAddress">Street Address</label>
    <input type="text" class="form-control" name="street_address" placeholder="1234 Main St">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" name="city" placeholder="City">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <input type="text" class="form-control" name="state" placeholder="State">
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip Code</label>
      <input type="text" class="form-control" name="zip_code" placeholder="Zip Coe">
    </div>
  </div>
    
   <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">County</label>
      <input type="text" class="form-control" name="county" placeholder="County">
    </div>
    <div class="form-group col-md-6">
      <label for="inputState">Country</label>
      <input type="text" class="form-control" name="country" placeholder="Country">
    </div>
  </div>
  <center><button type="submit" name="submit" class="btn btn-primary">Add Contact</button></center>
</form>
    
<?php
?>

</body>
</html>
