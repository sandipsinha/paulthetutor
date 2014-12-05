<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Appointment Info", $strAbsPath, "admin", "popup");
$appntId = $_REQUEST['appntId'];
If($_REQUEST['action'] == "update" and isset($_REQUEST['appntId']) and isset($_REQUEST['strTableName'])){
	$_REQUEST['date'] = format_date_db($_REQUEST['date']);
	$_REQUEST['start_time'] = format_time_db_input($_REQUEST['start_time_h'].":".$_REQUEST['start_time_m'], $_REQUEST['ampm']);
	
	/* ss code, depending on the value of datefilter make the updates */

	if(!isset($_REQUEST['datefilter']) || ($_REQUEST['datefilter'] == 'this') or $_REQUEST[sched_id] == 0 or $_REQUEST[sched_id] == -1 or isEmpty($_REQUEST[sched_id]) ) {
		session_mod($_REQUEST['appntId'], $_REQUEST['date'], $_REQUEST['start_time'], $_REQUEST['sid'], $_REQUEST['hours'], $_REQUEST['rate'], $_REQUEST['pay'], $_REQUEST['tid'], '', $_REQUEST['name'],array('comments'=>$_REQUEST['comments']));
	} else {
		$qrySessionData = "SELECT sched_id, date FROM PTAddedApp WHERE id = $appntId";
		$resSessionData = mysql_query($qrySessionData);
		$arrSessionData = mysql_fetch_array($resSessionData);
		
		$qrySessions = "SELECT * FROM PTAddedApp WHERE sched_id = " . $arrSessionData['sched_id'];
		
		if ($_REQUEST['datefilter'] == 'after') 
			$qrySessions .= " AND PTAddedApp.date >= '" . $_REQUEST['date'] . "'";

		$resSessions = mysql_query($qrySessions);
		
		while($arrSession = mysql_fetch_array($resSessions)) {
			//echo('session ' . $arrSession['id'] . 'modified<br>');
			session_mod($arrSession['id'], $_REQUEST['date'], $_REQUEST['start_time'], $_REQUEST['sid'], $_REQUEST['hours'], $_REQUEST['rate'], $_REQUEST['pay'], $_REQUEST['tid'], '', $_REQUEST['name'],array('comments'=>$_REQUEST['comments']));
		}
	}

	echo '<script type="text/javascript">opener_reload();</script>';
} 

if(isset($appntId)){
	$query = "SELECT * FROM PTAddedApp WHERE id = $appntId";
	$result = mysql_query($query);
	
	if($result){
		$appoint = mysql_fetch_object($result);
		if(isset($tutor_id) && $appoint->tutor_id != $tutor_id)
			die("Error. You are not authorized to View this appointment.");
		
		if(isset($_GET["del"])){
				echo session_del($appntId,'','');
				echo '<script type="text/javascript">popup_close();opener_reload();</script>';
			
		}
				
		$t_query = "select first_name, last_name from PT_Tutors WHERE id = $appoint->tid";
		$t_result = mysql_query($t_query);
		$tutor = mysql_fetch_object($t_result);
		
		$s_query = "select students from PT_Family_Info WHERE id = $appoint->sid";
		$s_result = mysql_query($s_query);
		$students = mysql_fetch_object($s_result);
		
		$start = date("g:i a",strtotime($appoint->start_time));
		$date = date("m-d-Y",strtotime($appoint->date));
	}
}
else
	die("Error");

?>
<fieldset>  
<legend>Appointment Info</legend>  
<table cellspacing="2" cellpadding="3">  
<tr>
	<td align="right">Name:</td>  
	<td><?=$appoint->name ?></td>
</tr> 

<tr>
	<td align="right">Tutor:</td>  
	<td><?="$tutor->first_name $tutor->last_name"  ?></td>  
<tr> 

<tr>
	<td align="right">Students:</td>  
	<td><?="$students->students"  ?></td>
</tr>  

<tr>
	<td align="right">Date:</td>  
	<td><?=$date ?></td>
</tr>  

 
<tr>
	<td align="right">Start:</td>  
	<td><?=$start ?></td>
</tr>  

<tr>  
	<td align="right">Hours:</td>  
	<td><?=$appoint->hours ?></td>
</tr>  

<tr>  
	<td align="right">Rate:</td>  
	<td><?=$appoint->rate ?></td>
</tr>  

<tr>  
	<td align="right">Pay:</td>  
	<td><?=$appoint->pay ?></td>
</tr> 

<tr>  
	<td align="right">Comments:<//td>  
	<td><?=$appoint->comments ?></td>
</tr> 

</table>
</fieldset>  
<fieldset class="submit">  
<button class="edit" onclick="document.location='added_appoint_edit.php?appntId=<?=$appntId?>'">Edit</button>
<?php if($appoint->sched_id != -1) { ?>
<button class="edit" onclick="document.location='schedule_edit.php?id=<?=$appoint->sched_id?>'">Edit schedule</button>
<?php  }; ?>
<button onclick="if (confirm('Are you sure you want to delete this record?')) document.location='added_appoint.php?appntId=<?=$appntId?>&del=1'">Delete</button>
<button onclick="popup_close()">Close</button>
</fieldset> 
<?
put_ptts_footer("popup");
?>
