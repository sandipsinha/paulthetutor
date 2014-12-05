<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
if ($x_admin <> 1) {
	include('.check_login.php');
}	
reqToVars();

$student = $_REQUEST['student'];
$testid = $_REQUEST['testid'];
$answers = $_REQUEST['answer'];

$values = "";
while(list($sect,$secas) = each($answers)){
	while(list($prob,$ans) = each($secas)){
		$message = "";
		$res = runquery("select * from TP_SAT_Questions where section_num = $sect and test_id = $testid and number = $prob");
		$row_ans = mysql_fetch_array($res);
		$correcta = $row_ans['answer'];
		$checkable = $row_ans[checkable];
		$spr = $row_ans[spr];
		$question_id = $row_ans[id];
		
// this is the new code that puts the answers in TP_HW_Answers
		$student_id = singlequery("select student_id from PT_TestPrep_Reg where id = $student");
		
//		echo "sid is $student_id and select student_id from PT_TestPrep_Reg where id = $student";
		
//		die;
		
		process_question($student_id, $question_id, $ans);		

echo "		proess_question($student_id, $question_id, $ans);		<BR>";

		
		$arRes = getSATQResult($ans, $correcta, $checkable, $spr);
		$result = $arRes['res'];
		$points = $arRes['raw'];
		$set = "sid='".$student."', test='".$testid."', section='".$sect."', problem='".$prob."', answer='".$ans."', raw_points='".$points."', correct_answer='".$correcta."',result='".$result."'";
		$res_found = runquery("SELECT id FROM TP_SAT_Answers WHERE sid='".$student."' AND test='".$testid."' AND section='".$sect."' AND problem='".$prob."' ");
		if (mysql_num_rows($res_found) == 0)
			runquery("Insert into TP_SAT_Answers SET $set");
		else{
			$row_found = mysql_fetch_array($res_found); 
			runquery("UPDATE TP_SAT_Answers SET $set WHERE id='".$row_found[id]."'");
		}
	}	
}

$linkadd = '';
$folder = getfolder('','','');
if($folder == 'ldsatadmin') $linkadd = "&student_id=$student_id&testprep_id=$student";


// die();
header("Location: satdiagresults.php?test_id=$testid$linkadd");

put_ptts_footer("");
?>