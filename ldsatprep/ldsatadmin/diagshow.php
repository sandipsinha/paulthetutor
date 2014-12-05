<?php
/*******************************************************
Inputs
arAns[][] - two dimensional array. first key is the section_id, second is the problem number. value is the answer

********************************************************/
ob_start();
include("../../includes/pttec_includes.phtml");
$folder = getfolder('','','');
MySQL_PaulTheTutor_Connect();
if ($folder <> 'ldsatadmin') {
	include('.check_login.php');
}	

if(!$_REQUEST[act_id]) $act_id = 38;
if(!$_REQUEST[sat_id]) $sat_id = 37;

if ((!isEmpty($_REQUEST[student_id])))  $student_id = $_REQUEST[student_id];
if ((!isEmpty($x_conf_sid))) $testprep_id = $x_conf_sid;

if((isEmpty($_REQUEST[student_id])) and (!(isEmpty($testprep_id)))){
	$sQS = "select student_id from PT_TestPrep_Reg where id = $testprep_id";
	$student_id = singlequery($sQS);
}
$student_name = singlequery("select first_name from PTStudentInfo_New where id = $student_id");

put_ptts_header("Diagnostic Results", $strAbsPath, "", "");
?>
<br />
<link href="../../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Diagnostic Score Report for for <?=$student_name?></td>
</tr>
<tr>
<td height ="100" align="center">

 
   
 <br />
<br />
<br />
<span class="Head1_Green">ACT Diagnostic </span>
<?php
show_test_results($student_id, $act_id);
?>
<br />
<br />

<span class="Head1_Green">SAT Diagnostic </span>
<?php
show_test_results($student_id, $sat_id);
put_ptts_footer("");
?>