<?php
$latA = $_GET['latA'];
$lngA = $_GET['lngA'];
$latB = $_GET['latB'];
$lngB = $_GET['lngB'];
$radius = 0.5;

require("phpsqlajax_dbinfo.php");

// Opens a connection to a MySQL server 
$connection=mysql_connect ($host, $username, $password);

$db_selected = mysql_select_db($database, $connection); 
if (!$db_selected) {
    die ('Can\'t use db :'. mysql_error());
}


// Look for nearest routes near point A 
$query1 = "SELECT DISTINCT route_number, route_type FROM coordinates
    WHERE (6371*ACOS(COS(RADIANS($latA))*COS(RADIANS(lat))*COS(RADIANS(lng)- RADIANS($lngA))+SIN(RADIANS($latA))*SIN(RADIANS(lat)))) < $radius ORDER BY route_number";
$result1 = mysql_query($query1);

// Look for nearest routes near point Â
$query2 = "SELECT DISTINCT route_number, route_type FROM coordinates
    WHERE (6371*ACOS(COS(RADIANS($latB))*COS(RADIANS(lat))*COS(RADIANS(lng)- RADIANS($lngB))+SIN(RADIANS($latB))*SIN(RADIANS(lat)))) < $radius ORDER BY route_number";

$result2 = mysql_query($query2); 

if (!$result1) {
    die("lnvalid query:".mysql_error());
}
if(!$result2){
    die("lnvalid query2:".mysql_error());
}
$i=0;
while($row1 = @mysql_fetch_assoc($result1)){
    $r1[$i]=$row1['route_number'];
    $r2[$i]=$row1['route_type'];
    $i++;
}

$i=0;
while ($row2 = @mysql_fetch_assoc($result2)){
    $s1[$i]=$row2['route_number'];
    $s2[$i]=$row2['route_type'];
    $i++;
}

// If routes near points A and Â have same number and type, echo them 
$t=0;
echo "<select id='pathAB'>"; 
for ($j=0; $j<sizeof($r1); $j++){
    for ($i=0; $i<sizeof($s1); $i++){
        if ($r1[$j]==$s1[$i] && $r2[$j]==$s2[$i]){
            echo "<option value='{$r1[$j]} {$s2[$i]}'>{$r1[$j]} {$s2[$i]}</option>";
            $t=1;
        }
    }
    $i=0;
}
if ($t==0){
    echo "<option value=''>no route</option>";
}
echo "</select>";
?>
