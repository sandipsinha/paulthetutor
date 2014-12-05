<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Appointment Info", $strAbsPath, "admin", "popup");
$folder = getfolder('','','');

$appntId = $_REQUEST['appntId'];
If($_REQUEST['action'] == "update" and isset($_REQUEST['appntId']) and isset($_REQUEST['strTableName'])){
//	printarray($_REQUEST);
	$_REQUEST['date'] = format_date_db($_REQUEST['date']);
	$_REQUEST['start_time'] = format_time_db_input($_REQUEST['start_time_h'].":".$_REQUEST['start_time_m'], $_REQUEST['ampm']);

//if the rate and pay are to be set manually
	if(!(isEmpty($_REQUEST[man_rp]))){
		 $opts[set_money] = 1;	
		 echo "the opts have been set <BR>";
	}
	
	$old_apid = $appntId;
	$appntId = appoint_modify($_REQUEST['appntId'], $_REQUEST['date'],$_REQUEST['location_id'], $_REQUEST['student_id'], $_REQUEST['tid'], $_REQUEST['start_time'], $_REQUEST['hours'], $_REQUEST['rate_id'], $_REQUEST['schedule_id'],$_REQUEST['comments'],$_REQUEST['name'],$_REQUEST['rate'],$_REQUEST['pay'],$opts);
	
//	session_mod($_REQUEST['appntId'], $_REQUEST['date'], $_REQUEST['start_time'], $_REQUEST['sid'], $_REQUEST['hours'], $_REQUEST['rate'], $_REQUEST['pay'], $_REQUEST['tid'], '', $_REQUEST['name'],array('comments'=>$_REQUEST['comments']));
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
		
		$location = get_item_name($appoint->location_id,"PT_Locations");
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
	<td align="right">Location:</td>  
	<td><?=$location ?></td>
</tr>  
<? if($folder=="admin"){ ?>
<tr>  
	<td align="right">Rate:</td>  
	<td><?=$appoint->rate ?></td>
</tr>  
<? } ?>
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
<button class="edit" onclick="document.location='appoint_edit_loc.php?appntId=<?=$appntId?>'">Edit</button>
<button onclick="if (confirm('Are you sure you want to delete this record?')) document.location='added_appoint.php?appntId=<?=$appntId?>&del=1'">Delete</button>
<button onclick="popup_close()">Close</button>
</fieldset> 
<?
put_ptts_footer("popup");
?>
