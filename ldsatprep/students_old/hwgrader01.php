<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
include('.check_login.php');
$strTableName = "TP_SAT_Tests";
?>
<link href="../../includes/paulthetutors.css" rel="stylesheet" type="text/css" />

<form name = "form" method="POST" action="hwgrader03.php"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    

<table align="center" cellspacing="2" cellpadding="0" border="1" class=table_1>
<tr>
    <td class=td_header>Choose Section</td>
</tr>
<tr><td>

<table border="0">
<tr><td colspan="2"><BR /><BR /></td></tr>
<?
    $res = runquery("select * from $strTableName");
    //$res = runquery("select * from $strTableName");
    while($row = mysql_fetch_array($res)){
        $arr_tests[$row[id]] = $row[name];
    }
    putSelectInput('Choose Test ', 'test_id', $arr_tests, '' , '', '','Choose test');
	
?>
<tr><td width="271" align="right">Section Number: </td><td width="181" align="left">
<select name="section_num">
  <option></option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
</select>


</td></tr>
<tr><td colspan="2" class="header3" align="center"><br /><hr> <span class="Head3">-OR- </span>
<hr /><br /></td></tr>

<tr><td align="right"><strong>Official SAT Study Guide Page Number: </strong><BR />
  <span class="form_comments">Enter any page in the section</span></td><td> <input name="bb_page_num" type="text" size="4" maxlength="4" /></td></tr> 



<?
MySQL_JustForm_End("", "form","");
?>
      </table></td></tr></table></form><br>
<?php
put_ptts_footer("");
?>