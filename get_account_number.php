<?php
ob_start();
include("../includes/pttec_includes.phtml");
// printarray($_REQUEST);
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin",'popup');
?>
<div align="center">
<table bordercolor="#000000" cellpadding="3" cellspacing="3">
<TR><TD><span class="Head2_Green"> Retrieve Account/Family Number</span></TD></TR>
<BR><BR>
<?
If(!(isEmpty($_REQUEST['$email_username']))){
		$$email_username = $_REQUEST[$email_username];
		$family_id = singlequerry("select id FROM PT_Family_Info where billing_email='".addslashes($email_username)."' OR main_email='".addslashes($email_username)."' LIMIT 1");
		$family_name = get_fam_name($family_id);
echo "<TR><td>Family/Account Number for $family_name is $family_id<BR><BR><BR></td></tr>";

}	


?>
<form name="form1">
<TR><TD>

<input name="email_username" type="text" size="30" maxlength="30">

<BR> <BR>
<input name="" type="submit"> &nbsp;&nbsp;<button onclick="popup_close()">Close</button>
</td></tr></form></table></div>
