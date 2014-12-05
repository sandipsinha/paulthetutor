<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin", "");
?>

<table width="450" border="2" cellspacing="2" cellpadding="0" class=table_1>
  <tr>
    <td class="td_header">Which Bills Shall We Send?</td>
  </tr>
  <tr>
    <td>
     <form method="post" action="sendbillsaction_new.php">
      <table border="0" cellpadding="3" margin="0" cellspacing="3" width="100%" bgcolor="#FFFFFF">
          <TR>
            <TD>
        <div align="right">Family
          </div></td>
      <td>&nbsp;
      <?


      put_fam_search("last", "fid", 0, "Select Family");
//      put_fam_menu("last", "fid", 0, "Select Family");
      ?>
      </td>
      </tr>
              <?
$QStrsi = runquery("select * from PT_Tutors ORDER BY first_name");
while($arsi = mysql_fetch_array($QStrsi)){
  $arsis[$arsi[id]] = "$arsi[first_name] $arsi[last_name]";
}
putSelectInput('Tutor', 'tid', $arsis, '', '', '','Choose a Tutor');
?>
          <TR>
            <TD width="51%">
              <div align="right">Month </div>
            <TD width="49%">&nbsp;
<? putMonthsSelect('month'); ?> </td> </tr>
          <TR>
            <TD width="51%">
              <div align="right">Year </div>
            <TD width="49%">&nbsp;
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
put_new_footer();
?>
