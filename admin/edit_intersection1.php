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
        var infowindow;
        var intersections = [];
        
        function load() {
            var options = {
              zoom: 12,
              center: new google.maps.LatLng(42.87192, 74.61150),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById('map'), options);
            
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
        function saveInter() { 
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
            });
            var html = "<b>" + name + "</b><br />" + address + 
                "<br />";
            google.maps.event.addListener(marker, 'click', function(){
                if(!infowindow){
                    infowindow = new google.maps.InfoWindow();
                }
                infowindow.setContent(html);
                infowindow.open(map, marker); 
            });
            google.maps.event.addListener(marker, 'dblclick', function(){
                
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
        function checkNum(str) { 
            if (str=="") {
                document.getElementByld("pathNum").innerHTML="";
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
                    document.getElementByld("pathCheck").innerHTML=xmlhttp.responseText; 
                }
            }
            var pathType = document.getElementByld("pathType").value;
            xmlhttp.open("GET","checkNum.php?pathNum="+str+"&pathType="+pathType,true);
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
                            <td colspan="2"><h1>Edit intersection</h1></td>
                        </tr>
                        
                        <tr><td colspan="2"><span id="interCheck"></span></span></td></tr>
                    </table>
                    <input type="button" onclick="showInter()" value="Show all" />
                    <input type="button" onclick="saveInter()" value="Save" />
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
