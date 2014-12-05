<?php
//check if the user is logged in
//$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/config.php");
include($strAbsPath . "/includes/.check_login.php");
require_once($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
reqToVars();
echo"<link rel='stylesheet' type='text/css' href=$strAbsPath . '/paulthetutors_com/includes/paulthetutors.css' />";

put_ptts_header("Paul the Tutor's - View Bill Page", $strAbsPath, "tutors", "");

$famid=$_SESSION['fid'];
$fid = $famid;
$main_name = getMainName($fid);
?>
<span class="Head1_Green">Hello <?echo $main_name;?></span><span> (<?echo "Not $main_name?";?> <a href='login_parents.php?logout=1'>Logout</a>)<br/><br/></span>
<?
$page_name = phptohtm();
include("$page_name");

put_ptts_footer("");

?>
