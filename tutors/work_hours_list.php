<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

include($strAbsPath . "/includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "tutors", "");

$tablename = "PT_NT_Work_Hours";
$tid = $_SESSION['tutor_id'];

If(isset($_POST['move_id']) && !(empty($_POST['move_id']))){
  $move_id = $_POST['move_id'];
  $MQStr = "select * from $tablename where id=$move_id and tutor_id=$tid";
  $MRS = runquery($MQStr);
  if($MAR = mysql_fetch_assoc($MRS)){
    $DQStr = "delete from $tablename where id = $move_id";
    echo "<div class=text_success style='text-align:center'>Record $move_id has been deleted</div><BR>";
    // delete the row in work_hours
    mysql_query($DQStr);
    // now delete the associated appointment, if applicable
    mysql_query("DELETE from PT_Other_Appt WHERE work_hours_id = ".$move_id);
  } 
} 


?>

<div align="right">
	<button onclick="javascript:popup('work_hours_edit.php','Details','600','820')">Add new work hours</button> 
</div>
<br />
	
<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Work hours</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td class="text_grey"><b>Date</b></td>
  	<td class="text_grey"><b>Hours</b></td>
  	<td class="text_grey"><b>Rate</b></td>
  	<td class="text_grey"><b>Description</b></td>
  	<td class="text_grey"><b>Comments</b></td>
  	<td class="text_grey"><b>Action</b></td>
  </tr>
 
<?php 

$QStr = "select * from $tablename 
	where tutor_id=$tid
	order by date DESC";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
 		<td>'.date("m/d/Y", strtotime($row['date'])).'&nbsp;</td>
 		<td>'.$row['hours'].'&nbsp;</td>
 		<td>'.$row['rate'].'&nbsp;</td>
 		<td>'.$row['description'].'&nbsp;</td>
 		<td>'.$row['comments'].'&nbsp;</td>
 		<td nowrap align=center>
 			<a onclick="javascript:popup(\'work_hours_edit.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a onclick="if (confirm(\'Are you sure you want to delete this entry?\n\nIf there is an appointment associated with it, the appointment will also be deleted.\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="delete" border="0"></a>&nbsp;
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
