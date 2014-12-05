<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Applicants", $strAbsPath, "admin", "");
$tablename = "PT_Prospect_Admin";
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
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css" />


<div align="right">
	<button onclick="javascript:popup('edit_record.php?strTable=<?=$tablename;?>','Details','600','820')">Add New Rate</button> 
</div>
<br />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 

$sort = $_REQUEST[sort];
if(isEmpty($sort))	$sort = "id";
$order = $_REQUEST[order];
if(isEmpty($order)) $order = "DESC";

$sortby = "Order by $sort $order";
	


?>
	<BR />

<table width="900"  border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Applicants</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 60px">
<?
$fields = array(
		"id" => "id",
		"applicant" => "Applicant",
		"cover_letter" =>	"Cover Letter",
		"experience" => "Experience",
		"other_information" => "Other Info",
		"notes" => "Notes"
		);
		
put_sorting_headers($fields, $sort, $order,1);		

$aqs = "select *, id, (Concat(first_name, ' ', last_name, '<br> <a href=\"mailto:', email ,'?Subject=Working%20at%20Paul%20the%20Tutor\'s&cc=admin@paulthetutors.com\">', email, '</a> <br>', phone, '<br>', position, ' <BR>', application_date)) as applicant, LEFT (experience, 250) as experience, LEFT (cover_letter, 200) as cover_letter, (Concat('Status: ', stage, '<br>', notes)) as notes from $tablename $where $sortby LIMIT 100 ";
$rs = runquery($aqs);

put_table_cells($fields,$rs,$tablename,1,1);	
	

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
