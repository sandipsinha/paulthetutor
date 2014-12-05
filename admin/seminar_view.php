<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Seminar Info", $strAbsPath, "admin",'');
$id = $_REQUEST[id];
$strTableName = "TP_Seminar_Info";
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
<legend>Seminar Info</legend>  
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
<button class="edit" onclick="document.location='seminar_edit.php?id=<?=$id?>'">Edit</button>
 &nbsp;&nbsp;&nbsp;&nbsp;&laquo;<a href='seminars_list.php'>Back to seminars list</a>
</fieldset> 
<?
put_ptts_footer("");
?>
