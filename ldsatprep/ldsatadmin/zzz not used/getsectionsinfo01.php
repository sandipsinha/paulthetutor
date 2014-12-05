<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",($_REQUEST[popup] ? "popup" : ""));
?>
<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Tests</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST" action="getsectionsinfo02.php"><table border="0" cellpadding="3" margin="0" align="center" cellspacing="3" bgcolor="#FFFFFF">
 <tr>
    <td colspan="2" align="center"><br>See sections for which test?</td>
</tr>
     
<?
$res = runquery("select * from TP_SAT_Tests ORDER BY id ASC");
while($row = mysql_fetch_array($res))
    $arr_tests[$row[id]] = $row[name];
putSelectInput('', 'test_id', $arr_tests, '', '', '','Choose a Test');
?>
<tr>
            <td colspan="2" align="center"><br>
                 <input type="submit" value="Submit" onclick="if (!document.form.test_id.value) {alert('Please select a test'); return false;}">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset">
              </td>
</tr>
        </table>
      </form></td></tr></table>
<?
put_ptts_footer("");
?>