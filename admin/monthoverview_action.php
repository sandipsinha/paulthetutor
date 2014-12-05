<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$titlestring = "Monthly Overview";
$month = $_REQUEST[month];
$year = $_REQUEST[year];
put_ptts_header($titlestring, $strAbsPath, "admin", $_REQUEST["popup"]);

?>
<table width="100%" border="0" height="0" cellpadding="0" margin="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
	    <td class=td_header><?=$titlestring; ?></td>
	  </tr>
<tr>
  <td>    
<?php 	month_overview($month,$year,$tid);?>	  
	</td>
</tr>
</table>

<?
put_ptts_footer($_REQUEST["popup"]);
?>