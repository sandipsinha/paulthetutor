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
	
	//update
	if ($_REQUEST['action'] == "update" && isset($_REQUEST['id'])){
		$strWhere = " id = '$id'";
		$msg = UpdateFields($_REQUEST['strTableName'], $_REQUEST2, $arMandFields, '', $tdStyle, $strWhere); 
		if (!$msg){
			$_REQUEST['sched_id'] = $id;                            
			if ($_REQUEST['start_date'] == $arFieldsVals['start_date'] && $_REQUEST['end_date'] == $arFieldsVals['end_date'] && $_REQUEST['dow'] == $arFieldsVals['dow']){
				$res_mod = runquery("SELECT * FROM $tablename2 WHERE sched_id='".$id."'");
				while($row_mod=mysql_fetch_array($res_mod)) 
					session_mod($row_mod['id'], '', $_REQUEST['start_time'], $_REQUEST['fid'], $_REQUEST['hours'], $_REQUEST['rate'], $_REQUEST['pay'], $_REQUEST['tid'], $_REQUEST['student_id'], $_REQUEST['name']);
			}else{
				$arr_old_days = get_sched_dates($arFieldsVals['dow'], $arFieldsVals['start_date'], $arFieldsVals['end_date'], '');  
				          
				//the dow has changed
				if ($_REQUEST['dow']!=$arFieldsVals['dow']){
					$res_del = runquery("SELECT id FROM $tablename2 WHERE sched_id='".$id."'");
                                        $mailmsg = "A schedule was modified:";
					while($row_del=mysql_fetch_array($res_del))
						$mailmsg .= "\n". session_del($row_del['id'],'',array('email_paul'=>false,'email_tut'=>false));
	 				foreach ($arr_days as $k=>$v){
						  $mailmsg .= "\n". session_add2($v, $_REQUEST['start_time'],$_REQUEST['fid'],$_REQUEST['hours'], $_REQUEST['rate'], $_REQUEST['pay'], $_REQUEST['tid'],'','', $_REQUEST['name'], $_REQUEST['sched_id'],'',array('email_paul'=>false,'email_tut'=>false));
	 				 }
				}else{ //the start_date and end_date has been changed

					  foreach ($arr_days as $k=>$v){
						  if (!in_array($v,$arr_old_days)){
						      session_add2($v, $_REQUEST['start_time'],$_REQUEST['fid'],$_REQUEST['hours'], $_REQUEST['rate'], $_REQUEST['pay'], $_REQUEST['tid'],'',$_REQUEST['student_id'], $_REQUEST['name'], $_REQUEST['sched_id'],'',array('email_paul'=>false,'email_tut'=>false));
						  }
					  }
					  
					  $arr_days_diff = array_diff($arr_old_days, $arr_days);
					  //print_r($arr_days_diff);
					  foreach ($arr_days_diff as $k=>$v){
						  $res_del = runquery("SELECT id FROM $tablename2 WHERE sched_id='".$id."' AND date='".$v."'");
						  while($row_del=mysql_fetch_array($res_del)){
						    //echo 'del:'. $row_del['id'].'<br>';
						    $mailmsg .= "\n". session_del($row_del['id'],'',array('email_paul'=>false,"email_tut"=>false));    
						  }
					  }
				}
                if ($folder == "admin") {
                  $tut = tutor_info($tutor_id);
                  ptts_mail($tut['email'], "schedule changed", $mailmsg) ;
                }
                ptts_mail("paul@paulthetutors.com", "schedule changed", $mailmsg) ;

			}
		//end update

		}
	}
	//insert	
	 elseif ($_REQUEST['action'] == "insert"){
	 	 $msg = InsertFields($_REQUEST['strTableName'], $_REQUEST2, $arMandFields, '', $tdStyle, $strWhere); 
	 	 
	 	 //insert the dates in the appointment
	 	 $_REQUEST['sched_id'] = $msg; 
                 $mailmsg = "A schedule was added with the following appointments:";
	 	 foreach ($arr_days as $k=>$v){
			 $mailmsg .= "\n" . session_add2($v, $_REQUEST['start_time'],$_REQUEST['fid'],$_REQUEST['hours'], $_REQUEST['rate'], $_REQUEST['pay'], $_REQUEST['tid'],'',$_REQUEST['student_id'], $_REQUEST['name'], $_REQUEST['sched_id'],'', array('email_paul'=>false,'email_tut'=>false)); 
	 	 }
	 	 //end insert dates
                if ($folder == "admin") {
                  $tut = tutor_info($tutor_id);
                  ptts_mail($tut['email'], "schedule added", $mailmsg) ;
                }
                ptts_mail("paul@paulthetutors.com", "schedule added", $mailmsg) ;

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
?>
<div style="padding:10px">  
<table cellspacing="0" cellpadding="0" border="0">
<?
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
echo '<tr height=10><td></td></tr>';
putTextField("Start Date<font color='#FF0000'>*</font>&nbsp;&nbsp;", "start_date", 11, 11, $arFieldsVals['start_date'],'','');
echo '<tr height=10><td></td></tr>';
$arFieldsVals['end_date'] = format_date_print($arFieldsVals['end_date']);
putTextField("End Date<font color='#FF0000'>*</font>&nbsp;&nbsp;", "end_date", 11, 11, $arFieldsVals['end_date'],'','');
echo '<tr height=10><td></td></tr>';
 putTimeField2("Start Time  ", "start_time", $arFieldsVals['start_time'], "","required"); 

echo '<tr height=10><td></td></tr>';
$arr_days = array('Monday'=>'Monday','Tuesday'=>'Tuesday','Wednesday'=>'Wednesday','Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday','Sunday'=>'Sunday');
putSelectInput('Dow<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;', 'dow', $arr_days, $arFieldsVals['dow'], '', '','');
echo '<tr height=10><td></td></tr>';
putTextField("Rate<font color='#FF0000'>*</font>&nbsp;&nbsp;&nbsp;", "rate",6,6,$arFieldsVals['rate'],'','');
echo '<tr height=10><td></td></tr>';
putTextField("Hours<font color='#FF0000'>*</font>&nbsp;&nbsp;&nbsp;", "hours",4,6,$arFieldsVals['hours'],'','');
echo '<tr height=10><td></td></tr>';
putTextField("Pay<font color='#FF0000'>*</font>&nbsp;&nbsp;&nbsp;", "pay",6,6,$arFieldsVals['pay'],'','');
?>
<tr>
	<td colspan="2">
<?
	MySQL_JustForm($strTableName, $arFieldNames, $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
?>
</td>
</tr>

<?php
$arRequired = array("tid"=>"Tutor","student_id"=>"Student","pay"=>"Pay","start_date"=>"Start Date","end_date"=>"End Date","dow"=>"Day Of Week");
MySQL_JustForm_End($arRequired, "form1","");
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
