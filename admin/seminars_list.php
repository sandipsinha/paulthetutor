<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("View Current Seminars for Paul The Tutor's", $strAbsPath, "admin", "");
$order = $_REQUEST['order'];
$sort = $_REQUEST['sort'];
$move_id = $_REQUEST['move_id'];
$tablename = "TP_Seminar_Info";
if ($sort == "")
	$sort = "id";
if($order==""){
	$order="DESC";
}else
	$order=$_REQUEST['order'];
$order2 = ($order == "ASC" ? "DESC" : "ASC"); 

If(!(empty($move_id))){
	$MQStr = "DELETE from $tablename where id=$move_id";
	runquery($MQStr);
} 
?>
<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  	<td align="right" style="padding-bottom:5px"><button onclick="document.location='seminar_edit.php'; return false" style="cursor:pointer">Add New Seminar</button></td>
  </tr>
  <tr height="40">
    <td class="td_header">Seminars List</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=id&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Seminar ID</b>'.($sort == 'id' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Name</b>'.($sort == 'name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Date</b>'.($sort == 'date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td class="text_grey"><b>Start Time</b></td>
  	<td class="text_grey"><b>End Time</b></td>
  	<td class="text_grey"><b>Location</b></td>
  	<td class="text_grey"><b>Max Capacity</b></td>
  	<td class="text_grey"><b>Registered</b></td>
  	<td class="text_grey"><b>Action</b></td>
  </tr>

<? 

$QStr = "select * from $tablename order by ".($sort!="id" ? "trim($sort)" : "$sort")." $order";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
 		<td>'.$row[id].'</td>
 		<td>'.$row['name'].'&nbsp;</td>
 		<td>'.$row[date].'&nbsp;</td>
 		<td>'.$row[start_time].'&nbsp;</td>
 		<td>'.$row[end_time].'&nbsp;</td>
 		<td>'.$row[location].'&nbsp;</td>
 		<td>'.$row[max_capacity].'&nbsp;</td>
 		<td>'.$row[registered].'&nbsp;</td>
 		<td nowrap  align=center><a href="seminar_view.php?id='.$row[id].'"><img SRC="../images/view.gif" ALT="view" border="0"></a>&nbsp;
 			<a href="seminar_edit.php?id='.$row[id].'"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a href="#void" onclick="if (confirm(\'Are you sure you want to delete this class?\')) {document.form.move_id.value='.$row[id].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;
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
