<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin", "");
?>

<table width="450" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" class=table_1>
  <tr>
    <td class=td_header>Please Enter the Information</td>
  </tr>
  <tr>
    <td>
     <form method="post" action="monthoverview_action.php">
	    <table border="0" cellpadding="3" margin="0" cellspacing="3" width="100%" bgcolor="#FFFFFF">
      
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
