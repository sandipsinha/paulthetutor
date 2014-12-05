<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
if ($x_admin <> 1) {
	include('.check_login.php');
}	
$strTableName = "TP_SAT_Tests";
?>

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Choose Test</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST" action="<?php echo (!$x_conf_sid || $x_admin ? "satgrader01.php" : "satgrader02.php")?>"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    
<tr>
    <td colspan="2" align="left"><br>Choose a Test</td>
</tr>
     
<?
$res = runquery("select t.*, COUNT(s.id) as nrsec from TP_SAT_Tests t LEFT JOIN TP_SAT_Sections s ON t.id=s.test_id WHERE s.section_type!='' GROUP BY s.test_id ORDER BY t.pick_order DESC, t.id ASC");
while($row = mysql_fetch_array($res)){
    if ($row[num_sections]-1-($row[missing_sections] ? 1 : 0) == $row[nrsec])
        $arr_tests[$row[id]] = $row[name];
}
putSelectInput('', 'test_id', $arr_tests, '', '', '','Choose a Test');

MySQL_JustForm_End(array("test_id" =>"Test"), "form","");
?>
      </form></td></tr></table><br>
<?php
put_ptts_footer("");
?>