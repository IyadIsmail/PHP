<?php
session_start();
require_once 'config.php';
    // Create connection
mysql_connect($host, $username, $password) or
    die("Could not connect: " . mysql_error());
mysql_select_db($db_name);

$result = mysql_query("SELECT ca,n FROM tt1");
if (mysql_num_rows($result) > 0) { 
    echo "<table cellpadding=10 border=1>"; 
    while($row = mysql_fetch_array($result)) { 
        $out = str_replace(',', '.<br>', $row['n']);
        echo "<tr>"; 
        echo "<td height=100 width=250>".$row['ca']."<br>"."</td>"; 
        echo "<td height=100 width=250>".nl2br($out)."<br>"."</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
}     
    //while($row = mysql_fetch_array($result)) {
        //$out = str_replace(',', '.<br>', $row['n']);
        //echo  $row['ca']. nl2br($out)."<br/>";
    //}
    
    
    

    //$row = mysql_fetch_row($result);
    //$out = preg_replace('/\s/', ',', $row[0]);
    //echo $out;
   // $conn->close();


?>

