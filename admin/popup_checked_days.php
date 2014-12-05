<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "popup");
$date = $_REQUEST['date'];
$arr_tutors = "(".$_REQUEST['arr_tutors'].")";
?>
<table cellspacing="0" cellpadding="0" width="100%">
<tr><td><fieldset>  
<legend>Checked Days Info for date <?=format_date_print($date)?></legend>  
<table border="0" cellpadding="0" cellpadding="0" >
<?php
if(isset($date)){
	$res = runquery("SELECT t.*, c.checked FROM PT_Tutors t LEFT JOIN PT_Checked_Day c ON (t.id=c.tid AND c.date='".$date."') OR c.tid is NULL WHERE t.id IN ".$arr_tutors);
	while($row = mysql_fetch_array($res)){
		echo '<tr>
					<td>'.$row['first_name'].' '.$row['last_name'].':&nbsp;&nbsp;</td>
					<td><b>'.($row['checked'] == 1 ? "CHECKED" : "<font color=red>UNCHECKED</font>").'</b></td>
		     </tr>';
	}
}
?>
</td>
</tr>
</table>
</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
 <div align="center"><button onclick="popup_close()">Close</button></div>
</fieldset></td>
</tr> 
</table>
<?
put_ptts_footer("popup");
?>