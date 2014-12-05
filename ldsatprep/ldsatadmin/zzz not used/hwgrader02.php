<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$test_id = $_REQUEST[test_id];
include('.check_login.php');
$strTableName = "TP_SAT_Sections";
if ($test_id){
?>

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Choose Section</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST" action="hwgrader03.php"><input type="hidden" name="test_id" value="<?=$test_id?>"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    
<?
    $res = runquery("select * from $strTableName WHERE test_id='".$test_id."' ORDER BY section_number");
    while($row = mysql_fetch_array($res)){
        $arr_sections[$row[section_number]] = $row[section_number];
    }
    putSelectInput('Choose Section ', 'section_num', $arr_sections, '' , '', 'required','Choose section');
?>
<?
MySQL_JustForm_End(array("section_num" =>"Section"), "form","");
?>
      </form></td></tr></table><br>
<?php
}
put_ptts_footer("");
?>