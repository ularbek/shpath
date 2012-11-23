<?php
    //start the session 
    session_start();
    //check to make sure the session variable is registered 
    if(!isset($_SESSION['login'])){
        header("Location: index.php");
    }
    //http://www.w3schools.com/
    // Gets data from URL parameters 
    
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    
    require("../phpsqlajax_dbinfo.php");
    // Opens a connection to a MySQL server 
    $connection = mysql_connect ($host, $username, $password); 
    if (!$connection) {
        die('Not connected :'. mysql_error());
    }
    // Set the active MySQL database
    $db_selected = mysql_select_db($database, $connection); 
    if (!$db_selected) {
        die ('Can\'t use db :'. mysql_error());
    }
    // Insert new row with user data
    $query = "INSERT INTO markers (lat, lng) values($lat, $lng)";
        $result = mysql_query($query);
            if (!$result) {
                die('lnvalid query:'. mysql_error());
            }
        mysql_close($connection);
?>
