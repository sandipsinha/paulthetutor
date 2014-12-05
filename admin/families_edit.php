<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'');
$strTableName = "PT_Family_Info";
$id = $_REQUEST['id'];
?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">

<table cellspacing="0" cellpadding="0"  width="100%">
<tr><td><fieldset>  
<legend>Family Info</legend>  
<?php
$QStr = "select * from $strTableName where id = $id";

if(isset($id)){
	If($_REQUEST[action] == "update" and isset($_REQUEST[id]) and isset($_REQUEST[strTableName])){
	$strWhere = " id = $_REQUEST[id]";
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
	if (!$_REQUEST[password])
		$_REQUEST[password] = $arFieldsVals[password];
	$msg = UpdateFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
	if (!$msg)
		echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
	else 
		echo $msg;
} 
	putHiddenField("id", $id);
	putHiddenField("action", "update");
	$strNotUsed = "id";
	putHiddenField("strNotUsed", $strNotUsed);

	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
MySQL_JustForm($strTableName, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
}
?>

<?php
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
?>
</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button>
 &nbsp;&nbsp;&nbsp;&nbsp;<a href='families.php'>Back to families list</a>
</fieldset></td>
</tr> 
</form></td></tr></table>
<?
put_ptts_footer("");
?>
