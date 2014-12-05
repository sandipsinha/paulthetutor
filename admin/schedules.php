<?php
include("../includes/pttec_includes.phtml");
$folder = getfolder('','','');
if ($folder == "tutors")
	include("../includes/tut_auth.php");
printarray($_REQUEST);
	
MySQL_PaulTheTutor_Connect();
put_ptts_header("Schedules", $strAbsPath, "admin",'');
	
// $order = isset($_REQUEST['order']) ? $_REQUEST['order']: null;


$delete_id = isset($_REQUEST['delete_id']) ? $_REQUEST['delete_id'] : null;
$tablename = "PTSchedInfo2";
$tablename2 = "PTAddedApp";
if (isEmpty($_REQUEST[sort])){
	$sort = "start_date";
} else {
	$sort = $_REQUEST[sort];
}
if(isEmpty($_REQUEST[order])){
	$order="DESC";
}else{
	$order=$_REQUEST['order']; 
}

echo "sort is $sort <BR>";

$date_two_years_ago = (date('Y')-2).'-'.date('m').'-'.date('d');
$tutor_id = $_SESSION['tutor_id'];
if ($tutor_id)
	$is_tutor = 1;
elseif ($folder == "admin")
	$tutor_id = $_REQUEST['tid'];

if ($delete_id){
	if ($is_tutor){
		$QStr = "select * from $tablename where id = '$delete_id'";
		$FieldsRS = runquery($QStr);
		$arFieldsVals = mysql_fetch_array($FieldsRS);
		if ($arFieldsVals['tid']!=$tutor_id)
			die("Error. You are not authorized to delete this schedule.");
	}
	$del_tut_id = singlequery("select tid from $tablename where id = '$delete_id'");
	
	//$qryDelete_schedule = "delete FROM $tablename where id = '$delete_id'";
	$qryDelete_schedule = "UPDATE $tablename SET archived = 1 WHERE id = '$delete_id'";
	
	if (runquery($qryDelete_schedule)){
		$res_del = runquery("SELECT id FROM $tablename2 WHERE sched_id='".$delete_id."'");
                $mailmsg= "A schedule was deleted:";
		while($row_del=mysql_fetch_array($res_del))
		  $mailmsg .= "\n". session_del($row_del['id'],'', array('email_paul'=>false,'email_tut'=>false));
                if ($folder == "admin") {
                  $tut = tutor_info($del_tut_id);
                  ptts_mail($tut['email'], "schedule deleted", $mailmsg) ;
                }
                ptts_mail("paul@paulthetutors.com", "schedule deleted", $mailmsg) ;

		echo "<div class=text_success style='text-align:center'>The schedule $delete_id has been deleted.</div>";
	}
}	

?>
<style type="text/css">
.bold_red {
	font-weight: bold;
	color: #F00;
}
</style>


<form name=form method="get"><input type="submit" style="display:none">
<input type="hidden" name=tid value="<?=$tid?>">
<input type="hidden" name=sort value="<?=$sort?>">
<input type="hidden" name=order value="<?=$order?>">
<input type="hidden" name=delete_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td align="left">
<?
if ($folder == "admin"){
	tutorsid_menu($tutor_id,"tid","document.form.submit()");
}
?>
</td>
<td align="right">

<button onclick="javascript:popup('schedule_edit.php','AddSchedule','600','600')">Add New Schedule</button>


</tr><tr height=5><td></td></tr>
  <tr>
    <td class=td_header colspan="2">Scheduling Information</td>
  </tr>
  <tr>
    <td  valign="top"  colspan="2">
  <table border=1 width="100%" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=id&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>ID</b>'.($sort == 'id' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=flast_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Student</b>'.($sort == 'flast_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>

  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=flast_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Parent</b>'.($sort == 'flast_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
	
  	<? if (!$is_tutor){?>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=tutor_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Tutor</b>'.($sort == 'tutor_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<?}?>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=start_date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Start date</b>'.($sort == 'start_date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td class="text_grey"><b>End Date</b></td>
  	<td class="text_grey"><b>Day of Week</b></td>
  	<td class="text_grey"><b>Start Time</b></td>
  	<td class="text_grey"><b>Hours</b></td>
  	<td class="text_grey"><b>Rate</b></td>
  	<td class="text_grey"><b>Pay</b></td>
  	<td class="text_grey"><b>Action</b></td>
  </tr>


<? 

/* hiding archived schedules from regular users */

if ($folder != "admin") {
	$strExtra_condition = " AND s.archived = 0 ";
} else $strExtra_condition = "";


$QStr = "select s.*, SUBSTRING_INDEX(f.main_name, ' ', -1) as flast_name, SUBSTRING_INDEX(f.main_name, ' ', 1) as ffirst_name, f.students, CONCAT_WS(' ',t.first_name, t.last_name) as tutor_name FROM $tablename s  LEFT JOIN PT_Family_Info f ON s.fid = f.id LEFT JOIN PT_Tutors t ON s.tid = t.id WHERE end_date>='".$date_two_years_ago."' ".($tutor_id ? " AND s.tid='".$tutor_id."'" : ""). $strExtra_condition ." ORDER BY  ".($sort!="id" ? "trim($sort)" : "$sort")." $order, start_date DESC, end_date DESC, flast_name ASC";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){

// get the student's name
$student_id = $row[student_id];
$student_name = get_student_name($student_id);
	
$family_id = $row[fid];	

$arc_note = "";

	
?>
  <tr>
    <td nowrap="nowrap">
  
 <?
 echo "$row[id] &nbsp";
 if($row[archived] == 1){
 ?>
 <img src="../images/red_garbage_can.png" width="16" height="16" alt="ARCHIVED" />
<? } ?>
 
  </td>	
  <td><?="$student_name ($student_id) &nbsp";?> </td>		
		
<?	
 echo '
 		<td>'.$row['flast_name'].($row['ffirst_name']!='' ? ', '.$row['ffirst_name'] : '')." ($family_id) &nbsp;</td>";

 if (!$is_tutor){
 		echo '<td>'.$row['tutor_name'].'&nbsp;</td>';
			}
  echo '<td>'.$row['start_date'].'&nbsp;</td>
 		<td>'.$row['end_date'].'&nbsp;</td>
 		<td>'.$row['dow'].'&nbsp;</td>
 		<td>'.format_time_print($row['start_time']).'&nbsp;</td>
 		<td>'.$row['hours'].'&nbsp;</td>
 		<td>'.$row['rate'].'&nbsp;</td>
 		<td>'.$row['pay'].'&nbsp;</td>
 		<td nowrap  align=center>';
 if($row[archived] == 1){
	echo ' <img src="../images/red_garbage_can.png" width="16" height="16" alt="ARCHIVED" /> <span class="bold_red">
Archived</span>';
 } else {
	 echo'<a onclick="javascript:popup(\'schedule_edit.php?id='.$row['id'].'\',\'Edit Schedule\',\'600\',\'600\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;&nbsp;
			<a onclick="javascript:popup(\'schedule_end.php?id='.$row['id'].'\',\'End Schedule\',\'600\',\'300\')"><img SRC="../images/stop_schedule.png" ALT="End Schedule" border="0"></a>&nbsp;&nbsp;
			<a onclick="javascript:popup(\'schedule_delete.php?id='.$row['id'].'\',\'Delete Schedule\',\'600\',\'300\')"><img SRC="../images/del_x.gif" ALT="Delete Schedule" border="0"></a>&nbsp;&nbsp;';
 }
echo '</td></tr>';
}

?>
</table>
</td>
</tr>	
</table>
</form>
<?
put_ptts_footer("");
?>
