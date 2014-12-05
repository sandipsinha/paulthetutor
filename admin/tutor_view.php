<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Appointment Info", $strAbsPath, "",'popup');
$id = $_REQUEST[id];
$strTableName = "PT_Tutors";
if(isset($id)){
	$query = "SELECT * FROM $strTableName WHERE id = $id";
	$result = mysql_query($query);
	if($result)
		$row = mysql_fetch_object($result);
}
else
	die("Error");

?>
<fieldset>  
<legend>Tutor Info</legend>  
<table cellspacing="2" cellpadding="3">  
<?
	$QStrCol = "SHOW COLUMNS FROM $strTableName";
	if(($ColumnsRS = mysql_query($QStrCol))){
		while($arColumn = mysql_fetch_array($ColumnsRS)){
			echo '<tr>
					<td nowrap valign=top>&nbsp;&nbsp;'.setDisplayFieldVals($arColumn["Field"]).':</td>
					<td valign=top>'.$row->$arColumn["Field"].'</td>';
		}
	}
?>
</table>
</fieldset>  
<fieldset class="submit">  
<button class="edit" onclick="document.location='tutor_edit.php?id=<?=$id?>'">Edit</button>
<button onclick="popup_close()">Close</button>
</fieldset> 
<?
put_ptts_footer("popup");
?>
