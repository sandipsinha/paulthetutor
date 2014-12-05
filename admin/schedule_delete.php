<?php
ob_start();


include("../includes/pttec_includes.phtml");
//printarray($_REQUEST);

MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$folder = getfolder('','','');
if ($folder == "tutors")
	include("../includes/tut_auth.php");
	
$strTableName = "PTSchedInfo2";
$tablename2 = "PTAddedApp";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$tutor_id = $_SESSION['tutor_id'];
if ($folder == "admin")
	$tutor_id = $_REQUEST['tid'];

$days_week_int = array("Sunday"=>0, "Monday"=>1,"Tuesday"=>2,"Wednesday"=>3,"Thursday"=>4,"Friday"=>5,"Saturday"=>6);

?>
<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">
<table cellspacing="0" cellpadding="0"  width="100%">
<tr>
	<td>
<?
$QStr = "select * from $strTableName where id = '$id'";
$arFieldsVals = array();

	
$strNotUsed = "dow_num, dow, id, tid, fid, start_time, student_id, start_date, end_date, name, sched_id, rate, pay, hours";
putHiddenField("strNotUsed", $strNotUsed);
$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);

if ($id && $tutor_id && ($tutor_id!=$arFieldsVals['tid']))	
	die("Error. You are not authorized to end this schedule.");
	
if ($tutor_id)
	$arFieldsVals['tid'] = $tutor_id;


// if anything is supposed to happen, get students name and $family_id
if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete'){

// if theh student id is sent get the family info
	if ($_REQUEST['student_id']){
		$student_id = $_REQUEST['student_id'];
		$_REQUEST['name'] = get_student_name($student_id);
		$family_id = get_student_fid($student_id);
		$_REQUEST['fid'] = $family_id;
	} else if ($_REQUEST['fid']){ // if theh family id is sent get the student info
?>
		<script type="text/javascript">
			alert("Family ID was passed, not student ID.  This is a code problem that should be fixed. Tutor's pleae inform Paul the Tutor!");
		</script>
<?
		$student_id = get_family_sid($fid);
		$sname = get_family_sname($fid);
		$_REQUEST['name'] = $sname;
		$_REQUEST['student_id'] = $student_id;
	}
	
	
	
	$_REQUEST['start_date'] = format_date_db($_REQUEST['start_date']);
	
	/* SS code 
	setting up the values for the actions ahead */
	
	$arrScheduleData = array();
		
	$arrScheduleData['id'] = $_REQUEST['id'];
	$arrScheduleData['tid'] = $_REQUEST['tid'];
	$arrScheduleData['end_date'] = $_REQUEST['end_date'];


	echo 'calling delete schedule<br>';	
	
	if($_REQUEST['datefilter']=='all') 
		Delete_schedule(array('id'=>$_REQUEST['id'], 'end_date' => '', 'tid'=>$_REQUEST['tid']));
	if($_REQUEST['datefilter']=='after') 
		End_schedule(array('id'=>$_REQUEST['id'], 'end_date' => $_REQUEST['end_date'], 'tid'=>$_REQUEST['tid']));
	 
	if (!$msg || is_int($msg))
		echo "<div class=text_success style='text-align:center'>The data has been saved.".(is_int($msg) ? " Added record: $msg" : "")."</div>";
	else 
		echo $msg;
	echo '<script type="text/javascript">opener_reload();</script>';
	}

if ($id){
	putHiddenField("id", $id);
	putHiddenField("action", "delete");
}

?>
<div style="padding:10px">  
<fieldset class="dateFilter"><legend>Delete Schedule </legend>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
<?
$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);

$opts['required'] = 1;

if ($tutor_id){	
	putHiddenField("tid", $tutor_id);
}
else{
	echo '<tr>
			<td align=right>Tutor<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;</td>
			<td>';
		tutorsid_menu($arFieldsVals['tid'],"tid");
	echo '</td>
	</tr>';
}


?>

<?php /* SS code to add the date filter */ ?>

<?
if (isset($_REQUEST['id'])){ 
	echo '<tr height=10><td></td></tr>';

?>
<tr>
	<td>
    	
			<input type="radio" id="all" name="datefilter"  value="all" checked >Delete all sessions past and future<br>
    	    <input type="radio" id="aft" name="datefilter" value="after" >Delete only sessions after: 
            <input type="text" id="end_date" name="end_date" value="<? echo date('m-d-Y'); ?>">
        
    </td>
</tr> 
<? }; ?>

<tr>
	<td>  
<button type="submit" name="Submit" onclick="if(document.form1.all.checked) { if(confirm('Are you sure you want to delete EVERY session associated with this schedule, even the ones that have already occurred?')) { document.form1.submit(); } else return false;} else {document.form1.submit();}">Delete</button> 
</td>
</tr> 
</form></table></fieldset></div>
<?
put_ptts_footer("popup");
?>
<script language="JavaScript" type="text/javascript">

$(document).ready(function(){
	jquery_date('end_date');

	
	$('#end_date').click(function () {
         $('#aft').attr('checked', true);
    });
	


});
</script>
