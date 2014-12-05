<?php

include("../includes/pttec_includes.phtml");
$folder = getfolder('','','');
if ($folder == "tutors")
include("../includes/tut_auth.php");
	
MySQL_PaulTheTutor_Connect();
put_ptts_header("Notes on Students", $strAbsPath, "admin",'');
$strTableName = "PT_Comments_Student";

// as student_id = 0 means all students who are not registered

if($folder != "tutors")
{
	$student_id = isset($_REQUEST['student_id']) ? $_REQUEST['student_id']: null;
	$tutor_id= isset($_REQUEST['tutor_id']) ? $_REQUEST['tutor_id']: null;
}
if($folder == "tutors")
{
	$student_id = isset($_REQUEST['student_id']) ? $_REQUEST['student_id']: NULL;
	$tutor_id= $_SESSION['tutor_id'];
}
	
if($student_id == 0){
	$student_name = "All Students";
} else if ($student_id == -1){
	$student_name = "Non-Registered Students";
} else {
 // if the student is registered, get their name	
	$student_name = get_student_name($student_id);
}

if($tutor_id == 0){
	$tutor_name = "All Tutors";
} else {
 // if the student is registered, get their name	
	$tutor_name = get_tutor_name($tutor_id);
}

	

$order = isset($_REQUEST['order']) ? $_REQUEST['order']: null;
$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : null;
$order1 = isset($_REQUEST['order1']) ? $_REQUEST['order1']: null;
if (isset($_REQUEST['sort1'])){
	$sort1 = " , $_REQUEST[sort1]";
} else {
	$sort1 = null;
}	


// echo "sort is $sort <BR>";

$delete_id = isset($_REQUEST['delete_id']) ? $_REQUEST['delete_id'] : null;
$strTableName = "PT_Comments_Student";
if (isEmpty($sort)){
	$sort = "date";
	$order = "DESC";
}
if($sort <> "id") {
	$sort1 = ", id";
	$order1 = "DESC";
}

$date_two_years_ago = (date('Y')-2).'-'.date('m').'-'.date('d');
//$tutor_id = $_SESSION['tutor_id'];
//if ($tutor_id)
	//$is_tutor = 1;
//elseif ($folder == "admin")
	//$tutor_id = $_REQUEST['tid'];

if ($delete_id){
	if ($is_tutor){
		$QStr = "select * from $strTableName where id = '$delete_id'";
		$FieldsRS = runquery($QStr);
		$arFieldsVals = mysql_fetch_array($FieldsRS);
		if ($arFieldsVals['tid']!=$tutor_id)
			die("Error. You are not authorized to delete this schedule.");
	}
	if (runquery("update $strTableName set archived = 1 where id = '$delete_id'")){

		echo "<div class=text_success style='text-align:center'>The comment $delete_id has been deleted.</div>";
	}
}	

?>

<form name=form method="get"><input type="submit" style="display:none">
<input type="hidden" name=sort value="<?=$sort?>">
<input type="hidden" name=order value="<?=$order?>">
<input type="hidden" name=delete_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php if($folder != "tutors")
{?>
<tr><td align="right">Tutor Name&nbsp;&nbsp;</td><td><?php tutorsid_menu($tutor_id,"tutor_id","this.form.submit()","all"); ?></td><tr>

<?php }?>
<tr>
	
<?
	put_student_search("", "student_id",  $student_id, "student_id", '');
//	get_student_id($student_id, "student_id","this.form.submit()","Other","All Students");
	
?>

<TD colspan="2"  align="center" width="30%">
<input type="submit" value="See Specific Notes" />
&nbsp;&nbsp;&nbsp;  
<INPUT Type="BUTTON" VALUE="See All Notes" ONCLICK="window.location.href='comments_inprogress.php'"> </TD>

</tr>
  <tr>
    <td class=td_header colspan="2">Notes on <?=$student_name;?></td>
  </tr>

<tr ><td align="right" colspan="2"> <button onclick="javascript:popup('comment_edit_inprogress.php','AddComment','600','600')">Add New Comment</button>
</td></tr>


  <tr>
    <td  valign="top"  colspan="2">
  <table border=1 width="100%" class="table_1" align="center" cellpadding="2" cellspacing="0">   
  <tr style="background: #eee; height: 35px">
  	
