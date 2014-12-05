<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/.check_login.php");
include($strAbsPath . "/includes/pttec_includes.phtml");

// printarray($_REQUEST);

MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "parents", "");
if (!$sat_id)
	$sat_id = $_REQUEST['sat_id'];

$today = date("Y-m-d");
$student_id = singlequery("select student_id from PT_TestPrep_Reg where id = $sat_id");

	
//	echo "select * from PT_TestPrep_Reg where fid = '".$_SESSION['fid']."' AND id='".$sat_id."' LIMIT 1 <Br><br>";
	
$res = runquery("select * from PT_TestPrep_Reg where fid = '".$_SESSION['fid']."' AND id='".$sat_id."' LIMIT 1");
$row=mysql_fetch_array($res);
if (!$row[id])
	exit();
else{
	$class_id = $row['class'];
	$class_name = singlequery("select class_name from PT_SAT_Class_Info where id = $class_id");
	$_SESSION['sat_id'] = $sat_id;
	$_SESSION['sat_class_id'] = $class_id;
}

// echo "select * from TP_HW_Answers where testprep_id = '".$sat_id."' ORDER BY DATE DESC LIMIT 1  <BR><BR>";

$res_last = runquery("select * from TP_Student_Answers where student_id = '".$student_id."' ORDER BY DATE DESC LIMIT 1");
$row_last = mysql_fetch_array($res_last);
$test_last_hw = $row_last[test_id];
$section_last_hw = $row_last[section_num];

// printarray($row_last);

?>
<table width="100%" border="0" cellpadding="7" cellspacing="0" style="border:solid 1px #999">
  <tr height="40">
    <td class="td_header">LD SAT Prep Class <?echo $class_name?></td>
  </tr>
 <tr>
    <td><a href="homework.php">See Homework Assignments</a></td>
</tr>

 <tr>
    <td><a href="homeworkresults03.php?test_id=<?=$test_last_hw?>&section=<?=$section_last_hw?>">See  Homework Results</a></td>
</tr>
 <tr>
    <td><a href="satscorereporter.php">See Test Results</a></td>
</tr>
</table>
<?php
put_ptts_footer("");
?>