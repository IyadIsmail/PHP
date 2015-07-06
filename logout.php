<?php
session_start();
require_once 'config.php';
//redirect function
function returnheader($location){
	$returnheader = header("location: $location");
	return $returnheader;
}
// Connect to server and select databse.
 
$connection = mysql_connect("$host", "$username", "$password")or die("cannot connect");
$db_select = mysql_select_db("$db_name")or die("cannot select DB");

// destroy cookies and sessions
setcookie("userloggedin", "");
$username = "";
session_destroy();

//redirect
returnheader("index.php");

?>