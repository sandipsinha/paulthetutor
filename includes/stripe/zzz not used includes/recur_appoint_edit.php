<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("pttec_includes.phtml");
include($strAbsPath . "/paulthetutors_com/includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "",'popup');

$strBack = get_strBack();



$msg = "";



$tutor_id = $_SESSION['tutor_id'];

if(isset($_GET['appntId']))
{
	$id = $_GET['appntId'];
	
	$query = "SELECT * FROM PT_Recurring_Appt WHERE id =$id";
	
	$result = mysql_query($query);
	$appoint = mysql_fetch_object($result); 
	
	
	if($appoint->tid != $_SESSION[tutor_id])
		die("Error. You are not authorized to View this appointment.");
		
	
	
	
	$start_date = date("m-d-Y",strtotime($appoint->start_date));
	$end_date = date("m-d-Y",strtotime($appoint->end_date));
	
	
	
	$start_time = date("g:iA", strtotime($appoint->start_time));
	$end_time = date("g:iA", strtotime($appoint->end_time));
	
	
	
}
else
	die("error");



if(isset($_POST['appnt_id']))
{
	$name = $_POST['name'];
	$desc = $_POST['description'];
	
	$id = $_POST['appnt_id'];
	$tid = $tutor_id;
	
	$date = $_POST['startdate'];
	$date_arr = explode('-',$date);
	$start_date = $date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
	
	
	
	$date = $_POST['enddate'];
	$date_arr = explode('-',$date);
	$end_date = $date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
	
	
	
	
	$start_time = date("G:i:s",strtotime($_POST['starttime']));
	$end_time = date("G:i:s",strtotime($_POST['endtime']));
	
	
	
	/*$start_time_array = explode(':',$start_time);
	$end_time_array = explode(':',$end_time);
	
	
	$start_hours = $start_time_array[0];
	$start_mins = $start_time_array[1];
	if(strlen($start_mins)==1)$start_mins='0'.$start_mins;
	$start_ampm = $start_time_array[2];
	
	$starttime = date("G:i:s", strtotime("$start_hours:{$start_mins}$start_ampm"));
	$clock_out = date("G:i:s", strtotime("$end_hours:{$end_mins}$end_ampm"));
	
	
	
	$end_hours = $end_time_array[0];
	$end_mins = $end_time_array[1];
	if(strlen($end_mins)==1)$end_mins='0'.$end_mins;
	
	$end_ampm = $end_time_array[2];
	
	*/
	
	
	
	$query = "UPDATE PT_Recurring_Appt SET ";
	$query.="tid = $tid,";
	$query.="start_date = '$start_date',";
	$query.="end_date = '$end_date',";
	$query.="start_time ='$start_time',";
	$query.="end_time ='$end_time',";
	$query.="name ='$name',";
	$query.="description ='$desc'";
	$query.= " WHERE id = $id";
	
	
	if(mysql_query($query))
	{
		$msg = "Successfully updated appointment";
		
		
		echo '<script type="text/javascript">';
		echo "window.opener.location=window.opener.location;";
		echo '</script>';
		
	}
	else
		$msg = "Error saving appointment";
}






?>



<link rel="stylesheet" type="text/css" href="/styles/form.css" />


<link rel="stylesheet" type="text/css" href="/includes/jquery-ui-1.8.4.custom.css"/>
<script type="text/javascript" src="/includes/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/includes/jquery-ui-1.8.4.custom.min.js"></script>
<script type="text/javascript" src="/includes/jquery.timeentry.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){

	$(".date").datepicker({ dateFormat: 'mm-dd-yy'  });
	$(".time").timeEntry();
	
});

</script>


<div style="text-align:center">

		<?=$msg?>
</div>

<form method="POST" id="edit_appoint" action="recur_appoint_edit.php?appntId=<?=$id?>">  

<input type="hidden" name="appnt_id" value="<?=$appoint->id ?>"/>
<fieldset>  
<legend>Edit Appointment</legend>  
<ol>  
<li>  
<label for="startdate">Start Date:</label>  
<input value="<?=$start_date?>" id="startdate" name="startdate" class="text date" type="text" />  
</li>  

<li>  
<label for="enddate">End Date</label>  
<input value="<?=$end_date?>" id="enddate" name="enddate" class="text date" type="text" />  
</li> 

<li>  
<label for="starttime">Start Time</label>  
<input value="<?=$start_time?>"  id="starttime" name="starttime" class="text time" type="text" />  
</li> 

<li>  
<label for="endtime">End Time</label>  
<input value="<?=$end_time?>"  id="endtime" name="endtime" class="text time" type="text" />  
</li> 

<li>  
<label for="name">Name</label>  
<input value="<?=$appoint->name?>"  id="name" name="name" class="text" type="text" />  
</li> 

<li>  
<label for="name">Description</label>  

<textarea id="description" name="description" class="text" type="text"><?=$appoint->description?></textarea>
</li> 


</ol>  
</fieldset>  

</form>


<fieldset class="submit">  


<button class="submit edit" onclick="$('#edit_appoint').submit()">Save</button>
<button class="edit" onclick="document.location='recur_appoint.php?appntId=<?=$id?>'">Cancel</button>
<button onclick="document.location='recur_appoint.php?appntId=<?=$id?>&del=1'">Delete</button>





</fieldset>  