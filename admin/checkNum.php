<?php
    //start the session 
    session_start();
    //check to make sure the session variable is registered 
    if(!isset($_SESSION['login'])){
        header( "Location: index.php");
    }
    // Gets data from URL parameters
    $pathNum = $_GET['pathNum'];
    $pathType = $_GET['pathType']; 
    
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
    
    
    $pt="";
    if ($pathType=="trolleybus")
        $pt="Trolleybus"; 
    if ($pathType=="bus")
        $pt="Bus"; 
    if ($pathType=="minibus")
        $pt="Minibus";
    
    $query = "SELECT route_number FROM coordinates WHERE route_type='$pathType'";
    $result = mysql_query($query);
    
    while ($row = @mysql_fetch_assoc($result)){
        if ($row['route_number'] == $pathNum) {
            $response = "<br/><b>{$pt} <font color='red'>($pathNum}</font> already exists.</b>"; 
            break;
        }
        else $response="";
    }
    //output the response 
    echo $response;
?>
