<?php
$dbServer = "localhost";
$dbUsername = "root";
$dbPassword = "";
//$db = "elections";

$connect = mysql_connect($dbServer, $dbUsername, $dbPassword);

if(!$connect){
die('Could not connect to the DB: ');
}
/*$dbConnect = mysql_select_db($db, $connect);
if(!$dbConnect){
die('Could not conncet to the db: '. mysql_error());
}*/
?>