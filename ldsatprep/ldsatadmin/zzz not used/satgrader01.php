<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$strTableName = "TP_SAT_Tests";
$test_id=$_REQUEST[test_id];
if ($test_id){
?>

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Choose Student</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST" action="satgrader02.php"><input type="hidden" name="test_id" value="<?php echo $test_id?>"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    
<?
    $res = runquery("select b.id, b.student_name, b.class from  PT_TestPrep_Reg b  ORDER BY b.student_name");
    while($row = mysql_fetch_array($res)){
        $arr_students[$row[id]] = $row[student_name].' (Class '.$row['class'].')';
    }
    putSelectInput('Choose Student ', 'ldsat_sid', $arr_students, '' , '', 'required','Choose student');
?>
<tr>
            <td colspan="2" align="center"><br>
                <input type="submit" value="Submit">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"><br><br>
              </td>
</tr>
<?
MySQL_JustForm_End(array("ldsat_sid" =>"student"), "form","");
?>
      </form></td></tr></table><br>
<?php
}
put_ptts_footer("");
?>