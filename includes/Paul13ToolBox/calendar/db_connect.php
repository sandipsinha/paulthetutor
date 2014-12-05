<?php
$con = mysql_connect('localhost', 'root', 'asifiqbal');
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }
mysql_select_db("demo", $con);
?>