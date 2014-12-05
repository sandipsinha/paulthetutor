<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/paulthetutors_com/includes/.check_login.php");
require_once($strAbsPath . "/paulthetutors_com/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Record Info", $strAbsPath, "",'popup');

$strTable = $_SESSION[strTable];
$get_id = $_GET[hidden_id];

$QStr = "select * from $strTable where id = $get_id";
$showRS = runquery($QStr);
$temparray = mysql_fetch_assoc($showRS);


?> 
<fieldset>  
<legend>Record Info</legend>  

<table width="500" border="3" bordercolor="#000000" cellspacing="0" cellpadding="3">
<?
	while(list($key,$value ) = each($temparray)){
		if(isEmpty($value)) $value = "&nbsp;";
		$key = setDisplayFieldVals($key);

	
	
		echo "<tr><td>$key  </td><td>$value</td></tr> ";
	}
?>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>
</fieldset> 
<fieldset class="submit">  
<button onclick="popup_close()">Closed</button>
</fieldset> 
<?
put_ptts_footer("popup");
?>

