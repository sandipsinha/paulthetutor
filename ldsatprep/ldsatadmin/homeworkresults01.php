<?php
if($_REQUEST[class_id] == 1) {
?>
<html>
<head>
<META HTTP-EQUIV="refresh" CONTENT="0; url=homeworkresultsall.php?class_id=1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	
	If you do not get redirected <a href="index.php">click here</a></body>
<? 
die();
} // end if it's a one on one student
	
ob_start();
include("../../includes/pttec_includes.phtml");
// printarray($_REQUEST);

MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$strTableName = "TP_HW_Gradable";
$class_id = $_REQUEST['class_id'];
if ($class_id){
?>

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Choose Homework</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST" action="homeworkresults02.php"><input type="hidden" name="class_id" value="<?php echo $class_id?>"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    
<?
    $res = runquery("select a.*, b.name_report as test_name from $strTableName a LEFT JOIN TP_SAT_Tests b ON a.test=b.id WHERE a.class_id='".$class_id."' ORDER BY a.due_date DESC");
    while($row = mysql_fetch_array($res)){
        $arr_homeworks[$row[test]."|".$row[section]] = $row[test_name].", Section ".$row[section].", Due date: ".format_date_print($row[due_date],'yy-mm-dd','-','mm/dd/yy','/');
    }
    putSelectInput('Choose Homework ', 'homework_id', $arr_homeworks, '' , '', 'required','Choose Homework');
?>
<tr>
            <td colspan="2" align="center"><br>
            or <a href="homeworkresultsall.php?class_id=<?=$class_id?>">View all homework for a student</a><br><br>
              </td>
</tr>
<?
MySQL_JustForm_End(array("homework_id" =>"Homework"), "form","");
?>
      </form></td></tr></table><br>
<?php
put_ptts_footer("");
}
?>
