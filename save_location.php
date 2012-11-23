<?php

    $address = $_GET['address'];
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    $type = $_GET['type'];
    $image = $_GET['image'];
    
    require("phpsqlajax_dbinfo.php");
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
    $query = sprintf("INSERT INTO locations (address, lat, lng, type, image) values ('%s', '%s', '%s', '%s', '%s');", 
        strval($address), floatval($lat), floatval($lng), strval($type), strval($image));
    $result = mysql_query($query);
        if (!$result) {
            die('lnvalid query:'. mysql_error());
        }
    mysql_close($connection);

?>