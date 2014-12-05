<?php
include("../includes/pttec_includes.phtml");
$folder = getfolder('','','');
if ($folder == "tutors"){
	include("../includes/tut_auth.php");
	$is_tutor = 1;
}
	
	
MySQL_PaulTheTutor_Connect();
put_ptts_header("Non-Tutoring Appointments", $strAbsPath, "admin",'');
$order = $_REQUEST['order'];
$sort = $_REQUEST['sort'];
$delete_id = $_REQUEST['delete_id'];
$tablename = "PT_Recurring_Appt";
$tablename2 = "PT_Other_Appt";
if ($sort == "")
	$sort = "start_date";
set_time_limit(0);	
if($order==""){
	$order="DESC";
}else
	$order=$_REQUEST['order']; 
$date_two_years_ago = (date('Y')-2).'-'.date('m').'-'.date('d');
$tutor_id = $_SESSION['tutor_id'];
if ($tutor_id)
	$is_tutor = 1;
elseif ($folder == "admin")
	$tid = $tutor_id = $_REQUEST['tid'];

if ($delete_id){
	if ($is_tutor){
		$QStr = "select * from $tablename where id = '$delete_id'";
		$FieldsRS = runquery($QStr);
		$arFieldsVals = mysql_fetch_array($FieldsRS);
		if ($arFieldsVals['tid']!=$tutor_id)
			die("Error. You are not authorized to delete this schedule.");
	}
	if (runquery("delete FROM $tablename where id = '$delete_id' LIMIT 1")){
		$res_del = runquery("SELECT id FROM $tablename2 WHERE sched_id='".$delete_id."'");
		  while($row_del=mysql_fetch_array($res_del)){
				non_tut_session_del($row_del['id']);    
		  }
		echo "<div class=text_success style='text-align:center'>The non-tutoring appointment $delete_id has been deleted.</div>";
	}
}	

?>

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
	tutorsid_menu($tutor_id,"tid","document.form.submit()",array('all'=>true));
}
?>
</td>
<td align="right"><button onclick="javascript:popup('miviram_non_tutoring_appointment_edit.php','Add Schedule','600','600')">Add New Non-Tutoring Appointment</button>
</tr><tr height=5><td></td></tr>
  <tr>
    <td class=td_header colspan="2">Non-Tutoring Appointments</td>
  </tr>
  <tr>
    <td  valign="top"  colspan="2">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  <td nowrap><?php  echo '<a class=a_grey href="?'."&sort=id&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>ID</b>'.($sort == 'id' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  <td nowrap><?php  echo '<a class=a_grey href="?'."&sort=name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Name</b>'.($sort == 'name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<? if (!$is_tutor){?>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=tutor_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Tutor</b>'.($sort == 'tutor_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<?}?>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=start_date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Start date</b>'.($sort == 'start_date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=end_date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>End date</b>'.($sort == 'end_date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td class="text_grey"><b>Day of Week</b></td>
  	<td class="text_grey"><b>Start Time</b></td>
  	<td class="text_grey"><b>End Time</b></td>
  	<td class="text_grey"><b>Pay Rate</b></td>
  	<td class="text_grey"><b>Description</b></td>
  	<td class="text_grey"><b>Action</b></td>
  </tr>


<? 
$QStr = "select s.*, CONCAT_WS(' ',t.first_name, t.last_name) as tutor_name
FROM $tablename s LEFT JOIN  PT_Tutors t ON s.tid = t.id 
WHERE 1 ".($tutor_id ? " AND s.tid='".$tutor_id."'" : "").
" ORDER BY  ".($sort!="id" ? "trim($sort)" : "$sort")." $order, start_date DESC, end_date DESC";

$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
	$query = "select rate FROM $tablename2 where tutor_id = '$tutor_id' AND 
	sched_id = $row[id] LIMIT 1";
	$result = runquery( $query );

	$arT_start = explode(":",$row['start_time']);
	$arT_end = explode(":",$row['end_time']);
	$ampm_start = date("g:i a", mktime($arT_start[0], $arT_start[1], 0, 3, 0, 2000));
	$ampm_end = date("g:i a", mktime($arT_end[0], $arT_end[1], 0, 3, 0, 2000));
	$ampm_start = format_time_print($row['start_time']);
	$ampm_end = format_time_print($row['end_time']);
	
//	if(isEmpty($row[rate])){
		//$payrate = 0;
	//} else {
	while( $row2 = mysql_fetch_array( $result ) )
		$payrate = $row2['rate'];
	//}		
	
 echo '<tr>
 		<td>'.$row[id].'&nbsp;</td>
 		<td>'.$row[name].'&nbsp;</td>';
 if (!$is_tutor){
 		echo '<td>'.$row['tutor_name'].'&nbsp;</td>';
			}
  echo '<td>'.$row[start_date].'&nbsp;</td>
 		<td>'.$row[end_date].'&nbsp;</td>
 		<td>'.$row[day_of_week].'&nbsp;</td>
 		<td>'.$ampm_start.'&nbsp;</td>
 		<td>'.$ampm_end.'&nbsp;</td>
 		<td>'.$payrate.'&nbsp;</td>
 		<td>'.$row[description].'&nbsp;</td>
 		<td nowrap  align=center><a onclick="javascript:popup(\'non_tutoring_appointment_edit.php?id='.$row[id].'\',\'Edit Appointment\',\'600\',\'600\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;&nbsp;
 			<a onclick="if (confirm(\'Delete '.$row[name].'?\')) {document.form.delete_id.value='.$row[id].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;
 		</td>
 </tr>';
}

?>
</table>
</td>
</tr>	
</table>
</form>
<?
set_time_limit(60);	
put_ptts_footer("");
?>
