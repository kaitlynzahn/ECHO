<?php
    require("homePageNavBar.php");
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title> User Login</title>
    <meta charset = "utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <link href="form.css" rel="stylesheet" type="text/css">
    <link href="navbar.css" rel="stylesheet" type="text/css">
    
<!--
     <link href="jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <script src="jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <script src="jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
-->
<!--
    <script>
        $(function(){
            $("input[type=submit]").button();
        });
    </script>
    
-->
    <script>
        var element = document.getElementById("log");
        element.classList.add("activeClass");
    </script>
    
    </head>
<body>    
     <div id="loginWidget" class="ui-widget">
        <h1 class="ui-widget-header">Login</h1>
        
        <?php
            if ($error) {
                print "<div class=\"ui-state-error\">$error</div>\n";
            }
        ?>

        <!--this will go back to login.php once the login function works-->
<!--        <form action="login.php" method="POST">-->
         <form action="login.php" method="POST">
            
            <input type="hidden" name="action" value="do_login">
            
            <div class="stack">
                <label for="username">Username:</label>
                <input placeholder="Username" type="text" id="username" name="username" class="ui-widget-content ui-corner-all" autofocus value="<?php print $username; ?>">
            </div>
            
            <div class="stack">
                <label for="password">Password:</label>
                <input placeholder="Password" type="password" id="password" name="password" class="ui-widget-content ui-corner-all">
            </div>
            
            <div class="stack">
                <input type="submit" value="Submit">
            </div> 

        </form>
         
         
    </div>
    
    
</body>    
</html>
