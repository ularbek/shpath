 <?php 
 
 //This is the directory where images will be saved 
 $target = "images/locations/"; 
 $target = $target.basename( $_FILES['photo']['name']); 
 
 //This gets all the other information from the form 
 $pic=($_FILES['photo']['name']); 
 
 // Connects to your Database
 require("phpsqlajax_dbinfo.php");
 // Opens a connection to a MySQL server
$connection=mysql_connect ($host, $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

 //Writes the information to the database 
 mysql_query("INSERT INTO images(url) VALUES ('$target')") ; 
 
 //Writes the photo to the server 
 if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)){
    //Tells you if its all ok 
    header('Location: http://localhost/sh-path/add_location.php?image='.$target); 
 }else {
    //Gives and error if its not 
    echo "Sorry, there was a problem uploading your file."; 
 } 
 ?> 