<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Recover Records for Paul The Tutor's", $strAbsPath, "admin", "");
$move_id = $_REQUEST['move_id'];


$tablename = "PT_Tutors";
if(!(isEmpty($move_id))){ 
	$MQStr = "select * from ZZ_" . $tablename . "_Archive where id=$move_id";
	$MRS = mysql_query($MQStr);
	while($MAR = mysql_fetch_assoc($MRS)){
		foreach($MAR as $k=>$v)
			$MAR[$k] = addslashes($v);
		$MAR["id"] = $MAR["tutor_id"];
		unset($MAR["tutor_id"]); unset($MAR["archive_date"]);    
		$MARk = array_keys($MAR);
		$cols = implode(",",$MARk);
		$vals = implode("', '",$MAR);
		
		$MQStr = "Insert into $tablename ($cols) Values ('$vals')";
		
		if(mysql_query($MQStr)){
			echo "<div class=text_success style='text-align:center'>Record $MAR[tutor_id] has been recovered</div>";
			mysql_query("DELETE FROM ZZ_" . $tablename . "_Archive where id=$move_id");               
		} else {
			echo "didn't work ";
			echo "<BR>" . mysql_error();
		}	
		// if the query works
	} // while goes through people to be archived
} // if anyone is to be archived

?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class=td_header>Recover Archived Data</td>
  </tr>
    <tr>
    <td valign="top" bgcolor="#FFFFFF">
    <form name="form1" method="post">
    	<input type=hidden name=move_id>
    	<input type=submit style="display: none"> 
        <table border=1 width="100%" cellspacing="0" class="table_1" align="center" cellpadding="6" cellspacing="0">
<? 

$QStr = "select * FROM ZZ_" . $tablename."_Archive";
$iRS = mysql_query($QStr);
if (mysql_num_rows($iRS)){
	?>
		<tr style="font-weight:bold">
			<td>&nbsp;Tutor</td>
			<td>&nbsp;Email</td>
			<td>&nbsp;Phone</td>
			<td>&nbsp;Archive Date</td>
			<td>&nbsp;Recover</td>                     
		</tr>
<?
while($row = mysql_fetch_array($iRS)){
//start and new row and put the check box with the value of the id
	$temp_id = $row[id];
	echo "<tr>";
    echo "<td>".$row[first_name].' '.$row[last_name]."</td>
         <td>".$row[email]."</td>
          <td>".$row[mobile_phone]."</td>
          <td>".date("m/d/Y",strtotime($row[archive_date]))."</td>
          <td align=center><a href=#void onclick=\"if(confirm('Are you sure you want to recover this tutor?')){document.form1.move_id.value='$temp_id'; document.form1.submit()}\"><img src='../images/check.gif' border=0></td>";          
	echo "</tr>";
}	
?>
<?}
else echo '<tr>
			<td>No records</td>
           </tr>';
?>

</table>

		
		</form> 
</table>
<?
put_ptts_footer("");
?>
