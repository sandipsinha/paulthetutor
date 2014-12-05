<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "",'popup');
$folder = getfolder('','','');
if ($folder == "tutors")
	include("../includes/tut_auth.php");
	
$strTableName = "PT_Recurring_Appt";
$tablename2 = "PT_Other_Appt";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;;
$tutor_id = isset($_SESSION['tutor_id']) ? $_SESSION['tutor_id'] : null;
$days_week_int = array("Sunday"=>0, "Monday"=>1,"Tuesday"=>2,"Wednesday"=>3,"Thursday"=>4,"Friday"=>5,"Saturday"=>6);
?>
<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">
<table cellspacing="0" cellpadding="0"  width="100%">
<tr>
	<td><fieldset>  
<legend>Non-Tutoring Appointment</legend>  
<?
$QStr = "select * from $strTableName where id = '$id'";
$arFieldsVals = array();

	
$strNotUsed = "dow_num, day_of_week, id, tid, start_date, end_date, start_time, end_time, sched_id";
putHiddenField("strNotUsed", $strNotUsed);
$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);


if ($id && $tutor_id && ($tutor_id!=$arFieldsVals['tid']))	
	die("Error. You are not authorized to edit this schedule.");
	
if ($tutor_id)
	$arFieldsVals['tid'] = $tutor_id;


