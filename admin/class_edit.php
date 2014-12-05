<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",$_REQUEST[popup]);
$strTableName = "PT_SAT_Class_Info";
$id = $_REQUEST['id'];
?>

     <form method="post"  name="form1">
 
<fieldset><legend>Class Info</legend> 
<table border="0"  cellspacing="3" cellpadding="3" width="100%">
<tr><td colspan="2"> 
 
<?php
$QStr = "select * from $strTableName where id = $id";
if ($_REQUEST[action]){
  If($_REQUEST[action] == "update" and isset($_REQUEST[id]) and isset($_REQUEST[strTableName])){
  $strWhere = " id = $_REQUEST[id]";
  $FieldsRS = runquery($QStr);
  $arFieldsVals = mysql_fetch_array($FieldsRS);
  $msg = UpdateFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
} elseif ($_REQUEST[action] == "insert"){
  //  printarray($_REQUEST);
      $msg = InsertFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
}

if (!$msg || is_int($msg))
    echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
  else 
    echo $msg;
}
// $test_id = $_REQUEST[testid];
// putHiddenField("testid", $test_id);
if ($id){
  putHiddenField("id", $id);
  putHiddenField("action", "update");
}else
  putHiddenField("action", "insert");


  $strNotUsed = "id,class_name,class_id,classid,review_date,review_time, extended_time, size, enrolled, status";
  putHiddenField("strNotUsed", $strNotUsed);
  putHiddenField("popup", $_REQUEST[popup]);
  
if ($id){
  $FieldsRS = runquery($QStr);
  $arFieldsVals = mysql_fetch_array($FieldsRS);
}
$cidQStr = "select max(id) from PT_SAT_Class_Info";  
$last_id = singlequery($cidQStr);
// echo '<a onclick="javascript:popup(\'class_list.php\',\'Details\',\'500\',\'550\')"> see classes </a>';

$classname_comment = '<a onclick="javascript:popup(\'class_list.php\',\'Details\',\'500\',\'550\')"> see classes </a>';

putTextInput("Class Name", "class_name", 20, 20, $temp_classname, "$classname_comment", "required");

// get_test_id();
  
MySQL_JustForm($strTableName, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);

?>

<?php
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
if($_REQUEST[popup] == 'popup'){ ?>
	<button onclick="popup_close()">Close</button>  
<? }  ?>	

</td></tr>
<tr>
  <td>  
  
<? if($_REQUEST[popup] != 'popup'){ ?>
 &nbsp;&nbsp;&nbsp;&nbsp;&laquo;<a href='classes_list.php'>Back to classes list</a>
<? } ?> 
 </td></tr></table>
</fieldset></form>
<?
put_ptts_footer($_REQUEST[popup]);
?>