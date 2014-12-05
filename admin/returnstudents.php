<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Recover Records for Paul The Tutor's", $strAbsPath, "admin", "");
$move_id = $_REQUEST['move_id'];
$tablename = "PTStudentInfo_New";
$tablename_archive = "ZZ_PTStudentInfo_Archive";
if(count($move_id)){
	foreach ($move_id as $k=>$v) 
		zz_restore_archive_data($v,$tablename,$tablename_archive);
}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height="40">
    <td class="td_header">Recover Archived Data</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><form name="form1" method="GET">
        <table border=1 width="100%" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
         <tr height=25>
  		 	<td colspan="2">&laquo;<a href="studentinfo.php" style="text-decoration:none">See Students List</a></td>
 		 </tr>
		<tr><td><div><strong>&nbsp;Recover</strong></div></td>
		<td><div><strong>&nbsp;Student ID</strong></div></td>
		<td><div><strong>&nbsp;Student</strong></div></td>
		<td><div><strong>&nbsp;Family Id</strong></div></td>
		</tr>
<? 

$QStr = "select *  from $tablename_archive ORDER BY TRIM(first_name) ASC";
$iRS = mysql_query($QStr);
while($iAR = mysql_fetch_array($iRS)){
	$temp_id = $iAR[id];
	echo "<tr><td> <input name=\"move_id[$temp_id]\" type=\"checkbox\" value=\"$temp_id\"></td>
	<td>".$iAR['old_id']."</td>
	<td>".$iAR['first_name'].' '.$iAR['lastt_name']."</td>
	<td>".$iAR['fid']."</td>
	</tr>";
}	
?>
<tr><td colspan="4" align="center">   <input name="" type="submit" value="Recover Data">
  &nbsp;&nbsp;&nbsp;
  <input type="reset" name="Reset" value="Reset"></td>
</tr>

</table>

		
		</form> 
</table>
<?
put_new_footer();
?>
