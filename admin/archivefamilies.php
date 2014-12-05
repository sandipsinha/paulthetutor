<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Archive Records for Paul The Tutor's", $strAbsPath, "admin", "");
$move_id = $_REQUEST['move_id'];

$tablename = "PT_Family_Info";
$tablename_archive = "ZZ_PT_Family_Info_Old";
$tablename_students = "PTStudentInfo_New";
$tablename_students_archive = "ZZ_PTStudentInfo_Archive";
If(!(empty($move_id))){
	foreach ($move_id as $k=>$v){
		$ret = zz_archive_data($v,$tablename,$tablename_archive);
		if ($ret == 1){
			$res = runquery("SELECT id FROM $tablename_students WHERE fid='".$v."'");
			while($row = mysql_fetch_array($res)){
				 	zz_archive_data($row[id],$tablename_students,$tablename_students_archive);
				}
			}
		}
}
?>



<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Archive Data</td>
  </tr>
  <tr>
    <td height="65" valign="top" bgcolor="#FFFFFF">      <form name="form1" method="post" action="archivefamilies.php">
        <table border=1 width="100%" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
		<tr><td width="10%">&nbsp;<strong>Archive</strong></div></td>
		<td width="90%">&nbsp;<strong>Family</strong></div></td>
		</tr>
<? 


$QStr = "select id, main_name, students from $tablename order by id";
$iRS = mysql_query($QStr);
while($iAR = mysql_fetch_row($iRS)){
//start and new row and put the check box with the value of the id
	$temp_id = $iAR[0];
	echo "<tr><td align=\"center\"> <input name=\"move_id[$temp_id]\" type=\"checkbox\" value=\"$temp_id\"></td><td>";
	while (list ($key, $value) = each($iAR)){
		echo "$value &nbsp;";
	}
	echo "</td></tr>";
}	
?>
<tr><td colspan="2" align="center">   <input name="" type="submit" value="Submit">
  &nbsp;&nbsp;&nbsp;
  <input type="reset" name="Reset" value="Reset"></td>
</tr>
<tr><td colspan="2">
<a href="returnfamilies.php">Retreive a Family from the Archive</a>
</td>
</tr>	
</table>

	
		</form> 



</table>
<?
put_ptts_footer("");
?>
