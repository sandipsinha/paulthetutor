<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

//include($strAbsPath . "/includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "tutors", "");
$page_name = phptohtm();
include("$page_name");
put_new_footer();

?>
