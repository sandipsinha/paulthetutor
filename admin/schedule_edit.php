<?php
ob_start();


include("../includes/pttec_includes.phtml");
// printarray($_REQUEST);

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
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css" />

<fieldset>  
<legend>Schedule</legend>  

  <form method="post"  name="form1">
<div>  
<table  cellspacing="0" cellpadding="8" border="1" bordercolor="#006633" width="100%">
     
<?
// if we are editing a schedule, ask which dates to edit
if (isset($_REQUEST['id'])){ 

?>

<tr>
	<td colspan="2">
    	<fieldset class="dateFilter"><legend>Apply the changes to </legend>
			<input type="radio" name="datefilter" value="all" checked>All sessions<br>
    	    <input type="radio" id="after" name="datefilter" value="after" >
    	    Changes take effect on: 
    	    <input type="text" id="date_filter" name="date_filter" value="<? echo date('m-d-Y'); ?>">
          <span class="form_comments">sessions on this date will be changed</span>
        </fieldset>
    </td>
</tr> 
<? }; 
$QStr = "select * from $strTableName where id = '$id'";
$arFieldsVals = array();

	
$strNotUsed = "dow_num, dow, id, tid, fid, start_time, student_id, start_date, end_date, name, sched_id, rate, pay, hours";
putHiddenField("strNotUsed", $strNotUsed);
$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);

if ($id && $tutor_id && ($tutor_id!=$arFieldsVals['tid']))	
	die("Error. You are not authorized to edit this schedule.");
	
if ($tutor_id)
	$arFieldsVals['tid'] = $tutor_id;


// if anything is supposed to happen, get students name and $family_id
if(isset($_REQUEST['action']) && $_REQUEST['action'] && isset($_REQUEST['strTableName'])){

// if theh student id is sent get the family info
	if ($_REQUEST['student_id']){
		$student_id = $_REQUEST['student_id'];
		$_REQUEST['name'] = get_student_name($student_id);
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
	
	
	
	$_REQUEST['dow_num'] = $days_week_int[$_REQUEST['dow']];
	$_REQUEST2 = $_REQUEST;
	$_REQUEST['start_date'] = format_date_db($_REQUEST['start_date']);
	$_REQUEST['end_date'] = format_date_db($_REQUEST['end_date']);
	$_REQUEST['start_time'] = format_time_db_input($_REQUEST['start_time']['hour'].":".$_REQUEST['start_time']['minutes'], $_REQUEST['start_time']['ampm']);
	//echo $_REQUEST['start_time'];
	$arr_days = get_sched_dates($_REQUEST['dow'], $_REQUEST['start_date'], $_REQUEST['end_date'], '');
	
	/* SS code 
	setting up the values for the actions ahead */
	
	$arrScheduleData = array();
		
	$arrScheduleData['id'] = $_REQUEST['id'];
	$arrScheduleData['student_id'] = $_REQUEST['student_id'];
	$arrScheduleData['tid'] = $_REQUEST['tid'];
	$arrScheduleData['start_date'] = $_REQUEST['start_date'];
	$arrScheduleData['end_date'] = $_REQUEST['end_date'];
	$arrScheduleData['start_time'] = $_REQUEST['start_time'];
	$arrScheduleData['dow'] = $_REQUEST['dow'];
// GET RATE AND PAY UNLESS HAND PICKED
	$arRP = calc_sess_rate(0, $_REQUEST['location_id'], $_REQUEST['fid'], $_REQUEST['student_id'], $_REQUEST['tid'], 0);

	$arrScheduleData['hours'] = $_REQUEST['hours'];
	$arrScheduleData['rate'] = $arRP['rate'];
	$arrScheduleData['pay'] = $arRP['pay'];
	$arrScheduleData['location_id'] = $_REQUEST['location_id'];
	$arrScheduleData['comments'] = $_REQUEST['comments'];
	$arrScheduleData['name'] = $_REQUEST['name'];
	$arrScheduleData['fid'] = $_REQUEST['fid'];
	$arrScheduleData['dow_num'] = $_REQUEST['dow_num'];


	//update
	if ($_REQUEST['action'] == "update" && isset($_REQUEST['id'])){
		if(Schedule_Changed(get_Schedule_Data($_REQUEST['id']), $arrScheduleData))  {
			if($_REQUEST['datefilter'] == 'all'	) {
				Edit_schedule_details($arrScheduleData);
			} else { // this is if the change should only take effect to sessions after a certain date
			$temp_df = $_REQUEST['date_filter'];
echo "the dte filter is $temp_df <BR>";			
				Edit_schedule_details($arrScheduleData, $_REQUEST['date_filter']);
			}
		}
		
	}
	//insert	
	 elseif ($_REQUEST['action'] == "insert"){
		 
		 Insert_schedule($arrScheduleData, true);
	 }
	 //end insert

	 
	if (!$msg || is_int($msg))
		echo "<div class=text_success style='text-align:center'>The data has been saved.".(is_int($msg) ? " Added record: $msg" : "")."</div>";
	else 
		echo $msg;
	echo '<script type="text/javascript">opener_reload();</script>';
	}

if ($id){
	putHiddenField("id", $id);
	putHiddenField("action", "update");
	$_REQUEST['student_id'];
}else {
	putHiddenField("action", "insert");
}

$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);

