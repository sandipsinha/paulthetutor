<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Work Hours for Paul The Tutor's", $strAbsPath, "admin", "");
$tablename = "PT_NT_Work_Hours";
$tutors_table = "PT_Tutors";
$move_id = isset($_POST['move_id'])?$_POST['move_id']:null;
$month = (int) isset($_REQUEST['month'])?$_REQUEST['month']: date('m');
$year = (int) isset($_REQUEST['year'])?$_REQUEST['year']: date('Y');

If(!(empty($move_id))){
	$MQStr = "select * from $tablename where id=$move_id";
	$MRS = runquery($MQStr);
	if($MAR = mysql_fetch_assoc($MRS)){
		$DQStr = "delete from $tablename where id = $move_id";
		echo "<div class=text_success style='text-align:center'>Record $move_id has been deleted</div><BR>";
		mysql_query($DQStr);
	} 
} 

?>

<div>
<div style="float:left">
  <a href="<?= (($month-1 < 1) ? "?month=12&year=".($year-1) : "?month=". ($month-1) ."&year=$year") ?>">&lt;</a> 
  <?= date('M',strtotime("$year-$month-01"))?>
  <a href="<?= (($month+1 > 12) ? "?month=1&year=".($year+1) : "?month=". ($month+1) ."&year=$year") ?>">&gt;</a> 
</div>
<div style="float:right">
	<button onclick="javascript:popup('miviram_non_tutoring_appointment_edit.php','Details','600','820')">Add new work hours</button> 
</div>
<br />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 
$QStr_tutors = "select distinct w.tutor_id, t.first_name, t.last_name from $tablename w
	join $tutors_table t on w.tutor_id = t.id	
	where YEAR(date) = ". $year . " AND MONTH(date) = ". $month ."
	order by t.first_name, t.last_name";
$RS_tutors = runquery($QStr_tutors);
while($tutor_row = mysql_fetch_array($RS_tutors)){
?>
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header"><?php echo $tutor_row['first_name'].' '.$tutor_row['last_name'] ?> - Work Hours</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td class="text_grey" width="20%"><b>Date</b></td>
  	<td class="text_grey" width="10%"><b>Hours</b></td>
  	<td class="text_grey" width="10%"><b>Rate</b></td>
  	<td class="text_grey" width="10%"><b>Total</b></td>
  	<td class="text_grey" width="20%"><b>Title</b></td>
  	<td class="text_grey" width="20%"><b>Comments</b></td>
  	<td class="text_grey" width="10%"><b>Action</b></td>
  </tr>
 
<?php 

$QStr = "select w.*, t.first_name, t.last_name from $tablename w 
	join $tutors_table t on w.tutor_id = t.id	
	where tutor_id=".$tutor_row['tutor_id']." and YEAR(date) = ". $year . " AND MONTH(date) = ". $month ."
	order by date DESC";
$RS = runquery($QStr);

$total = 0;
while($row = mysql_fetch_array($RS)){
 echo '<tr>
 		<td>'.date("m/d/Y", strtotime($row['date'])).'&nbsp;</td>
 		<td>'.$row['hours'].'&nbsp;</td>
 		<td>'.$row['rate'].'&nbsp;</td>
 		<td>'.($row['rate']*$row['hours']).'&nbsp;</td>
 		<td>'.$row['name'].'&nbsp;</td>
 		<td>'.$row['comments'].'&nbsp;</td>
 		<td nowrap align=center>
 			<a onclick="javascript:popup(\'work_hours_edit.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a onclick="if (confirm(\'Are you sure you want to delete this work hours?\')) {document.form.move_id.value='.$row[id].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="delete" border="0"></a>&nbsp;
 		</td>
 		
 </tr>';
 $total += $row['rate']*$row['hours'];
}

?>

	<tr>
		<td colspan=3><b>Grand Total</b></td>
		<td colspan=4><b><?php echo $total; ?></b></td>
	</tr>
</table>
<br/>

<?php } ?>


<br />
<table width="40%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Total Work Hours</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td class="text_grey"><b>Tutor</b></td>
  	<td class="text_grey"><b>Total</b></td>
  </tr>
 
<?php 

$QStr = "select t.first_name, t.last_name, sum(w.hours*w.rate) as total from $tablename w 
	join $tutors_table t on w.tutor_id = t.id	
	where date >= '".date("Y-m-01")."'
	group by w.tutor_id
	order by t.first_name, t.last_name";

$RS = runquery($QStr);

$total = 0;
while($row = mysql_fetch_array($RS)){
 echo '<tr>
 		<td>'.$row['first_name'].' '.$row['last_name'].'&nbsp;</td>
 		<td>'.round($row['total'], 2).'&nbsp;</td>
 </tr>';
 $total += $row['total'];
}

?>

	<tr>
		<td><b>Grand Total</b></td>
		<td><b><?php echo round($total, 2); ?></b></td>
	</tr>
</table>
<br/>


</td>
</tr>	
</table>

</form>

<?
put_ptts_footer("");
?>
