<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$type = 'popup';
put_ptts_header("", $strAbsPath, "admin",$type);
$strTableName = "PT_NT_Work_Hours";
$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
?>


<table  cellspacing="3" cellpadding="3" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">
<fieldset><legend><em><strong>Work Hours Info</strong></em></legend>
<table cellspacing="0" cellpadding="0" border="0"  width="100%">
<tr><td>  
  
<?php
$QStr = "select * from $strTableName where id = $id";
if (isset($_REQUEST['action'])){
	If($_REQUEST['action'] == "update" and isset($_REQUEST['id']) and isset($_REQUEST['strTableName'])){
	$strWhere = " id = $_REQUEST[id]";
	$msg = non_tut_hours('edit', $_REQUEST, null, 'id', null, $strWhere); 
} elseif ($_REQUEST['action'] == "insert"){
	 	 $msg = non_tut_hours('add', $_REQUEST, '', '', null, null); 
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
	$strNotUsed = "date,other_appt_id";
	putHiddenField("strNotUsed", $strNotUsed);
	putHiddenField("action", "update");
}else
	putHiddenField("action", "insert");
	$strNotUsed = "id,date,other_appt_id,tutor_id";
	putHiddenField("strNotUsed", $strNotUsed);
	
if ($id){
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
}

get_tutor_id($arFieldsVals[tutor_id], 'tutor_id','',array('all'=>true));
?>
<tr><td align="right">
<label for="date" style="margin-left: 50px; margin-right: 10px;">Date<font color="#FF0000">*</font></label></td><td>
<input name="date" type="text" id="date" size="7" value="<?php echo ($id ? date("m-d-Y", strtotime($arFieldsVals['date'])) : ''); ?>" >
 </td></tr>
<?php
$arRequired = MySQL_JustForm($strTableName, "", isset($arFieldsVals)?$arFieldsVals:null, null, null, $strNotUsed, null);

?>
<?php
$arRequired['date']='date';
MySQL_JustForm_End($arRequired, "form1","");
?>

</td></tr> 
</form></td></tr></table>

<script type="text/javascript">

$(document).ready(function(){

	$("#date").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=date('m-d-Y');?>'  });
	
});

</script>

<?
put_ptts_footer($type);
?>
