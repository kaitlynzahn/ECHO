<?php
require("navbar.php");
require("connection.php");


use dbObj;
$db = new dbObj();
$connString =  $db->getConnstring();

if(isset($_POST['word'])) {

    $word= "%".$_POST['word']."%";
    $sql_search = "select * from contact WHERE full_name LIKE  '$word' 
OR health_center_name LIKE '$word' 
OR job_title LIKE '$word'
 OR specialty LIKE '$word'
 OR mobile LIKE '$word'
 OR email LIKE '$word'
 ";
  
 $query_search = pg_query($connString, $sql_search) or die("error to fetch employees data");
 $data_search = pg_fetch_all($query_search);
 
  } else {
    $data_search=null;
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
        
 <h4>Search Contacts</h4>
<nav class="navbar navbar-dark bg-dark">
<form class="form-inline my-2 my-lg-0 d-flex justify-content-start" method="post">
      <input class="form-control mr-sm-2 search_bar" type="search" placeholder="Search any contact by entering any details" name="word" aria-label="Search">
      <button class="btn btn-warning my-2 my-sm-0 btnClick" type="submit">Search</button>
</form>
</nav>
        









<br>


<table class="table table-search">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Organisation Name</th>
            <th scope="col">Job Title</th>
            <th scope="col">Specialty</th>
            <th scope="col">Mobile</th>
            <th scope="col">Email</th>

          </tr>
        </thead>
        <tbody>
        <?php
         if(!$data_search){
            echo "";
          }else{
        
        foreach($data_search as $key => $item) :?>
        <tr>
            <td><?php echo $item['full_name'] ?></td>
            <td><?php echo $item['health_center_name'] ?></td>
            <td><?php echo $item['job_title'] ?></td>
            <td><?php echo $item['specialty'] ?></td>
            <td><?php echo $item['mobile'] ?></td>
            <td><?php echo $item['email'] ?></td>
          
          </tr>
          <?php endforeach; }?>
          
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
   .search_bar{
    width: 710px !important;
   }
    

</style>

<script>


    
</script>