<?
if (($student_id == 0) or (isEmpty($student_id))){ //if they are looking for comments about students who are not yet registered, will have to put the name of the student, and have it be sortable
?>

		

<? 
} // end if not a registered student
?>
	
	
	<?php  
//	echo '<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=id&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>ID</b>'.($sort == 'id' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a></td>';


	
	echo 
	'<td nowrap><a class=a_grey href="?'."&sort=id&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>ID</b>'.($sort == 'id' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a></td>
	<td nowrap><a class=a_grey href="?'."&sort=date&tutor_id=$tutor_id&student_id=$student_id&".($order == "ASC" ? "order=DESC" : "order=ASC").'" style="text-decoration:none"><b>date</b>'.($sort == 'date' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=first_name&tutor_id=$tutor_id&student_id=$student_id&".($order == "ASC" ? "order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Student Name</b>'.($sort == 'first_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
    
	
  	<td class="text_grey"><b>Commentor</b></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort_title=title&tutor_id=$tutor_id&student_id=$student_id&".($order_title == "ASC" ? "order_title=DESC" : "order_title=ASC").'" style="text-decoration:none"><b>Title</b>'.($sort_title == 'title' ? ' <img border=0 src="../images/order_'.($order_title == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td class="text_grey"><b>Comment</b></td>

  		<td class="text_grey"><b>Action</b>
		
		</td>
	
  </tr>


<?  
$where=" where 1 = 1 ";
if($student_id == NULL && $tutor_id==NULL ){
	
	}
if(((isEmpty($student_id)) or ($student_id == 0)) && $tutor_id!=NULL){
	
	$where .=" and tutor_id = $tutor_id";
}

if($student_id != NULL && $tutor_id==NULL)
{
	$where .=" and student_id = $student_id";
}

if($student_id != NULL && $tutor_id!=NULL)
{
	$where .=" and student_id = $student_id";
}	

$QStr = "select * from $strTableName $where and archived <> 1  ORDER BY $sort $order $sort1 $order1";

// echo  "qstr is $QStr<BR>";

$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){

// get the student's name

if (($row[student_id] == 0) or ($row[student_id] == -1) or (isEmpty($row[student_id]))){ // if sid is 0, then get the name from the database
	$student_name = $row[first_name]. " " . $row[last_name];
	$row[student_id] == "Unregistered";
} else {
	$student_name = get_student_name($row[student_id]);
	
} // end if we need to put the students name
// put the date in printable form
$str_date = format_date_print($row[date]);
		
?>
  <tr>
  <td><?="$row[id] &nbsp";?> </td>
  <td nowrap><?="$str_date &nbsp";?> </td>
  <td><?="$student_name ($row[student_id])  &nbsp";?> </td>		
		
<?	

 if ($row['tutor_id'] <> 0){ // if the commentor is a ptts employee
 	$tutor_ar = tutor_info($row[tutor_id]);
	$commentor = $tutor_ar['first_name'] . " " . $tutor_ar['last_name'];
} else { // if the commentor is not one of us
	$commentor = $row['commentor'];
}	
	 		echo '<td>'.$row['commentor'].'&nbsp;</td>';

  echo '<td>'.$row['title'].'&nbsp;</td>
 		<td>'.$row['comment'].'&nbsp;</td>';

		
 		echo '<td nowrap  align=center><a onclick="javascript:popup(\'comment_view.php?id='.$row['id'].'&strTableName=PT_Comments_Student\',\'View Comment\',\'600\',\'600\')"><img SRC="../images/view.gif" ALT="view" title="view" border="0"></a>';
		
		
if(($folder == 'admin') or ($row[tutor_id] == $tutor_id)){
	
		echo '<a onclick="javascript:popup(\'comment_edit_inprogress.php?id='.$row['id'].'&strTable=PT_Comments_Student\',\'Edit Comment\',\'600\',\'600\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;&nbsp;
 			<a onclick="if (confirm(\'Delete Comment '.$row['id'].'?\')) {document.form.delete_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;';
} // end if admin
 		
echo '</td></tr>';

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
