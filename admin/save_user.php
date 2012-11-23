<?php
    //start the session 
    session_start();
    //check to make sure the session variable is registered 
    if(!isset($_SESSION['login'])){
        header( "Location: index.php");
    }
    
    // Gets data from URL parameters 
    $name = $_GET['userName'];
    $surname = $_GET['userSurname'];
    $login = $_GET['login'];
    $passwd = $_GET['password']; 
    
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
    //Insert new row with user data
    $query = sprintf("INSERT INTO admins (login, password, name, surname) values ('%s', '%s', '%s', '%s');",
        strval($login), strval($passwd), strval($name), strval($surname));
    $result = mysql_query($query); 
    if (!$result) {
        die('Invalid query:'. mysql_error());
    }
    mysql_close($connection);
?>
