<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");

?>
<link href="../../includes/paulthetutors.css" rel="stylesheet" type="text/css" />


<table  align="left" cellspacing="2" cellpadding="0" border="3" class=table_1>
<tr>
<td class=td_header>Select Student and Test Section</td>

   
</tr>
<tr>
<td width="600" >
<? (!isEmpty($_REQUEST[action])?$action = $_REQUEST[action]:$action = "testans_get.php");
?>


 <form name = "form" method="POST" action="<?=$action;?>"><br>
<? 
$folder = getfolder('','','');
if($folder == "ldsatadmin"){ ?>
<fieldset> 
<legend><span class="Head2">Select a Student</span></legend>
 <table border="0" cellpadding="2" margin="0" cellspacing="2" bgcolor="#FFFFFF">    

        <?
select_testprep_student();
?></table></fieldset>
<? } // if we need to ask about the student because we're in admin ?>
<br />
<fieldset >
<legend><span class="Head2"> Select a Test</span></legend>
<table border="0">

<tr valign="top">
<td nowrap="nowrap">

Test: <?

just_select_test();

?>

</td></tr>

</table>
</fieldset>
<div align="center"> <input name="" type="submit" /></div>

      </form>

<br>
<?
if($folder == "ldsatadmin"){ ?>

<script language="JavaScript" type="text/javascript">
 var frmvalidator = new Validator("form");
frmvalidator.addValidation("student_id","req","Please select a student");

</script> 
<? } // if this is the admin folder, make sure that the student_id is selected 

put_ptts_footer("");
?>