$opts['required'] = 1;
get_student_id($arFieldsVals['student_id'], "student_id", $callback, $opts);
;
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

$a_time = explode(" ",format_time_print($arFieldsVals['start_time']));
$a_time2 = explode(":",$a_time[0]);
$start_time_hours = $a_time2[0];
$start_time_minutes = $a_time2[1];
$ampm = isset($a_time[1]) ? $a_time[1] : '';
if ($ampm == "")
	$ampm = "pm";
$arFieldsVals['start_date'] = format_date_print($arFieldsVals['start_date']);
putTextField("Start Date<font color='#FF0000'>*</font>&nbsp;&nbsp;", "start_date", 11, 11, $arFieldsVals['start_date'],'','');
$arFieldsVals['end_date'] = format_date_print($arFieldsVals['end_date']);
putTextField("End Date<font color='#FF0000'>*</font>&nbsp;&nbsp;", "end_date", 11, 11, $arFieldsVals['end_date'],'','');
 putTimeField2("Start Time  ", "start_time", $arFieldsVals['start_time'], "","required"); 

$arr_days = array('Monday'=>'Monday','Tuesday'=>'Tuesday','Wednesday'=>'Wednesday','Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday','Sunday'=>'Sunday');
putSelectInput('Dow<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;', 'dow', $arr_days, $arFieldsVals['dow'], '', '','');
putTextField("Hours<font color='#FF0000'>*</font>&nbsp;&nbsp;&nbsp;", "hours",4,6,$arFieldsVals['hours'],'','');

if(1 == 2){
	putTextField("Rate&nbsp;&nbsp;&nbsp;", "rate",6,6,$arFieldsVals['rate'],'','');
	putTextField("Pay&nbsp;&nbsp;&nbsp;", "pay",6,6,$arFieldsVals['pay'],'','');
}

	MySQL_JustForm($strTableName, $arFieldNames, $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
	
?>

<?php
$arRequired = array("tid"=>"Tutor","student_id"=>"Student","start_date"=>"Start Date","end_date"=>"End Date","dow"=>"Day Of Week");
MySQL_JustForm_End($arRequired, "form1","");
?>

<?php /* SS code to add the date filter */ ?>




</form>
</fieldset>
<?
put_ptts_footer("popup");
?>
<script type="text/javascript">

$(document).ready(function(){
	jquery_date('start_date');
	jquery_date('end_date');
	jquery_date('date_filter');
	
	$('#date_filter').click(function () {
         $("#after").attr('checked', true);
    });
});
</script>
