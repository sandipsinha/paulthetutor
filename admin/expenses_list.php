<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Expenses", $strAbsPath, "admin", "");
$order = $_REQUEST['order'];
$sort = $_REQUEST['sort'];
$move_id = $_REQUEST['move_id'];
$tablename = "PT_Expenses";
if ($sort == "")
	$sort = "purchase_date";
if($order==""){
	$order="DESC";
}else
	$order=$_REQUEST['order'];
$order2 = ($order == "ASC" ? "DESC" : "ASC"); 

If(!(empty($move_id))){
	$MQStr = "DELETE from $tablename where id=$move_id";
//	runquery($MQStr);
	echo "we would have $MQStr";
} 
?>
<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  	<td align="right" style="padding-bottom:5px"><button onclick="document.location='class_edit.php'; return false" style="cursor:pointer">Add New Class</button></td>
  </tr>
  <tr height="40">
    <td class="td_header">Classes List</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=id&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Class ID</b>'.($sort == 'id' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=start_date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Start Date</b>'.($sort == 'purchase_date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=end_date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>End Date</b>'.($sort == 'end_date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td class="text_grey"><b>Class Time</b></td>
  	<td class="text_grey"><b>Location</b></td>
  	<td class="text_grey"><b>Size</b></td>
  	<td class="text_grey"><b>Status</b></td>
  	<td class="text_grey"><b>Action</b></td>
  </tr>

<? 

$QStr = "select * from $tablename order by ".($sort!="id" ? "trim($sort)" : "$sort")." $order";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
 		<td>'.$row[id].'</td>
 		<td>'.$row['start_date'].'&nbsp;</td>
 		<td>'.$row[end_date].'&nbsp;</td>
 		<td>'.$row[class_time].'&nbsp;</td>
 		<td>'.$row[location].'&nbsp;</td>
 		<td>'.$row[size].'&nbsp;</td>
 		<td>'.$row[status].'&nbsp;</td>
 		<td nowrap  align=center><a href="class_view.php?id='.$row[id].'"><img SRC="../images/view.gif" ALT="view" border="0"></a>&nbsp;
 			<a href="class_edit.php?id='.$row[id].'"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a href="#void" onclick="if (confirm(\'Are you sure you want to delete this class?\')) {document.form.move_id.value='.$row[id].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;
 			<a target=_blank href="view_rosters.php?class='.$row[id].'">Rosters</a>&nbsp;
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
