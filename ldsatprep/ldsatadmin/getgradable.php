<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Gradable Homework", $strAbsPath, "admin","");
$class_id = $_REQUEST[class_id];
$student_id = $_REQUEST[student_id];
$id = $_REQUEST[id];
$strTableName = "TP_HW_Gradable";
?>

<form method="post"  name="form1">
<table cellspacing="0" cellpadding="0"  width="100%" border="0">
<tr><td><fieldset>  
<legend>Gradable Homework</legend> 
<table cellpadding="5"  width="100%" border="0">
<tr><td width=111 nowrap></td><td width="100%" style="padding:0px"></td></tr>
<?php
$QStr = "select * from $strTableName where id = $id";
if ($_REQUEST[action]){
    $_REQUEST[strNotUsed] = "";
    If($_REQUEST[action] == "update" and isset($_REQUEST[id]) and isset($_REQUEST[strTableName])){
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
    
    $strNotUsed = "id,class_id,test,section";
    putHiddenField("strNotUsed", $strNotUsed);
    
if ($id){
    $FieldsRS = runquery($QStr);
    $arFieldsVals = mysql_fetch_array($FieldsRS);
}

$res = runquery("select * from PT_SAT_Class_Info ".(!$id ? " WHERE end_date>'".date("Y-m-d")."'" : "")." ORDER BY id DESC");
while($row = mysql_fetch_array($res)){
    $arr_classes[$row[id]] = "Class $row[class_name] ($row[location] - $row[dow])";
}

$res = runquery("select * from TP_SAT_Tests");
while($row = mysql_fetch_array($res)){
    $arr_tests[$row[id]] = $row[name];
}
for ($i=1;$i<=10;$i++)
    $arr_sections[$i] = $i;

?>
<br>
<fieldset> 
<legend>Select a Class or Student</legend>
 <table border="3" cellpadding="2" margin="0" cellspacing="2" bgcolor="#FFFFFF">    

        <?
putSelectInput('Choose a class&nbsp;', 'class_id', $arr_classes, (!$id ? $arr_classes[$_REQUEST[class_id]] : $arr_classes[$arFieldsVals['class_id']]), '', '','Choose a Class');

select_testprep_student($student_id);
?></table></fieldset>
<br />
<fieldset >
<legend> Select Section</legend>
<table border="0">

<tr valign="top">
 <td nowrap="nowrap">
 <fieldset>
 Blue Book 


Page:  
  <input name="bb_page_num" type="text" size="4" maxlength="4" id="bb_page_num" />&nbsp;&nbsp;&nbsp;&nbsp;<br />
  
  <span class="form_comments">Enter any page from the test section</span>
 </fieldset>
</td>
<td nowrap="nowrap">
<BR />
<div align="center" class="Head3">&nbsp;&nbsp;-OR-&nbsp;&nbsp;</div>
</td>
<td nowrap="nowrap">

<fieldset>

Test: <?

just_select_test();

?>
<BR />

Section: 
<input name="section_num" type="text" size="3" maxlength="3" id="section_num" />
</fieldset>

</td></tr>

</table>
<tr>
    <td colspan=2 align="left" style="padding:0px">
<?
$strNotUsed = $strNotUsed . " , student_id, sat_id ";
MySQL_JustForm($strTableName, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
$arRequired = array("due_date"=>"Due Date","assigned_date"=>"Assigned date","test"=>"Test","section"=>"Section");
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
 echo "&nbsp;&nbsp;&nbsp;&nbsp;&laquo;<a href='hwgradable.php'>View gradable homework</a>";
?>
</fieldset></td>
</tr>
</table>
</form>
<?
put_ptts_footer(($_REQUEST[popup] ? "popup" : ""));
?>