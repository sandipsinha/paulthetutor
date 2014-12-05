<?php
ob_start();
session_start();
include("../includes/pttec_includes.phtml");
$folder = getfolder('','','');
if ($folder == "tutors"){
	include("../includes/tut_auth.php");
	$is_tutor = 1;
}
MySQL_PaulTheTutor_Connect();
put_ptts_header("Appointment Info", $strAbsPath, "admin", "popup");

if(isset($_GET["appntId"]))
{
	$id = $_GET["appntId"];
	
	$query = "SELECT * FROM PT_Other_Appt WHERE id = $id";
	
	
	$result = mysql_query($query);
	
	if($result)
	{
		$appoint = mysql_fetch_object($result);
		
		if($appoint->tutor_id != $_SESSION['tutor_id'] && !stristr($_SERVER['REQUEST_URI'],"admin"))
			die("Error. You are not authorized to View this appointment.");
		
		if(isset($_GET["del"]))
		{
			if(non_tut_session_del($id))
			{
				echo '<script type="text/javascript">';
				echo "window.opener.location=window.opener.location;";
				echo "self.close();";
				echo '</script>';
			}
			
		}
		
		
		
		
		$t_query = "select first_name, last_name from PT_Tutors WHERE id = $appoint->tutor_id";
		$t_result = mysql_query($t_query);
		
		$tutor = mysql_fetch_object($t_result);
		
		$start = date("g:i a",strtotime($appoint->start_time));
		$end = date("g:i a",strtotime($appoint->end_time));
		
		$date = date("m-d-Y",strtotime($appoint->date));
		/*
		echo "Name : $appoint->name <br />";
		echo "Date: $date <br />";
		echo "Start: $start <br /> ";
		echo "End: $end <br />";
		echo "Tutor: $tutor->first_name $tutor->last_name <br />";
		echo "Email: $appoint->email <br />";
		echo "Phone: $appoint->phone <br />";
		echo "Comments: $appoint->comments <br />";
		
		
		echo '<BR> <a href="other_appoint_edit.php?appntId='.$id.'">Edit this appointment</a>';
		echo '<a href="other_appoint.php?appntId='.$id.'&del=1">Delete this appointment</a>';
		*/
	}
}
else
	die("Error");

?>

<!-- <link rel="stylesheet" type="text/css" href="/styles/paulthetutor.css" /> -->
<link rel="stylesheet" type="text/css" href="/styles/form.css" />

<script type="text/javascript">


$(document).ready(function(){

	$("button").button();
	
})

</script>

<fieldset>  
<legend>Appointment Info</legend>  
<ol>  
<li>  
<label for="name">Name</label>  
<?=$appoint->name ?>
</li>  

<li>  
<label for="tname">Tutor</label>  
<?="$tutor->first_name $tutor->last_name"  ?>
</li>  

<li>  
<label for="date">Date</label>  
<?=$date ?>
</li>  



<li>  
<label for="start">Start</label>  
<?=$start ?>
</li>  

<li>  
<label for="end">End</label>  
<?=$end ?>
</li>  

<li>  
<label for="email">Email</label>  
<?=$appoint->email ?>
</li>  


<li>  
<label for="phone">Phone</label>  
<?=$appoint->phone ?>
</li>  

<li>  
<label for="comments">Comments</label>  
<?=$appoint->comments ?>
</li> 

 
</ol>  
</fieldset>  
<fieldset class="submit">  
<button class="edit" onclick="document.location='other_appoint_edit.php?appntId=<?=$id?>'">Edit</button>
<button onclick="document.location='other_appoint.php?appntId=<?=$id?>&del=1'">Delete</button>
<span class="text_warning">* Any Non-Tutoring Work Hours associated with this appointment will also be deleted.</span>

</fieldset> 
