<?php
//This script generates existing route numbers according to a type.
$pathType = $_GET['pathType'];
require("phpsqlajax_dbinfo.php");

//Opens a connection to a MySQL server 
$connection = mysql_connect ($host, $username, $password); 
if (!$connection) {
    die('Not connected :'.mysql_error());
}
// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection); 
if (!$db_selected) {
    die ('Can\'t use db :'.mysql_error());
}
//Select all the rows in the markers table
$query = "SELECT DISTINCT route_number FROM coordinates WHERE route_type='$pathType' ORDER BY route_number";
$result = mysql_query($query);

if (!$result) {die('lnvalid query:'.mysql_error());}
echo "<select id='path'>";

while ($row = @mysql_fetch_assoc($result)){
    echo "<option value={$row['route_number']}>{$row['route_number']}</option>";
}
echo "</select>";
?>
