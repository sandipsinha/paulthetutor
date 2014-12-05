<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "index");
?>
<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Gradable Homework</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="GET" action="hwgradable02.php"><table border="0" cellpadding="3" margin="0" align="center" cellspacing="3" bgcolor="#FFFFFF">
 <tr>
    <td colspan="2" align="center"><br>See gradable homework for which class?</td>
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
      </form></td></tr></table>
<?
put_ptts_footer("");
?>