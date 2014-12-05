<?php
//ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

//include($strAbsPath . "/includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();

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
-->
</style>
<table width="686" border="2" cellpadding="3" cellspacing="0" background="../images/flowbg.gif">

  <tr>
    <td height="25" colspan="2" valign="top"><span class="Head1_Green">
        Tutuors Enter Your Information </span>
      <div align="right"></div></td>
 </tr>
 <?
 if (isset($_REQUEST['ok_double_registration']) && $_REQUEST['ok_double_registration'] == 0){
	echo '<tr>
			<td align=center class=text_error colspan=2><div class=div_error>'.$_REQUEST['msg_double'].' <span class=text_normal>Retrieve your informations <a class=a_blue href="getlostinfo.php">here</a>.</div></td>
	      </tr>';
	      $arFieldsVals = $_REQUEST;
      } else { $arFieldsVals = null; }
 ?>  
  <tr>
 
    <td height="51" valign="top">
<form method="post" name="tutors" id="tutors" action="puttutorinfo.php">
<?
$arFieldComments['gvoice_phone'] = "(510) 730-03XX provided by Paul the Tutor's.<BR>If none provided, leave blank";
$arFieldNames['gvoice_phone'] = "Google Voice Phone Number";
$arFieldComments['gc_username'] = "We will connect our calendar to your Google Calendar<BR>Usually your GMail address";
$arFieldNames['gc_username'] = "Google Calendar Username";
$arFieldComments['alert_preference'] = "How you would like to receive reminders";


$strNotUsed = "resume,id,gc_name,nickname,cell_carrier,email,position_name,archived,position";
putHiddenField("strNotUsed", $strNotUsed);
putHiddenField("position", "tutor");
$arReq = MySQL_JustForm("PT_Tutors", $arFieldNames, $arFieldsVals,$arFieldComments,null,$strNotUsed, "tutors");
$secret = '<tr valign="middle"><td><div align="right" valign="middle">';
$secret .= 'Secret Code<font color="#FF0000">*</font></div></td><td>';
$secret .= '<input type="text" name="secret" size="16" maxlength="40"><td></tr>';

MySQL_JustForm_End($arReq, "tutors", array('extra_input'=>$secret),$strNotUsed);
?>
</form>

&nbsp;	
    </td>
	  
	  
  </tr>
<tr>
  <td height="138" colspan="3">&nbsp;</td>
</tr>  
</table>
</body>
</html>

<?
put_ptts_footer("");

?>
