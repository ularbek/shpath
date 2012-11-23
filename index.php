<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

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
			// Event listener for placing points A & B
			google.maps.event.addListener(map, "click", function(event) {
				deletePolys();
				if (cntr == 2) {
					deleteMarkers();
					cntr=0;
					ab = [];
                    
				}
                if(cntr == 0){
                    
                    markerIcon = 'images/markerA.png'; 
                }else{
				    markerIcon = 'images/markerB.png';
				}
				ab[cntr] = event.latLng;
				var marker = new google.maps.Marker({
					clickable: false,
					position: event.latLng,
					icon: markerIcon,
					map: map
				});
				markersArray.push(marker);
				cntr++;
				if (cntr == 2){
					find_path_AB();
				}
			});
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
				// code for IE6, IE5
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					document.getElementById("pathNumber").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "pathNumbs.php?pathType=" + str, true);
			xmlhttp.send();
		}
		
		function  find_path_AB(){
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
					document.getElementById("searchab").innerHTML=xmlhttp.responseText;
					for (var c=0; c<11; c++){
						progressBar.start(10);
						progressBar.updateBar(c);
						setTimeout('doNothing()', 10);
					}
				}
			}
            
			xmlhttp.open("GET", "searchAB.php?latA="+ab[0].lat()+"&lngA="+ab[0].lng()+"&latB="+ab[1].lat()+"&lngB="+ab[1].lng(), true);
			xmlhttp.send();
		}
		function find_short_Path(){
		    deletePolys();
			poly = new google.maps.Polyline(polyOptions);
			poly.setMap(map);
            
            var url;
            url = "shortPath.php?latA="+ab[0].lat()+"&lngA="+ab[0].lng()+"&latB="+ab[1].lat()+"&lngB="+ab[1].lng();
            
            downloadUrl(url, function(data) {
				var xml = parseXml(data);
				var markers = xml.documentElement.getElementsByTagName("marker");
                var p = xml.documentElement.getElementsByTagName("point");
				for (var i = 0; i < markers.length; i++) {
					progressBar.start(markers.length-1);
					progressBar.updateBar(i);
					setTimeout('doNothing()', 20);
					var point = new google.maps.LatLng(
    					parseFloat(markers[i].getAttribute("lat")),
    					parseFloat(markers[i].getAttribute("lng")));
					var path = poly.getPath();
					path.insertAt(pathCoordinates.length, point);
                    intersections[i] = point;
				}
                /*for(var i=0; i<p.length; i++){
                    alert(p[i].getAttribute("num"));    
                }*/
                
			});
            
		}
        
		function searchPath(){
			// Search database for a route btwn A & B points
			infowindow.close();
		    deletePolys();
			progressBar.hide();
			poly = new google.maps.Polyline(polyOptions);
			poly.setMap(map);
			var searchStr = document.getElementById('pathAB').value;
			var arr = searchStr.split(" ");
			var pathNum = arr[0];
			var pathType = arr[1];
			//alert n
			var search_path = 'phpsqlajaxgen_xml.php?path='+pathNum+'&type='+pathType;
			// Getting coordinates from database and drawing a line
			downloadUrl(search_path, function(data) {
				var xml = parseXml(data);
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					progressBar.start(markers.length-1);
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
        
		function addLocationA(){
            deletePolys();
            deleteMarkers();
            var from = document.getElementById("from").value;
            
            var search_location = 'search.php?address='+from;
            markerIcon = 'images/markerA.png';
             
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
        function addLocationB(){
            var to = document.getElementById("to").value;
            
            var search_location = 'search.php?address='+to;
            markerIcon = 'images/markerB.png';
             
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
                    ab[1] = point;
                    var marker = createMarker(point, address, type, image);
                }
                find_path_AB(); 
            });
		}
		function createMarker(point, address, type, image){
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
					<table>
                        <tr>
                            <td colspan="3"><h1>Search by address</h1></td>
                        </tr>
                        <tr>
                            <td colspan="3">Find Location by Address:</td>
                        </tr>
                        <tr>
                            <td>From</td>
                            <td>
                                <input id="from" type="text" size="15" />
                            </td>
                            <td>
                                <input class="searchBtn" type="submit" onclick="addLocationA()" value="Add" />
                            </td>
                        </tr>
                        <tr>
                            <td>to</td>
                            <td>
                                <input id="to" type="text" size="15" />
                            </td>
                            <td>
                                <input type="button" onclick="addLocationB()" value="Add" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="button" onclick="find_short_Path()" value="Find" /></td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Hint:</b> to find address please write address name on the text field and click Add button.If you don't know addresses you can <a href="locations.php">click here</a>.</td>
                        </tr>
						<tr>
							<td colspan="3"><h1>View existing routes</h1></td>
						</tr>
						<tr>
							<td>Transport Type:</td>
							<td>

								<select id="pathType" name="transport" onchange="showNumbs(this.value)">
									<option value="">Select...</option>
									<option value="bus">Bus</option>
									<option value="minibus">Minibus</option>
									<option value="trolleybus">Trolleybus</option>
								</select>
							</td>

						</tr>
						<tr>
							<td>Route Number: </td>
							<td>
								<div id="pathNumber">...</div>
							</td>
						</tr>
						<tr>

							<td><input type="button" onclick="showPath()" value="Show"/></td>
						</tr>
						<tr>
							<td colspan="3"><h1>Search for a route:</h1></td>
						</tr>
						<tr>
							<td>Variants: </td>
							<td>

								<div id="searchab">...</div>
							</td>
						</tr>
						<tr>
							<td><input type="button" onclick="searchPath()" value="Show"/></td>
						</tr>
						<tr>
							<td colspan="3"><b>Hint:</b> to find a path to get from point A to point B, please, select two points on the map.</td>

						</tr>
                        
                        <tr>
                            <td colspan="3"><h1>Find shortest path</h1></td>
                        </tr>
                        <tr>
							<td>Variants: </td>
							<td>

								<div id="shortpath">...</div>
							</td>
						</tr>
                        <tr>
                            <td colspan="2"><input type="button" onclick="find_short_Path()" value="Find" /></td>
                        </tr>
						
						<tr>

							<td colspan="2"></td>
						</tr>
						<tr>
                            <td colspan="3"><a class="reset" href="index.php">RESET</a></td>
                        </tr>
					</table>
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