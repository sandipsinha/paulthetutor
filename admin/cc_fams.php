<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Stored CC Info", $strAbsPath, "admin", "");
$tablename = "PT_Strip_Info";
$move_id = isset($_POST['move_id'])?$_POST['move_id']:null;

if(!isEmpty($move_id)){
	archive($move_id,$tablename);
	echo "archived $move_id <BR>";
}

$where = " where 1 = 1 ";

?> 

<div align="right">
	<button onclick="javascript:popup('https://www.paulthetutors.com/admin/strip_saved_charge2.php?popup=popup','Charge a Family','600','500')">Charge A Family</button> 
    &nbsp; &nbsp;
    <button onclick="javascript:popup('strip_autopay.php','Details','600','820')">Add New Family</button> 

</div>
<br />

<form name=form method="post"><input type="submit" style="display:none">
<input type="hidden" name=move_id>

<?php 

$sort = $_REQUEST[sort];
if(isEmpty($sort))	$sort = "id";
$order = $_REQUEST[order];
if(isEmpty($order)) $order = "ASC";

$sortby = "Order by $sort $order";
	
$where .= " and archived = 0 ";

$QStr = "select s.*, user_id as fam_id, (select main_name from PT_Family_Info as f where f.id = s.user_id) as family  from $tablename as s $where $sortby";




// echo "$QStr is the qstring <BR>";
$rs = runquery($QStr);

// printRS($rs);

?>
	<BR />
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Credit Card Families</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
<?
$fields = array(
		"id" => "id",
		"fam_id" => "Family ID",
		"family" => "Family",
		"last_four" =>	"Last Four",
		"due" => "Total Due",
		"autopay" => "Auto Pay"
		);
		
put_sorting_headers($fields, $sort, $order, FALSE);		

	while($row = mysql_fetch_array($rs)){
		echo "<tr>";
		while (list ($field, $label) = each ($fields)){
			if($field <> "due"){
				echo "<td> $row[$field] </td>";
			} else {
				$total_due = get_amount_due($row[fam_id]);
				echo "<td> \$$total_due </td>";

			}

		}
		reset($fields);
		
?>
<!--<td> Removed by LH 9-25-14 at pauls request
<a onClick="javascript:popup('show_record.php?strTable=<?=$tablename;?>&record_id=<?=$row['id'];?>','Details','600','820')">
      <img src="<?=$back;?>../images/view.gif" border="0"></a> &nbsp; -->
<?php /*
		echo '<a onclick="if (confirm(\'Are you sure you want to delete this record?\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="' . $back . '../images/del_x.gif" ALT="delete" border="0"></a>&nbsp;';
        
		echo '</td>';*/
		echo "</tr>";

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
