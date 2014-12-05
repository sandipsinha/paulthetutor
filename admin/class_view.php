<?php
ob_start();
include("../includes/pttec_includes.phtml");
$popup = $_REQUEST[popup];
echo "popup is $popup <BR>";
MySQL_PaulTheTutor_Connect();
put_ptts_header("Class Info", $strAbsPath, "admin",$popup);
$id = $_REQUEST[id];
$strTableName = "PT_SAT_Class_Info";
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
<legend>Class Info</legend>  
<table cellspacing="2" cellpadding="3">  
<?
	$QStrCol = "SHOW COLUMNS FROM $strTableName";
	if(($ColumnsRS = mysql_query($QStrCol))){
		while($arColumn = mysql_fetch_array($ColumnsRS)){
			echo '<tr>
					<td>&nbsp;&nbsp;'.setDisplayFieldVals($arColumn["Field"]).':</td>
					<td>'.$row->$arColumn["Field"].'</td>';
		}
	}
?>
</table>
</fieldset>  
<fieldset class="submit">  
<button class="edit" onclick="document.location='class_edit.php?popup=popup&id=<?=$id?>'">Edit</button>
</fieldset> 
