<?php
include("../includes/pttec_includes.phtml");
$folder = getfolder('','','');
if ($folder == "tutors")
	include("../includes/tut_auth.php");
	
MySQL_PaulTheTutor_Connect();
put_ptts_header("Comments", $strAbsPath, "admin",'');
$strTableName = "PT_Comments_Student";

// as student_id = 0 means all students who are not registered
$student_id = isset($_REQUEST['student_id']) ? $_REQUEST['student_id']: "-1";	
// echo "student id is $student_id <BR>";
// printarray($_REQUEST);
if($student_id == 0){
	$student_name = "Non-Registered Students";
} else if ($student_id == -1){
	$student_name = "All Students";
} else {
 // if the student is registered, get their name	
	$student_name = get_student_name($student_id);
}	

$order = isset($_REQUEST['order']) ? $_REQUEST['order']: null;
$sort = isset($_REQUEST_['sort']) ? $_REQUEST['sort'] : null;
$delete_id = isset($_REQUEST['delete_id']) ? $_REQUEST['delete_id'] : null;
$tablename = "PT_Comments_Students";
if ($sort == "")
	$sort = "date";
if($order==""){
	$order="DESC";
}else
	$order=$_REQUEST['order']; 
$date_two_years_ago = (date('Y')-2).'-'.date('m').'-'.date('d');
$tutor_id = $_SESSION['tutor_id'];
if ($tutor_id)
	$is_tutor = 1;
elseif ($folder == "admin")
	$tutor_id = $_REQUEST['tid'];

if ($delete_id){
	if ($is_tutor){
		$QStr = "select * from $tablename where id = '$delete_id'";
		$FieldsRS = runquery($QStr);
		$arFieldsVals = mysql_fetch_array($FieldsRS);
		if ($arFieldsVals['tid']!=$tutor_id)
			die("Error. You are not authorized to delete this schedule.");
	}
	if (runquery("delete FROM $tablename where id = '$delete_id'")){
		$res_del = runquery("SELECT id FROM $tablename2 WHERE sched_id='".$delete_id."'");
                $mailmsg= "A schedule was deleted:";
		while($row_del=mysql_fetch_array($res_del))
		  $mailmsg .= "\n". session_del($row_del['id'],'', array('email_paul'=>false,'email_tut'=>false));
                if ($folder == "admin") {
                  $tut = tutor_info($tutor_id);
                  ptts_mail($tut['email'], "schedule deleted", $mailmsg) ;
                }
                ptts_mail("paul@paulthetutors.com", "schedule deleted", $mailmsg) ;

		echo "<div class=text_success style='text-align:center'>The comment $delete_id has been deleted.</div>";
	}
}	

?>

<form name=form method="get"><input type="submit" style="display:none">
<input type="hidden" name=tid value="<?=$student_id?>">
<input type="hidden" name=tid value="<?=$tid?>">
<input type="hidden" name=sort value="<?=$sort?>">
<input type="hidden" name=order value="<?=$order?>">
<input type="hidden" name=delete_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	
<?
	get_student_id($student_id, "student_id","this.form.submit()","Other")
?>
<TD width="30%"></TD>
<td align="right">

<button onclick="javascript:popup('comment_edit.php','AddComment','600','600')">Add New Comment</button>

</td>
</tr><tr height=5><td></td></tr>
  <tr>
    <td class=td_header colspan="2">Comments for <?=$student_name;?></td>
  </tr>
  <tr>
    <td  valign="top"  colspan="2">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	
<?
if (($student_id == 0) or (isEmpty($student_id))){ //if they are looking for comments about students who are not yet registered, will have to put the name of the student, and have it be sortable
?>

		<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=first_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b> Student</b>'.($sort == 'first_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>

<? 
} // end if not a registered student
?>
	
	
	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>date</b>'.($sort == 'date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>


  	<td class="text_grey"><b>Commentor</b></td>
  	<td class="text_grey"><b>Title</b></td>
  	<td class="text_grey"><b>Comment</b></td>
<? if($folder == 'admin'){ ?>
  		<td class="text_grey"><b>Action</b></td>
<? } ?>		
  </tr>


<? 
if($student_id == 0){
	$order = "first_name ASC, date DESC";
	$sort = "";
}	

$QStr = "select * from $strTableName where student_id = $student_id ORDER BY $sort $order ";

echo "qstr is $QStr<BR>";

$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){

// get the student's name
if ((student_id ==0) or (isEmpty($student_id))){ // if sid is 0, then get the name from the database
	$student_name = $row[first_name]. " " . $row[last_name];

		
?>
  <tr><td><?="$student_name ($row[student_id]) &nbsp";?> </td>		
		
<?	
} // end if we need to put the students name

 if ($row['tutor_id'] <> 0){ // if the commentor is a ptts employee
 	$tutor_ar = get_tut_info($row[tutor_id]);
	$commentor = $tutor_ar['first_name'] . " " . $tutor_ar['last_name'];
} else { // if the commentor is not one of us
	$commentor = $row['commentor'];
}	
	 		echo '<td>'.$row['commentor'].'&nbsp;</td>';

  echo '<td>'.$row['title'].'&nbsp;</td>
 		<td>'.$row['comment'].'&nbsp;</td>';

if($folder == 'admin'){
		
 		echo '<td nowrap  align=center><a onclick="javascript:popup(\'schedule_edit.php?id='.$row['id'].'\',\'Edit Schedule\',\'600\',\'600\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;&nbsp;
 			<a onclick="if (confirm(\'Delete '.$row['dow'].' with '.$row['flast_name'].($row['ffirst_name']!='' ? ', '.$row['ffirst_name'] : '').($row['students'] ? " ($row[students])" : '').'?\')) {document.form.delete_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;
 		</td>';
echo '</tr>';
} // end if admin
} // end while/row
?>
</table>
</td>
</tr>	
</table>
</form>
<?

put_ptts_footer("");
?>
