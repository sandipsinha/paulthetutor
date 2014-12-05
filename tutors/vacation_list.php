<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

if(strstr($_SERVER['PHP_SELF'], 'admin')) {
  $where = '';
  $admin = true;
} else { 
  include($strAbsPath . "/includes/tut_auth.php");
  $where = ' WHERE tid = '.$_SESSION['tutor_id'];
  $tid = $_SESSION['tutor_id'];
  $admin = false;
}

MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "tutors", "");

$tablename = "PTVacations";


If(isset($_POST['move_id']) && !(empty($_POST['move_id']))){
  $move_id = $_POST['move_id'];
  $MQStr = "select * from $tablename where id=$move_id and tid=".$tid;
  $MRS = runquery($MQStr);
  if($MAR = mysql_fetch_assoc($MRS)){
    $DQStr = "delete from $tablename where id = $move_id";
    echo "<div class=text_success style='text-align:center'>Record $move_id has been deleted</div><BR>";
    // delete the row
    mysql_query($DQStr);
  } 
} 


?>

<div align="right">
	<button onclick="javascript:popup('vacation_edit.php','Details','600','820'); return false;">Add Vacation</button> 
</div>
<br />
	
<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Vacations</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  <?php $admin && print('<td class="text_grey"><b>Tutor</b></td>'); ?>
  	<td class="text_grey"><b>Start Date</b></td>
  	<td class="text_grey"><b>End Date</b></td>
  	<td class="text_grey"><b>Comments</b></td>
  	<td class="text_grey" align="center"><b>Actions</b></td>
  </tr>
 
<?php 

if ($admin) {
  $QStr = "SELECT $tablename.*, PT_Tutors.first_name, PT_Tutors.last_name FROM $tablename LEFT JOIN PT_Tutors ON $tablename.tid = PT_Tutors.id ORDER BY start_date DESC"; 
} else {
  $QStr = "SELECT * FROM $tablename $where ORDER BY start_date DESC";
}
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>';
 !!$admin && print("<td>".$row['first_name']. ' '. $row['last_name'].'</td>');
 		echo '<td>'.date("m/d/Y", strtotime($row['start_date'])).'&nbsp;</td>
 		<td>'.date("m/d/Y", strtotime($row['end_date'])).'&nbsp;</td>
 		<td>'.$row['other'].'&nbsp;</td>
 		<td nowrap align=center>
 			<a onclick="javascript:popup(\'vacation_edit.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a onclick="if (confirm(\'Are you sure you want to delete this vacation?\n\nIf appointments or schedules were modified when this vacation was created, they have not be restored. Please make sure to re-enter any appointments or schedules that are once again valid.\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="delete" border="0"></a>&nbsp;
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
