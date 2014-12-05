<?php
// Connect to the MySQL database
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();
reqToVars();

put_ptts_header("", $strAbsPath, "", "");

?> 


<?php

// Query the Database 
$QStr = "SELECT id, test_id, section_number, first_page, last_page FROM TP_SAT_Sections where first_page = 0 or first_page IS NULL or last_page = 0 or last_page IS NULL order by test_id, section_number";
$RS = runquery($QStr);
?>

<table>
<tbody>
<tr>

<?php 
// Print the Query
while ($arid = mysql_fetch_array($RS)){
		
		$id = $arid[0];
		$test_id = $arid[1];
		$section_number = $arid[2];
		$first_page = $arid[3];
		$last_page = $arid[4];
		echo "<tr><td>$test_id</td><td><textarea>$last_page</textarea></td></tr>";
}	     

?>

</tr>
</tbody>
</table>

<?php put_ptts_footer(""); ?>