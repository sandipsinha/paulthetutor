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
<link href="../../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />

<table border="4"  align="center" cellpadding="3" cellspacing="0" bordercolor="#000000" bordercolorlight="#000000" bordercolordark="#000000" class="tablemain">
<tr>
    <td colspan="2" class=td_header>Homework Summary</td>
</tr>
<tr>
<td height ="100" align="center" width="350">
 <form name = "form" method="post" action="homeworkresults01.php">
 <table border="0" cellpadding="3" margin="0" align="center" cellspacing="3" bgcolor="#FFFFFF">
 <tr>
    <td width="232" colspan="2" align="center"><br>      
              <span class="Head3">Select a  Class and Section</span></td>
</tr>
     
<?
$res = runquery("select * from PT_SAT_Class_Info ORDER BY id DESC");
while($row = mysql_fetch_array($res)){
    $arr_classes[$row[id]] = "Class $row[class_name] ($row[dow] $row[class_time])";
}
putSelectInput('Class: ', 'class_id', $arr_classes, '', '', '','Choose a Class');
?>
<tr><td>
Test: </td><td> <?

just_select_test();

?>
</td></tr><tr><td>

Section: </td><td>
<input name="section_num" type="text" size="3" maxlength="3" id="section_num" />

</td></tr>
<tr>
            <td colspan="2" align="center"><br>
                <input type="submit" value="Submit" onclick="if (!document.form.class_id.value) {alert('Please select a class'); return false;}">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset">
            </td>
</tr>
        </table>
     </form> </td>
	 <td width="350">
<form action="ans_grader.php" method="post">
      <table border="0" cellpadding="3" margin="0" align="center" cellspacing="3" bgcolor="#FFFFFF">
        <tr>
          <td width="237" colspan="2" align="center"><br>
            <span class="Head3">Select A Student</span></td>
        </tr>
			<?
            select_testprep_student($student_id, 'student_id','');
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