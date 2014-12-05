<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
include('.check_login.php');
$strTableName = "TP_SAT_Tests";
?>
<link href="../../includes/paulthetutors.css" rel="stylesheet" type="text/css">


<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=Head1_Green>Class Videos </td>
</tr>
<tr><td>
    <p><span class="Head2">Class 1: March 20th</span>    <br>
      No Video Available
  </p>
    <p><span class="Head2">Class 2: March 27th</span><br>
      <a href="session%2020%20class%201%202011.03.28.mp4">Part 1</a><br>
      <a href="session%2020%20class%201B%202011.03.28.mp4">Part 2</a><br>
      <br> 
      </p></td>
</tr>


</table>
<br>
<?php
put_ptts_footer("");
?>