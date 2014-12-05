<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$folder = getfolder('','','');
if($folder == "ldsatadmin"){
	$testprep_id = $_REQUEST[testprep_id];
} else {
	include('.check_login.php');
	$testprep_id = $x_conf_sid;

}

$test_id = $_REQUEST[test_id];

if((isEmpty($student_id)) and (!isEmpty($testprep_id))) $student_id = singlequery("select student_id from PT_TestPrep_Reg where id = $testprep_id");

$strTableName = "TP_HW_Answers";
$student_info = get_student_info($student_id);

put_ptts_header("Diagnostic summary for $student_info[full_name]", $strAbsPath, "admin", "index");
?>
<form name=form method="post">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height="40">
    <td class="td_header">Diagnostic summary for <?=$student_info[full_name]?></td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
 	 <table border=0 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
 		 <tr style="background: #eee">
     	 <td nowrap>

	  
<?php  
$secQS = "select distinct test_id, section_num from $strTableName where testprep_id = $testprep_id and test_id = $test_id order by section_num ASC";


$secRS = runquery($secQS);
while($row = mysql_fetch_array($secRS)){ // get each test and section that has been done 
	$test_id = $row[test_id];
	$section_num = $row[section_num];
	echo "<tr style=\"background: #eee;\"><td>";
	show_sec_results($testprep_id,NULL,$test_id,$section_num);
	echo "<BR><BR></td></tr>";
}	

?>
</td>
</tr>
</table>
</td>
</tr>    
</table>
</form>
<?

// echo "student_id is $student_id";

show_sat_results($student_id, $test_id);
put_ptts_footer("");
?>