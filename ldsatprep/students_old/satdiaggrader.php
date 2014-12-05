<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
if ($x_admin <> 1) {
	include('.check_login.php');
}	
$strTableName = "TP_SAT_Tests";
?>

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Choose Test</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST" action="satdiaggrader02.php"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    
<tr>
    <td colspan="2" align="left"><br>Choose a Test*</td>
</tr>
     
<?
$arr_tests = MySQL_fillArray("id", "name_report", "TP_SAT_Tests", "where name like '%Diagnostic%' and test_type = 1", "name_report");

putSelectInput('', 'test_id', $arr_tests, $test_id, '', '','Choose a Test');
?>
<?
MySQL_JustForm_End(array("test_id" =>"Test"), "form","");
?>
      </form></td></tr></table><br>
<?php
put_ptts_footer("");
?>