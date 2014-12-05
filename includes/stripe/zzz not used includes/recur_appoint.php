<?php

$strBack = "../";  //if this page is in a subdirectory, the strBack is "../" so we look back a folder in links.
// $intTableFieldsid is the id of the info we are to update
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("pttec_includes.phtml");
include($strAbsPath . "/paulthetutors_com/includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "",'popup');


function appoint_delete($appointId)
{
	$query = "DELETE FROM PT_Recurring_Appt WHERE id = $appointId";
	return mysql_query($query);
}

if(isset($_GET["appntId"]))
{
	$id = $_GET["appntId"];
	
	$query = "SELECT * FROM PT_Recurring_Appt WHERE id = $id";
	
	
	$result = mysql_query($query);
	
	if($result)
	{
		$appoint = mysql_fetch_object($result);	
		
		if($appoint->tid != $_SESSION[tutor_id])
			die("Error. You are not authorized to View this appointment.");
		
		if(isset($_GET["del"]))
		{
			
			
			if(appoint_delete($id))
			{
				echo '<script type="text/javascript">';
				echo "window.opener.location=window.opener.location;";
				echo "self.close();";
				echo '</script>';
			}
			
		}
		
		
		
		
		$t_query = "select first_name, last_name from PT_Tutors WHERE id = $appoint->tid";
		$t_result = mysql_query($t_query);
		
		$tutor = mysql_fetch_object($t_result);
		
		$start = date("g:i a",strtotime($appoint->start_time));
		$end = date("g:i a",strtotime($appoint->end_time));
		
		$start_date = date("m-d-Y",strtotime($appoint->start_date));
		$end_date = date("m-d-Y",strtotime($appoint->end_date));
		
	}
}

?>

<!-- <link rel="stylesheet" type="text/css" href="/styles/paulthetutor.css" /> -->
<link rel="stylesheet" type="text/css" href="/styles/form.css" />
<link rel="stylesheet" type="text/css" href="/includes/jquery-ui-1.8.4.custom.css"/>
<script type="text/javascript" src="/includes/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/includes/jquery-ui-1.8.4.custom.min.js"></script>

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
<label for="startdate">Date</label>  
<?=$start_date ?>
</li>  

<li>  
<label for="enddate">Date</label>  
<?=$end_date ?>
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
<label for="description">Description</label>  
<?=$appoint->description ?>
</li> 

 
</ol>  
</fieldset>  
<fieldset class="submit">  
<button class="edit" onclick="document.location='recur_appoint_edit.php?appntId=<?=$id?>'">Edit</button>
<button onclick="document.location='recur_appoint.php?appntId=<?=$id?>&del=1'">Delete</button>


</fieldset> 