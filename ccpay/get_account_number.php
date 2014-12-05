<?php
ob_start();
include("../includes/pttec_includes.phtml");
// printarray($_REQUEST);
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin",'popup');
?>

<div align="left"></div>
<table bordercolor="#000000" cellpadding="3" cellspacing="3" width="100%">
  <TR><TD><span class="Head2_Green"> Retrieve Account/Family Number<BR><BR><BR><BR><BR><BR></span></TD></TR>
  

  <form name="form1">
  <TR><TD>
  <?
//printarray($_REQUEST);

If(!(isEmpty($_REQUEST[email_username]))){



		$email_username = $_REQUEST[email_username];
		
		$iQStr = "select id FROM PT_Family_Info where billing_email='".addslashes($email_username)."' OR main_email='".addslashes($email_username)."' LIMIT 1";
		
		$family_id = singlequery($iQStr);
		
//		echo "string is $iQStr<BR>";
		
		$family_name = get_fam_name($family_id);
echo "Family/Account Number for $family_name is $family_id<BR><BR><BR>";

} else {
?>
  

  
  <div align="center">Email Address: 
      <input name="email_username" type="text" size="30" maxlength="30">
      <? } ?>
    
    <BR> 
      <BR>
      <BR>
      <BR>
      <input name="Submit" type="submit" id="Submit" value="Submit">
&nbsp;&nbsp;
  <button onclick="popup_close()">Close</button>
  </div>  
  </td></tr></form>
</table>
