<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtmll/DTD/xhtmll- strict.dtd">
<?php
    //start the session 
    session_start();
    //check to make sure the session variable is registered 
    if(!isset($_SESSION['login'])){
        header("Location: index.php");
    }
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Shortest path problem</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        var pathCoordinates = [];
        var map;
        var poly;
        var xmlhttp;
        
        function load(){
            var options = {
              zoom: 12,
              center: new google.maps.LatLng(42.87192, 74.61150),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById('map'), options);
        }
        function showPath(){
            var pathType = document.getElementById("pathType").value; 
            var pathNum = document.getElementById("path").value; 
            if (pathType==""){
                alert("Transport type is not selected!"); return;
            }
            if (pathNum==""){
                alert("Route number is not selected!"); return;
            }
            deletePoly();
            pathCoordinates = new google.maps.MVCArray(); 
            var polyOptions = {
                path: pathCoordinates, 
                strokeColor: '#ee2424', 
                strokeOpacity: 1.0,
                strokeWeight: 3
            }
            poly = new google.maps.Polyline(polyOptions); 
            poly.setMap(map);
            
            var search_path = '../phpsqlajaxgen_xml.php?path='+pathNum+'&type='+pathType; 
            // Getting coordinates from database and drawing a line 
            downloadUrl(search_path, function(data) { 
                var xml = parseXml(data);
                var markers = xml.documentElement.getElementsByTagName("marker"); 
                for (var i = 0; i < markers.length; i++) {
                    var point = new google.maps.LatLng(
                        parseFloat(markers[i].getAttribute("lat")),
                        parseFloat(markers[i].getAttribute("lng"))
                    );
                    var path = poly.getPath();
                        path.insertAt(pathCoordinates.length, point);
                }
            });
            
        }
        function deletePath(){
            var pathType = document.getElementById("pathType").value; 
            var pathNum = document.getElementById("path").value; 
            if (pathType==""){
                alert("Transport type is not selected!"); return;
            }
            if (pathNum==""){
                alert("Route number is not selected!"); return;
            }
            var r = confirm("Do you realy want to delete this route?"); 
                if (r==false) {
                    return;
                }
                var url = 'delete_coordinates.php?pathNum=' + pathNum + '&pathType=' + pathType;
                
                downloadUrl(url, function(data, responseCode){}); 
                alert("Route has been successfully deleted."); 
                deletePoly();
                document.getElementById("pathType").value=""; 
                document.getElementById("path").value="";
        }
        function downloadUrl(url, callback) {
			var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
            
			request.onreadystatechange = function() {
				if (request.readyState == 4) {
					request.onreadystatechange = doNothing;
					callback(request.responseText, request.status);
                    
				}
			};
			request.open('GET', url, true);
			request.send(null);
		}
        function parseXml(str) {
            if (window.ActiveXObject) {
                var doc = new ActiveXObject('Microsoft.XMLDOM');
                doc.loadXML(str);
                return doc;
            }else if (window.DOMParser) {
                return (new DOMParser).parseFromString(str, 'text/xml');
            }
        }
        function showNumbs(str) { 
            if (str=="") {
                document.getElementById("path").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari 
                xmlhttp= new XMLHttpRequest();
            }
            else {
                //code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    document.getElementById("pathNumber").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../pathNumbs.php?pathType=" + str, true); 
            xmlhttp.send();
        }
        function deletePoly() {
            // Clear map from polylines if these are exist 
            if (poly) {
                for (i in poly) {
                    poly.setMap(null);
                }
                poly.length =0;
            }
        }
        function doNothing() {}
    </script>
</head>
<body onload="load()" onunload="GUnload()">
    <div id="wrapper">
        <div>
            <div>
                <h4>Administration panel</h4>
                <h2><a href="index.php">Shortest path problem</a></h2>
                <p>Shortest path problem by using Google Map API </p>
            </div>
        </div>
        
    <!-- end #header -->
        <div id="line"></div>
        <div id="page">
            <div id="page-bgtop">
				<div id="page-bgbtm">
					<div id="content">
						<div class="post">
							<div class="mapstyle" id="map">
							</div>
						</div>
					</div>
					<!-- end #content -->

    				<div id="menu">
                    <table>
                        <tr>
                            <td>Transport Type:</td>
                            <td><select id="pathType" onchange="showNumbs(this.value)">
                                <option value="">Select...</option>
                                <option value="bus">Bus</option>
                                <option value="minibus">Minibus</option>
                                <option value="trolleybus">Trolleybus</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Route Number: </td>
                            <td><div id="pathNumber">...</div></td>
                        </tr>
                    </table>
                    <input type="button" onclick="showPath()" value="Show"/>
                    <input type="button" onclick="deletePath()" value="Delete" />
                    <input type="button" onclick="location.href='panel.php'" value="Back" />
                </div>
				
				<div style="clear: both;">&nbsp;</div>
				</div>
			</div>
        </div>
        <div id="footer">
            
        </div>
</body>
</html>
