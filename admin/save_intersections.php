<?php
    //start the session 
    session_start();
    //check to make sure the session variable is registered 
    if(!isset($_SESSION['login'])){
        header("Location: index.php");
    }
    //http://www.w3schools.com/
    // Gets data from URL parameters 
    
    $lat1 = $_GET['lat1'];
    $lng1 = $_GET['lng1'];
    $lat2 = $_GET['lat2'];
    $lng2 = $_GET['lng2'];
    
    $id1 = 0;
    $id2 = 0;
    $length = 0;
    $x = $lat1 - $lat2;
    $y = $lng1 - $lng2;
    $x = abs($x);
    $y = abs($y);
    
    $length = sqrt(($x*$x) + ($y*$y));
    
    
    
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
    
    $query1 = "SELECT * FROM markers";
    
    $result1 = mysql_query($query1); 
    if (!$result1) {
        die('Invalid query:'. mysql_error());
    }
    
    while ($row1 = @mysql_fetch_assoc($result1)){
        if($row1['lat'] == $lat1 && $row1['lng']==$lng1){
            $id1 = $row1['id'];
        }
        if($row1['lat'] == $lat2 && $row1['lng'] == $lng2){
            $id2 = $row1['id'];
        }
    }
    
    
    
    // Insert new row with user data
    $query = "INSERT INTO intersection (marker_id, marker_id2, length) values($id1, $id2, $length)";
        $result = mysql_query($query); 
        if (!$result) {
            die('lnvalid query:'. mysql_error());
        }
        mysql_close($connection);
?>
