<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

include($strAbsPath . "/includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "tutors", "");

$tid = $_SESSION['tutor_id'];
$tutor_id = $tid;


$msg = "";





if(isset($_REQUEST['del']))
{
	$time_id = $_REQUEST['del'];
	
	$query="DELETE FROM PT_SchedSS_Norm WHERE id = $time_id";
	
	if(mysql_query($query))
		$msg = "Deleted record!";
	else
		$msg = "Error";
}

if(isset($_REQUEST['key']))
{

	$start_hours = $_REQUEST['start_time_hours'];
	$start_mins = $_REQUEST['start_time_minutes'];
	if(strlen($start_mins)==1)$start_mins='0'.$start_mins;
	$start_ampm = $_REQUEST['start_ampm'];
	
	$location_id = $_REQUEST[location_id];
	
	$end_hours = $_REQUEST['end_time_hours'];
	$end_mins = $_REQUEST['end_time_minutes'];
	if(strlen($end_mins)==1)$end_mins='0'.$end_mins;
	
	$end_ampm = $_REQUEST['end_ampm'];
	
	
	
	//$tutor_id = $_REQUEST['tid'];
	$dow = $_REQUEST['dow'];
	$clock_in = date("G:i:s", strtotime("$start_hours:{$start_mins}$start_ampm"));
	$clock_out = date("G:i:s", strtotime("$end_hours:{$end_mins}$end_ampm"));
	
	$date = $_REQUEST['start_date'];
	$date_arr = explode('-',$date);
	$start_date = $date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
	
	
	
	$date = $_REQUEST['stop_date'];
	$date_arr = explode('-',$date);
	$stop_date = $date_arr[2]."-".$date_arr[0]."-".$date_arr[1];

	
	
	
	switch($_REQUEST['dow'])
	{
		case 1: $strdow="Monday"; break;
		case 2: $strdow="Tuesday"; break;
		case 3: $strdow="Wednesday"; break;
		case 4: $strdow="Thursday"; break;
		case 5: $strdow="Friday"; break;
		case 6: $strdow="Saturday"; break;
		case 7: $strdow="Sunday"; break;
	}





	if($_REQUEST['key'] == -1)
		{
			$msg = add_times()?"Added new record!":"Error";
		}
	else
		{
			$times_id = $_REQUEST['key'];
			$msg = update_times()?"Updated record!":"Error";
			
		}
	
}




function add_times()
{
	
	
	
	global $tutor_id, $dow, $clock_in, $clock_out, $start_date, $stop_date, $strdow;
	$query = "INSERT INTO PT_SchedSS_Norm (tutor_id, dow, clock_in, clock_out, strdow, start_date, end_date, location_id)
				 VALUES($tutor_id, $dow, '$clock_in', '$clock_out', '$strdow', '$start_date', '$stop_date', '$location_id') ";
	
	
	
	
	return mysql_query($query);	
	
	
	
	
}

function print_select_tutors()
{
	
}

function update_times()
{
	
	global $times_id, $tutor_id, $dow, $clock_in, $clock_out, $start_date, $stop_date, $strdow;
	
	$query = "UPDATE PT_SchedSS_Norm SET
				tutor_id=$tutor_id, 
				dow = $dow, 
				clock_in='$clock_in', 
				clock_out='$clock_out',
				strdow = '$strdow',
				start_date='$start_date', 
				end_date = '$stop_date' 
			   WHERE id = $times_id";
	
	//echo $query;exit;
			 
	return mysql_query($query);	
	
	
	
}



	$tid = $tutor_id;


	
	$ten_d_ago = date("Y-m-d",strtotime("-10 day"));
	
	$query = "SELECT * FROM PT_SchedSS_Norm WHERE tutor_id = $tid AND end_date > '$ten_d_ago' ORDER BY end_date ASC";
	
	$result = mysql_query($query);




?>

<link rel="stylesheet" type="text/css" href="../NewPTTcss.css" />
<link rel="stylesheet" type="text/css" href="/styles/form.css" />
<script type="text/javascript" src="/includes/jquery-1.4.2.min.js"></script>

<link rel="stylesheet" type="text/css" href="/includes/jquery-ui-1.8.4.custom.css"/>
<script type="text/javascript" src="/includes/jquery-ui-1.8.4.custom.min.js"></script>

<script type="text/javascript">


$(document).ready(function(){

	
	$(".date").datepicker({dateFormat: 'mm-dd-yy'});
	$("#start_date").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$start_date==""?date("m-d-Y"):$start_date;?>'  });
	$("#stop_date").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$stop_date==""?date("m-d-Y"):$stop_date;?>'  });
	
})

</script>

<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
<span class="Head1_Green">Enter Weekly In and Out Times</span><BR>
<span class="Head2">Enter your schedule for each day of the week</span><BR><BR>


<div style="text-align:center">

		<?=$msg?>
</div>
<? if(isset($tid) && $tid!=-1): ?>
<div id="form_container">
	
<form method="POST" action=""> 

<input type="hidden" name="key" value="-1" />

 
<fieldset>  
<legend>Set Times</legend>  
<ol>  
 


 <input type="hidden" name="tid" value="<?=$tutor_id?>" />


 
<li>  
<label for="dow">Day of Week</label>

<select name = "dow">
	<option></option>
	<option value="1">Monday</option>
	<option value="2">Tuesday</option>
	<option value="3">Wednesday</option>
	<option value="4">Thursday</option>
	<option value="5">Friday</option>
	<option value="6">Saturday</option>
	<option value="7">Sunday</option>
</select>

</li>

<li>
<label for="location_id">Location</label>
<?
just_location_menu();
?>


</li>

<li>

<label for="start">Start</label>  
<input name="start_time_hours" type="text" class="text small" id="start_time_hours" size="2" maxlength="2" />  

<input name="start_time_minutes" type="text" class="text small" id="start_time_minutes" size="2" maxlength="2" /> 


<select class="small" name="start_ampm" id="start_ampm">
  <option value="am">am</option>
  <option value="pm">pm</option>
</select>
</li>  

<li>  
<label for="end">End</label>  
<input name="end_time_hours" type="text" class="text small" id="end_time_hours" size="2" maxlength="2" />  
<input name="end_time_minutes" type="text" class="text small" id="end_time_minutes" size="2" maxlength="2" /> 

<select class="small" name="end_ampm" id="end_ampm">
  <option value="am">am</option>
  <option value="pm">pm</option>
</select>

</li> 

<li>  
<label for="start_date">Start Date</label>  
<input id="start_date" name="start_date" class="text date" type="text"/>  
</li> 

<li>  
<label for="stop_date">Stop Date</label>  
<input id="stop_date" name="stop_date" class="text date" type="text"/>  
</li> 




</ol>  
</fieldset>  
<fieldset class="submit">  
<input class="submit" type="submit"  
value="Save" />  




</fieldset>  


</form>

</div><? endif?>


<?
while($record = mysql_fetch_object($result)){ 



		$start_date = date("m-d-Y",strtotime($record->start_date));
		$stop_date = date("m-d-Y",strtotime($record->end_date));
	
		$clock_in = $record->clock_in;
		$clock_out = $record->clock_out;
		
		
		$start_hrs = date("g", strtotime($clock_in));
		$start_mins = date("i",strtotime($clock_in));
		$start_ampm = date("a", strtotime($clock_in));
		
		
		
		$end_hrs = date("g", strtotime($clock_out));
		$end_mins = date("i", strtotime($clock_out));
		$end_ampm = date("a", strtotime($clock_out));
		
		$dow = $record->dow;
		
		$key = $record->id;
		
		

?>
	
	<form action="set_times.php" method="post">
		
	
		<input type="hidden" name="tid" value="<?=$tid ?>"/>
		<input type="hidden" name="key" value="<?=$key?>" />
		
		<ul>
			<li>  
			
			<select name="dow" >
	<option value="1" <?=$dow == 1?"Selected":""?>>Monday</option>
	<option value="2" <?=$dow == 2?"Selected":""?>>Tuesday</option>
	<option value="3" <?=$dow == 3?"Selected":""?>>Wednesday</option>
	<option value="4" <?=$dow == 4?"Selected":""?>>Thursday</option>
	<option value="5" <?=$dow == 5?"Selected":""?>>Friday</option>
	<option value="6" <?=$dow == 6?"Selected":""?>>Saturday</option>
	<option value="7" <?=$dow == 7?"Selected":""?>>Sunday</option>
</select>
			
				<input name="start_date" class="text date" type="text" value="<?=$start_date ?>"/> 
									
					<input name="stop_date" class="text date" type="text" value="<?=$stop_date ?>"/> 
					
			
				<input  name="start_time_hours" class="text small" type="text" value="<?=$start_hrs ?>"/>  
				
				<input name="start_time_minutes" class="text small" type="text" value="<?=$start_mins ?>"/> 
				
				
				<select class="small" name="start_ampm">
				  <option value="am">am</option>
				  <option value="pm" <?=$start_ampm=="pm"?"selected":"";?>>pm</option>
				</select>
				
				
				
				
				<input name="end_time_hours" class="text small" type="text" value="<?=$end_hrs ?>"/>  
				<input name="end_time_minutes" class="text small" type="text" value="<?=$end_mins ?>"/> 
				
				<select class="small" name="end_ampm">
				  <option value="am">am</option>
				  <option value="pm" <?=$end_ampm=="pm"?"selected":"";?>>pm</option>
				</select>
				
				<input class="submit" type="submit" name="update" value="Save" />  
				<input type="button" value="Delete" onclick="document.location='set_times.php?del=<?=$record->id?>'"/> 

			</li>
		</ul>
	</form>

<?php } ?>







<br>
<a href="set_special_times.php">Set Special Times</a>
<?
put_new_footer();

?>
