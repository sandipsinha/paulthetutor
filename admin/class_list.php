<?php
ob_start();
include("../includes/pttec_includes.phtml");
// printarray($_REQUEST);
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin",'popup');
$CQStr = "select class_name, end_date from PT_SAT_Class_Info order by end_date DESC LIMIT 15";
$RS = runquery($CQStr);

?>
<div align="center">
<form><fieldset><legend>List of Classes</legend>
<table bordercolor="#000000" cellpadding="3" cellspacing="3">
<TR><TD>
<span class="Head2_Green"></span>
<BR><BR>
<?
while($row = mysql_fetch_array($RS)){
	echo "$row[0] <BR>";
}	
?>

<BR> <BR>
<button onclick="popup_close()">Close Window</button>
</td></tr></table></fieldset></form></div>
