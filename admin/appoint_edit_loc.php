<?php
// for now we are using added appoint edit to edit a session


ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "popup");
$folder = getfolder('','','');
$strTableName = "PTAddedApp";
$appntId = $_REQUEST['appntId'];

if($folder == "tutors") 
	die("We are updating the editing process. It will but up again soon. If you have any questions, email us at info@paulthetutors.com please.");

?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post" action="appoint_loc.php" name="form1">

<table cellspacing="0" cellpadding="0" width="100%">
<tr><td><fieldset>  
<legend>Appointment Info EDIT</legend>  
<table border="0" cellpadding="0" cellpadding="0" >
<?php

//if id was passed then use the info from that user
//if(isset($appntId)){
	putHiddenField("appntId", $appntId);
	putHiddenField("action", "update");

	$QStr = "select * from $strTableName where id = $appntId";
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
	$strNotUsed = "id, sid, start_time, fid, family_id, date, rate_id, sched_id";
	
	if($folder <> "admin"){
		$strNotUsed = "$strNotUsed, rate, tid, name";

//	echo "$folder is and snu is $strNotUsed <BR>";		

		putHiddenField("rate", $arFieldsVals['rate']);
		putHiddenField("tid", $arFieldsVals['tid']);
		putHiddenField("name", $arFieldsVals['name']);
	}
	
	putHiddenField("strNotUsed", $strNotUsed);
	putHiddenField("id", $arFieldsVals['id']);
	putHiddenField("rate_id", $arFieldsVals['rate_id']);
	putHiddenField("sched_id", $arFieldsVals['sched_id']);


// printarray($arFieldsVals);
echo '<tr><td width=80 nowrap></td><td width="100%"></td></tr>';
$arFieldsVals['date'] = format_date_print($arFieldsVals['date']);
putTextField("Date&nbsp;&nbsp;&nbsp;", "date", 11, 11, $arFieldsVals['date'],'','');
echo '<tr height=10><td></td></tr>';

$a_time = explode(" ",format_time_print($arFieldsVals['start_time']));
echo $arFieldsVals['start_time'] . "start time is <BR>";
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
<tr>
	<td colspan=2 astyle="padding-left:33px">
<?
MySQL_JustForm($strTableName, "", $arFieldsVals, '', '', $strNotUsed, '');
//}
	
// do not need to enter id or any auto-increment
?>

<?php
$arRequired = array("hours"=>"Hours","pay"=>"Pay","location_id"=>"Location","date"=>"Date","start_time_h"=>"Start Time Hours" ,"start_time_m"=>"Start Time Minutes");
MySQL_JustForm_End($arRequired, "form1","");
?>
</td>
</tr>
</table>
</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
 <div align="left"><input type="submit" name="Submit" value="Save"> <button onclick="popup_close()">Close</button></div>
</fieldset></td>
</tr> 
</form></td></tr></table>


<?

// printarray($arRequired);
put_ptts_footer("popup");
?>
<script type="text/javascript">
$(document).ready(function(){
	jquery_date('date');
});
</script>
