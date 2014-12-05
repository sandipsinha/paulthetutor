<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$strTableName = "PT_TestPrep_Reg";
$class_id = $_REQUEST['class_id'];
$homework_id = $_REQUEST['homework_id'];
$a = explode("|",$homework_id);
$test_id = $a[0];
$section = $a[1];
if ($class_id && $test_id && $section){
	$test_name = singlequery("SELECT name_report FROM TP_SAT_Tests WHERE id='".$test_id."'");
?>
<table width="100%"  align="center" cellspacing="0" cellpadding="0">
 <tr>
 	<td class="td_header" style="padding-bottom:5px">Students List from class <?php echo $class_id?> - Test <?php echo $test_name.", section ".$section?> </td>
 </tr>
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" cellpadding="2" cellspacing="0" width="100%">
  <tr style="background: #eee; height: 35px">
      <td class="text_grey"><b>Student Name</b></td>
      <td class="text_grey"><b>Date completed</b></td>
      <td class="text_grey"><b>Action</b></td>
  </tr>

<? 

$QStr = "select * from $strTableName a WHERE class='".$class_id."' order by student_name";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
	$resc= runquery("select date FROM TP_HW_Answers WHERE class_id='".$class_id."' AND testprep_id='".$row[id]."' AND test_id='".$test_id."' AND section_num='".$section."'  order by date ASC LIMIT 1");
	$rowc = mysql_fetch_array($resc);
 echo '<tr>
         <td>'.$row['student_name'].'&nbsp;</td>
         <td>'.($rowc[date]!='' ?  format_date_print(substr($rowc[date],0,10),'yy-mm-dd','-','mm/dd/yy','/')." ".substr($rowc[date],11,8) : '').'&nbsp;</td>
         <td>'.($rowc[date]!='' ? "<a href='homeworkresults03.php?sat_id=".$row[id]."&sat_class_id=".$class_id."&test_id=".$test_id."&section=".$section."'>View HW results</a>" : "").'&nbsp;</td>
 </tr>';
}

?>
</table></td></tr>
<tr><td><br> Or <?php echo '<a href="homeworkresults03all.php?sat_class_id='.$class_id."&test_id=".$test_id."&section=".$section.'">View HW results for all students</a>'; ?>
</table>
<?php
put_ptts_footer("");
}
?>
