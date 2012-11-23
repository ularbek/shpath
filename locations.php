<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Student    : Ularbek Turdukeev  
Project    : Shortest path problem by using Google Map API
Date       : June, 2012
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>Shortest path problem by using Google Map API</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

	<link rel="icon" href="images/favicon.png" type="image/x-icon" /> 
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript" src="http://code.google.com/apis/gears/gears_init.js"></script>
	<script type="text/javascript" src="admin/progressBar.js"></script>
    <?php
        if(isset($_GET['types'])){
            $types = $_GET['types'];
            $script = '<script type="text/javascript">var loc=[';
            foreach($types as $type){
                $script .= "'".$type."',";
            }
            $script .= '];</script>';
            echo $script;
        }
        
    ?>
	<script type="text/javascript">
		var xmlhttp;
		var pathCoordinates = [];
		var ab = []; // latitude & langitude of markers
        var markerIcon;
        
		var markersArray = []; 
		var map;
		var poly; // polyline
		var cntr = 0;
        var cout = 0;
		var polyOptions = {
			path: pathCoordinates,
			strokeColor: '#ee2424',
			strokeOpacity: 1.0,
			strokeWeight: 3
		}
		var currentLocation;
		var infowindow = new google.maps.InfoWindow();
		var progressBar;
        var intersections = [];
        var image = "images/locations/63.jpg";
		
        
		function load() {
			var useragent = navigator.userAgent;
			if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
				window.location = "smartphone.php"
			} 
			// Loading google map to the web page
			map = new google.maps.Map(document.getElementById("map"), {
				center: new google.maps.LatLng(42.87192, 74.61150),
				zoom: 12,
				mapTypeId: 'roadmap'
			});
			progressBar = new progressBar(); 
			map.controls[google.maps.ControlPosition.RIGHT].push(progressBar.getDiv());
			
            findTypes();
            if(loc.length > 0){
                for(var i=0; i<loc.length; i++){
                    getLocation(loc[i]);
                }
            }
		}
		
		function showPath(){
			deletePolys();
			deleteMarkers();
			infowindow.close();
			poly = new google.maps.Polyline(polyOptions);
			poly.setMap(map);
			var path_num = document.getElementById('path').value;
			var type = document.getElementById('pathType').value;
			var search_path = 'phpsqlajaxgen_xml.php?path='+path_num+'&type='+type;
            
			// Getting coordinates from database and drawing a line
			downloadUrl(search_path, function(data) {
                
				var xml = parseXml(data);
				var markers = xml.documentElement.getElementsByTagName("marker");
				progressBar.start(markers.length-1);
				for (var i = 0; i < markers.length; i++) {
					progressBar.updateBar(i);
					setTimeout('doNothing()', 20);
					var point = new google.maps.LatLng(
					parseFloat(markers[i].getAttribute("lat")),
					parseFloat(markers[i].getAttribute("lng")));
					var path = poly.getPath();
					path.insertAt(pathCoordinates.length, point);
				}
                
			});
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
			}
			else if (window.DOMParser) {
				return (new DOMParser).parseFromString(str, 'text/xml');
			}
		}
        function findTypes(){
            if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp= new XMLHttpRequest();
			}
			else {
				// code for IE6, IE5
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					document.getElementById("types").innerHTML=xmlhttp.responseText;
					for (var c=0; c<11; c++){
						progressBar.start(10);
						progressBar.updateBar(c);
						setTimeout('doNothing()', 10);
					}
				}
			}
            
			xmlhttp.open("GET", "getLocations.php", true);
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
			if (markersArray){
				for (i in markersArray) {
					markersArray[i].setMap(null);
				}
			}
		}
        function getLocation(type){
            deletePolys();
            deleteMarkers();
            
            var search_location = 'showLocation.php?type='+type;
            
             
            // Getting coordinates from database and drawing a line 
            downloadUrl(search_location, function(data) {
                var xml = parseXml(data);
                var markers = xml.documentElement.getElementsByTagName("marker");
                
                for (var i=0; i<markers.length; i++) {
                    var address = markers[i].getAttribute("address");
                    var type = markers[i].getAttribute("type");
                    var point = new google.maps.LatLng(
                        parseFloat(markers[i].getAttribute("lat")),
                        parseFloat(markers[i].getAttribute("lng"))
                    );
                    image = markers[i].getAttribute("image");
                    if(image == ""){
                        image = "images/locations/no_image.jpg";
                    }
                    ab[0] = point;
                    var marker = createMarker(point, address, type, image);
                }
                
            });
        }
		function createMarker(point, address, type, image){
            switch(type){
                case 'university':
                    markerIcon = 'images/university.png';
                    break;
                case 'coffee':
                    markerIcon = 'images/coffee.png';
                    break;
                case 'address':
                    markerIcon = 'images/home.png';
                    break;
                case 'supermarket':
                    markerIcon = 'images/supermarket.png';
                    break;
                case 'congress':
                    markerIcon = 'images/congress.png';
                    break;
                default:
                    markerIcon = '';
                    break;
            }
            var marker = new google.maps.Marker({
                position: point,
                icon: markerIcon,
                map: map,
            });
            var html = "<b><img id='pic' src=" + image + " />" + "</b><br />" + address + 
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
		function doNothing() {}
	</script>
</head>
<body onload="load()" onunload="GUnload()">
	<div id="wrapper">
		<div>

			<div id="logo">
				<h2><a href="index.php">Shortest path problem</a></h2>
				<p>Shortest path problem by using Google Map API</p>
			</div>
            <div id="top_menu">
                <a href="add_location.php">Add new Location</a>
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

				<div id="sidebar">
                    <form action="locations.php" method="GET" >
					<table cellpadding="0" cellspacing="0">
                        <tr>
                            <td id="types">
                            </td>
                        </tr>
                    </table>
                    <input type="submit" value="Show"  />
                    </form>
                    <br />
                    <br />
                    <p><b>Hint:</b> If you find address please go <a href="index.php">back</a> and fill the search by address.</p>
                    <a class="reset" href="locations.php">RESET</a>
				</div>
				<!-- end #sidebar -->
				<div style="clear: both;">&nbsp;</div>
				</div>
			</div>

		</div>
	<!-- end #page -->
	</div>
	<div id="footer">
		
	</div>
	<!-- end #footer -->

</body>
</html>