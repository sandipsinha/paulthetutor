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
 <form name = "form" method="POST" action="hwgrader03.php"><br>
<fieldset> 
<legend>Select a Student</legend>
 <table border="0" cellpadding="2" margin="0" cellspacing="2" bgcolor="#FFFFFF">    

        <?
select_testprep_student();
?></table></fieldset>
<br />
<fieldset >
<legend> Select a Section</legend>
<table border="0">

<tr valign="top">
 <td nowrap="nowrap">
 <fieldset>
 Blue Book 


Page:  
  <input name="bb_page_num" type="text" size="4" maxlength="4" id="bb_page_num" />&nbsp;&nbsp;&nbsp;&nbsp;<br />
  
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
<div align="center"> <input name="" type="submit" /></div>

      </form>

<br>

<script language="JavaScript" type="text/javascript">
 var frmvalidator = new Validator("form");
frmvalidator.addValidation("student_id","req","Please select a student");

</script> 
<?php
put_ptts_footer("");
?>