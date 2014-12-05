<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Recover Records for Paul The Tutor's", $strAbsPath, "admin", "");
$move_id = $_REQUEST['move_id'];
$tablename = "PT_Family_Info";
$tablename_archive = "ZZ_PT_Family_Info_Old";
$tablename_students = "PTStudentInfo_New";
$tablename_students_archive = "ZZ_PTStudentInfo_Archive";
if(count($move_id)){
	foreach ($move_id as $k=>$v){ 
		$ret = zz_restore_archive_data($v,$tablename,$tablename_archive);
		$res_old_id = runquery("SELECT old_id FROM $tablename_archive WHERE id='".$v."'");
		$row_old_id = mysql_fetch_array($res_old_id);
		$old_id = $row_old_id[old_id];
		if ($ret == 1){
			$res = runquery("SELECT id FROM $tablename_students_archive WHERE fid='".$old_id."'");
				while($row = mysql_fetch_array($res)){
				 		zz_restore_archive_data($row[id],$tablename_students,$tablename_students_archive);
				}
			}
		}
}

?>



<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height="40">
    <td class="td_header">Recover Archived Data</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><form name="form1" method="GET" action="returnfamilies.php">
        <table border=1 width="100%" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
         <tr height=25>
  		 	<td colspan="2">&laquo;<a href="families.php" style="text-decoration:none">See Family List</a></td>
 		 </tr>
		<tr><td><div><strong>&nbsp;Archive</strong></div></td>
		<td><div><strong>&nbsp;Family</strong></div></td>
		</tr>
<? 

$QStr = "select id,old_id, main_name, students,TRIM(SUBSTRING_INDEX(main_name, ' ', -1)) as last_name, SUBSTRING_INDEX(main_name, ' ', 1) as first_name  from ZZ_" . $tablename . "_Old ORDER BY TRIM(last_name) ASC";
$iRS = mysql_query($QStr);
while($iAR = mysql_fetch_array($iRS)){
//start and new row and put the check box with the value of the id
	$name = ""; $a = array();

		$a = explode(" ", trim($iAR[main_name]));

		$a = array_reverse($a);

		foreach ($a as $m=>$n){

			if ($a!='')

				$name.= trim($n).($m == 0 ? ", " : "");

		}
	$temp_id = $iAR[id];
	echo "<tr><td> <input name=\"move_id[$temp_id]\" type=\"checkbox\" value=\"$temp_id\"></td><td>";
	echo $iAR['old_id'].' '.$name.' ('.$iAR['students'].')';
	echo "</td></tr>";
}	
?>
<tr><td colspan="2" align="center">   <input name="" type="submit" value="Submit">
  &nbsp;&nbsp;&nbsp;
  <input type="reset" name="Reset" value="Reset"></td>
</tr>

</table>

		
		</form> 
</table>
<?
put_new_footer();
?>
