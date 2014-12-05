<?php
include($strAbsPath."/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("View Student's Assignments", $strAbsPath, "admin", "");
// printarray($_REQUEST);
// printarray($_SESSION);

$folder = getfolder('','','');
$order = $_REQUEST['order'];
$sort = $_REQUEST['sort'];



$strTableName = "PT_Student_Assignments";
$where = " where 1 = 1 ";

$move_id = $_REQUEST['move_id'];
If(!(empty($move_id))){
	archive($move_id,$strTableName);

}
if ($sort == "")
	$sort = "due_date";
if($order==""){
	$order="DESC";
}else
	$order=$_REQUEST['order'];
$order2 = ($order == "ASC" ? "DESC" : "ASC"); 


If(!isEmpty($_REQUEST[student_id])){
	$student_id = $_REQUEST[student_id];
	$where = $where . " and student_id = $student_id ";
}

If(!isEmpty($_REQUEST[tutor_id])){
	$tutor_id = $_REQUEST[tutor_id];
	
	if(isEmpty($student_id))
		$where = $where . " and tutor_id = $tutor_id";
		
}
If(!isEmpty($_SESSION[fid])){
	$family_id = $_SESSION[fid];
	
	if(isEmpty($student_id)){
		$where = $where . " and student_id in (select id from PTStudentInfo_New where fid = $family_id)  ";
	}
		
}

If(!isEmpty($_REQUEST[family_id])){
	$family_id = $_REQUEST[family_id];
	
	if(!isEmpty($student_id)){
		$where = $where . " and student_id in (select id from PTStudentInfo_New where family_id = $family_id)  ";
		
		echo "$where is <br>";
	}
		
}


?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css" />

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr><td>
  <table width="100%"><tr>
  <tr>
    <td colspan="2">
  <span class="Head2_Green">See Assignments a Student</span>
<?
if($folder == "admin"){
	get_tutor_id($tutor_id,"tutor_id","this.form.submit()");
}

put_student_search("search", "student_id",  $student_id, "student_id", "this.form.submit()");

?>
<tr><td colspan="2" align="center">
<BR />  <input name="" type="submit" />&nbsp; &nbsp;<input name="" type="reset" />
</td></tr>
  
  
  
  </td>
  	</table></td></tr>
  <tr height="40">
    <td class="td_header">Assignments</td>
  </tr>
  <td align="right" style="padding-bottom:5px"><button onclick="javascript:popup('student_assignments_edit.php?strTable=<?=$strTableName;?>','','700','500')"  style="cursor:pointer">Add Assignment</button></td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">

<?
//create the "Status" array
$QStrCol = "SHOW FULL COLUMNS FROM $strTableName where field = 'status'";
$arRow = rowquery($QStrCol);
$arStatus = MySQL_SetToArray($arRow[Type]);

//printarray($arRow);
// echo "arrow is $arRow[Type]<BR>";
// printarray($arStatus);

$fields = array(
		"id" => "id",
		"student" => "Student",
		"assignment" =>	"Assignment",
		"due_date" => "Due Date",
		"status" => "Status"
		);
		
put_sorting_headers($fields, $sort, $order,1);		


?>

  </tr>

<? 

$QStr = "select a.*, CONCAT(s.first_name, ' ', s.last_name) as student from $strTableName a JOIN PTStudentInfo_New s on a.student_id = s.id $where order by ".($sort!="id" ? "trim($sort)" : "$sort")." $order";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
	$student_name = get_student_name($row[student_id]);
 echo '<tr>
 		<td>'.$row[id].'</td>
 		<td>'.$row[student].'</td>
 		<td>'.$row[assignment].'</td>
 		<td>'.format_date_print(substr($row[due_date],0,10),"yy-mm-dd","-","mm/dd/yy","/").'&nbsp;</td>
 		<td>';
		
// echo "$row[status] is the status <BR>";		
justSelectInput("status", "status[$row[id]]", $arStatus, $row[status],'','status');		
		
echo '</td>
 		<td nowrap  align=center><a style="cursor:pointer" onclick="javascript:popup(\'show_record.php?strTable='.$strTableName.'id='.$row[id].'\',\'Details\',\'500\',\'500\')"><img SRC="../images/view.gif" ALT="view" border="0"></a>
 		</td>
 </tr>';
 
// &nbsp;<a style="cursor:pointer" onclick="javascript:popup(\'credits_edit.php?id='.$row[id].'\',\'Details\',\'500\',\'500\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;<a style="cursor:pointer" onclick="if (confirm(\'Are you sure you want to delete this row?\')) {document.form.move_id.value='.$row[id].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp; 
 
 
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
