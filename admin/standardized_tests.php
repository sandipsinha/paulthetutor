<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("PTTs Tutor's Rates", $strAbsPath, "admin", "");
$tablename = "TP_SAT_Tests";
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
	<button onclick="javascript:popup('edit_record.php?strTable=<?=$tablename;?>','Details','600','820')">Add New Rate</button> 
</div>
<br />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 

$sort = $_REQUEST[sort];
if(isEmpty($sort))	$sort = "id";
$order = $_REQUEST[order];
if(isEmpty($order)) $order = "ASC";

$sortby = "Order by $sort $order";
	


$QStr = "select id, name, (select abbreviation from TP_Type_Tests tt where tt.id = tn.test_type) as test_type, source  from $tablename as tn $where $sortby";
$rs = runquery($QStr);

?>
	<BR />
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Standardized Tests</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
<?
$fields = array(
		"id" => "id",
		"name" => "Name",
		"test_type" => "Type",
		"source" =>	"Source",
		);
		
put_sorting_headers($fields, $sort, $order,1);		

put_table_cells($fields,$rs,1,1,1);	
	

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
