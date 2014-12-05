<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$strTable = $_REQUEST[strTable];
$id = $_REQUEST[id];
$QStr = "select * from $strTable where id = $id";

printarray($_REQUEST);
// if editing comment, should be able to update the date
if((isEmpty($_REQUEST[action])) and ($strTableName = "PT_Comments_Student")) $strNotUsed = "id";


if ($_REQUEST[action]){
	If($_REQUEST[action] == "update" and isset($_REQUEST[id]) and isset($_REQUEST[strTable])){
		$strWhere = " id = $_REQUEST[id]";
		$msg = UpdateFields($_REQUEST[strTable], $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
} elseif ($_REQUEST[action] == "insert"){
	 	 $msg = InsertFields($_REQUEST[strTable], $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 

	$note_info = $_REQUEST;
	$subject = "New Note About $_REQUEST[parents]";
	$message = "There is a new note which you can read at http://www.paulthetutors.com/admin/new_ce.php \n\n";

	while (list($key, $val) = each($note_info)) {
		if($key == 'parents' or $key == 'students' or $key == 'subjects' or $key == 'comments' or $key == 'phone' or $key == 'email') 
		$message = $message . "\n <B>$key</B>: $val ";
	}
	
	$headers = 'From: newcontact@paulthetutors.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
	$other_p='-fnewcontact@paulthetutors.com';
	$to = "paul@paulthetutors.com";
	$mail_result = ptts2_mail($to,$subject,$message,$headers,$other_p);
echo "result is $mail_result";
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
	$strNotUsed = "id,assinged_to, answered_by_eid,assigned_to_eid";
	putHiddenField("strNotUsed", $strNotUsed);
//	putHiddenField("needs_attention", '1');
	$arFieldsVals['needs_attention'] = 1;
	
?>
<tr>
	<td colspan="2">
<?
get_tutor_id($arFieldsVals[answered_by_eid],"answered_by_eid","","","Answered By");

MySQL_JustForm($strTable, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);

get_tutor_id($arFieldsVals[assigned_to_eid],"assigned_to_eid","","","Assigned To");
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