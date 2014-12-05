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
 <form name = "form" method="post" action="getcorrectans02.php"><table border="0" cellpadding="0" align="center" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
    <td colspan="2" align="left"><br>See answers for which test?<br><span class=form_comments>If a test is not in the list, does not have all the sections completed.</span><br><br></td>
</tr>
     
<?
$res = runquery("select t.*, COUNT(s.id) as nrsec from TP_SAT_Tests t LEFT JOIN TP_SAT_Sections s ON t.id=s.test_id WHERE s.section_type!='' GROUP BY s.test_id ORDER BY t.id ASC");
while($row = mysql_fetch_array($res)){
    if ($row[num_sections]-1-($row[missing_sections] ? 1 : 0) == $row[nrsec])
        $arr_tests[$row[id]] = $row[name];
}
putSelectInput('', 'test_id', $arr_tests, '', '', '','Choose a Test');
?>
<tr>
            <td colspan="2" align="left"><br>
                <input type="submit" value="Submit" onclick="if (!document.form.test_id.value) {alert('Please select a test'); return false;}">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset">
              </td>
</tr>
        </table>
      </form></td></tr></table>
<?
put_ptts_footer("");
?>