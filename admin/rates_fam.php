<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Rates for a Family", $strAbsPath, "admin", "");
$tablename = "PT_Rates_Fam";
$move_id = isset($_POST['move_id'])?$_POST['move_id']:null;

If(!(empty($move_id))){

	archive($move_id, $tablename);
	
} 

?>

<div align="right">
	<button onclick="javascript:popup('rate_fam_edit.php','Details','600','820')">Add New Rate</button> 
</div>
<br />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 

$sort = $_REQUEST[sort];
if(isEmpty($sort))	$sort = "id";
$order = $_REQUEST[order];
if(isEmpty($order)) $order = "DESC";

$sortby = "Order by $sort $order";
	


$QStr = "select id, archived, family_id, purchase_date, end_date, (select main_name from PT_Family_Info as f where f.id = r.family_id) as family, student_id, (select short_name from PT_Locations as l where l.id = r.location_id) as location  ,(select CONCAT(first_name, LEFT(last_name, 2)) from PT_Tutors where PT_Tutors.id = r.tutor_id) as tutor, (select CONCAT(first_name, ' ', last_name) from PTStudentInfo_New as s where s.id = r.student_id) as student, rate, pay, hours_purchased, hours_remaining from PT_Rates_Fam as r $where $sortby";
$rs = runquery($QStr);

?>
	<BR />
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Family Rate Information</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1  class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
<?
put_sorting_header("id", "id",$sort,$order);
put_sorting_header("fid", "family_id",$sort,$order);
put_sorting_header("Family", "family",$sort,$order);
put_sorting_header("Student", "student",$sort,$order);
put_sorting_header("Tutor", "tutor",$sort,$order);
put_sorting_header("Location", "location",$sort,$order);
put_sorting_header("Rate", "rate",$sort,$order);
put_sorting_header("Pay", "pay",$sort,$order);
put_sorting_header("Start", "purchased_date",$sort,$order);
put_sorting_header("End", "end_date",$sort,$order);

echo"<th>Action</th>  </tr><tr> ";
 
while($row = mysql_fetch_array($rs)){
	echo '<td>'.$row['id'];
	if($row[archived] == 1){ ?>
 		<img src="../images/red_garbage_can.png" width="16" height="16" alt="ARCHIVED" />
<? 	}

	echo '</td>';
	echo '<td>'.$row['family_id'].'</td>';
	echo '<td>'.$row['family'].'</td>';
	
	echo '<td>'.$row['student'].'</td>';
	echo '<td>'.$row['tutor'].'</td>';
	echo '<td>'.$row['location'].'</td>';
	echo '<td>'.$row['rate'].'</td>';
	echo '<td>'.$row['pay'].'</td>';
	
	echo '<td>'.$row['purchase_date'].'</td>';
	echo '<td>'.$row['end_date'].'</td>';
	
if($row[archived] == 0) {
	echo '<td> <a onclick="javascript:popup(\'rate_fam_edit.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;<a onclick="if (confirm(\'Are you sure you want to delete this rate?\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="delete" border="0"></a>&nbsp;</td></tr>';
} else {
	echo '<td> ' ?>
     &nbsp;
     <? echo '  </td></tr>';
	 
}
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
