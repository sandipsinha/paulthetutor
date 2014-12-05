<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin",$_REQUEST['popup']);
?>
<script type="text/javascript">
$(document).ready(function(){
	jquery_date('date');
});
</script>

<?
$strTableName = "PTAddedApp";
if ($tutors == 1 && !$_SESSION['tutor_id'])
	exit('You are not authorized');

If(($_REQUEST[action] == "insert") and isset($_REQUEST[strTableName])){
	if ($_REQUEST[family_id]){
// creat a get_students function		
		$FQStr = "select students from PT_Family_Info where id = ".$_REQUEST[family_id];
		$FRS = runquery($FQStr);
		$far = mysql_fetch_array($FRS);
		$_REQUEST['name'] = $far['students'];
	}
	$_REQUEST['date'] = format_date_db($_REQUEST['date']); 
	$_REQUEST['start_time'] = format_time_db_input($_REQUEST['start_time_h'].":".$_REQUEST['start_time_m'], $_REQUEST['ampm']);
	$msg = session_add2($_REQUEST['date'], $_REQUEST['start_time'],$_REQUEST['family_id'],$_REQUEST['hours'], $_REQUEST['rate'], $_REQUEST['pay'], $_REQUEST['tid'],$contacts,$_REQUEST[student_id],$_REQUEST[name]); 
	echo "<div class=text_success style='text-align:center'>".$msg."</div>";
	if($_REQUEST['popup'] == 'popup')
		echo '<script type="text/javascript">opener_reload();</script>';
} 

$QStrsi = runquery("select * from PT_Tutors ORDER BY first_name");
while($arsi = mysql_fetch_array($QStrsi)){
	$arr_tutors[$arsi[id]] = "$arsi[first_name] $arsi[last_name]";
}

?>

<table  cellspacing="0" cellpadding="0" width="100%">
<?php  if (!$_REQUEST['popup'] == 'popup'){?>
 <tr>
    <td class="td_header">&nbsp;Add Tutoring Session&nbsp;</td>
  </tr>
 <?php }?>
  <tr bgcolor="#FFFFFF">
    <td><br>
     <form method="post"  name="form1"><input type="hidden" name="popup" value="<?php echo $_REQUEST['popup']?>">

<table cellspacing="0" cellpadding="0"  width="100%" border="0">
<tr><td>
<a href="schedule_edit.php">Add Recurring Tutoring Schedule</a>
<br />
<a href="miviram_non_tutoring_appointment_edit.php">Add Non-Tutoring Appt/Work</a>
<br />
<fieldset>  
<legend>Add a Tutoring Session</legend>

<div style="padding:10px">

<table cellspacing="0" cellpadding="3" border="0">
<?php
	putHiddenField("action", "insert");
	$strNotUsed = 'sid, tid, name, date, start_time, sched_id, family_id, student_id';
	putHiddenField("strNotUsed", $strNotUsed);
	$arFieldNames = array("hours"=>"Duration");
	
	get_student_id();

//	put_student_search();

	if ($tutors == 1){ //tutors folder
		if ($_SESSION['tutor_id'])
			putHiddenField("tid", $_SESSION['tutor_id']);
	}
	else{
		?> <tr height=10><td width="30%" ></td><td></td></tr>
		<?
		putSelectInput('Tutor<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;', 'tid', $arr_tutors, '', '', '','Choose a Tutor');
	}
		?> <tr height=10><td width="20%" ></td><td></td></tr>
		<?
	putTextField("Date<font color='#FF0000'>*</font>&nbsp;&nbsp;", "date", 11, 11, ($arFieldVal['date'] ? $arFieldVal['date'] : $_REQUEST['date']),'','');
	echo '<tr height=10><td></td></tr>';
	$a_time = explode(" ",format_time_print($arFieldsVals['start_time']));
	$a_time2 = explode(":",$a_time[0]);
	$start_time_hours = $a_time2[0];
	$start_time_minutes = $a_time2[1];
	$ampm = $a_time[1];
	if ($ampm == "")
		$ampm = "pm";
	$arFieldsVals['start_date'] = format_date_print($arFieldsVals['start_date']);	
	
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
	<td colspan="2">
<?
	MySQL_JustForm($strTableName, $arFieldNames, $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
?>
</td>
</tr>
<?php
$arRequired = array("tid"=>"Tutor","student_id"=>"Student","pay"=>"Pay","date"=>"Date","start_time_h"=>"Start Time Hours" ,"start_time_m"=>"Start Time Minutes");
if ($tutors)
	unset($arRequired['tid']);
MySQL_JustForm_End($arRequired, "form1","");
?>
</table></div>
</fieldset></td></tr>
</form></table>
<?
put_ptts_footer($_REQUEST['popup']);
?>
