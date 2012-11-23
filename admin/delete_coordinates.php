<?php
    //start the session 
    session_start();
    //check to make sure the session variable is registered 
    if(!isset($_SESSION['login'])){
        header("Location: index.php");
    }
    // Gets data from URL parameters 
    $pathNum = $_GET['pathNum'];
    $pathType = $_GET['pathType']; 
    require("../phpsqlajax_dbinfo.php");
    // Opens a connection to a MySQL server 
    $connection = mysql_connect($host, $username, $password);
    
    $db_selected = mysql_select_db($database, $connection); 
    if (!$db_selected) {
        die ('Can\'t use db :'. mysql_error());
    }

    // Insert new row with user data
    $query = "DELETE FROM coordinates WHERE route_type='$pathType' AND route_number='$pathNum'";
    $result = mysql_query($query); 
    if (!$result){
        die('Invalid query: '. mysql_error());
    }
    mysql_close($connection);
?>
