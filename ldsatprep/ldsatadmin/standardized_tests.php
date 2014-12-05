<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Standardized Tests", $strAbsPath, "admin", "");
$tablename = "TP_Test_Info";
$move_id = isset($_POST['move_id'])?$_POST['move_id']:null;

If(!(empty($move_id))){
	$MQStr = "select id from $tablename where id=$move_id";
	$MRS = runquery($MQStr);
	if($MAR = mysql_fetch_assoc($MRS)){
		$DQStr = "update $tablename set archived = 1 where id = $move_id";
		echo "<div class=text_success style='text-align:center'>Record $move_id has been Archived</div><BR>";
		mysql_query($DQStr);
	} 
} 

?>
<link href="../../includes/paulthetutors.css" rel="stylesheet" type="text/css" />


<div align="right">
<!-- 
	<button onclick="javascript:popup('edit_record.php?strTable=<?=$tablename;?>','Details','600','820')">Add New Test</button> 
-->
<a class="bold_text" href="gettestinfo.php">Add A Test</a> </div>
<br />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 

$sort = $_REQUEST[sort];
if(isEmpty($sort))	$sort = "order_number ASC, id";
$order = $_REQUEST[order];
if(isEmpty($order)) $order = "ASC";

$sortby = " Order by $sort $order ";
	
$where =  " where archived = 0 ";

$QStr = "select id, name, (select abbreviation from TP_Type_Tests tt where tt.id = tn.test_type_id) as test_type from $tablename as tn $where $sortby";
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
		);
		
put_sorting_headers($fields, $sort, $order,1);		
$strTable = $tablename;
put_table_cells($fields,$rs,$strTable,1,1,"../../");	
	

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
