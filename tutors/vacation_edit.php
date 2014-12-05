<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

if(strstr($_SERVER['PHP_SELF'], 'admin')) {
  $where = '';
  $admin = true;
    $tid = (isset($_REQUEST['tid'])) ? (int) $_REQUEST['tid'] : 0;
    } else { 
  include($strAbsPath . "/includes/tut_auth.php");
  $where = ' WHERE tid = '.$_SESSION['tutor_id'];
  $tid = $_SESSION['tutor_id'];
  $admin = false;
  isset($_SESSION['tutor_id']) && $tid = $_SESSION['tutor_id'];
}

MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "tutors", "popup");

$strTableName = "PTVacations";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : false;

?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">

<table cellspacing="0" cellpadding="0"  width="100%">
<tr><td><fieldset>  
<legend>Add/Edit Vacation</legend>  
<?php
if ($id) {
$QStr = "select * from $strTableName where id = $id";
}
if (isset($_REQUEST['action'])){
	
	If($_REQUEST['action'] == "update" and isset($_REQUEST['id']) and isset($_REQUEST['strTableName'])){
	$strWhere = " id = $id";
      $msg = UpdateFields($strTableName, $formdata, $mandFields,'id,tid', '', $strwhere); 
        

} elseif ($_REQUEST['action'] == "insert"){
      $msg = InsertFields($strTableName, $_REQUEST, null,'id', null, null); 
      vacation_clear_cal($tid, date('Y-m-d', strtotime(str_replace('-', '/', $_REQUEST['start_date']))), date('Y-m-d', strtotime(str_replace('-', '/', $_REQUEST['end_date']))));
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
	putHiddenField("tid", $tid);
	$strNotUsed = "date";
	putHiddenField("strNotUsed", $strNotUsed);
	putHiddenField("action", "update");
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
}else
	putHiddenField("action", "insert");
	putHiddenField("tid", $tid);
	$strNotUsed = "id,tutor_id,date";
	putHiddenField("strNotUsed", $strNotUsed);
	$arFieldsVals = null;
?>



<?php
MySQL_JustForm($strTableName, "", $arFieldsVals, '', '', 'tid', ''); 
      tutorsid_menu($tid,"tid");
?>

<?php
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
?>
</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button>
 &nbsp;&nbsp;&nbsp;&nbsp;<span class="warning">Adding a vacation will delete sessions and schedules, and cannot be undone.  Make sure it's right before you hit save.</span>
</fieldset></td>
</tr> 
</form></td></tr></table>

<script type="text/javascript">

$(document).ready(function(){

	$("#date").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=date('m-d-Y');?>'  });
	
});

</script>

<?
put_ptts_footer("popup");
?>
