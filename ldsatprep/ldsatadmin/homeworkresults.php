<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "index");
?>
<style type="text/css">
<!--
.tablemain {
	border: 6px solid #000000;
}
-->
</style>




<table border="4"  align="center" cellpadding="3" cellspacing="0" bordercolor="#000000" bordercolorlight="#000000" bordercolordark="#000000" class="tablemain">
<tr>
    <td colspan="2" class=td_header>Homework Summary</td>
</tr>
<tr>
<td height ="100" align="center" width="350">
 <form name = "form" method="GET" action="homeworkresults01.php">
 <table border="0" cellpadding="3" margin="0" align="center" cellspacing="3" bgcolor="#FFFFFF">
 <tr>
    <td colspan="2" align="center"><br>       homework summary for which class?</td>
</tr>
     
<?
$res = runquery("select * from PT_SAT_Class_Info ORDER BY id DESC");
$arr_classes[1] = "One on One";
while($row = mysql_fetch_array($res)){
    $arr_classes[$row[id]] = "Class $row[class_name] ($row[dow] $row[class_time])";
}
putSelectInput('', 'class_id', $arr_classes, '', '', '','Choose a Class');
?>
<tr>
            <td colspan="2" align="center"><br>
                <input type="submit" value="Submit" onclick="if (!document.form.class_id.value) {alert('Please select a class'); return false;}">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset">
            </td>
</tr>
        </table>
     </form> </td>
	 <td width="350">
<form action="hwsum_student02.php" method="post">
      <table border="0" cellpadding="3" margin="0" align="center" cellspacing="3" bgcolor="#FFFFFF">
        <tr>
          <td colspan="2" align="center"><br>
            homework summary for which student?</td>
        </tr>
        <?
$res = runquery("select id, student_name from PT_TestPrep_Reg ORDER BY student_name ASC");
while($row = mysql_fetch_array($res)){
    $arr_students[$row[id]] = "$row[student_name]";
}
putSelectInput('', 'testprep_id', $arr_students, '', '', '','Choose a Student');
?>
        <tr>
          <td colspan="2" align="center"><br>
              <input type="submit" value="Submit" onclick="if (!document.form.testprep_id.value) {alert('Please select a student'); return false;}">
&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="reset" name="Submit2" value="Reset">
          </td>
        </tr>
      </table></form>
</td></tr></table>
<?
put_ptts_footer("");
?>