<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
//MySQL_PaulTheTutor_Connect();
//$popup = $_REQUEST[popup];
// printarray($_REQUEST);

?>
<?php 
	put_ptts_header("Applying For Admin Position", $strAbsPath, "", $popup);
?>
<?
analytics();
put_ptts_footer("popup");

?>