if(isset($_REQUEST['action']) && $_REQUEST['action'] && isset($_REQUEST['strTableName'])){
	
	if(isset($_REQUEST['day_of_week']) && $_REQUEST['day_of_week']!='')
	$_REQUEST['dow_num'] = $days_week_int[$_REQUEST['day_of_week']];
	else
	$_REQUEST['day_of_week']='0';
	
	//------ explicitly we are going to provide value for enddate if the event is not repeated. In this case, enddate=start date
	if(isset($_REQUEST['repeatedevent'])) 
	{
		// do nothing
	}
	else	
	{
		$_REQUEST['end_date']=$_REQUEST['start_date'];
		//$_REQUEST['day_of_week'] =0;
	}
	//--- end of above
	//echo  $_REQUEST['start_date']." -from main file- ".$_REQUEST['end_date'];
	$_REQUEST2 = $_REQUEST;
	$_REQUEST['start_date'] = format_date_db($_REQUEST['start_date']);
	if(isset($_REQUEST['end_date']) && $_REQUEST['end_date']!="")
	$_REQUEST['end_date'] = format_date_db($_REQUEST['end_date']);
	else 
	$_REQUEST['end_date']='';
	
	$_REQUEST['start_time'] = format_time_db_input($_REQUEST['start_time']['hour'].":".$_REQUEST['start_time']['minutes'], $_REQUEST['start_time']['ampm']);
	$_REQUEST['end_time'] = format_time_db_input($_REQUEST['end_time']['hour'].":".$_REQUEST['end_time']['minutes'], $_REQUEST['end_time']['ampm']);
	$_REQUEST['tutor_id'] = $_REQUEST['tid'];
	
	$arr_days = get_sched_dates1($_REQUEST['day_of_week'], $_REQUEST['start_date'], $_REQUEST['end_date'], '');
	
	
		//echo "trace";
	//die();
	//update
	if ($_REQUEST['action'] == "update" && isset($_REQUEST['id'])){
		$strWhere = " id = '$id'";
		$msg = UpdateFields($_REQUEST['strTableName'], $_REQUEST2, $arMandFields, '', $tdStyle, $strWhere); 
		if (!$msg){
			$strWhereApp = " sched_id = '$id'";   
			$strNotUsedApp = "sched_id, id, date, "; 
			$_REQUEST['sched_id'] = $id;                            
			if ($_REQUEST['start_date'] == $arFieldsVals['start_date'] && $_REQUEST['end_date'] == $arFieldsVals['end_date'] && $_REQUEST['day_of_week'] == $arFieldsVals['day_of_week']){
				$res_mod = runquery("SELECT * FROM $tablename2 WHERE sched_id='".$id."'");
				while($row_mod=mysql_fetch_array($res_mod)) 		
				
				if($_REQUEST['paid']=='Paid')	
						non_tut_session_mod_update($row_mod['id'], '', $_REQUEST['start_time'], $_REQUEST['end_time'], $_REQUEST['tutor_id'],$_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['comments'],1,$_REQUEST['rate']);
							else
							non_tut_session_mod_update($row_mod['id'], '', $_REQUEST['start_time'], $_REQUEST['end_time'], $_REQUEST['tutor_id'],$_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['comments'],0, '');
			}else{
				//$arr_old_days = get_sched_dates($arFieldsVals['day_of_week'], $arFieldsVals['start_date'], $arFieldsVals['end_date'], '');  
				$arr_old_days = get_sched_dates1($arFieldsVals['day_of_week'], $arFieldsVals['start_date'], $arFieldsVals['end_date'], '');  
				//$arr_days = get_sched_dates1($arFieldsVals['day_of_week'], $arFieldsVals['start_date'], $arFieldsVals['end_date'], '');
	//------ explicitly we are going to provide value for enddate if the event is not repeated. In this case, enddate=start date
	//--- end of above          
				//the dow has changed
				if ($_REQUEST['day_of_week']!=$arFieldsVals['day_of_week']){
						$res_del = runquery("SELECT id FROM $tablename2 WHERE sched_id='".$id."'");
						while($row_del=mysql_fetch_array($res_del))
							non_tut_session_del($row_del['id']);
	 				foreach ($arr_days as $k=>$v){
	 	 				    $_REQUEST['date'] = $v;
							if($_REQUEST['paid']=='Paid')	
						  	non_tut_session_add($v, $_REQUEST['start_time'],$_REQUEST['end_time'], $_REQUEST['tutor_id'],$_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['comments'], $_REQUEST['sched_id'],1, $_REQUEST['rate']);
							else
							non_tut_session_add($v, $_REQUEST['start_time'],$_REQUEST['end_time'], $_REQUEST['tutor_id'],$_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['comments'], $_REQUEST['sched_id'],0, '');
	 				 }                       
				}else{ //the start_date and end_date has been changed
					    
					  foreach ($arr_days as $k=>$v){
						  if (!in_array($v,$arr_old_days)){
						     $_REQUEST['date'] = $v;
							 if($_REQUEST['paid']=='Paid')	
							 non_tut_session_add($v, $_REQUEST['start_time'],$_REQUEST['end_time'], $_REQUEST['tutor_id'],$_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['comments'], $_REQUEST['sched_id'],1, $_REQUEST['rate']);
							 else
							 non_tut_session_add($v, $_REQUEST['start_time'],$_REQUEST['end_time'], $_REQUEST['tutor_id'],$_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['comments'], $_REQUEST['sched_id'],0, '');
						  }
					  }
					  
					  $arr_days_diff = array_diff($arr_old_days, $arr_days);
					  foreach ($arr_days_diff as $k=>$v){
						 $res_del = runquery("SELECT id FROM $tablename2 WHERE sched_id='".$id."' AND date='".$v."'");
						  while($row_del=mysql_fetch_array($res_del)){
						  	  //echo 'del:'. $row_del['id'].'<br>';
								non_tut_session_del($row_del['id']);    
						  }
					  }
				}
			}
		//end update
		}
	}
	//insert	
	 elseif ($_REQUEST['action'] == "insert"){
		 		
	 	 $msg = InsertFields($_REQUEST['strTableName'], $_REQUEST2, $arMandFields, '', $tdStyle, $strWhere); 
	 	 
	 	 //insert the dates in the appointment
	 	 if (!is_int($msg))
	 	 	die($msg);
	 	 $_REQUEST['sched_id'] = $msg; 
	 	 foreach ($arr_days as $k=>$v){
	 	 	 $_REQUEST['date'] = $v;
			// echo $_REQUEST['status'];
			// die();
			 if($_REQUEST['paid']=='Paid')
				 non_tut_session_add($v, $_REQUEST['start_time'],$_REQUEST['end_time'], $_REQUEST['tutor_id'],$_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['comments'], $_REQUEST['sched_id'],1, $_REQUEST['rate']);			 				 
			 else
			 	non_tut_session_add($v, $_REQUEST['start_time'],$_REQUEST['end_time'], $_REQUEST['tutor_id'],$_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['comments'], $_REQUEST['sched_id']);
			 
			 
// Use this version if it is a paid session non_tut_session_add($v, $_REQUEST['start_time'],$_REQUEST['end_time'], $_REQUEST['tutor_id'],$_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['comments'], $_REQUEST['sched_id'],1, $RATE);			 
	 	 }
	 	 //end insert dates
	 }
	 //end insert
	 
	if (!$msg || is_int($msg)){
		echo "<div class=text_success style='text-align:center'>The data has been saved.".(is_int($msg) ? " Added record: $msg" : "")."</div>";
		echo '<script type="text/javascript">opener_reload();</script>';
	}
	else 
		echo $msg;
	}

if ($id){
	putHiddenField("id", $id);
	putHiddenField("action", "update");
}else
	putHiddenField("action", "insert");

//-- to fetch price and rate of the selected id
$result_array=array();
if($id!="")
{
//echo "SELECT * FROM $tablename2 WHERE sched_id='".$id."'";
$result_table = runquery("SELECT * FROM $tablename2 WHERE sched_id='".$id."'");
$result_array=mysql_fetch_array($result_table);
//print_r($result_array);
}
//---- ended here
?>
<div style="padding:10px">  
<table cellspacing="0" cellpadding="0" border="0">
<tr>
			<td width=80 nowrap></td>
			<td width=100%></td>
</tr>
<?
$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);

