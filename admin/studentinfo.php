<?php
include("../includes/config.php");
include("../includes/pttec_includes.phtml");
$folder = getfolder('','','');
MySQL_PaulTheTutor_Connect();
put_ptts_header("View Current Students for Paul The Tutor's", $strAbsPath, "admin", "");
$order = isset($_REQUEST['order'])?$_REQUEST['order']:'ASC';
$sort = isset($_REQUEST['sort'])?$_REQUEST['sort']:'first_name';
$move_id = isset($_REQUEST['move_id'])?$_REQUEST['move_id']:null;
$fid = isset($_REQUEST['fid'])?$_REQUEST['fid']:null;
$tablename = "PTStudentInfo_New ";
$tablename2 = "PT_Family_Info ";
$order2 = ($order == "ASC" ? "DESC" : "ASC");

if(isEmpty($archived))
	$archived = 0;
$where = " where (s.archived = $archived  or ISNULL(s.archived))";


if ($fid)
	$where.= ' AND s.fid='.$fid; 

If(!(empty($move_id))){
	archive($move_id, $tablename);
}
?>
<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id><input type="hidden" name=fid value="<?php echo $fid?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height="40">
    <td class="td_header">Student Information</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
 <?php if ((!isset($folder) || $folder != "tutors") && !$fid){?>
     <tr height=25>
  		 	<td colspan="8">&laquo;<a href="returnstudents.php" style="text-decoration:none">See Archived Students</a></td>
<td colspan=2 align=right>
	<button onclick="javascript:popup('student_edit.php','Details','600','820')">Add new Student</button> 
</div>
<br />

 		 </tr>
 <?php }?>
  <tr style="background: #eee; height: 35px">
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=id&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>ID</b>'.($sort == 'id' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=fid&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Fam ID</b>'.($sort == 'fid' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=last_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Last Name</b>'.($sort == 'last_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=first_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>First Name</b>'.($sort == 'first_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td class="text_grey"><b>Phone</b></td>
  	<td class="text_grey"><b>Email</b></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=f_last_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Main Contact</b>'.($sort == 'f.last_name, f.first_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td class="text_grey"><b>Main Phone</b></td>
  	<td class="text_grey"><b>Main Email</b></td>
  	<td class="text_grey"><b>Action</b></td>
  </tr>

<? 

$QStr = "select s.*, f.main_name as f_main_name, f.main_phone as f_main_phone, f.main_email as f_main_email, SUBSTRING_INDEX(f.main_name, ' ', -1) as f_last_name, SUBSTRING_INDEX(f.main_name, ' ', 1) as f_first_name from $tablename s LEFT JOIN $tablename2 f ON s.fid=f.id $where order by ".($sort!="id" ? "$sort" : "$sort")." $order";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
	$f_name = get_fam_name_last_first($row['f_main_name']);
 echo '<tr>
 		<td valign=top>'.$row['id'].'</td>
 		<td valign=top>'.$row['fid'].'</td>
 		<td valign=top>'.$row['last_name'].'&nbsp;</td>
 		<td valign=top>'.$row['first_name'].'&nbsp;</td>
 		<td valign=top>'.$row['phone'].'&nbsp;</td>
 		<td valign=top>'.$row['email'].'&nbsp;</td>
 		<td valign=top>'.$f_name.'&nbsp;</td>
 		<td valign=top>'.$row['f_main_phone'].'&nbsp;</td>
 		<td valign=top>'.$row['f_main_email'].'&nbsp;</td>';
 		echo '<td nowrap  align=center><a onclick="popup(\'student_view.php?id='.$row['id'].'\',\'\',600,700)"><img SRC="../images/view.gif" ALT="view" border="0"></a>&nbsp;';
		if($folder == 'admin'){
			echo '<a onclick="popup(\'student_edit.php?id='.$row['id'].'\',\'\',600,700)"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a href="#void" onclick="if (confirm(\'Are you sure you want to archive this student?\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;';
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
