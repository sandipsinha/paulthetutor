<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Rates by Location for Paul The Tutor's", $strAbsPath, "admin", "");
$tablename = "PT_Rates";
$move_id = isset($_POST['move_id'])?$_POST['move_id']:null;

If(!(empty($move_id))){
	$MQStr = "select id, rate, pay, description, (select short_name from PT_Locations where PT_Locations.id = PT_Rates_Loc.location_id) as location from PT_Rates_Loc where id=$move_id";
	$MRS = runquery($MQStr);
	if($MAR = mysql_fetch_assoc($MRS)){
		$DQStr = "delete from $tablename where id = $move_id";
		echo "<div class=text_success style='text-align:center'>Record $move_id has been deleted</div><BR>";
//		mysql_query($DQStr);
	} 
} 

?>

<div align="right">
	<button onclick="javascript:popup('rate_loc_edit.php','Details','600','820')">Add New Rate</button> 
</div>
<br />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 

$sort = $_REQUEST[sort];
if(isEmpty($sort))	$sort = "id";
$order = $_REQUEST[order];
if(isEmpty($order)) $order = "ASC";

$sortby = "Order by $sort $order";
	


$QStr = "select id, rate, pay, description, (select name from PT_Locations where PT_Locations.id = PT_Rates_Loc.location_id) as location from PT_Rates_Loc $where $sortby";
$r = runquery($QStr);
?>
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Location Rate Information</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
<?
	echo '<th nowrap><a class=a_grey href="?'."&sort=id&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>ID</b>'.($sort == 'id' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a></th>';


		echo '<th nowrap><a class=a_grey href="?'."&sort=location&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Name</b>'.($sort == 'location' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a></th>';


?>
  	<th class="text_grey"><b>Rate</b></th>
  	<th class="text_grey"><b>Pay</b></th>
  	<th class="text_grey"><b>Description</b></th>
  	<th class="text_grey"><b>Action</b></th>
  </tr>
 
<?php 
while($row = mysql_fetch_array($r)){
	echo '<tr><td>'.$row['id'].'</td><td>'.$row['location'].'</td><td>$'.(float) $row['rate'].'</td><td>$'.(float) $row['pay'].'</td><td>'.$row['description'].'</td><td> <a onclick="javascript:popup(\'rate_loc_edit.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;<a onclick="if (confirm(\'Are you sure you want to delete this rate?\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="delete" border="0"></a>&nbsp;</td></tr>';
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
