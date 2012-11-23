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
    <title>Shortest apth problem</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript"> 
        var poly, map; 
        var markers = [];
        var path = new google.maps.MVCArray();
        var infowindow;
        var intersections = new Array(2);
        var count = 0;
        var cntr = 0;
        
        function load() {
            var options = {
              zoom: 12,
              center: new google.maps.LatLng(42.87192, 74.61150),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById('map'), options);
            
            google.maps.event.addListener(map, 'click', addPoint);
            
            for(var j=0; j<2; j++){
                intersections[j] = new Array(2);
            }            
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
        function savePoint() { 
            var url;
            
            for (var i = 0; i < path.getLength(); i++){ 
                var latlng = path.getAt(i); 
                var lat = latlng.lat(); 
                var lng = latlng.lng(); 
                var order = i+1;
                
                url = 'save_point.php?lat=' + lat +
                    '&lng=' + lng;
                downloadUrl(url, function(data, responseCode){});
            }
            alert("Route has been successfully added."); 
            reset();
        }
        function saveInter(){
            var url;
            var lat1 = intersections[0][0];
            var lng1 = intersections[0][1];
            var lat2 = intersections[1][0];
            var lng2 = intersections[1][1];
            addInter(lat2, lng2);
            
            url = 'save_intersections.php?lat1=' + lat1 +
                '&lng1=' + lng1 + '&lat2=' + lat2 +
                '&lng2=' + lng2;
            
            downloadUrl(url, function(data, responseCode){});
            alert("Route has been successfully added."); 
            reset();
        }
        
        function addInter(latitute, longitute){
            var url;
            url = 'save_point.php?lat=' + latitute +
                '&lng=' + longitute;
            downloadUrl(url, function(data, responseCode){});
            
        }
        function showInter(){
            deletePoly();
            
            var search_path = '../phpsqlajaxgen_xml2.php'; 
            // Getting coordinates from database and drawing a line 
            downloadUrl(search_path, function(data) {
                var xml = parseXml(data);
                var markers = xml.documentElement.getElementsByTagName("marker");
                
                for (var i=0; i<markers.length; i++) {
                    var name = markers[i].getAttribute('name');
                    var address = markers[i].getAttribute("address");
                    var type = markers[i].getAttribute("type");
                    var point = new google.maps.LatLng(
                        parseFloat(markers[i].getAttribute("lat")),
                        parseFloat(markers[i].getAttribute("lng"))
                    );
                    var marker = createMarker(point, name, address);
                }
                
            });
        }
        function createMarker(point, name, address, type){
            var marker = new google.maps.Marker({
                position: point,
                map: map,
                draggable: true,
            });
            var html = "<b>Click second marker to connect</b><br />" + address + 
                "<br />";
            google.maps.event.addListener(marker, 'click', function(){
                
                if(cntr == 1){
                    var latlng = marker.getPosition();
                    var lat = latlng.lat();
                    var lng = latlng.lng();
                    
                    intersections[1][0] = lat;
                    intersections[1][1] = lng;
                    
                    var route = [
                        new google.maps.LatLng(intersections[0][0], intersections[0][1]),
                        new google.maps.LatLng(intersections[1][0], intersections[1][1])
                    ]
                    poly = new google.maps.Polyline({
                        path:  route,
                        strokeColor: "#ff0000",
                        strokeOpacity: 0.6,
                        strokeWeight: 5
                    });
                    poly.setMap(map);
                    
                    var url;
                    var lat1 = intersections[0][0];
                    var lng1 = intersections[0][1];
                    var lat2 = intersections[1][0];
                    var lng2 = intersections[1][1];
                    
                    url = 'save_intersections.php?lat1=' + lat1 +
                        '&lng1=' + lng1 + '&lat2=' + lat2 +
                        '&lng2=' + lng2;
                    
                    downloadUrl(url, function(data, responseCode){});
                    alert("Route has been successfully added."); 
                    reset();
                            
                }else{
                    var latlng = marker.getPosition();
                    var lat = latlng.lat();
                    var lng = latlng.lng();
                        
                    intersections[0][0] = lat;
                    intersections[0][1] = lng;
                    
                    cntr++;
                    if(!infowindow){
                        infowindow = new google.maps.InfoWindow();
                    }
                    infowindow.setContent(html);
                    infowindow.open(map, marker);
                }
                
            });
            google.maps.event.addListener(marker, 'dblclick', function(){
            marker.setMap(null);
            
            for (var i = 0,l = markers.length; i < l && markers[i] != marker; ++i); 
                    markers.splice(i, 1); 
                    path.removeAt(i);
            });
            google.maps.event.addListener(marker, 'dragstart', function(){
                var latlng = marker.getPosition();
                var lat = latlng.lat();
                var lng = latlng.lng();
                
                var get_position = '../phpsqlajaxgen_xml2.php';
                // Getting coordinates from database and drawing a line 
                downloadUrl(get_position, function(data) {
                    var xml = parseXml(data);
                    
                    var markers = xml.documentElement.getElementsByTagName("marker");
                    
                    for (var i=0; i<markers.length; i++) {
                        var name = markers[i].getAttribute('name');
                        var address = markers[i].getAttribute("address");
                        var type = markers[i].getAttribute("type");
                        var point = new google.maps.LatLng(
                            parseFloat(markers[i].getAttribute("lat")),
                            parseFloat(markers[i].getAttribute("lng"))
                        );
                        
                        if(markers[i].getAttribute("lat")==lat && markers[i].getAttribute("lng")==lng){
                            var marker = createMarker(point, name, address);
                            for(var j=0; j<2; j++){
                                intersections[count][0] = lat;
                                intersections[count][1] = lng;
                            }
                            count++;
                        }
                    }
                    
                });
               
            });
            google.maps.event.addListener(marker, 'dragend', function(){
                var latlng = marker.getPosition();
                var lat = latlng.lat();
                var lng = latlng.lng();
                for(var j=0; j<2; j++){
                    intersections[count][0] = lat;
                    intersections[count][1] = lng;
                }
                var route = [
                    new google.maps.LatLng(intersections[0][0], intersections[0][1]),
                    new google.maps.LatLng(intersections[1][0], intersections[1][1])
                ]
                poly = new google.maps.Polyline({
                    path:  route,
                    strokeColor: "#ff0000",
                    strokeOpacity: 0.6,
                    strokeWeight: 5
                });
                poly.setMap(map);
            });
            return marker;
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
        function parseXml(str) {
            if (window.ActiveXObject) {
                var doc = new ActiveXObject('Microsoft.XMLDOM');
                doc.loadXML(str);
                return doc;
            }else if (window.DOMParser) {
                return (new DOMParser).parseFromString(str, 'text/xml');
            }
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
                            <td colspan="2"><h1>Add new intersection</h1></td>
                        </tr>
                        
                        <tr><td colspan="2"><span id="interCheck"></span></span></td></tr>
                    </table>
                    <input type="button" onclick="showInter()" value="Show all" />
                    <input type="button" onclick="savePoint()" value="Save Point" />
                    <input type="button" onclick="saveInter()" value="Save Inter" />
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
