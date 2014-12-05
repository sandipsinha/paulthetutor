<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "popup");
$strTableName = "PTAddedApp";
$appntId = $_REQUEST['appntId'];
?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post" action="added_appoint.php" name="form1">

<fieldset>  
<legend>Appointment Info</legend>  
<table border="0" cellpadding="0" >
<?php

//if id was passed then use the info from that user
//if(isset($appntId)){
	putHiddenField("appntId", $appntId);
	putHiddenField("action", "update");

	$QStr = "select * from $strTableName where id = $appntId";
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
	$strNotUsed = "id, sid, tid, start_time, fid, family_id, date, sched_id, student_id";
	putHiddenField("strNotUsed", $strNotUsed);
	putHiddenField("id", $arFieldsVals['id']);
	putHiddenField("tid", $arFieldsVals['tid']);
	putHiddenField("sid", $arFieldsVals['sid']);
	
//switch sched_id to a negative number in order to make the session not change with the 
	$new_sched_id = -1 * abs($arFieldsVals['sched_id']);
	putHiddenField("sched_id", $new_sched_id);

// printarray($arFieldsVals);
echo '<tr><td width=80 nowrap></td><td width="100%"></td></tr>';
$arFieldsVals['date'] = format_date_print($arFieldsVals['date']);
putTextField("Date&nbsp;&nbsp;&nbsp;", "date", 11, 11, $arFieldsVals['date'],'','');
echo '<tr height=10><td></td></tr>';

$a_time = explode(" ",format_time_print($arFieldsVals['start_time']));
// echo $arFieldsVals['start_time'] . "start time is <BR>";
// printarray($a_time);

$a_time2 = explode(":",$a_time[0]);
$start_time_hours = $a_time2[0];
$start_time_minutes = $a_time2[1];
$ampm = $a_time[1];
$arFieldsVals['start_time'] = format_time_print($arFieldsVals['start_time']);
echo '<tr>
			<td align=right>Start Time<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;</td>
			<td>
<input name="start_time_h" type=text id="start_time_h" size="4" maxlength="2" value="'.$start_time_hours.'">
: 
<input name="start_time_m" type="text" id="start_time_m" size="4" maxlength="2" value="'.$start_time_minutes.'">
<select name="ampm" id="ampm">
<option value="am" '.($ampm == "am" ? "selected" : "").'>am</option>
<option value="pm" '.($ampm == "pm" ? "selected" : "").'>pm</option>
</select>
</td>
	</tr>';
?>
<?
MySQL_JustForm($strTableName, "", $arFieldsVals, '', '', $strNotUsed, '');
//}
	
// do not need to enter id or any auto-increment

if ($arFieldsVals['sched_id']!=-1 and $arFieldsVals['sched_id']!= 0 and !isEmpty($arFieldsVals['sched_id']) ){ 
	echo '<tr height=10><td></td></tr>';

?>
<!--
<tr>
	<td colspan="2">
    	<fieldset class="dateFilter"><legend>Apply the changes to </legend>
			<input type="radio" name="datefilter" value="this" checked>This session only<br>
			<input type="radio" name="datefilter" value="all">All sessions in schedule<br>
    	    <input type="radio" name="datefilter" value="after" >All sessions from now on
		 </fieldset>
    </td>
</tr> 
-->
<? }; // if it's part of a schedule, give the option of which sessions to edit

$arRequired = array("hours"=>"Hours","pay"=>"Pay","date"=>"Date","start_time_h"=>"Start Time Hours" ,"start_time_m"=>"Start Time Minutes");
MySQL_JustForm_End($arRequired, "form1","");
?>


<?php /* SS code to add the date filter */ ?>


 </table>
</form></td></tr></table>
<?
put_ptts_footer("popup");
?>
<script type="text/javascript">
$(document).ready(function(){
	jquery_date('date');
});
</script>
