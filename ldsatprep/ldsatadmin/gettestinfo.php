<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$test_id= $_REQUEST[test_id];

if($_REQUEST[id] and isEmpty($test_id)){
	 $test_id = $_REQUEST[id];
	 $edit_test = 1;
}

$strTableName = "TP_Test_Info";
put_ptts_header("", $strAbsPath, "admin",($_REQUEST[popup] ? "popup" : ""));

$QStr = "select * from $strTableName where id = $test_id";

?>

<form method="post" action="getsecinfo.php"  name="form1">
<table cellspacing="0" cellpadding="0"  width="100%" border="1" class="table_1">
<tr>
    <td class="td_header">Enter Test Info</td>
</tr>
<tr>
    <td><table cellpadding="5"  border="0">
<?php

if ($test_id){
    putHiddenField("test_id", $test_id);
    putHiddenField("action", "update");
	$QStr = "select * from $strTableName where id = $test_id";
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);

} else { 

    putHiddenField("action", "insert");
	
}
    
    $strNotUsed = "id,archived";
    putHiddenField("strNotUsed", $strNotUsed);
    
?>
<tr>
    <td colspan=2 align="left" style="padding:0px">
<?
$arFieldNames = array("name_report"=>"Short Name","num_sections"=>"Last Section","spr_section"=>"Student Produced Response Section","spr_section"=>"Student Produced Response Section","spr_begin"=>"First Student Produced Response");
$arFieldComments = array("order_number"=>"How often will students use this test?","spr_section"=>"What section has the Student Produced Responses?","spr_begin"=>"What problem is the first Student Produced Response?","missing_sections"=>"What section is skipped?");
MySQL_JustForm($strTableName, $arFieldNames, $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
$arRequired = array("name"=>"Name");
putTextInput("Number of Sections", "num_sections", 3, 3, NULL, "Leave blank for most normal tests");
putTextInput("Missing Section", "missing_section", 1, 1, NULL, "Is there any section that is missing?");



MySQL_JustForm_End($arRequired, "form1","");
?>
</td>
</tr>
</table></td></tr>
</table>
</form>
<?
put_ptts_footer(($_REQUEST[popup] ? "popup" : ""));
?>