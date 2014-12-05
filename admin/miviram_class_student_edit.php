<?php
ob_start();
include("../includes/pttec_includes.phtml");
// printarray($_REQUEST);
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin",$_REQUEST['popup']);
$strTableName = $_REQUEST['tab'];
if ($_REQUEST[tab] == "TP_Seminar_Reg")
  $sem = 1;
if ($sem == 1)
  $strTableName2 = "TP_Seminar_Info";
else
  $strTableName2 = "PT_SAT_Class_Info";
$id = $_REQUEST['student_id'];
?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">

<table cellspacing="0" cellpadding="0"  width="100%">
<tr><td><fieldset>  
<legend>Student Info</legend>
<div style="padding:10px"><table cellspacing="0" cellpadding="0">
<?php
// the student_id was passed, so it will be used to determine the family_id (fid)
if ($_REQUEST[action]){
   $arFieldsVals = $_REQUEST;
   $class_student_id = $_REQUEST[student_id];
  }

  if(!(isEmpty($_REQUEST['student_id']))){
    $student_id = $_REQUEST['student_id'];
    $SQS = "select first_name, last_name, fid from PTStudentInfo_New where id = $student_id";
    $SRS = runquery($SQS);
    $Sar = mysql_fetch_array($SRS);
    $_REQUEST['fid'] = $Sar[fid];
    $_REQUEST['student_name'] = "$Sar[first_name] $Sar[last_name]";
    $_REQUEST['username'] = $Sar[first_name];
    $_REQUEST['password'] = $Sar[last_name];
  }  
  
  if (($_REQUEST['fid']!=$arFieldsVals['fid'] && $arFieldsVals['fid']) || !$arFieldsVals['fid']){
    $Fres = runquery("select main_name, main_email, main_phone from PT_Family_Info where id = '".$_REQUEST['fid']."'");
    $frow = mysql_fetch_array($Fres);
    $_REQUEST['name'] = $frow['main_name'];
    $_REQUEST['parent_name'] = $frow['main_name'];
    $_REQUEST['email'] = $frow['main_email'];
    $_REQUEST['phone_number'] = $frow['main_phone'];
  }
  $_REQUEST[strNotUsed] = "id";
  
  If($_REQUEST[action] == "update" and isset($_REQUEST[id]) and isset($_REQUEST[strTableName])){
       
    $strWhere = " id = $id";
    if (!$_REQUEST[username])
      $_REQUEST[username] = $arFieldsVals[username];
    if (!$_REQUEST[password])
      $_REQUEST[password] = $arFieldsVals[password];
    $msg = UpdateFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
} elseif ($_REQUEST[action] == "insert"){
	  
	  
	 //--- function call to class_add_student()
	 $check=class_add_student($_REQUEST['student_id'], $_REQUEST['class'], $_REQUEST['paid'], $_REQUEST['fee'], $_REQUEST['learning_disability'], $_REQUEST['extended_time'], $_REQUEST['tutor_id'], '', '0');	 
	 // --- Ended Here  ---//




if (!$msg || is_int($msg))
    echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
  else 
    echo $msg;
  echo "<br>";
  echo '<script type="text/javascript">opener_reload();</script>';
}

$arr_classes[1] = "One on one Tutoring";


$QStrsi = runquery("select id, class_name from $strTableName2 ORDER BY id desc");
  while($arsi = mysql_fetch_array($QStrsi)){
    $text_class = ($sem == 1 ? "Seminar" : "Class ").$arsi[class_name];
    $arr_classes[$arsi[id]] = $text_class;
    if ($arFieldsVals[($sem == 1 ? "seminar_id" : "class")] == $arsi[id])
      $class_sel = $text_class;
}


if ($id && $_REQUEST[action] != "insert"){
  // putHiddenField("id", $id);
  putHiddenField("action", "update");
//  $strNotUsed = "id,fid,class,seminar_id";
}else{
  putHiddenField("action", "insert");
}
  $strNotUsed = "id,fid,class,seminar_id,name,username,password,phone_number,email,parent_name";

  $strNotUsed = $strNotUsed . ", student_id, student_name";
  putHiddenField("strNotUsed", $strNotUsed);
?>
<tr><td align=right > Select the Student<font color="#FF0000">*</font>&nbsp;&nbsp;</td><td>
<select name="student_id" id="student_id" >
<option>Select a Student</option>
<?
$SQS = "select id, first_name, last_name from PTStudentInfo_New order by first_name";
$SRS = runquery($SQS);

$class_sid = $_REQUEST[student_id];
While($arTI = mysql_fetch_array($SRS)){ 
// if a student is being edited, make sure that student is selected

if($class_sid == $arTI[0]){
	$selected = " selected";
} else {
	$selected = "";
}		
?>
        <option value="<?="$arTI[0]";?>" <?=$selected;?>>
<?
echo "$arTI[1] $arTI[last_name] $arTI[0]";
?>
        </option>
      <? } ?>  
 </select>
 
 </td></tr>
  
<tr height=10><td></td></tr>

<?
putSelectInput(($sem == 1 ? "Seminar" : "Class").'<font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;', ($sem == 1 ? 'seminar_id' : 'class'), $arr_classes, ($class_sel!='' ? $class_sel : $_REQUEST['cls']), '', '','Choose');
  echo '<tr height=10><td></td></tr>';

?>
<tr>
  <td colspan="2">
<?


MySQL_JustForm($strTableName, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
?>
</td>
</tr>
<?php
MySQL_JustForm_End($arRequired, "form1","");
?>
</table></div>
</fieldset></td></tr>
<tr>
  <td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button>
<button onclick="popup_close()">Close</button>
</fieldset></td>
</tr> 
</form></td></tr></table>
<?
put_ptts_footer("popup");
?>