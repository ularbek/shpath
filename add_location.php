<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Student    : Alexey Murkaev  
Project    : BPT GIS
Date       : May, 2010
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
	<script type="text/javascript">
		var map;
        var loc;
        function load(){
            var options = {
              zoom: 13,
              center: new google.maps.LatLng(42.87192, 74.61150),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById('map'), options);
            
            google.maps.event.addListener(map, 'click', addLocation);
        }
        function addLocation(event){
            var marker = new google.maps.Marker({ 
                position: event.latLng, 
                map: map, 
                draggable: true
            });
            loc = event.latLng;
            
        }
        function saveLocation(){
            var url;
            var lat = loc.lat();
            var lng = loc.lng();
            
            var address = document.getElementById("address").value; 
            var type = document.getElementById("addType").value;
            var image = document.getElementById("picture").value; 
            
            /*var pathCheck = document.getElementById("pathCheck").innerHTML;*/ 
            if (address ==""){
                alert("Address field is empty!"); return;
            }
            if (type ==""){
                alert("Address type field is empty!"); return;
            }
            /*if (pathCheck !=""){
                alert("Address is not unique!"); return;
            }*/
            
            url = "save_location.php?address="+address+"&lat="+lat+"&lng="+lng+"&type="+type+"&image="+image;
            
            downloadUrl(url, function(data, responseCode){});
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
                            <td colspan="3"><h1>Add Location</h1></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <form action="upload_file.php" method="post"
                                    enctype="multipart/form-data">
                                    <label for="file">Image:</label>
                                    <input type="file" name="photo" id="file" />
                                    <br />
                                    <input type="submit" name="submit" value="Upload" />
                                </form>
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                    if(isset($_GET['image']) && $_GET['image'] != ''){
                                        echo "<img id='pic' src='".$_GET['image']."'>";
                                        echo "<input id='picture' type='hidden' value='".$_GET['image']."' />";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="50px"></td>
                        </tr>
                        <tr>
                            <td>Address :</td>
                            <td>
                                <input id="address" type="text" name="from" size="15" />
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Type :</td>
                            <td>
                                <input id="addType" type="text" name="to" size="15" />
                            </td>
                            
                        </tr>
                        
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                <input type="button" onclick="saveLocation()" value="Add" />
                            </td>
                        </tr>
                        <tr>
							<td colspan="3"><b>Hint:</b> to add new Location select point on the map.</td>

						</tr>
						<tr>

							<td colspan="2"></td>
						</tr>
						<tr></tr>
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