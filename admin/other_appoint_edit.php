<?php
ob_start();
session_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "popup");

$tutor_id = isset($_SESSION['tutor_id']) ? $_SESSION['tutor_id'] : null;

if(isset($_GET["appntId"]))
{

	$id = $_GET["appntId"];
	
	$query = "SELECT * FROM PT_Other_Appt WHERE id = $id";
	
	$result = mysql_query($query);
	
	if($result)
	{
		
		$appoint = mysql_fetch_object($result);
		
		
		if($appoint->tutor_id != $tutor_id && !stristr($_SERVER['REQUEST_URI'],"admin"))
			die("Error. You are not authorized to Edit this appointment.");
		
		
		
	
		
		$t_query = "select first_name, last_name from PT_Tutors WHERE id = $appoint->tutor_id";
		$t_result = mysql_query($t_query);
		
		$tutor = mysql_fetch_object($t_result);
		
		$start = strtotime($appoint->start_time);
		$end = strtotime($appoint->end_time);
		
		//$start = date("g:i a",strtotime($appoint->start_time));
		//$end = date("g:i a",strtotime($appoint->end_time));
		
		$start_hrs = date("g", $start);
		$start_mins = date("i",$start);
		$start_ampm = date("a", $start);
		
		$end_hrs = date("g", $end);
		$end_mins = date("i", $end);
		$end_ampm = date("a", $end);
		
		$date = date("m-d-Y",strtotime($appoint->date));
		
		echo '';
		
	}
}
else
	die("Error");


if(isset($_POST["appnt_id"]))
{
	$appnt_id = $_POST['appnt_id'];
	$start_hours = $_POST['start_time_hours'];
	$start_mins = $_POST['start_time_minutes'];
	if(strlen($start_mins)==1)$start_mins='0'.$start_mins;
	$date = $_POST['date'];
	$start_ampm = $_POST['start_ampm'];
	$start_time =  format_time_db_input($start_hours.":".$start_mins, $start_ampm);
	
	$end_hours = $_POST['end_time_hours'];
	$end_mins = $_POST['end_time_minutes'];
	if(strlen($end_mins)==1)$end_mins='0'.$end_mins;
	$end_ampm = $_POST['end_ampm'];
	$end_time =  format_time_db_input($end_hours.":".$end_mins, $end_ampm);

	//$date = strtotime($date);
	
	//$tutor_id= $tutor_id;
	
	$name = $_POST['name'];
	$email =  $_POST['email'];
	$phone =  $_POST['phone'];
	$comments =  $_POST['comments'];
	$tutor_id = $_POST[tutor_id];
	
	$date_arr = explode('-',$date);
	$date_formatted = $date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
	//$date_formatted = date("Y-m-d",strtotime($date));
	
	non_tut_session_mod($appnt_id, $date_formatted, $start_time, $end_time, $tutor_id, $name, $email,$phone, $comments);
	//$query = "INSERT INTO PT_Other_Appt (name, start_time, end_time, date, tutor_id, email, phone, comments) 
		//		VALUES ('$name','$start_time','$end_time','$date_formatted','$tid','$email','$phone','$comments')";
	
	
		echo '<script type="text/javascript">';
		echo "window.opener.location=window.opener.location;";
		echo "document.location='other_appoint.php?appntId=$appnt_id'";
		echo '</script>';

}


?>
<!-- <link rel="stylesheet" type="text/css" href="/styles/paulthetutor.css" /> -->

<link rel="stylesheet" type="text/css" href="/styles/form.css" />

<script type="text/javascript">


$(document).ready(function(){

	$(".date").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$date?>'  });
	$("button").button();
})

</script>


<form id="edit_appoint" method="post" action="other_appoint_edit.php?appntId=<?= $$id ?>">  

<input type="hidden" name="appnt_id" value="<?=$appoint->id ?>"/>

<fieldset>  
<legend>Edit Appointment</legend>  
<ol>  





<li>  
<label for="name">Name</label>  
<input id="name" name="name" class="text" type="text" value="<?=$appoint->name?>" />  
</li>  

<li>  
<label for="date">Date</label>  
<input id="date" name="date" class="text date" type="text" value="<?=$date ?>"/>  
</li>  

<?
if($folder != "tutor"){
?>	
	<li>  
	<label for="tutor">Tutor</label>  
<?
$selected_tid = $appoint->tutor_id;
tutorsid_menu($selected_tid, "tutor_id",$callback);
?>	  
	</li>  
<?
}
?>



<li>  
<label for="start">Start</label>  
<input id="start_time_hours" name="start_time_hours" style="width:40px" class="text small" type="text" value="<?=$start_hrs ?>" />  

<input id="start_time_minutes" name="start_time_minutes" style="width:40px" class="text small" type="text" value="<?=$start_mins ?>"/> 


<select class="small" name="start_ampm" id="start_ampm">
  <option value="am">am</option>
  <option value="pm" <?=$start_ampm=="pm"?"selected":"";?>>pm</option>
</select>
</li>  

<li>  
<label for="end">End</label>  
<input id="end_time_hours" name="end_time_hours" style="width:40px" class="text small" type="text" value="<?=$end_hrs ?>" />  
<input id="end_time_minutes" name="end_time_minutes" style="width:40px" class="text small" type="text" value="<?=$end_mins ?>"/> 

<select class="small" name="end_ampm" id="end_ampm">
  <option value="am">am</option>
  <option value="pm" <?=$end_ampm=="pm"?"selected":"";?>>pm</option>
</select>

</li>  

<li>  
<label for="email">Email</label>  
<input id="email" name="email" class="text" type="text" value="<?=$appoint->email ?>"/>  
</li>  


<li>  
<label for="phone">Phone</label>  
<input id="phone" name="phone" class="text" type="text" value="<?=$appoint->phone ?>"/>  
</li>  


<li>  
<label for="comments">Comments</label>  
<textarea id="comments" name="comments" class="text"><?=$appoint->comments ?></textarea>

</li>  

 
</ol>  
</fieldset>  

<fieldset claass="submit">  


<button class="submit edit" onclick="checkInputs()">Save</button>
<button onclick="document.location='other_appoint.php?appntId=<?=$id?>&del=1'">Delete</button>






</fieldset>  
</form>

<script type="text/javascript">
function checkInputs()
{
	if($("#name").attr("value")=="")
	{
		alert("Please enter your name");
		return false;
	}
	else if($("#tid").attr("value")=="")
	{
		alert("Please select a tutor");
		return false;
	}
	else if($("#date").attr("value")=="")
	{
		alert("Please select date");
		return false;
	}
	else if($("#start_time_hours").attr("value")=="" || $("#start_time_minutes").attr("value")=="")
	{
		alert("Please enter start time");
		return false;
	}
	else if($("#end_time_hours").attr("value")=="" || $("#end_time_minutes").attr("value")=="")
	{
		alert("Please enter end time");
		return false;
	}

	$("#edit_appoint").submit();
	return true;
}
</script>
