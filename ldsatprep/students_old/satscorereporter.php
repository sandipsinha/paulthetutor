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

 	$SSQstr = "select UNIQUE id, name from TP_Test_info where id in (SELECT test_id FROM TP_Section_Info where id in (select section_id from TP_Test_Questions where id in (select question_id from TP_Student_Answers where student_id = $student_id)))";
    $res = runquery($SSQstr);

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