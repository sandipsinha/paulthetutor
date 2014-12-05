<?php
$msg = "";

$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

$page_name = phptohtm();
include("$page_name");

?>
