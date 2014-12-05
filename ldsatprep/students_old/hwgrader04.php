<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");


printarray($_REQUEST);

$strTableName = "TP_HW_Answers";
$test_id = $_REQUEST[test_id];
$section_num = $_REQUEST[section_num];

$folder = getfolder('','','');
if($folder == "ldsatadmin"){
	$testprep_id = $_REQUEST[testprep_id];
} else {
	include('.check_login.php');
	$testprep_id = $x_conf_sid;
}
$student_id = NULL;
if ((!isEmpty($_REQUEST[student_id])))  $student_id = $_REQUEST[student_id];
if ((!isEmpty($x_conf_sid))) $testprep_id = $x_conf_sid;
if ((!isEmpty($_REQUEST[testprep_id]))) $testprep_id = $_REQUEST[testprep_id];

if((isEmpty($_REQUEST[student_id])) and (!(isEmpty($testprep_id)))){
	
	$sQS = "select student_id from PT_TestPrep_Reg where id = $testprep_id";
	
//	ECHO $sQS;

	$student_id = singlequery($sQS);
}

 echo "student id is $student_id and testprepid = $testprep_id<br>";



if ($test_id && $section_num){
	
// get the test's name
$res_test = runquery("select name from TP_SAT_Tests where id = $test_id");
$row_test = mysql_fetch_array($res_test);
	
?>
<link href="../../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Score Report for for <?=$row_test[name]?>, Section <?=$section_num?></td>
</tr>
<tr><td align="center" class="news_header"><br>Results</td></tr>
<tr>
<td height ="100" align="center">

 
 <br><table border="5" cellpadding="5" margin="0" align="center" cellspacing="0" bgcolor="#FFFFFF" class="table_1">   
 
 <tr><td>
<?
	show_sec_results($testprep_id,NULL,$test_id,$section_num);
	
if($folder == "ldsatadmin")
	$tps = "&testprep_id=$testprep_id";	
?>

</td></tr>
<tr>
            <td colspan="2"><br><br>
<form action="hwgrader03.php" method="post" name="more_tests">

 <input type="hidden" name="testprep_id" value="<?=$testprep_id?>">

<fieldset><legend>Grade Another Test</legend>            
            <div align="center">
<?
just_select_test($test_id);
?>  Section: <input name="section_num" type="text" value="<?=$section_num;?>" size="2" maxlength="2" />
<br /><input name="" type="submit" /> 
</div>
</fieldset> </form>           
        </td>
</tr>
   </table><br>
<?php
}
put_ptts_footer("");
?>