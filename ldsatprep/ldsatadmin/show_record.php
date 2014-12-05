<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Student Info", $strAbsPath, "admin",'popup');
$record_id = $_REQUEST[record_id];
$strTable = $_REQUEST[strTable];
if(!(isEmpty($record_id))){
	echo "<fieldset><legend> Record $record_id for $strTable</legend>";  
	
	$query = "SELECT * FROM $strTable WHERE id = $record_id";
	$result = runquery($query);
	if($result)	printRS($result);
		
}
else
	die("Error");
	
?>
</fieldset>  
<fieldset class="submit">  
<button class="edit" onclick="document.location='edit_record.php?id=<?=$id?>'">Edit</button>
<button onclick="popup_close()">Close</button>
</fieldset> 
<?
put_ptts_footer('popup');
?>
