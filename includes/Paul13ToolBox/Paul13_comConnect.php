<?php
$chost="localhost";
$cusername="paul13";
$cpassword="212121";
	
If (!($ConnPaul13 = mysql_pconnect($chost, $cusername, $cpassword))){
}
$Paul13DB = "paul13_com";

mysql_select_db($Paul13DB, $ConnPaul13);
?>