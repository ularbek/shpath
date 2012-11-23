<?php
    require("../phpsqlajax_dbinfo.php");
    $connection = mysql_connect ($host, $username, $password);
    $db_selected = mysql_select_db($database, $connection);
    $query="SELECT login FROM admins ORDER BY login";
    $result=mysql_query($query);
    
    echo "<select id='user'>";
    while ($row = @mysql_fetch_assoc($result)){
        if ($row['login'] != 'root'){
            echo "<option value='{$row['login']}'>{$row['login']}</option>";
        }
    }
    echo "</select>";
    mysql_close($connection);
?>
