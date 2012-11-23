<?php

require("phpsqlajax_dbinfo.php");

// Opens a connection to a MySQL server 
$connection=mysql_connect ($host, $username, $password);

$db_selected = mysql_select_db($database, $connection); 
if (!$db_selected) {
    die ('Can\'t use db :'. mysql_error());
}

$query = "SELECT DISTINCT type FROM locations";
$result = mysql_query($query);

if(!$result){
    die("Invalid query:".mysql_error);
}


echo "<td id='types'><table>";
while($row = @mysql_fetch_assoc($result)){
    echo "<tr>";
    echo "<td width='20'><input type='checkbox' value='{$row['type']}' name='types[]' /></td>";
    echo "<td>{$row['type']}</td>";
    echo "</tr>";
}
echo "</table></td>";