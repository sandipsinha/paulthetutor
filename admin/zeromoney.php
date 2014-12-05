<?php
include("../includes/pttec_includes.phtml");
$folder = getfolder('','','');
if ($folder == "tutors")
	include("../includes/tut_auth.php");
	
MySQL_PaulTheTutor_Connect();
put_ptts_header("Zero Money", $strAbsPath, "admin",'');
	
$order = $_REQUEST['order'];
$sort = $_REQUEST['sort'];
$delete_id = $_REQUEST['delete_id'];
$tablename = "PTAddedApp";
if ($sort == "")
	$sort = "date";
if($order==""){
	$order="DESC";
}else
	$order=$_REQUEST['order']; 
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

		session_del($delete_id,'','');
		echo "<div class=text_success style='text-align:center'>The appointment $delete_id has been deleted.</div>";
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
	tutorsid_menu($tutor_id,"tid","document.form.submit()");
}
?>
</td>
</tr><tr height=5><td></td></tr>
  <tr>
    <td class=td_header colspan="2">Zero Money Appointments Information</td>
  </tr>
  <tr>
    <td  valign="top"  colspan="2">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=flast_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Family</b>'.($sort == 'flast_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=students&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Students</b>'.($sort == 'students' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<? if (!$is_tutor){?>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=tutor_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Tutor</b>'.($sort == 'tutor_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<?}?>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Date</b>'.($sort == 'date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td class="text_grey"><b>Start Time</b></td>
  	<td class="text_grey"><b>Hours</b></td>
  	<td class="text_grey"><b>Rate</b></td>
  	<td class="text_grey"><b>Pay</b></td>
  	<td class="text_grey"><b>Action</b></td>
  </tr>


<? 
$QStr = "select s.*, SUBSTRING_INDEX(f.main_name, ' ', -1) as flast_name, SUBSTRING_INDEX(f.main_name, ' ', 1) as ffirst_name, f.students, CONCAT_WS(' ',t.first_name, t.last_name) as tutor_name FROM $tablename s  LEFT JOIN PT_Family_Info f ON s.sid = f.id LEFT JOIN PT_Tutors t ON s.tid = t.id WHERE (s.rate=0 OR s.rate is NULL OR s.pay=0)  ".($tutor_id ? " AND s.tid='".$tutor_id."'" : "")." ORDER BY  ".($sort!="id" ? "trim($sort)" : "$sort")." $order, date DESC,flast_name ASC";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
	if ($row[start_time]){
		$arT = explode(":",$row['start_time']);
		$ampm = date("g:i a", mktime($arT[0], $arT[1], 0, 3, 0, 2000));
	}
	
 echo '<tr>
 		<td>'.$row['flast_name'].($row['ffirst_name']!='' ? ', '.$row['ffirst_name'] : '').'&nbsp;</td>';
  echo '<td>'.$row[students].'&nbsp;</td>';
  if (!$is_tutor){
 		echo '<td>'.$row['tutor_name'].'&nbsp;</td>';
			}
  echo '<td>'.$row[date].'&nbsp;</td>
 		<td>'.$ampm.'&nbsp;</td>
 		<td>'.$row[hours].'&nbsp;</td>
 		<td>'.$row[rate].'&nbsp;</td>
 		<td>'.$row[pay].'&nbsp;</td>
 		<td nowrap  align=center><a href="#void" onclick="javascript:popup(\'added_appoint_edit.php?appntId='.$row[id].'\',\'Edit Appointment\',\'600\',\'600\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;&nbsp;
 			<a href="#void" onclick="if (confirm(\'Delete '.$row[dow].' '.$ampm.' with '.addslashes($row['flast_name']).($row['ffirst_name']!='' ? ', '.$row['ffirst_name'] : '').($row[students] ? " ($row[students])" : '').'?\')) {document.form.delete_id.value='.$row[id].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;
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
put_ptts_footer("");
?>
