<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("View Current Credits for Paul The Tutor's", $strAbsPath, "admin", "");
$order = $_REQUEST['order'];
$sort = $_REQUEST['sort'];
$move_id = $_REQUEST['move_id'];
$tablename = "PT_Credits";
if ($sort == "")
	$sort = "name";
if($order==""){
	$order="ASC";
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
  	<td align="right" style="padding-bottom:5px"><button onclick="javascript:popup('credits_edit.php','','500','500')"  style="cursor:pointer">Add New Credit row</button></td>
  </tr>
  <tr height="40">
    <td class="td_header">Credits</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=fid&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Family ID</b>'.($sort == 'fid' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Name</b>'.($sort == 'name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Date</b>'.($sort == 'date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td class="text_grey"><b>Amount</b></td>
  	<td class="text_grey"><b>Actions</b></td>
  </tr>

<? 

$QStr = "select * from $tablename order by ".($sort!="id" ? "trim($sort)" : "$sort")." $order";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
 		<td>'.$row[fid].'</td>
 		<td>'.$row['name'].'&nbsp;</td>
 		<td>'.format_date_print(substr($row[date],0,10),"yy-mm-dd","-","mm/dd/yy","/").'&nbsp;</td>
 		<td>'.$row[amount].'&nbsp;</td>
 		<td nowrap  align=center><a style="cursor:pointer" onclick="javascript:popup(\'credits_view.php?id='.$row[id].'\',\'Details\',\'500\',\'500\')"><img SRC="../images/view.gif" ALT="view" border="0"></a>&nbsp;
 			<a style="cursor:pointer" onclick="javascript:popup(\'credits_edit.php?id='.$row[id].'\',\'Details\',\'500\',\'500\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a style="cursor:pointer" onclick="if (confirm(\'Are you sure you want to delete this row?\')) {document.form.move_id.value='.$row[id].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;
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
