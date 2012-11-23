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
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Shortest path problem</title>
    <link href="../style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
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
            <div id="sidebar">
                <table>
                    <tr><td><h1>Management</h1></td></tr>
                    <tr><td><a href="add_route.php">Add transport route</a></td><tr>
                    <tr><td><a href="delete_route.php">Delete transport route</a></td></tr>
                    <tr><td><a href="add_intersection.php">Add route</a></td></tr>
                    
                    <tr><td><a href="user_management.php">User management</a></tr></td> 
                    <tr><td><a href="logout.php">Log out</a></tr></td>
                </table>
            </div>
        </div>
    </div>
    <div id="footer">

</div>
</body>
</html>
