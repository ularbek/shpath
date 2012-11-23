<?php

include("dijkstra.php");

$latA = $_GET['latA'];
$lngA = $_GET['lngA'];
$latB = $_GET['latB'];
$lngB = $_GET['lngB'];
$radius = 1;
$rad = 0.2;

require("phpsqlajax_dbinfo.php");

function parseToXML($htmlStr){
    $xmlStr=str_replace(i<',,&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace("",'&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr); return $xmlStr;
}
// Opens a connection to a MySQL server 
$connection=mysql_connect ($host, $username, $password);

$db_selected = mysql_select_db($database, $connection); 
if (!$db_selected) {
    die ('Can\'t use db :'. mysql_error());
}
// Look for nearest routes near point A 
$query1 = "SELECT DISTINCT * FROM markers
    WHERE (6371*ACOS(COS(RADIANS($latA))*COS(RADIANS(lat))*COS(RADIANS(lng)- RADIANS($lngA))+SIN(RADIANS($latA))*SIN(RADIANS(lat)))) < $radius";
$result1 = mysql_query($query1);

// Look for nearest routes near point Â
$query2 = "SELECT DISTINCT * FROM markers
    WHERE (6371*ACOS(COS(RADIANS($latB))*COS(RADIANS(lat))*COS(RADIANS(lng)- RADIANS($lngB))+SIN(RADIANS($latB))*SIN(RADIANS(lat)))) < $radius";
$result2 = mysql_query($query2); 

if (!$result1) {
    die("lnvalid query:".mysql_error());
}
if(!$result2){
    die("lnvalid query2:".mysql_error());
}


$i=0;
while($row1 = @mysql_fetch_assoc($result1)){
    $x = abs($row1['lat'] - $latA);
    $y = abs($row1['lng'] - $lngA);
    if($i==0){    
        $disA = sqrt(($x*$x) + ($y*$y));
        $idA = $row1['id'];
        $i++;
    }
    if($disA > sqrt(($x*$x) + ($y*$y))){
        $disA = sqrt(($x*$x) + ($y*$y));
        $idA = $row1['id'];
    }
}


$i=0;
while ($row2 = @mysql_fetch_assoc($result2)){
    $x = abs($row2['lat'] - $latB);
    $y = abs($row2['lng'] - $lngB);
    if($i == 0){    
        $disB = sqrt(($x*$x) + ($y*$y));
        $idB = $row2['id'];
        $i++;
    }
    if($disB > sqrt(($x*$x) + ($y*$y))){
        $disB = sqrt(($x*$x) + ($y*$y));
        $idB = $row2['id'];
    }
}
// I is the infinite distance.
define('I',1000);

// Size of the matrix
$matrixWidth = 4;

$query3 = "SELECT * FROM intersection";
$result3 = mysql_query($query3);
if(!$result3){
    die("lnvalid query2:".mysql_error());
}

$points = array();
$i = 0;

while($row3 = @mysql_fetch_assoc($result3)){
    $points[$i++] = array($row3['marker_id'], $row3['marker_id2'], $row3['length']);
};

$ourMap = array();


// Read in the points and push them into the map

for ($i=0,$m=count($points); $i<$m; $i++) {
    $x = $points[$i][0];
    $y = $points[$i][1];
    $c = $points[$i][2];
    $ourMap[$x][$y] = $c;
    $ourMap[$y][$x] = $c;
}

// ensure that the distance from a node to itself is always zero
// Purists may want to edit this bit out.

for ($i=0; $i < $matrixWidth; $i++) {
    for ($k=0; $k < $matrixWidth; $k++) {
        if ($i == $k) $ourMap[$i][$k] = 0;
    }
}


// initialize the algorithm class
$dijkstra = new Dijkstra($ourMap, I,$matrixWidth);

// $dijkstra->findShortestPath(0,13); to find only path from field 0 to field 13...
$fromClass = $idA;
$toClass = $idB;

$dijkstra->findShortestPath($fromClass, $toClass);

// Display the results

//echo '<pre>';
//echo "the map looks like:\n\n";
//echo $dijkstra -> printMap($ourMap);
//echo $dijkstra -> getResults((int)$toClass);
$res = array();
$res = $dijkstra -> getResults((int)$toClass);
$pointLat = array();
$pointLng = array();

header("Content-type: text/xml");
// Start XML file, echo parent node 
echo '<markers>';
for($i=0; $i<count($res); $i++){
    $id = $res[$i];
    $query4 = "SELECT lat, lng FROM markers WHERE id='$id'";
    $result4 = mysql_query($query4); 
    if (!$result4) {
        die('Invalid query:'. mysql_error());
    }
    
    // Iterate through the rows, printing XML nodes for each 
    while ($row4 = @mysql_fetch_assoc($result4)){
        // ADD TO XML DOCUMENT NODE 
        $pointLat[$i] = $row4['lat'];
        $pointLng[$i] = $row4['lng'];
        
        echo '<marker ';
        echo 'lat="'.$pointLat[$i].'" ';
        echo ' lng="'.$pointLng[$i].'" ';
        echo '/>';
    }
}

for($l=0; $l<sizeof($pointLat)-1; $l++){
    $q1 = "SELECT DISTINCT route_number, route_type FROM coordinates
        WHERE (6371*ACOS(COS(RADIANS($pointLat[$l]))*COS(RADIANS(lat))*COS(RADIANS(lng)- RADIANS($pointLng[$l]))+SIN(RADIANS($pointLat[$l]))*SIN(RADIANS(lat)))) < $rad ORDER BY route_number";
    $res1 = mysql_query($q1);
    
    // Look for nearest routes near point Â
    $m = $l+1;
    $q2 = "SELECT DISTINCT route_number, route_type FROM coordinates
        WHERE (6371*ACOS(COS(RADIANS($pointLat[$m]))*COS(RADIANS(lat))*COS(RADIANS(lng)- RADIANS($pointLng[$m]))+SIN(RADIANS($pointLat[$m]))*SIN(RADIANS(lat)))) < $rad ORDER BY route_number";
    
    $res2 = mysql_query($q2); 
    
    if (!$res1 || !$res2) {
        die("lnvalid query:".mysql_error());
    }
    $k=0;
    while($ro1 = @mysql_fetch_assoc($res1)){
        $r1[$k]=$ro1['route_number'];
        $r2[$k]=$ro1['route_type'];
        $k++;
    }
    
    $k=0;
    while ($ro2 = @mysql_fetch_assoc($res2)){
        $s1[$k]=$ro2['route_number'];
        $s2[$k]=$ro2['route_type'];
        $k++;
    }
    $t=0;
     
    for ($j=0; $j<sizeof($r1); $j++){
        for ($i=0; $i<sizeof($s1); $i++){
            if ($r1[$j]==$s1[$i] && $r2[$j]==$s2[$i]){
                echo "<point num='{$r1[$j]}' />";
                $t=1;
            }
        }
        $i=0;
    }
    $j=0;
    if ($t==0){
        echo "<point num='no route' />";
    }
    $r1 = null;
    $s1 = null;
    $r2 = null;
    $s2 = null;
    
}
//End XML file 
echo '</markers>';

//echo '</pre>';


?> 