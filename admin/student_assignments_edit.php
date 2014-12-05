<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$strTableName = "PT_Student_Assignments";
$id = $_REQUEST[id];
$QStr = "select * from $strTableName where id = $id";

// printarray($_REQUEST);
// if editing comment, should be able to update the date

if ($_REQUEST[action]){
	If($_REQUEST[action] == "update" and isset($_REQUEST[id])){
		$strWhere = " id = $_REQUEST[id]";
		$msg = UpdateFields($strTableName, $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
} elseif ($_REQUEST[action] == "insert"){
	 	 $msg = InsertFields($strTableName, $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
}

if (!$msg || is_int($msg))
		echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
	else 
		echo $msg;
	echo "<br>";
	echo '<script type="text/javascript">opener_reload();</script>';
}



?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">

<table cellspacing="0" cellpadding="0"  width="100%">
<tr><td><fieldset>  
<legend>Record Info </legend>
<div style="padding:10px"><table cellspacing="0" cellpadding="0">
<?php
if ($id){
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
}
if ($folder == "students"){
		$strNotUsed .= "student_id";
		putHiddenField("student_id", $student_id);
}

if ($id){
	putHiddenField("id", $id);
	putHiddenField("action", "update");
}else
	putHiddenField("action", "insert");
	
	
	$strNotUsed = "id, fid";
	putHiddenField("strNotUsed", $strNotUsed);
	
?>
<tr>
	<td colspan="2">
<?
MySQL_JustForm($strTableName, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
?>
</td>
</tr>
<?php
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
?>
</table></div>
</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button>
<button onclick="popup_close()">Close</button>
</fieldset></td>
</tr></table>
</form></td></tr></table>
<?php
put_ptts_footer("popup");
?>
<script type="text/javascript">
$(document).ready(function(){
	jquery_date('date');
});
</script>