<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("PTTs Locations", $strAbsPath, "admin", "");
$tablename = "PT_Locations";
$move_id = isset($_POST['move_id'])?$_POST['move_id']:null;

If(!(empty($move_id))){
	$MQStr = "select id from $tablename where id=$move_id";
	$MRS = runquery($MQStr);
	if($MAR = mysql_fetch_assoc($MRS)){
		$DQStr = "delete from $tablename where id = $move_id";
		echo "<div class=text_success style='text-align:center'>Record $move_id has been deleted</div><BR>";
		mysql_query($DQStr);
	} 
} 

?>

<div align="right">
	<button onclick="javascript:popup('edit_record.php?strTable=<?=$tablename;?>','Details','600','820')">Add New Location</button> 
</div>
<br />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 

$sort = $_REQUEST[sort];
if(isEmpty($sort))	$sort = "id";
$order = $_REQUEST[order];
if(isEmpty($order)) $order = "ASC";

$sortby = "Order by $sort $order";
	


$QStr = "select * from $tablename $where $sortby";
$rs = runquery($QStr);

?>
	<BR />
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Locations</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
<?
put_sorting_header("id", "id",$sort,$order);
put_sorting_header("Name", "name",$sort,$order);
put_sorting_header("Short Name", "short_name",$sort,$order);

echo"<th>Action</th>  </tr><tr> ";
 
while($row = mysql_fetch_array($rs)){
	echo '<td>'.$row['id'].'</td>';
	echo '<td>'.$row['name'].'</td>';
	echo '<td>'.$row['short_name'].'</td>';
	
	
	echo '<td> <a onclick="javascript:popup(\'edit_record.php?strTable=' . $tablename . '&id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;<a onclick="if (confirm(\'Are you sure you want to delete this rate?\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="delete" border="0"></a>&nbsp;</td></tr>';
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
