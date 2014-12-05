<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");

$folder = getfolder('','','');

?>
<link href="../../includes/paulthetutors.css" rel="stylesheet" type="text/css" />


<table  align="left" cellspacing="2" cellpadding="0" border="3" class=table_1>
<tr>
<td class=td_header>Select <? if($folder == "ldsatadmin") { ?>Student and <? } ?>Test Section</td>


</tr>
<tr>
<td width="600" >
<?
$action = "testans_get.php";
if(!isEmpty($_REQUEST[action]))
	$action = $_REQUEST[action];
?>


 <form name = "form" method="POST" action="<?=$action;?>"><br>
<?
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
<legend><span class="Head2"> Select a Section</span></legend>
<table border="0">

<tr valign="top">
 <td nowrap="nowrap">
 <fieldset>
 Blue Book


Page:
  <input name="bb_page_num" type="text" size="4" maxlength="4" id="bb_page_num" />&nbsp;&nbsp;&nbsp;&nbsp;<br />

  <span class="form_comments">Enter any page from the test section</span>
 </fieldset>
<br>
<fieldset>
PTTS ACT Book


Page:
  <input name="ptts_page_num" type="text" size="4" maxlength="4" id="ptts_page_num" />&nbsp;&nbsp;&nbsp;&nbsp;<br />

  <span class="form_comments">Enter any page from the test section</span>
</fieldset>
</td>
<td nowrap="nowrap">
<BR />
<div align="center" class="Head3">&nbsp;&nbsp;-OR-&nbsp;&nbsp;</div>
</td>
<td nowrap="nowrap">

<fieldset>

Test: <?

just_select_test();

?>
<BR />

Section:
<input name="section_num" type="text" size="3" maxlength="3" id="section_num" />
</fieldset>

</td></tr>

</table>
</fieldset>

<br />
<!--
<fieldset >
<legend><span class="Head2"> Select a Test</span></legend>
<table border="0">

<tr valign="top">
<td nowrap="nowrap">

Test: <?

// just_select_test();

?>

</td></tr>

</table>
</fieldset>
-->

<br />
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
