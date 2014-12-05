<?php
ob_start();
include("../../includes/pttec_includes.phtml");
include("../../includes/sri_req2testsec.php");
MySQL_PaulTheTutor_Connect();
// printarray($_REQUEST);

put_ptts_header("", $strAbsPath, "", "");
?>
 <!-- <form name = "form" method="POST" action="ans_grader.php"> -->
 <form name = "form" method="POST" action="">
<?

$folder = getfolder('','','');
if($folder <> "ldsatadmin")
	include('.check_login.php');

sri_req2testsec($_REQUEST);
var_dump($_REQUEST);
$student_id = $_REQUEST[student_id];
putHiddenField("student_id", $student_id);
$student_name = get_student_name($student_id);


if(!isEmpty($test_id)){
	putHiddenField("test_id", $test_id);
	$ans_title = "Test $test_info[name] for $student_name ";
}

if(!isEmpty($section_id)){
	putHiddenField("section_id",$section_id);
	$ans_title = "Test $section_info[test_name] Section $section_info[section_num] $section_info[sec_name] for $student_name ";

}


?>

<table border="1"  align="center" cellspacing="0" cellpadding="0">
<tr>
    <td class=td_header>Enter Answers for <?=$ans_title;?></td>
</tr>
<tr valign="top"><td align="center">
<?


if(!isEmpty($section_id)){
	put_section_form($section_id,$student_id);
} else {
	put_test_form($test_id,$student_id,0);
}




?>


</td></tr>
<tr><td><input name="" type="submit" /></td></tr>
</table></form>
<?php
put_ptts_footer("");
?>
