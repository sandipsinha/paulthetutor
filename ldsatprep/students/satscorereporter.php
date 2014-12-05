<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
// printarray($_REQUEST);

MySQL_PaulTheTutor_Connect();
if(stristr($_SERVER[REQUEST_URI],'students'))
	include('.check_login.php');
elseif (!stristr($_SERVER[REQUEST_URI],'admin'))
	include($strAbsPath . "/includes/.check_login.php");
put_ptts_header("", $strAbsPath, "parents", "");
$strTableName = "TP_SAT_Tests";
if ($_REQUEST[sat_id]){
	$sat_id = $_REQUEST[sat_id];
} else {

	$sat_id = $_SESSION[sat_id];
}		

$student_id = singlequery("select student_id from PT_TestPrep_Reg where id = $sat_id");



?>
<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>See Results from Which Test</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST" action="satscorereporter02.php"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    
<?
puthiddenfield(student_id,$student_id);

 	$SSQstr = "SELECT DISTINCT TP_Test_Info.id as test_id, TP_Test_Info.name as name
FROM TP_Test_Info
JOIN TP_Test_Sections 
  ON TP_Test_Sections.test_id = TP_Test_Info.id
JOIN TP_Test_Questions 
  ON TP_Test_Questions.section_id = TP_Test_Sections.id
JOIN TP_Student_Answers 
  ON TP_Student_Answers.question_id = TP_Test_Questions.id
WHERE TP_Student_Answers.student_id = $student_id";
    $res = runquery($SSQstr);
	
//	printRS($res);

// if the student has completed at least one test, let them pick that test to see the results.	
	$res_num = mysql_num_rows($res); 
if ($res_num < 1 ) {
	$student_name = singlequery("select student_name from PT_TestPrep_Reg where id = $sat_id");
	echo "<div class=Head2_Green>Sorry, $student_name has not completed any tests</div><BR>";
} else {
		while($row = mysql_fetch_array($res)){
			$arr_tests[$row[test_id]] = $row[name];
		}
	
			
    putSelectInput('See Results from Which Test?', 'test_id', $arr_tests, '' , '', 'required','Choose test');
?>
<tr>
            <td colspan="2" align="center"><br>
                <input type="submit" value="Submit">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"><br><br>
              </td>
</tr>
<?
// MySQL_JustForm_End(array("test_id" =>"Test"), "form","");

} // end the else there are tests to see

?>
      </form></td></tr></table><br>
<?php
put_ptts_footer("");
?>