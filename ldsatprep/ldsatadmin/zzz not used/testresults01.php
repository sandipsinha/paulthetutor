<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$strTableName = "TP_SAT_Answers";
$test_id=$_REQUEST[test_id];
if ($test_id){
?>

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Choose Student</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST" action="testresults02.php"><input type="hidden" name="test_id" value="<?php echo $test_id?>"><input type="hidden" name="sat_id" id="sat_id"><input type="hidden" name="sat_class_id" id="sat_class_id"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    
<?
    $res = runquery("select a.*, b.student_name, b.class from $strTableName a LEFT JOIN PT_TestPrep_Reg b ON a.sid=b.id WHERE a.test='".$test_id."' ORDER BY b.student_name");
    while($row = mysql_fetch_array($res)){
        $arr_students[$row[sid]."|".$row['class']] = $row[student_name];
    }
    putSelectInput('Choose Student ', 's_id', $arr_students, '' , '', 'required','Choose student');
?>
<tr>
            <td colspan="2" align="center"><br>
                <input type="button" value="Submit" onclick="check_submit(document.form.s_id.value)">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"><br><br>
              </td>
</tr>
<?
MySQL_JustForm_End(array("s_id" =>"student"), "form","");
?>
      </form></td></tr></table><br>
      
<script language="javascript">
	function check_submit(val){
		if (val!=undefined && val!=''){
			s = val.split("|");
			document.form.sat_id.value=s[0];
			document.form.sat_class_id.value=s[1];
			document.form.submit();
		}else
			alert('Choose Student');
	}
</script>	
<?php
}
put_ptts_footer("");
?>