<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

// printarray($_REQUEST);

$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "tutors", "");
?>
<link href="../NewPTTcss.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.plain {
	font-weight: normal;
}
.style3 {font-weight: normal; font-size: 12px; }
.book_position {
	left: 5px;
	top: 450px;
	position: absolute;
}
.style6 {color: #FF0000}
-->
</style>

<style type="text/css" >
#divrecaptcha{
    width:500px;
    font-size:12px; font-family:Arial, Helvetica, sans-serif;
}
#controls{ width:180px; float:right; }
#recaptcha_image{
    padding:2px; background:#f9f9f9;
    border:1px solid #e0e0e0;
}
#recaptcha_response_field {
   border: 1px solid #999 !important; //Text input field border color
   background-color:#ccc !important; //Text input field background color
   width:120px !important;
   padding:5px;
}
#divrecaptcha a{
     font-size:11px;    font-family:Verdana;
    text-decoration:none; color:#3366ff;
}
#divrecaptcha a:hover{
     color:113399; text-decoration:underline;
}
</style>
   
 <form name="fam_register_form" method="post" action="fam_register_put.php"> <!--fam_register_put.php-->
<table width="675" border="0" cellpadding="5" cellspacing="0" background="../images/flowbg.gif">
<?
 if (isset($_REQUEST['ok_double_registration']) && $_REQUEST['ok_double_registration'] == '0'){
	echo '<tr><td align=center class=text_error colspan=2><div class=div_error>'.$_REQUEST['msg_double'];
        if (!isset($_REQUEST['bad_captcha'])) echo '<span class=text_normal> Retrieve your information <a class="a_blue" href="getlostinfo.php">here</a>';
        echo '. </div></td></tr>';
 } 
 ?>  
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>-->

  

  <tr>
    <td width="578" height="66" valign="top">
     
		
        <?php
$strNotUsed = getIgnoreColumns('PT_Family_Info', 'PT_Table_Info');
$strNotUsed = $strNotUsed . ",archived";
$arFieldComments['username'] = "please choose a username and password";
$arFieldComments['main_contact'] = "with whom should we correspond regarding tutoring";
$arFieldComments['billing_contact'] = "to whom should we send bills?";
$arFieldComments['mother'] = "first and last name";
$arFieldComments['father'] = "first and last name";
$arFieldComments['guardian'] = "first and last name";
$arFieldComments['mothers_email'] = "one email address(mother's, father's or guardian's) is required";
$arFieldComments['fathers_email'] = "one email address(mother's, father's or guardian's) is required";
$arFieldComments['guardians_email'] = "one email address(mother's, father's or guardian's) is required";

/*
$arFieldVals=array($_REQUEST['mother'],$_REQUEST['father'],$_REQUEST['guardian'],$_REQUEST['main_contact'],$_REQUEST['billing_contact'],$_REQUEST['username'],$_REQUEST['password'],$_REQUEST['main_phone'],$_REQUEST['mothers_phone'],$_REQUEST['fathers_phone'],$_REQUEST['guardians_phone'],$_REQUEST['mothers_email'],$_REQUEST['fathers_email'],$_REQUEST['guardians_email'],$_REQUEST['address'],$_REQUEST['city'],$_REQUEST['state'],$_REQUEST['zip']);*/
$arFieldsVals=null;

//$arRequired = MySQL_JustForm('PT_Family_Info', '', $arFieldsVals, $arFieldComments, $strUse, $strNotUsed, $tdStyle);
$arRequired = MySQL_JustForm('PT_Family_Info', '', $arFieldsVals, $arFieldComments, null, $strNotUsed, null);
?>	
 <tr>
 	<td align=right></td>
 	<td><input name="add_to_mailing_list" id="add_to_mailing_list" type="checkbox" checked>&nbsp;Add registrar to mailing list</td>
 </tr>		
 <tr> <td colspan="2">
 <div align="right">
          <input name="can_policy" id="can_policy" type="checkbox" value="" onclick="val_check()"> 
          Click here to indicate that you have read and understand the cancellation policy.<span class="style6">*</span><br>
          (<a href="http://www.paulthetutors.com/cancpolicy.php" target="_blank">read the cancellation policy</a>)</div>
</td></tr>		
<?php /*?><tr> <td align=right>Please enter the words to the right in the text box to prove you are human. If you can't read the words, <a href="javascript:Recaptcha.reload()">click here</a> to get new ones.</td><td><?php */?>
<script language="JavaScript" type="text/javascript">
function CheckEmails() {
	var frm = document.forms["fam_register_form"];
	if(frm.mothers_email.value=="" && frm.fathers_email.value=="" && frm.guardians_email.value=="")	{
		alert('You must enter at least one email address');
		frm.mothers_email.focus();
		return false;
	} else {
		if(!frm.can_policy.checked) {
			alert('Please indicate you have read and agree to the cancellation policy');
			frm.can_policy.focus();
                        return false;
		} 
        }
	if(!(/\w +\w/.test(frm.mother.value) || /\w +\w/.test(frm.father.value) || /\w +\w/.test(frm.guardian.value))) {
          alert('You must enter at least one full name');
          return false;
        }
        return true;
}


	
</script>		  
<?php
		  MySQL_JustForm_End($arRequired, "fam_register_form"); ?>
 <script language="Javascript" type="text/javascript">
 function val_check(){
	 if (document.getElementById('can_policy').checked == true)
	 	document.getElementById('can_policy').value=1;
	 else
	  	document.getElementById('can_policy').value='';
 }
	 	
 frmvalidator.addValidation("can_policy","req","Please check box to indicate you have read and agree to the cancellation policy");
 </script> 

 
    </td>
      </tr>
</table>
 </form> 
 
 <?
put_ptts_footer("");

?>
