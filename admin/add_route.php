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
        var poly, map; 
        var markers = [];
        var path = new google.maps.MVCArray();
        
        function load() {
            var options = {
              zoom: 12,
              center: new google.maps.LatLng(42.87192, 74.61150),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById('map'), options);
            
            poly = new google.maps.Polyline({
                path: path,
                strokeColor: '#ee2424', 
                strokeOpacity: 0.6, 
                strokeWeight: 4
            });
    
            poly.setMap(map);
            path = poly.getPath();
            google.maps.event.addListener(map, 'click', addPoint);
        }
        function addPoint(event) {
            path.insertAt(path.length, event.latLng); 
            var marker = new google.maps.Marker({ 
                position: event.latLng, 
                map: map, 
                draggable: true
            });
            markers.push(marker); 
            marker.setTitle("#" + path.length);
            google.maps.event.addListener(marker, 'dblclick', function(){
            marker.setMap(null);
            for (var i = 0,l = markers.length; i < l && markers[i] != marker; ++i); 
                    markers.splice(i, 1); 
                    path.removeAt(i);
            });
            google.maps.event.addListener(marker, 'dragend', function() {
                for (var i = 0,l = markers.length; i < l && markers[i] != marker; ++i); 
                    path.setAt(i, marker.getPosition());
            });
        }
        function savePath() { 
            var url;
            
            var path = poly.getPath();
            
            var pathNum = document.getElementById("pathNum").value; 
            var pathType = document.getElementById("pathType").value; 
            var pathCheck = document.getElementById("pathCheck").innerHTML; 
            if (pathType ==""){
                alert("Transport type field is empty!"); return;
            }
            if (pathNum ==""){
                alert("Route number field is empty!"); return;
            }
            if (path.getLength()<2){
                alert("You did not select a route on a map!"); return;
            }
            if (pathCheck !=""){
                alert("Route number is not unique!"); return;
            }
            
            for (var i = 0; i < path.getLength(); i++){ 
                var latlng = path.getAt(i); 
                var lat = latlng.lat(); 
                var lng = latlng.lng(); 
                var order = i+1;
                
                url = 'save_coordinates.php?pathNum=' + pathNum + '&lat=' + lat +
                    '&lng=' + lng + '&order=' + order + '&pathType=' + pathType;
                downloadUrl(url, function(data, responseCode){});
            }
            alert("Route has been successfully added."); 
            reset();
        }
        function reset(){
            window, location.reload();
        }
        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ? 
            new ActiveXObject('Microsoft.XMLHTTP'): 
            new XMLHttpRequest; 
            request.onreadystatechange = function() { 
                if (request.readyState == 4) {
                    request.onreadystatechange = doNothing; 
                    callback(request.responseText, request.status);
                }
            };
            request.open('GET', url, true); 
            request.send(null);
        }
        function checkNum(str) { 
            if (str=="") {
                document.getElementById("pathNum").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari 
                xmlhttp=new XMLHttpRequest();
            }else {
                // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) { 
                    document.getElementById("pathCheck").innerHTML=xmlhttp.responseText; 
                }
            }
            var pathType = document.getElementById("pathType").value;
            xmlhttp.open("GET","checkNum.php?pathNum="+str+"&pathType="+pathType,true);
            xmlhttp.send();
        }
        function deletePolys() {
            // Clear map from polylines if these are exist 
            if (poly) {
                for (i in poly) {
                    poly.setMap(null);
                }
                poly.length = 0;
            }   
        }
        function deleteMarkers() {
            // Clear map from markers if these are exist 
            if (markers){
                for (i in markers) {
                    markers[i].setMap(null);
                }
                markers.length = 0;
            }
        }
    </script>
</head>
<body onload="load()" onunload="GUnload()">
    <div id="wrapper">
        <div>
            <div>
                <h4>Administration panel</h4>
                <h2><a href="../index.php">Shortest path problem</a></h2>
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
                            <td colspan="2"><h1>Add new route</h1></td>
                        </tr>
                        <tr>
                            <td>Transport Type:</td>
                            <td><select id="pathType">
                                <option value="">Select...</option>
                                <option value="bus">Bus</option>
                                <option value="minibus">Minibus</option>
                                <option value="trolleybus">Trolleybus</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Route Number: </td>
                            <td><input type="text" id="pathNum" onkeyup="checkNum(this.value)" size="2"/></td>
                        </tr>
                        <tr><td colspan="2"><span id="pathCheck"></span></span></td></tr>
                    </table>
                    <input type="button" onclick="savePath()" value="Save" />
                    <input type="button" onclick="reset()" value="Reset" />
                    <input type="button" onclick="location.href='panel.php'" value="Back" />
                </div>
				
				<div style="clear: both;">&nbsp;</div>
				</div>
			</div>
            
        </div>
    </div>
    <div id="footer">
        
    </div>
</body>
</html>
