<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$test_id = $_REQUEST[test_id];

put_ptts_header("Enter Section Information for Test $test_id", $strAbsPath, "admin",($_REQUEST[popup] ? "popup" : ""));
// printarray($_REQUEST);

$id= $_REQUEST[id];
$test_type = singlequery("select test_type from TP_SAT_Tests where id = $test_id");

$first_section = 1;

switch ($test_type) {
   case 1:
		$first_section = 2;
        break;
		
   case 3: // ACT
		$iQS = "insert into TP_SAT_Sections (test_id, section_number, section_type, num_questions, time) values ";
		$iQSe = "$iQS ($test_id, 1, 'english', 75, 45) ";
		$iQSm = "$iQS ($test_id, 2, 'math', 60, 60) ";
		$iQSr = "$iQS ($test_id, 3, 'reading', 40, 35) ";
		$iQSs = "$iQS ($test_id, 4, 'science', 40, 35) ";
		
		runquery($iQSe);
		runquery($iQSm);
		runquery($iQSr);
		runquery($iQSs);

	  	break;
}





	



$strTableName = "TP_SAT_Sections";
$resTest = runquery("select * from TP_SAT_Tests  WHERE id='$test_id' LIMIT 1");
$rowTest = mysql_fetch_array($resTest);
$nr_sections = $rowTest[num_sections];
if ($rowTest[id]){
$ress = "select * from $strTableName  WHERE test_id='$test_id' ORDER BY section_number";
$res = runquery($ress);
while($row = mysql_fetch_array($res)){
    $rows[$row[section_number]] = $row;
}

if ($_REQUEST[action]){
    $_REQUEST[strNotUsed] = "answers_stored";
	for ($i=$first_section; $i<=$nr_sections; $i++){
        if ($i!=$rowTest[missing_sections]){
            if ($i == $rowTest[spr_section])
                $_REQUEST[student_produced_response] = $rowTest[spr_begin];
            else
                $_REQUEST[student_produced_response] = 0;
            $_REQUEST[test_id] = $test_id;
            $_REQUEST[section_number] = $i;
            $_REQUEST[first_page] = $_REQUEST["first_page".$i];
            $_REQUEST[last_page] = $_REQUEST["last_page".$i];
            $_REQUEST[section_type] = $_REQUEST["section_type".$i];
            $_REQUEST[num_questions] = $_REQUEST["num_questions".$i];
            $_REQUEST[time] = $_REQUEST["time".$i];
            if ($rows[$i]){
                $_REQUEST[id] = $rows[$i][id];
                $strWhere = " id = ".$rows[$i][id];
                $upd = UpdateFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
                $msg.=$upd;
            }else{
                $upd = InsertFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, '', $tdStyle, $strWhere);
                if (!is_int($upd))
                    $msg.=$upd;
            }
        }
    }
    
   if (!$msg)
    echo '<form name=form2 action="getcorrectans02.php" method=POST><input type=hidden name=test_id value="'.$test_id.'"></form><script>document.form2.submit();</script>';
    else 
        echo $msg;
}

?>
<form method="post"  name="form1">
<table cellspacing="0" cellpadding="0"  width="100%" border="1" class="table_1">
<tr>
    <td class="td_header"><?=$rowTest[name]?> Sections</td>
</tr>
<tr>
    <td><table cellpadding="5"  border="3" width="100%">
<?php

putHiddenField("action", "insert_upd");
putHiddenField("test_id", $test_id);
$strNotUsed = "id,test_id,section_number,answers_stored,student_produced_response";
putHiddenField("strNotUsed", $strNotUsed);
    
$arFieldNames = array("section_type"=>"Type","num_questions"=>"Number questions");
$arFieldComments = array("num_questions"=>"How many questions in the sections?","time"=>"How many minutes does the test taker have to finish?");

$res = runquery($ress);
while($row = mysql_fetch_array($res)){
    $rows[$row[section_number]] = $row;
}


for ($i=$first_section; $i<=$nr_sections; $i++){
    if ($i!=$rowTest[missing_sections]){
?>
<tr>
    <td colspan="2" bgcolor="#e3e3e3"><b>Enter information for section <?=$i?></b></td>
</tr>
<tr>
    <td align="left" style="padding:0px">
<?
$arFieldsVals = $rows[$i];
MySQL_JustForm($strTableName, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName,$i);
$arRequired = array("section_type".$i=>"Section Type","num_questions".$i=>"Number of questions","time".$i=>"Time");
?>

</td>
</tr>
<?}
}

?>
</table></td></tr>
<tr>
    <td style="padding:10px" align="center"><button type="submit" name="Submit">Submit and go to answers</button></td>
</tr>
</table>
</form>
</form>
<?
}
put_ptts_footer(($_REQUEST[popup] ? "popup" : ""));
?>