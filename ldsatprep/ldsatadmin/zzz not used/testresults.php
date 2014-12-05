<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$strTableName = "TP_SAT_Tests";
?>

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Choose Test</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST" action="testresults01.php"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    
<?
    //$res = runquery("select * from $strTableName WHERE id!=1 AND id!=2");
    $res = runquery("select * from $strTableName");
    while($row = mysql_fetch_array($res)){
        $arr_tests[$row[id]] = $row[name];
    }
    putSelectInput('Choose Test ', 'test_id', $arr_tests, '' , '', 'required','Choose test');
?>
<tr>
            <td colspan="2" align="center"><br>
                <input type="submit" value="Submit">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"><br><br>
              </td>
</tr>
<?
MySQL_JustForm_End(array("test_id" =>"Test"), "form","");
?>
      </form></td></tr></table><br>
<?php
put_ptts_footer("");
?>