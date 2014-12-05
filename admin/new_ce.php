<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("First Call or Email Log", $strAbsPath, "admin", "");
$tablename = "PT_First_Contact";
$move_id = isset($_POST['move_id'])?$_POST['move_id']:null;
?>

<div align="right">
	<button onclick="javascript:popup('edit_new_ce.php?strTable=<?=$tablename;?>','Details','600','820')">Add New Call</button> 
</div>
<br />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 

$sort = $_REQUEST[sort];
if(isEmpty($sort))	$sort = "needs_attention DESC, Status ASC, id ";
$order = $_REQUEST[order];
if(isEmpty($order)) $order = "DESC";

$sortby = "Order by $sort $order";
	


//$QStr = "select id,  CONCAT(parents, '<br>', phone, '<br>', email) as parents, students, subjects, comments, follow_up,(select CONCAT(t.first_name,' ',t.last_name) from PT_Tutors as t where t.id = $tablename.assigned_to_eid) as assigned_to,(select CONCAT(t.first_name,' ',t.last_name) from PT_Tutors as t where t.id = $tablename.answered_by_eid) as answered_to, family_id, IF(needs_attention=1,'Attention','Completed') as needs_attention from $tablename $where $sortby ";

$QStr = "select id, date, CONCAT(parents, '<br>', phone, '<br>', email) as parents, CONCAT(students, '<BR><BR>', subjects) as students, LEFT (comments, 400) as comments, follow_up,(select CONCAT(t.first_name,' ',t.last_name) from PT_Tutors as t where t.id = $tablename.assigned_to_eid) as assigned_to,(select CONCAT(t.first_name,' ',t.last_name) from PT_Tutors as t where t.id = $tablename.answered_by_eid) as answered_to, family_id, Status from $tablename $where $sortby ";
$rs = runquery($QStr);

// echo "sq is $QStr <BR>";

?>
	<BR />
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Potential Students</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
<?
$fields = array( 
		"id" => "id",
		"date" => "",
		"parents" => "",
		"students" => "",
		"comments" =>	"",
        "follow_up" =>	"Follow Up",
		"answered_to" => "",
		/*"needs_attention" => "Attention",*/
        "Status" => ""
		);

put_sorting_headers($fields, $sort, $order,1);

$editable=array( 0,0,0,0,0,1,0,2);//1 indicates a editable field add 2 says that is a drop down field
#put_table_cells($fields,$rs,$tablename,1,0);
put_table_cells($fields,$rs,$tablename,1,0,"",$editable);
	

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
