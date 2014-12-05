<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "index");
?>
<link href="../../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />
 <form name = "form" method="GET" action="hwsum02.php">

<table border="1" bordercolor="#000000"  width="100%"  align="center" cellspacing="0" cellpadding="0" >
<tr>
    <td colspan="2" class=td_header>Homework Summary</td>
</tr>
<tr>
<td>

 <table border="0" cellpadding="3" margin="0" align="center" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
    <td colspan="2" align="center"><br>
      <span class="Head3">Select A Class</span></td>
</tr>
     
<?
$res = runquery("select * from PT_SAT_Class_Info ORDER BY id DESC");
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

      </td>
	 <td width="350">

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
      
      
      
      </tr></table>
      </td></tr></table>  
</form>    
<?
put_ptts_footer("");
?>