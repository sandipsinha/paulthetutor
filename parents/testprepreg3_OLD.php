<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");
include("../includes/.check_login.php");

// Contact page for parents 

//check if the user is logged in
MySQL_PaulTheTutor_Connect();
put_ptts_header("Sign Up for LD SAT Prep at Paul the Tutor's", $strAbsPath, "parents", "");

$fid=$_SESSION['fid'];
$main_name = getMainName($fid);
?>
Hello <?echo $main_name;?></span><span> (<?echo "Not $main_name?";?> <a href='login_parents.php?logout=1'>Logout</a>)<br/><br/>
<?

$page_name = phptohtm();
include("$page_name");


put_ptts_footer("");
?>
