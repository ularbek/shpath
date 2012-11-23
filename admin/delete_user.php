<?php
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
    
    $query = "DELETE FROM admins WHERE login='$login'";
    
    $result=mysql_query($query);
    mysql_close($connection);
?>
