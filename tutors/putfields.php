<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

include($strAbsPath . "/includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();


put_ptts_header("", $strAbsPath, "tutors", "");
?>

<table width="600" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" bordercolor="#996600">
  <tr> 
    <td height="53"><span class="pageheader">Please Enter Your Information</span></td>
  </tr>
  <tr>
    <td>
      <table border="0" height="" cellpadding="3" margin=0 cellspacing="3" width="100%" bgcolor="#FFFFFF"><TR><TD>
        
<?php

/*
$arMandFields are all manditory fields (usually blank and found automatically)
$strNotUsed is string of fields not to be used (if any exist, they are sent as a hidden fiels from the GET page)
$tdStyle is style used for each column (usually blank)
*/


	$tester = InsertFields($strTableName, $HTTP_POST_VARS, $arMandFields, $strNotUsed, $tdstyle);


?>
 
The Information has been entered. 
</td></TR></table>
    </td>
  </tr></table>
<?
  put_new_footer();
?>