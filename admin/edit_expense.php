<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$strTable = "PT_Expenses";
$id = $_REQUEST[id];
$QStr = "select * from $strTable where id = $id";

if ($_REQUEST[action]){
	If($_REQUEST[action] == "update" and isset($_REQUEST[id]) and isset($strTable)){
		$strWhere = " id = $_REQUEST[id]";
		$msg = UpdateFields($strTable, $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
} elseif ($_REQUEST[action] == "insert"){
	 	 $msg = InsertFields($strTable, $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
		 
		 $subject = "Expense Added $_REQUEST[item], $$_REQUEST[amount], $_REQUEST[description]";
		 $message = "An expense was added to the database. $_REQUEST[item], $$_REQUEST[amount], $_REQUEST[description]";
		 $strHeader = "From: expenses@paulthetutors.com<expenses@paulthetutors.com>\r\nReply-to: info@paulthetutors.com\r\n";
	$addparameters = "-fexpenses@paulthetutors.com";

		 
		 ptts2_mail("info@paulthetutors.com",$subject,$message,$strHeader,$addparameters);

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
MySQL_JustForm($strTable, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
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