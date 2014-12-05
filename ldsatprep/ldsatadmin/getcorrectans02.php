<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",($_REQUEST[popup] ? "popup" : ""));
$test_id = $_REQUEST[test_id];
$success = $_REQUEST[success];
$strTableName = "TP_SAT_Questions";
$resTest = runquery("select * from TP_SAT_Tests  WHERE id='$test_id' LIMIT 1");
$rowTest = mysql_fetch_array($resTest);
$nr_sections = $rowTest[num_sections];
$test_type = $rowTest[test_type];

?>
<form name=form2 id=form2 action="getcorrectans02.php" method=POST style="margin:0px; padding:0px"><input type=hidden name=test_id value="<?=$test_id?>"><input type=hidden name=success value=1></form>
<form method="post"  name="form1">
<table cellspacing="0" cellpadding="0"  width="100%" border="1" class="table_1">
<tr>
    <td class="td_header">Enter <?=$rowTest[name]?> Correct Answers</td>
</tr>
<?
if ($success){
?>
<tr height=80>
    <td align="center"><br><span class="text_success">The answers for test "<?=$rowTest[name]?>" have been updated.</span><br><br></td>
</tr>
<?
}
elseif ($rowTest[id] && !$success){
    $ColumnsRS = runquery("SHOW COLUMNS FROM $strTableName");
    while($arColumn = mysql_fetch_array($ColumnsRS)){
        if ($arColumn['Field'] == "checkable")
            $arr_checkable = MySQL_SetToArray($arColumn["Type"]);
    }
    
$ress = "select * from TP_SAT_Sections WHERE test_id='$test_id' ORDER BY section_number";
$res = runquery($ress);
while($row = mysql_fetch_array($res)){
    $rows[$row[section_number]] = $row;
}

$first_section = 1;

switch ($test_type) {
   case 1:
		$first_section = 2;
        break;
}

// echo "first section is $first_section <BR>";


if ($_REQUEST[action]){
    $strNotUsed = "";
    for($i = $first_section; $i<=$nr_sections; $i++){
        if ($i!=$rowTest[missing_sections]){
		
            for ($j=1; $j<=$rows[$i][num_questions]; $j++){
                $resq = runquery("select * from $strTableName WHERE number=$j AND section_num='$i' AND test_id=$test_id LIMIT 1");
                $rowq = mysql_fetch_array($resq);
                $_REQUEST[test_id] = $test_id;
                $_REQUEST[section_num] = $i;
                $_REQUEST[section_id] = $rows[$i][id];
                $_REQUEST[number] = $j;
                $_REQUEST[answer] = $_REQUEST["answer".$i."_".$j];
                $_REQUEST[spr] = $_REQUEST["spr".$i."_".$j];
                $_REQUEST[checkable] = $_REQUEST["checkable".$i."_".$j];
                if ($rowq[id]){
                    $_REQUEST[id] = $rowq[id];
                    $strWhere = " id = ".$rowq[id];
                    $upd = UpdateFields($strTableName, $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
                    $msg.=$upd;
                }else{
                	$_REQUEST[id] = '';
                    $upd = InsertFields($strTableName, $_REQUEST, $arMandFields, '', $tdStyle, $strWhere);
                    if (!is_int($upd))
                        $msg.=$upd;
                }
            }
        }
    }
    
   if (!$msg)
    echo '<script>document.form2.submit();</script>';
    else 
        echo $msg;
}

putHiddenField("action", "insert_upd");
putHiddenField("test_id", $test_id);
$strNotUsed = "id";
putHiddenField("strNotUsed", $strNotUsed);
?>
<tr>
    <td><table cellpadding="5"  border="0" width="100%">
<?
for ($i=$first_section; $i<=$nr_sections; $i++){
    if ($i!=$rowTest[missing_sections]){
?>
<tr>
    <td bgcolor="#e3e3e3"><b>Enter correct answers for section <?=$i?></b></td>
</tr>
<tr>
    <td align="left" style="padding:0px"><table cellpadding="5" border="1" class="table_1"><tr style="background: #f8f8f8">
            <td class="text_grey" width="65"><b>Question #</b></td>
            <td class="text_grey" width="380"><b>Answer</b></td>
            <td class="text_grey" width="70"><b>Checkable</b></td>
        </tr>
<?
for ($j=1; $j<=$rows[$i][num_questions]; $j++){
    //$arRequired["answer".$i."_".$j] = "Answer to Section ".$i.", question ".$j;
    $resq = runquery("select * from $strTableName WHERE number=$j AND section_num='$i'  AND test_id=$test_id LIMIT 1");
    $rowq = mysql_fetch_array($resq);
    
?>
        <tr>
            <td valign="top"  align="center"><b><?=$j?></b></td>
            <td>
            <?
            //if is spr question
              if ($rows[$i][student_produced_response] && $j>=$rows[$i][student_produced_response]){
                  if ($j == $rows[$i][student_produced_response])
                    echo '<span style="font-size:10px">For problems with multiple answers, separate answers with or, and mark as "multi"<br>
                                                    For problems with a range of answers use <,<=,>,>= and mark as "range"<hr>';
                  echo '<input name="answer'.$i.'_'.$j.'" value="'.$rowq[answer].'" maxlength=20 style="width:50px"><input type=hidden name="spr'.$i.'_'.$j.'" value=1>';
              }else{
                  echo '<input name="answer'.$i.'_'.$j.'" value="'.$rowq[answer].'"  maxlength=1 style="width:25px"><input type=hidden name="spr'.$i.'_'.$j.'" value=0>';
              }
                  
            ?>
            </td>
            <td align="center"><select name="checkable<?=$i."_".$j?>">
                    <?
                    foreach ($arr_checkable as $k=>$v){
                        echo '<option value="'.$k.'" '.($rowq[checkable] == $k ? "selected" : "").'>'.$v.'</option>';
                    }
                    ?>
                </select></td>
        </tr>
<?
}
?>
</table>
</td>
</tr>
<?}
}?>
</table></td></tr>
<tr>
    <td style="padding:10px" align="center"><button type="submit" name="Submit">Save correct answers</button></td>
</tr>
<?
}
?>
</table>
</form>
<?
put_ptts_footer(($_REQUEST[popup] ? "popup" : ""));
?>