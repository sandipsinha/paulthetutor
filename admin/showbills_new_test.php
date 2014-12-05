<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin", "");
?>

<table width="450" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" class=table_1>
  <tr>
    <td class=td_header>Which Family and Month's Bills</td>
  </tr>
  <tr>
    <td>
     <!-- <form method="post" action="showbillsaction_new.php"> -->
     <form method="post" action="showbillsaction_new_test.php">
        <table border="0" cellpadding="3" margin="0" cellspacing="3" width="100%" bgcolor="#FFFFFF">
         
<?
if($folder == "tutors"){ // if this page is being included by a page in the tutors folder
    putHiddenField("folder", "tutors");
    $tutor_id = $_SESSION['tutor_id'];
    putHiddenField("tid", $tutor_id );
} else {     // if this page is in the admin folder

    $QStrsi = runquery("select * from PT_Tutors ORDER BY first_name");
    while($arsi = mysql_fetch_array($QStrsi)){
        $arr_tutors[$arsi['id']] = "$arsi[first_name] $arsi[last_name]";
    }
    putSelectInput('Tutor', 'tid', $arr_tutors, '', '', '','Choose a Tutor');
}   
?> 
            
<?
put_fam_search("hidden");
//put_fam_menu("none","fid",0,"All Families");
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
<? putYearsSelect('year'); ?>

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
