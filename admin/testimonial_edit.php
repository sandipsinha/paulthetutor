<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$strTableName = "PTTestimonials";
$id = $_REQUEST['id'];
?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">

<table cellspacing="0" cellpadding="0"  width="100%">
<tr><td><fieldset>  
<legend>Edit Testimonial</legend>  
<?php
$QStr = "select * from $strTableName where id = $id";
if (isset($_REQUEST['action']) && $_REQUEST['action']){
	If($_REQUEST['action'] == "update" and isset($_REQUEST['id']) and isset($_REQUEST['strTableName'])){
	$strWhere = " id = $_REQUEST[id]";
	$msg = UpdateFields($strTableName, $_REQUEST, $arMandFields, 'id', $tdStyle, $strWhere); 
} elseif ($_REQUEST['action'] == "insert"){
	$msg = InsertFields($strTableName, $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
}

if (!$msg || is_int($msg)){
		echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
		echo '<script type="text/javascript">opener_reload();</script>';
}
	else 
		echo $msg;
}
if ($id){
	putHiddenField("id", $id);
	$strNotUsed = "date";
	putHiddenField("strNotUsed", $strNotUsed);
	putHiddenField("action", "update");
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
}else
	putHiddenField("action", "insert");
	$strNotUsed = "id,date";
	putHiddenField("strNotUsed", $strNotUsed);
	
MySQL_JustForm($strTableName, "", $arFieldsVals, null, null, $strNotUsed, '');

?>

<?php
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
?>
<button type="submit" style="margin-left:8px;" name="Submit">Save</button>
</fieldset></td></tr>
</form></td></tr></table>

<?
put_ptts_footer("popup");
?>
