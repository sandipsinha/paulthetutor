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
     <form method="post" action="miviram_allbills_action.php" name="form">
	    <table border="0" cellpadding="3" margin="0" cellspacing="3" width="100%" bgcolor="#FFFFFF">
        <TR>
			 <TD width="51%">
              <div align="right">Family </div>
            </TD>
            <TD width="51%">
            
<?
echo fam_menu("last","fid",0,"Choose a Family");
?>
            </TD>
</TR>
  <TR>
            <TD colspan="2">
              <div align="center">
                <input type="submit" name="Submit" value="Submit" onclick="if (!document.form.fid.value) {alert('Please select a family'); return false;}">
                <input type="reset" name="Submit2" value="Reset">
              </div>

        </table>
      </form></td></tr></table>
<?
put_ptts_footer("");
?>
