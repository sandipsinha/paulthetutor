<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();
reqToVars();

put_ptts_header("SAT Class Info", $strAbsPath, "", "");
$page_name = phptohtm();
include("$page_name");
put_ptts_footer("");


?>
