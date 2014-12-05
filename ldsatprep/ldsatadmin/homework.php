<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "index");
?>

<table border="1" cellspacing="2" cellpadding="0" width="100%" class="table_1">
  <tr>
    <td class="td_header">LDSATPREP Admin Home</td>
  </tr>
  <tr>
    <td align="center"><br>
      <table width="100%" border="0" height="" cellpadding="7" margin=0 cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td><a href="gethwsum.php" style="font-weight:bold">Add Homework Summary</a></td>
        </tr>
         <tr>
          <td><a href="hwsum.php" style="font-weight:bold">View Homework Summary</a></td>
        </tr>
         <tr>
          <td><a href="gethwgradable.php" style="font-weight:bold">Add Gradable Homework</a></td>
        </tr>
         <tr>
          <td><a href="hwgradable.php" style="font-weight:bold">View Gradable Homework</a></td>
        </tr>
      </table><br>
    </td>
  </tr>
</table>
<?
put_ptts_footer("");
?>