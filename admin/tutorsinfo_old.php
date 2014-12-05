<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Tutors for Paul The Tutor's", $strAbsPath, "admin", "");
$order = isset($_REQUEST['order']) ? $_REQUEST['order'] : null;
$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : null;  
$move_id = isset($_REQUEST['move_id']) ? $_REQUEST['move_id'] : null;
$tablename = "PT_Tutors";

If(!(empty($move_id))){
	$msg = archive($move_id, $tablename);
	
} 
?>


<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css" />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?
if ($msg)
	echo "$msg <BR>";
	
?>	

  <div style="font-weight:bold" align="right"><a href="tutorsinfo.php?archived=1">See Also Archived Tutors</a>
  &nbsp;&nbsp;&nbsp;&nbsp;<a href="tutorsinfo.php?all=1">    See All Employees</a>
  &nbsp;&nbsp;&nbsp;&nbsp;<a href="tutorsinfo.php">    See Only Working Tutors</a><br /><br /></div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Tutors</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td class="text_grey"><b>Tutor ID</b></td>
  	<td class="text_grey"><b>Name</b></td>
  	<td class="text_grey"><b>Position</b></td>
  	<td class="text_grey"><b>GoogleVoice Phone</b></td>
  	<td class="text_grey"><b>Mobile Phone</b></td>
  	<td class="text_grey"><b>PTTS Email</b></td>
  	<td class="text_grey"><b>Personal Email</b></td>
  	<td class="text_grey"><b>Action</b></td>
  </tr>

<? 
$where = " where position like '%tutor%' and archived <> 1 ";
if($_REQUEST[archived] == 1)
	$where = " where position like '%tutor%' ";
	
if($_REQUEST[all] == 1)
	$where = " ";	

$QStr = "select * from $tablename $where order by position DESC,id ASC";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
 		<td>'.$row['id'].' &nbsp;</td>
 		<td>'.$row['first_name'].' '.$row['last_name'].'&nbsp;</td>
 		<td>'.$row['position'].'&nbsp;</td>
 		<td>'.$row['gvoice_phone'].'&nbsp;</td>
 		<td>'.$row['mobile_phone'].'&nbsp;</td>
 		<td>'.$row['email'].'&nbsp;</td>
 		<td>'.$row['personal_email'].'&nbsp;</td>
 		<td nowrap align=center><a onclick="javascript:popup(\'tutor_view.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/view.gif" ALT="view" border="0"></a>&nbsp;
 			<a onclick="javascript:popup(\'tutor_edit.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a onclick="if (confirm(\'Are you sure you want to archive this tutor?\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;
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
