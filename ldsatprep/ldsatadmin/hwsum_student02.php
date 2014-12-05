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
$class_id = $_REQUEST[class_id];
if((isEmpty($student_id)) and (!isEmpty($testprep_id))) $student_id = singlequery("select student_id from PT_TestPrep_Reg where id = $testprep_id");
$strTableName = "TP_HW_Answers";
$student_info = get_student_info($student_id);

put_ptts_header("Homework summary for $student_info[full_name]", $strAbsPath, "admin", "index");
$order = $_REQUEST['order'];
$sort = $_REQUEST['sort'];
$move_id = $_REQUEST['move_id'];
$tablename = "TP_HW_Summary";
if ($sort == "")
    $sort = "due_date";
if($order==""){
    $order="ASC";
}else
    $order=$_REQUEST['order'];
$order2 = ($order == "ASC" ? "DESC" : "ASC"); 

if(!(empty($move_id))){
    $MQStr = "DELETE from $tablename where id=$move_id";
    runquery($MQStr);
} 
?>
<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id><input type="hidden" name=class_id value="<?=$class_id?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
      <td align="right" style="padding-bottom:5px"><button onclick="javascript:popup('gethwsum.php?class_id=<?=$class_id?>&popup=1','Details','600','600')" style="cursor:pointer">Add New Homework</button></td>
  </tr>
  <tr height="40">
    <td class="td_header">Homework summary for <?=$student_info[full_name]?></td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
 	 <table border=0 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
 		 <tr style="background: #eee">
     	 <td nowrap>

	  
<?php  
$secQS = "select distinct test_id, section_num from $strTableName where testprep_id = $testprep_id order by test_id DESC,section_num ASC";


$other = "select distinct test_id, section_num from TP_HW_Answers where testprep_id = 188 order by test_id,section_num";
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
put_ptts_footer("");
?>