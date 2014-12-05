<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");
include("../includes/.check_login.php");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Paul the Tutor's - Table Viewer", $strAbsPath, "tutors", "");


foreach($_SESSION as $key=>$value) { global ${$key}; ${$key} = $value;}
$strTable = "PT_Tutors";
 $strFields = "id, first_name, last_name,  nickname,  username,  password";
 $booledit = "view";
// printarray($_SESSION);

$sortby = $_GET[sortby];
$sortorder = $_GET[sortorder];


tableview($strTable, $strFields, $arColumn, $strRestrictions, $booledit, $sortby, $sortorder, $tableclass, $other);


put_ptts_footer("");
?>
