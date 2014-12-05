<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Appointment Info", $strAbsPath, "admin",$_REQUEST['popup']);
$id = $_REQUEST[id];
$strTableName = "PT_Family_Info";
if(isset($id)){
	$query = "SELECT * FROM PT_Family_Info WHERE id = $id";
	$result = mysql_query($query);
	if($result)
		$row = mysql_fetch_object($result);
}
else
	die("Error");

?>
<fieldset>  
<legend>Family Info</legend>  
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
<?php if ($_REQUEST['only_view']){?>
<button onclick="popup_close()">Close</button>
<?php }else{?>
<button class="edit" onclick="document.location='families_edit.php?id=<?=$id?>'">Edit</button>
 &nbsp;&nbsp;&nbsp;&nbsp;<a href='families.php'>Back to families list</a>
 <?php }?>
</fieldset> 
<?
put_ptts_footer($_REQUEST['popup']);
?>
