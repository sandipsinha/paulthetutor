<?php
//$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/config.php");
include($strAbsPath . "/includes/.check_login.php");
require_once($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();

put_ptts_header("Paul the Tutor's - Bill Information Page", $strAbsPath, "tutors", "");



$fid=$_SESSION['fid'];
$type = $_REQUEST['type'];
if ($type == '')
	$type = 'all';
$main_name = getMainName($fid);
?>
<span class="Head1_Green">Hello <?echo $main_name;?></span><span> (<?echo "Not $main_name?";?> <a href='login_parents.php?logout=1'>Logout</a>)<br/><br/></span>

<?

$page_name = phptohtm();

include("$page_name");

put_ptts_footer("");

?>
