<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",($_REQUEST[popup] ? "popup" : ""));
$class_id = $_REQUEST[class_id];
$id= $_REQUEST[student_id];
$strTableName = "TP_HW_Summary";
?>

<form method="post"  name="form1">
<table cellspacing="0" cellpadding="0"  width="100%" border="0">
<tr><td><fieldset>  
<legend>Homework Info</legend> 
<table cellpadding="5"  border="0">
<tr><td width=111 nowrap></td><td width="100%" style="padding:0px"></td></tr>
<?php
$QStr = "select * from $strTableName where id = $id";
if ($_REQUEST[action]){
    $_REQUEST[strNotUsed] = "";
    If($_REQUEST[action] == "update" and isset($_REQUEST[student_id]) and isset($_REQUEST[strTableName])){
    $strWhere = " id = $id";
    $msg = UpdateFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
} elseif ($_REQUEST[action] == "insert"){

// if a student was selected as opposed to a class, the sat_id is passed.  get the student id from the table
		if(!(isEmpty($_REQUEST[sat_id]))){
			$sat_id = $_REQUEST[sat_id];
			$SNQS = "select student_id from PT_TestPrep_Reg where id = $sat_id";
			$_REQUEST[student_id] = singlequery($SNQS);
		} // end if	
          $msg = InsertFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
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
    putHiddenField("action", "update");
}else
    putHiddenField("action", "insert");
    
    $strNotUsed = "id,class_id";
    putHiddenField("strNotUsed", $strNotUsed);
    
if ($id){
    $FieldsRS = runquery($QStr);
    $arFieldsVals = mysql_fetch_array($FieldsRS);
}

$res = runquery("select * from PT_SAT_Class_Info ".(!$id ? " WHERE end_date>'".date("Y-m-d")."'" : ""));
while($row = mysql_fetch_array($res)){
    $arr_classes[$row[id]] = "Class $row[class_name] ($row[location] - $row[dow])";
}
putSelectInput('Choose a class&nbsp;', 'class_id', $arr_classes, (!$id ? $arr_classes[$_REQUEST[class_id]] : $arr_classes[$arFieldsVals['class_id']]), '', 'required','Choose a Class');

// put a student select menu (sat_id and student_name)
$SQS = "select student_id, student_name from PT_TestPrep_Reg where class = 1 and archived = 0 order by student_name";
SelectFromQuery($SQS, 'Select Student', 'student_id', 'Scott Hill', '', '', '', '');
?>
<tr>
    <td colspan=2 align="left" style="padding:0px">
<?
$strNotUsed = $strNotUsed . " , student_id, sat_id ";
MySQL_JustForm($strTableName, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
$arRequired = array("due_date"=>"Due Date","assigned_date"=>"Assigned date","assignment"=>"Assignment");
?>
<tr><td width=110 nowrap></td><td width="100%"></td></tr>
<?
MySQL_JustForm_End($arRequired, "form1","");
?>
</td>
</tr>
</table>
</fieldset></td></tr>
<tr>
    <td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button>
<?
if ($_REQUEST[popup]){
?>
<button onclick="popup_close()">Close</button>
<?
}
if (!$_REQUEST[popup])
 echo "&nbsp;&nbsp;&nbsp;&nbsp;&laquo;<a href='hwsum.php'>View homework summary</a>";
?>
</fieldset></td>
</tr>
</table>
</form>
<?
put_ptts_footer(($_REQUEST[popup] ? "popup" : ""));
?>