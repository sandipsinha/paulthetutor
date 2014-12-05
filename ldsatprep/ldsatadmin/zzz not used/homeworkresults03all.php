<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
if (!stristr($_SERVER[REQUEST_URI],'admin'))
	die('must be admin');
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$strTableName = "TP_HW_Answers";
put_ptts_header("", $strAbsPath, "admin", "");
if (!$test_id)
	$test_id = $_REQUEST[test_id];
$res_test = runquery("select name from TP_SAT_Tests where id = '$test_id'");
$row_test = mysql_fetch_array($res_test);
if ($_REQUEST[sat_class_id])
	$class_id = $_REQUEST['sat_class_id'];
else
	$class_id = $_SESSION['sat_class_id'];
if (!$section)
	$section = $_REQUEST[section];	
?>
<table width="100%" border="0" cellpadding="7" cellspacing="0" style="border:solid 1px #999">
  <tr height="40">
    <td class="td_header">Homework results on <?=$row_test[name].", section ".$section?></td>
  </tr>
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" cellpadding="2" cellspacing="0" width="100%">
  <tr style="background: #eee; height: 35px">
      <td class="text_grey"><b>Student</b></td>
      <td class="text_grey"><b>Problem</b></td>
      <td class="text_grey"><b>Correct Answer</b></td>
      <td class="text_grey"><b>Answer</b></td>
      <td class="text_grey"><b>Points</b></td>
      <td class="text_grey"><b>Date</b></td>
      <td class="text_grey"><b>Result</b></td>
  </tr>

<? 

$QStr = "select a.*, b.student_name from $strTableName a LEFT JOIN PT_TestPrep_Reg b ON a.testprep_id = b.id WHERE class_id='".$class_id."' AND test_id='".$test_id."' AND section_num='".$section."' order by problem";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
	if ($row['result'] == "wrong")
		$style = "color:#ff0000";
	elseif($row['result'] == "correct")
		$style = "color:green";
 echo '<tr>
         <td>'.$row['student_name'].'&nbsp;</td>
         <td>'.$row['problem'].'&nbsp;</td>
         <td>'.$row['corect_answer'].'&nbsp;</td>
         <td>'.$row['answer'].'&nbsp;</td>
         <td>'.$row['raw_points'].'&nbsp;</td>
         <td>'.($row[date]!='' ?  format_date_print(substr($row[date],0,10),'yy-mm-dd','-','mm/dd/yy','/')." ".substr($row[date],11,8) : '').'&nbsp;</td>
         <td style="'.$style.'">'.$row['result'].'&nbsp;</td>
 </tr>';
}

?>
</table></td></tr>
<?php
put_ptts_footer("");
?>
