<?php
$strBack = "../";  //if this page is in a subdirectory, the strBack is "../" so we look back a folder in links.
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

include($strAbsPath . "/includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();


putPTTHeader("PaulTheTutor.com", $strBack);

?>
<link rel="stylesheet" href="/styles/paulthetutor.css" type="text/css"> 
<table width="450" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" bordercolor="#996600">
  <tr>
    <td height="53"><span class="pageheader">Look at the Calendar For What Month </span></td>
  </tr>
  <tr>
    <td>
     <form method="GET" action="calendar_action.php">
	    <table border="0" cellpadding="3" margin="0" cellspacing="3" width="100%" bgcolor="#FFFFFF">
          <TR>
            <TD width="51%">
              <?
$QStrsi = "select students, billing_name, id from PT_Family_Info";
if(!($siRS = mysql_query($QStrsi))){
	echo "QStr:  $QStrsi <BR>" . mysql_error() . "<BR><BR>";
}

$arsis[0] = "All";

while($arsi = mysql_fetch_array($siRS)){
	$arsis[$arsi[id]] = "$arsi[billing_name] ($arsi[students])";
}


putSelectInput('Student', 'fid', $arsis, '', '', 'required');
?>
          <TR>
            <TD width="51%">
              <div align="right">Month </div>
            <TD width="49%">
<? putMonthsSelect('month'); ?> </td> </tr>
          <TR>
            <TD width="51%">
              <div align="right">Year </div>
            <TD width="49%">
<? putYearsSelect(year); ?>

</td></tr><TR>
            <TD colspan="2">
              <div align="center">
                <input type="submit" name="Submit" value="Submit">
                <input type="reset" name="Submit2" value="Reset">
              </div>

        </table>
      </form></td></tr></table>
<?
put_ptts_footer("");
?>
