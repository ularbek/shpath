<?php
    //start the session 
    session_start();
    //check to make sure the session variable is registered 
    if(!isset($_SESSION['login'])){
        header("Location: index.php");
    }
    //http://www.w3schools.com/
    // Gets data from URL parameters 
    $pathNum = $_GET['pathNum'];
    $pathType = $_GET['pathType'];
    $orderNum = $_GET['order'];
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
    $query = sprintf("INSERT INTO coordinates (route_number, route_type, order_number, lat, lng) values ('%s', '%s', '%s', '%s', '%s');", 
        intval($pathNum), strval($pathType), intval($orderNum), floatval($lat), floatval($lng));
        $result = mysql_query($query); 
            if (!$result) {
                die('lnvalid query:'. mysql_error());
            }
        mysql_close($connection);
?>
