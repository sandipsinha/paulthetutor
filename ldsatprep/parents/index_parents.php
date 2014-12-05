<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
$link_index_ldsatprep = 1;
include($strAbsPath . "/includes/.check_login.php");
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "parents", "");
$res = runquery("select * from PT_TestPrep_Reg where fid = '".$_SESSION['fid']."' GROUP BY class");
?>
<table width="100%" border="0" cellpadding="7" cellspacing="0" style="border:solid 1px #999">
  <tr height="40">
    <td class="td_header">LD SAT Prep Parents Homepage</td>
  </tr>
  <tr><td><br><br>
<?
while($row=mysql_fetch_array($res)){
	echo "<span class='Head2'><a href='ldsatpar_index.php?sat_id=".$row[id]."'>LD SAT Prep Class Number ".$row['class']." (student ".$row[student_name].")</a></span><hr>";
}
?>
<tr height=30>
    <td></td>
</tr>
</table>
<?php
put_ptts_footer("");
?>