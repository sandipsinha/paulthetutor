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
		$questions_id = $row_ans[id];
		$spr = $row_ans[spr];
		
// this is the new code that puts the answers in TP_HW_Answers
		$student_id = runquery("select student_id from PT_TestPrep_Reg where id = $student");
		process_question($student_id, $question_id, $ans);		
		
		
		$arRes = getSATQResult($ans, $correcta, $checkable, $spr);
		$result = $arRes['res'];
		$points = $arRes['raw'];
		$set = "sid='".$student."', test='".$testid."', section='".$sect."', problem='".$prob."', answer='".$ans."', raw_points='".$points."', correct_answer='".$correcta."',result='".$result."'";
		$set_hw = " ";
		$res_found = runquery("SELECT id FROM TP_SAT_Answers WHERE sid='".$student."' AND test='".$testid."' AND section='".$sect."' AND problem='".$prob."' ");
		if (mysql_num_rows($res_found) == 0)
			runquery("Insert into TP_SAT_Answers SET $set");
		else{
			$row_found = mysql_fetch_array($res_found); 
			runquery("UPDATE TP_SAT_Answers SET $set WHERE id='".$row_found[id]."'");
		}
	}	
}

// get all of the scores
$essay_score = $_REQUEST['essay_score'];
$mathraw = (int)getSecRawScore_New($testid, $student, "math","test");
$readingraw = (int)getSecRawScore_New($testid, $student, "reading","test");
$writingraw = (int)getSecRawScore_New($testid, $student, "writing","test");
$mathrep = (int)getReportedScore_New($mathraw, "math",'','');
$readingrep = (int)getReportedScore_New($readingraw, "reading",'','');
$writingrep = (int)getReportedScore_New($writingraw, "writing",$essay_score,'');



$set2 = "math_raw='".$mathraw."', reading_raw='".$readingraw."', writing_raw='".$writingraw."', essay_score='".$essay_score."', student_id='".$student."', test_id='".$testid."', math_reported='".$mathrep."',reading_reported='".$readingrep."',writing_reported='".$writingrep."'";

$res_found2 = runquery("SELECT id FROM TP_SAT_Scores WHERE student_id='".$student."' AND test_id='".$testid."'");
if (mysql_num_rows($res_found2) == 0)
	runquery("insert into TP_SAT_Scores SET $set2");
else{
			$row_found2 = mysql_fetch_array($res_found2); 
			runquery("UPDATE TP_SAT_Scores SET $set2 WHERE id='".$row_found2[id]."'");
}

?>
<strong>Test Results
</strong><BR><?


echo "math: ($mathraw) $mathrep <BR>critical reading: ($readingraw) $readingrep <BR>writing: ($essay_score - $writingraw) $writingrep";
?>
&nbsp;&nbsp;<br>
<form name=form3 action="<?php echo ($x_admin ?"testresults02.php" : "satscorereporter02.php")?>">
<input type=hidden name="sat_id" value="<?=$student;?>">
<input type="hidden" name="test_id" value="<?=$testid;?>">
<input type="hidden" name="sat_class_id" value="<?=$x_conf_class?>">
</form>
<a onclick="document.form3.submit()" href=#>See a full score report</a></tr>

        </table>
<?php
put_ptts_footer("");
?>