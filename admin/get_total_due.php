<?php
ob_start();
include("../includes/pttec_includes.phtml");
// printarray($_REQUEST);
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin",'popup');
?>
<div align="center">
<table bordercolor="#000000" cellpadding="3" cellspacing="3">
<TR><TD><span class="Head2_Green"> Get total due for a family</span></TD></TR>
<BR><BR>
<?
If(!(isEmpty($_REQUEST['family_id']))){
	$family_id = $_REQUEST[family_id];
	$total_due = get_amount_due($family_id);
	$family_name = get_fam_name($family_id);
echo "<TR><td>Total due is $$total_due <BR><BR><BR></td></tr>";

}	


?>
<form name="form1">
<TR><TD>

<?
put_fam_menu("last", "family_id", $family_id, "Choose a Family", "document.form1.submit()");
?>
<BR> <BR>
<input name="" type="submit"> &nbsp;&nbsp;<button onclick="popup_close()">Close</button>
</td></tr></form></table></div>
