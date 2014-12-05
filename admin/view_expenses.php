<?php
ob_start();



$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

if(!(isEmpty($_REQUEST))){
	foreach($_REQUEST as $key=>$value) { global ${$key}; ${$key} = $value;}
}	


$strTable = "PT_Expenses";

$NQst = "select show_name from PT_Table_Info where name = '$strTable'";
$TName = "Expenses";



put_ptts_header("$TName Viewer", $strAbsPath, "tutors", "");


 $booledit = "full";
// printarray($_SESSION);

if($_GET[sortby]){
	$sortby = $_GET[sortby];
	$sortorder = $_GET[sortorder];

} else {
	$sortby = "id";
	$sortorder = "DESC";
}

$refresh_link = $_SERVER['REQUEST_URI'];

?>
<style type="text/css">
<!--
.style2 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>

  
  <link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
<div align="center"><a class="Head2" onclick="javascript:popup('edit_expense.php','Details','600','820')"> <img src="../images/add_256.png" alt="Add Entry" width="27" height="27">  <span class="style2">Add
an Entry</span>  </a><BR>
  <span class="Head1"><?=$TName;?> Table</span><BR><BR>

  <?
tableview($strTable, $strFields, $arColumn, $strRestrictions, $booledit, $sortby, $sortorder, $tableclass, $other);


put_ptts_footer("");
?>
