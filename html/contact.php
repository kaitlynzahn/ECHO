<?php
require("navbar.php");
require("connection.php");


use dbObj;
$db = new dbObj();
$connString =  $db->getConnstring();

if(isset($_GET['letter'])) {

  $alphabet= $_GET['letter']."%";
  $sql_letter = "select * from contact WHERE last_name LIKE '$alphabet' order by last_name";

  $query_letter = pg_query($connString, $sql_letter) or die("error to fetch employees data");
  $data_letter = pg_fetch_all($query_letter);
} else {
  $data_letter=null;
}

?>



<!doctype html>
<html lang="en">
  <head>
      <title>Contact</title>
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
      
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!--make active tab on nav bar-->
    <script>
        var element = document.getElementById("lookuphome");
        element.classList.add("activeClass");
    </script>
      
  </head>

<body>


  <div class="container d-md-flex align-items-stretch">
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
     <div class="align-items-center"><h2 class="mb-4 r">Contacts</h2></div>
        

            <div class="buttons_top">
            <a class="btn btn-warning btn-lg " style='color:black' id="insertButton" href="insert_contact.php" role="button">Insert Contacts</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

         <!-- Export to csv -->
            <form method='post' action='downloadcontact.php'>
                <input type='submit' value='Export To CSV' name='Export' class="btn btn-warning btn-lg" style='color:black'>
                
                <?php 
                 $query = "SELECT c.ID, Full_name, First_name, Last_name, Job_title, Specialty, credential_name, Health_Center_Name, Street_address, Mobile, Fax, Other_phone, Email, Other_Email, Website, Notes  FROM contact c FULL OUTER JOIN has_credential h ON h.id=c.id";
                 $result = pg_query($connString, $query);
                 $contact_arr=array();
                 $contact_arr[0]=array("ID", "full_name", "first_name", "last_name", "Job_title", "speciality", "credential_name","health_center_name", "street_address", "mobile", "fax", "other_phone", "email", "other_email", "website", "notes");
                 while ($row = pg_fetch_row($result)) {
                    $ID=$row[0];
                    $Full_name=$row[1];
                    $First_name=$row[2];
                    $Last_name=$row[3];
                    $Job_title=$row[4];
                    $Specialty=$row[5];
                    $credential_name=$row[6];
                    $Health_Center_Name=$row[7];
                    $Street_address=$row[8];
                    $Mobile=$row[9];
                    $Fax=$row[10];
                    $Other_phone=$row[11];
                    $Email=$row[12];
                    $Other_Email=$row[13];
                    $Website=$row[14];
                    $Notes=$row[15];
                    $contact_arr[]=array($ID, $Full_name, $First_name, $Last_name, $Job_title, $Specialty, $credential_name, $Health_Center_Name, $Street_address, $Mobile, $Fax, $Other_phone, $Email, $Other_Email, $Website, $Notes);
                 }
                     ?>
                <?php
                  $serialize_contact_arr = serialize($contact_arr);
               ?>
                <textarea name='export_data' style='display: none'><?php echo $serialize_contact_arr; ?></textarea>
          </form>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <div>

          <a href="contactSearch.php" class="btn btn-warning btn-lg " style='color:black' role="button" aria-pressed="true">Navigate to search Contacts Page</a>
                </div>

                </div>
                <br>
<?php
array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');?>


<div>
  <h3>Click on an alphabet to get contact's last name starting with that alphabet</h3>
</div><br>
<div class="alphabets">

<?php foreach (range('A', 'M') as $letter) :?>
<span><a  class="ahrefClick" href="contact.php?letter=<?php  echo $letter ;?>"><u>
<?php echo $letter ?></u>
</a></span>&nbsp;&nbsp;
<?php endforeach;?>

</div>

<div class="alphabets">

<?php foreach (range('N', 'Z') as $letter) :?>
<span><a class="ahrefClick" href="contact.php?letter=<?php  echo $letter ;?>"><u>
<?php echo $letter ?></u>
</a></span>&nbsp;&nbsp;
<?php endforeach;?>

</div>





    
    <br>
     <table class="table table-letter">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Organization Name</th>
            <th scope="col">Job Title</th>

          </tr>
        </thead>
        <tbody>
        <?php
        if(!$data_letter){
          echo "";
        }else{
        foreach($data_letter as $key => $item) :?>
        <tr>
            <td><?php echo $item['full_name'] ?></td>
            <td><?php echo $item['health_center_name'] ?></td>
            <td><?php echo $item['job_title'] ?></td>
          
          </tr>
          <?php endforeach;}?>
          
          </tbody>
      </table>

      
  


   
    </div>
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
    .btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:visited {
        background-color: #D79900 !important;
        border-color: #D79900 !important;
        margin-bottom: 15px;
}
    #insertButton:hover{
        background-color: #D79900 !important;
        border-color: #D79900 !important;
    }

    #person_btn{
        background-color:#F0B73E;
        border-color: #F0B73E;
    }
    #person_btn:hover{
        background-color: #F0B73E;
    }
    .alphabets{
    background-color: blanchedalmond;
    font-size: 40px;
   
    }
    .buttons_top{
      display: -webkit-box;
    }

</style>

<script>


    
</script>
