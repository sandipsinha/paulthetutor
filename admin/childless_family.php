<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Families with no children", $strAbsPath, "admin", "");
$tablename = "PT_Family_Info";
$move_id = isset($_POST['move_id'])?$_POST['move_id']:null;

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

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 
  $q = "SELECT MAX(PTAddedApp2.date) as last_session, PT_Family_Info.* FROM PT_Family_Info 
  LEFT OUTER JOIN PTStudentInfo_New ON PT_Family_Info.id = PTStudentInfo_New.fid 
  LEFT OUTER JOIN PTAddedApp2 ON PT_Family_Info.id=PTAddedApp2.fid 
  WHERE PTStudentInfo_New.id IS NULL
  GROUP BY PT_Family_Info.id";
$r = runquery($q);
?>
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40"><td class="td_header">Family Information
    <span style="float:right; padding-right:8px;"><button onclick="javascript:popup('student_edit.php','Details','600','820')">Add new Student</button></span>
  </td></tr><tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<th class="text_grey" width="24%"><b>Main Name</b></th>
  	<th class="text_grey" width="24%"><b>Main Contact</b></th>
  	<th class="text_grey" width="24%"><b>Last Session</b></th>
  	<th class="text_grey" width="24%"><b>Main Phone</b></th>
  	<th class="text_grey" width="4%"><b>Action</b></th>
  </tr>
 
<?php 
while($row = mysql_fetch_array($r)){
echo '<tr><td>'.$row['main_name'].'</td><td>'.$row['main_contact'].'</td><td>'.$row['last_session'].'</td><td>'.$row['main_phone'].'</td><td>
 			<a onclick="javascript:popup(\'families_edit.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a onclick="if (confirm(\'Are you sure you want to delete this family?\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="delete" border="0"></a>&nbsp;</td></tr>';
}

?>

</table>
<br/>


<br />
</td>
</tr>	
</table>

</form>

<?
put_ptts_footer("");
?>
