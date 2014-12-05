<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

include($strAbsPath . "/includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "tutors", "");

$strTableName = "PT_NT_Work_Hours";
$id = $_REQUEST['id'];
$tid = $_SESSION['tutor_id'];

?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">

<table cellspacing="0" cellpadding="0"  width="100%">
<tr><td><fieldset>  
<legend>Work Hours Info</legend>  
<?php
$QStr = "select * from $strTableName where id = $id";
if ($_REQUEST['action']){
	
	If($_REQUEST['action'] == "update" and isset($_REQUEST['id']) and isset($_REQUEST['strTableName'])){
	$strWhere = " id = $_REQUEST[id]";
	$msg = non_tut_hours('edit', $_REQUEST, $arMandFields, 'id,tutor_id', $tdStyle, $strWhere); 
} elseif ($_REQUEST[action] == "insert"){
	 	 $msg = non_tut_hours('add', $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
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
	putHiddenField("tutor_id", $tid);
	$strNotUsed = "date";
	putHiddenField("strNotUsed", $strNotUsed);
	putHiddenField("action", "update");
}else
	putHiddenField("action", "insert");
	putHiddenField("tutor_id", $tid);
	$strNotUsed = "id,tutor_id,date";
	putHiddenField("strNotUsed", $strNotUsed);
	
if ($id){
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
}

?>

<label for="date" style="margin-left: 50px; margin-right: 10px;">Date</label>
<input name="date" type="text" id="date" size="7" value="<?php echo ($id ? date("m-d-Y", strtotime($arFieldsVals['date'])) : ''); ?>" >

<?php
MySQL_JustForm($strTableName, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);

?>

<?php
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
?>
</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button>
 &nbsp;&nbsp;&nbsp;&nbsp;&laquo;<a href='work_hours_list.php'>Back to work hours list</a>
</fieldset></td>
</tr> 
</form></td></tr></table>

<script type="text/javascript">

$(document).ready(function(){

	$("#date").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=date('m-d-Y');?>'  });
	
});

</script>

<?
put_ptts_footer("");
?>
