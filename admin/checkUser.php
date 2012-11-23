<?php
    //start the session 
    session_start();
    if(!isset($_SESSION['login'])){
        header( "Location: index.php");
    }
    // Gets data from URL parameters
    $login = $_GET['login']; 
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
    
    $response = "";
    $query = "SELECT login FROM admins";
    $result = mysql_query($query); 
    while ($row = @mysql_fetch_assoc($result)){ 
        if ($row['login'] == $login) {
            $response = "<b>Login <font color='red'>{$login}</font> already exists!</b><br />"; 
            break;
        }
    }
    echo $response; 
    mysql_close($connection);
?>
