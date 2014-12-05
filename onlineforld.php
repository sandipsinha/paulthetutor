<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");


put_ptts_header("", $strAbsPath, "", "");
$page_name = phptohtm();
include("$page_name");
include("distance_nav.htm");
put_ptts_footer("");

?>