if ($tutor_id){	
	putHiddenField("tid", $tutor_id);
}
else{
	echo '<tr>
			<td align=right>Tutor<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;</td>
			<td>';
		tutorsid_menu($arFieldsVals['tid'],"tid",null,array('all'=>true));
	echo '</td>
	</tr>';
}
$arFieldsVals['start_date'] = format_date_print($arFieldsVals['start_date']);
echo '<tr height=10><td></td></tr>';
putTextField("Start Date<font color='#FF0000'>*</font>&nbsp;&nbsp;", "start_date", 11, 11, $arFieldsVals['start_date'],'','');
echo '<tr height=10><td></td></tr>';
putCheckBoxInputEvent("Repeated Event?", repeatedevent,($arFieldsVals['dow_num']>0?'checked="checked"':''), "showFields()");
//echo '<tr height=10><td></td></tr>';
$arFieldsVals['end_date'] = format_date_print($arFieldsVals['end_date']);
putTextFieldShow("End Date<font color='#FF0000'>*</font>&nbsp;&nbsp;", "end_date", 11, 11, $arFieldsVals['end_date'],'','','show_enddate',($arFieldsVals['end_date']!=$arFieldsVals['start_date']?'true':'false'));

$arr_days = array('Monday'=>'Monday','Tuesday'=>'Tuesday','Wednesday'=>'Wednesday','Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday','Sunday'=>'Sunday');
putSelectInputShow('DOW<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;', 'day_of_week', $arr_days, $arFieldsVals['day_of_week'], '', '','','show_dow',($arFieldsVals['end_date']!=$arFieldsVals['start_date']?'true':'false'));
echo '<tr height=10><td></td></tr>';


$a_time = explode(" ",format_time_print($arFieldsVals['start_time']));
$a_time2 = explode(":",$a_time[0]);
$start_time_hours = $a_time2[0];
$start_time_minutes = $a_time2[1];
$ampm = $a_time[1];
if ($ampm == "")
	$ampm = "pm";
putTimeField2("Start Time", "start_time", $arFieldsVals['start_time'], "","required"); 
echo '<tr height=10><td></td></tr>';

$a_time = explode(" ",format_time_print($arFieldsVals['end_time']));
$a_time2 = explode(":",$a_time[0]);
$end_time_hours = $a_time2[0];
$end_time_minutes = $a_time2[1];
$ampm = $a_time[1];
if ($ampm == "")
	$ampm = "pm";
putTimeField2("End Time  ", "end_time", $arFieldsVals['end_time'], "","required"); 

?>
<tr>
	<td colspan="2">
<?
	MySQL_JustForm($strTableName, $arFieldNames, $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
?>
</td>
</tr>

<?php

//--- Added for Paid/Unpaid Status
$arr_paid = array(''=>'','Paid'=>'Paid','Unpaid'=>'Unpaid');
putSelectInputOnChange('Paid Work<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;', 'paid', $arr_paid, "", '', '','',' onchange="showrate();"');

putTextFieldShow("Rate&nbsp;&nbsp;", "rate", 10, 10, $result_array['rate'],'','','show_rate',($result_array['paid']==1?'true':'false'));
//
$arRequired = array("name"=>"Name", "tid"=>"Tutor","start_date"=>"Start Date","start_time[hour]"=>"Start Time Hours" ,"start_time[minutes]"=>"Start Time Minutes" ,"end_time[hour]"=>"End Time Hours" ,"end_time[minutes]"=>"End Time Minutes","paid"=>"Paid");
//$arRequired = array("name"=>"Name", "tid"=>"Tutor","start_date"=>"Start Date","end_date"=>"End Date","day_of_week"=>"Day Of Week","start_time[hour]"=>"Start Time Hours" ,"start_time[minutes]"=>"Start Time Minutes" ,"end_time[hour]"=>"End Time Hours" ,"end_time[minutes]"=>"End Time Minutes");
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
put_new_footer();
?>
<script type="text/javascript">

$(document).ready(function(){
	jquery_date('start_date');
	jquery_date('end_date');
});
function showFields() {

  var v1 = document.getElementById('show_enddate').style.visibility;
  var v2 = document.getElementById('show_dow').style.visibility;

  if (document.getElementById('repeatedevent').checked) { document.getElementById('show_enddate').style.visibility = "visible"; }
                 else {var txt1=document.getElementsByName('end_date');
				txt1[0].value='';document.getElementById('show_enddate').style.visibility = "hidden"; }
				 
  if (document.getElementById('repeatedevent').checked) { document.getElementById('show_dow').style.visibility = "visible"; }
                 else {var txt2=document.getElementsByName('day_of_week');
				  txt2[0].value='';document.getElementById('show_dow').style.visibility = "hidden";}
}

function showrate() {

  var v1 = document.getElementById('show_rate').style.visibility;

  if (v1 == "visible" && document.getElementById('paid').value=='Unpaid') { document.getElementById('show_rate').style.visibility = "hidden";document.getElementById('show_rate').value=''; }
                 else if (v1 == "hidden" && document.getElementById('paid').value=='Paid'){ document.getElementById('show_rate').style.visibility = "visible"; }				  
				 else { document.getElementById('show_rate').style.visibility = "hidden";document.getElementById('show_rate').value=''; }
}

</script>
