<?php

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

//add slashes to the username and md5() the password 
$user = $_POST['login'];
$pass = $_POST['passwd'];
$result = mysql_query("select login from admins where login='$user' AND password='$pass'");

//check that at least one row was returned 
$rowCheck = mysql_num_rows($result); 
if($rowCheck!=0){
    while($row = mysql_fetch_array($result)){
        //start the session and register a variable 
        session_start(); 
        //session_register('login');
        $_SESSION['login'] = "login"; 
        header("Location: panel.php");
        //break;
    }
}else {
    //if nothing is returned by the query, unsuccessful login code goes here...
    //echo 'Incorrect login name or password. Please try again.’; 
    header( "Location: index.php");
}
?>
