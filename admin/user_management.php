<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtmll/DTD/xhtmll- strict.dtd">
<?php
    //start the session 
    session_start();
    //check to make sure the session variable is registered 
    if(!isset($_SESSION['login'])){
        header( "Location: index.php");
    }
?>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Shortest path problem</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript">
        var xmlhttp; 
        function saveUser(){
            var userName = document.getElementById("name").value;
            var userSurname = document.getElementById("surname").value;
            var login = document.getElementById("login").value;
            var password = document.getElementById("passwd").value;
            var userCheck = document.getElementById("userCheck").innerHTML;
            
            if (userCheck != ""){
                alert("User login is not unique!"); return;
            }
            if (userName == ""){
                alert("User name field is empty!"); return;
            }
            if (userSurname==""){
                alert("User surname field is empty!"); return;
            }
            if (login==""){
                alert("Login field is empty!"); return;
            }
            if (password==""){
                alert("Password field is empty!"); return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari 
                xmlhttp = new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.open("GET",'save_user.php?userName='+userName+'&userSurname='+userSurname+'&login='+login+'&password='+password, true);
            xmlhttp.send();
            alert("User has been successfully added!");
            document.getElementById("name").value="";
            document.getElementById("surname").value="";
            document.getElementById("login").value="";
            document.getElementById("passwd").value="";
        }
        function deleteUser() {
            var login = document.getElementById("user").value;
            
            if (login==""){
                alert("Select login from the list!"); return;
            }
            var r = confirm("Do you realy want to delete this user?"); 
            if (r==false) {
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari 
                xmlhttp=new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            
            xmlhttp.open("GET", 'delete_user.php?login='+login, true); 
            xmlhttp.send();
            alert(login +" has been deleted!"); 
            showUsers();
        }
        function checkUser(str) {
            if (str=="") {
                document.getElementById("login").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest) {           
                // code for IE7+, Firefox, Chrome, Opera, Safari 
                xmlhttp = new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    document.getElementById("userCheck").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", 'checkUser.php?login='+str, true); 
            xmlhttp.send();
        }
        function showUsers() {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari 
                xmlhttp=new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() { 
                if (xmlhttp.readyState==4) { 
                    document.getElementById("deleteUser").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", 'showusers.php', true);
            xmlhttp.send(null);
        }
    </script>
</head>
<body>
    <div id="wrapper">
        <div>
            <h4>Administration panel</h4>
            <h2><a href="../index.php">Shortest path problem</a></h2>
            <p>Shortest path problem by using Google Map API </p>
        </div>
        <div id="page">
            <div class="mapstyle" id="map"></div>
            <h1>User management</h1>
            <div>
                <b>Add user:</b><br/>
                <table>
                    <tr>
                        <td>User name:</td>
                        <td><input type="text" id="name" /></td>
                    </tr>
                    <tr>
                        <td>User surname: </td>
                        <td><input type="text" id="surname" /></td>
                    </tr>
                    <tr>
                        <td>Login: </td>
                        <td><input type="text" id="login" onkeyup="checkUser(this.value)" /></td> 
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="password" id="passwd"/></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span id="userCheck"></span></td>
                    </tr>
                    <tr>
                        <td><input type="submit" onclick="saveUser()" value="Save"/></td>
                    </tr>
                    <tr>
                        <td> </td>
                    </tr>
                    <tr>
                        <td><b>Delete user:</b></td>
                        <td><div id="deleteUser">List of users</div></td>
                    </tr>
                </table>
                <input type="button" onclick="showUsers()" value="Show"/>
                <input type="button" onclick="deleteUser()" value="Delete"/>
                <input type="button" onclick="location.href='panel.php'" value="Back"/>
            </div>
        </div>
    </div>
    <div id="footer">
        
    </div>
        <!-- end #footer -->
</body>
</html>
