<?php
ob_start();
include("../includes/pttec_includes.phtml");
// printarray($_REQUEST);
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$msg = "";
$folder = getfolder('','','');
if ($folder == "tutors"){
	include("../includes/tut_auth.php");
	$tutor_id = $_SESSION['tutor_id'];
}
	
$strTableName = "PT_Comments_Student";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$days_week_int = array("Sunday"=>0, "Monday"=>1,"Tuesday"=>2,"Wednesday"=>3,"Thursday"=>4,"Friday"=>5,"Saturday"=>6);

?>
<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">
<table cellspacing="0" cellpadding="0"  width="100%">
<tr>
	<td><fieldset>  
<legend>Schedule</legend>  
<?
$QStr = "select * from $strTableName where id = '$id'";
$arFieldsVals = array();

	
putHiddenField("strNotUsed", $strNotUsed);
$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);

/*************************************************************
if ($id && $tutor_id && ($tutor_id!=$arFieldsVals['tid']))	
	die("Error. You are not authorized to edit this schedule.");
****************************************************************/	
	
if ($tutor_id)
	$arFieldsVals['tid'] = $tutor_id;


// if anything is supposed to happen, get students name and $family_id
if(isset($_REQUEST['action']) && $_REQUEST['action'] && isset($_REQUEST['strTableName'])){

// if theh student id is sent get the family info
	if ($_REQUEST['student_id']){
		$student_id = $_REQUEST['student_id'];
		$atStu = get_student_info($student_id);
		
		$_REQUEST[first_name] = $arStu[first_name];
		$_REQUEST[last_name] = $arStu[last_name];
		
		$family_id = get_student_fid($student_id);
		$_REQUEST['fid'] = $family_id;
	} else if ($_REQUEST['fid']){ // if theh family id is sent get the student info
?>
		<script type="text/javascript">
			alert("Family ID was passed, not student ID.  This is a code problem that should be fixed. Tutor's you can ignore this!");
		</script>
<?
		$student_id = get_family_sid($fid);
		$sname = get_family_sname($fid);
		$_REQUEST['name'] = $sname;
		$_REQUEST['student_id'] = $student_id;
	}
	
	
	
	$_REQUEST_U = $_REQUEST;
	$_REQUEST_I = $_REQUEST;
	$_REQUEST['date'] = format_date_db($_REQUEST['date']);
	if ($_REQUEST['action'] == "update" && isset($_REQUEST['id'])){
		$strWhere = " id = '$id'";
		$msg = UpdateFields($_REQUEST['strTableName'], $_REQUEST_U, $arMandFields, '', $tdStyle, $strWhere); 
	}
	//insert	
	 elseif ($_REQUEST['action'] == "insert"){
	 	if(folder == 'tutors') { // if this is being done in a tutors folder, the commentor is that tutor
			$_REQUEST_I[tutor_id] = $_SESSION[tutor_id];
		}	
	 		
	 	 $msg = InsertFields($_REQUEST['strTableName'], $_REQUEST_I, $arMandFields, '', $tdStyle, $strWhere); 
	 	 
// need to set up the mailing system      ptts_mail("paul@paulthetutors.com", "schedule added", $mailmsg) ;

	 }
	 
	if (!$msg || is_int($msg))
		echo "<div class=text_success style='text-align:center'>The data has been saved.".(is_int($msg) ? " Added record: $msg" : "")."</div>";
	else 
		echo $msg;
	echo '<script type="text/javascript">opener_reload();</script>';
	}

if ($id){
	putHiddenField("id", $id);
	putHiddenField("action", "update");
}else {
	putHiddenField("action", "insert");
}
?>
<div style="padding:10px">  
<table cellspacing="0" cellpadding="0" border="0">
<?
$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);

$opts['required'] = 1;

if ($folder = "tutors"){	
	putHiddenField("tutor_id", $tutor_id);
	putHiddenField("tid", $tutor_id);
}
else{
	echo '<tr>
			<td align=right>Tutor<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;</td>
			<td>';
		tutorsid_menu($tutor_id,"tutor_id","","all");
	echo '</td>
	</tr>';
}
?>
<tr>
	<td colspan="2">
<?
	$strNotUsed = "id,tutor_id";
	MySQL_JustForm($strTableName, $arFieldNames, $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
?>
</td>
</tr>

<?php
$arRequired = array("tid"=>"Tutor","student_id"=>"Student","pay"=>"Pay","start_date"=>"Start Date","end_date"=>"End Date","dow"=>"Day Of Week");
?>
</table></div>
</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button> &nbsp;&nbsp;<button onclick="popup_close()">Close</button>
</fieldset></td>
</tr> 
</form></td></tr></table>
<?
put_ptts_footer("popup");
?>
<script type="text/javascript">

$(document).ready(function(){
	jquery_date('start_date');
	jquery_date('end_date');
});
</script>
