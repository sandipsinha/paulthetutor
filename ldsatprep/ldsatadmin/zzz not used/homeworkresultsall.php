<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$strTableName = "PT_TestPrep_Reg";
$class_id = $_REQUEST['class_id'];
$student_id = isset($_REQUEST['student_id']) ? $_REQUEST['student_id']: null;
$test_id = $a[0];
$section = $a[1];
?>
<table width="100%"  align="center" cellspacing="0" cellpadding="0">
 <tr>
<? if(!$student_id):  ?>
 	<td class="td_header" style="padding-bottom:5px;">Students List from class <?php echo $class_id?></td>
 </tr><tr><td>
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
      <td class="text_grey"><b>Student Name</b></td>
      <td class="text_grey"><b>Action</b></td>
  </tr>

<? 

$QStr = "select * from $strTableName a WHERE class='".$class_id."' order by student_name";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
         <td>'.$row['student_name'].'&nbsp;</td>
         <td><a href="homeworkresultsall.php?student_id='.$row['id']."&class_id=".$class_id.'">View HW results</a> &nbsp;</td>
 </tr>';
}

?>
</table></td>
<? else:
$res_student = runquery("select * from PT_TestPrep_Reg where id = '".$student_id."' LIMIT 1");
$row_student = mysql_fetch_array($res_student);
?>
    <td class="td_header">All homework results for <?=$row_student[student_name]; ?></td>
  </tr><tr>
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" cellpadding="2" cellspacing="0" width="100%">
  <tr style="background: #eee; height: 35px">
      <td class="text_grey"><b>Problem</b></td>
      <td class="text_grey"><b>Correct Answer</b></td>
      <td class="text_grey"><b>Answer</b></td>
      <td class="text_grey"><b>Points</b></td>
      <td class="text_grey"><b>Date</b></td>
      <td class="text_grey"><b>Result</b></td>
  </tr>
<?php
$QStr = "select a.*, b.name_report as test_name from TP_HW_Answers a LEFT JOIN TP_SAT_Tests b ON a.test_id = b.id WHERE testprep_id='".$student_id."' AND class_id='".$class_id."' order by test_id, section_num, problem";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
	if ($row['result'] == "wrong")
		$style = "color:#ff0000";
	elseif($row['result'] == "correct")
		$style = "color:green";
 echo '<tr>
         <td>'.$row['test_name'] .' - Section '. $row['section_num'] . ' - Problem '. $row['problem'].'&nbsp;</td>
         <td>'.$row['corect_answer'].'&nbsp;</td>
         <td>'.$row['answer'].'&nbsp;</td>
         <td>'.$row['raw_points'].'&nbsp;</td>
         <td>'.($row[date]!='' ?  format_date_print(substr($row[date],0,10),'yy-mm-dd','-','mm/dd/yy','/')." ".substr($row[date],11,8) : '').'&nbsp;</td>
         <td style="'.$style.'">'.$row['result'].'&nbsp;</td>
 </tr>';
}

?>
<? endif; ?>
</tr></table>
<?php
put_ptts_footer("");
?>
