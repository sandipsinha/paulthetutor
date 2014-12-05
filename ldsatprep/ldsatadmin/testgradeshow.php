<?php
/*******************************************************
Inputs
arAns[][] - two dimensional array. first key is the section_id, second is the problem number. value is the answer

********************************************************/
ob_start();
include("../../includes/pttec_includes.phtml");
$folder = getfolder('','','');
MySQL_PaulTheTutor_Connect();
if ($folder <> 'ldsatadmin') {
	include('.check_login.php');
}	

put_ptts_header("Test Results", $strAbsPath, "", "");


// printarray($_REQUEST);

$strTableName = "TP_HW_Answers";


// get all of the student information testprep_id vs. student_id
$folder = getfolder('','','');
if ((!isEmpty($_REQUEST[student_id])))  $student_id = $_REQUEST[student_id];
if ((!isEmpty($x_conf_sid))) $testprep_id = $x_conf_sid;
if ((!isEmpty($_REQUEST[testprep_id]))) $testprep_id = $_REQUEST[testprep_id];
if ((!isEmpty($_REQUEST[test_id]))) $test_id = $_REQUEST[test_id];

// echo "student_id is $student_id <BR>";

if ((!isEmpty($_REQUEST[testprep_id]))) $testprep_id = $_REQUEST[testprep_id];

if((isEmpty($_REQUEST[student_id])) and (!(isEmpty($testprep_id)))){
	$sQS = "select student_id from PT_TestPrep_Reg where id = $testprep_id";
	$student_id = singlequery($sQS);
}

	
// get the test's name
$res_test = runquery("select name from TP_SAT_Tests where id = $test_id");
$row_test = mysql_fetch_array($res_test);
$arAns = $_REQUEST[arAns];


if($_REQUEST[grade]){ //if we are supposed to grade a section
	foreach( $arAns as $section_num => $Answers){
		$section_id = singlequery("select id from TP_SAT_Sections where test_id = $test_id and section_number = $section_num");
		grade_test_section($student_id, $section_id, $Answers, $other);
//		echo " gra_act_seion($student_id, $section_id, $Answers, $other) ";
	}
}
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
 
 
<?

	if(is_null($arAns) and $test_id){
		$arAns = MySQL_fillArray("section_number", "section_number", "TP_SAT_Sections", $where = " where test_id = $test_id ", "section_number");
	}
		
	foreach( $arAns as $section_num => $Answers){
		echo "<tr><td>";
		show_test_sec($student_id,NULL,$test_id,$section_num);
//		echo"show_test_sc($student_id,NULL,$test_id,$section_num)";
		echo "</td></tr>";

	}
	
if($folder == "ldsatadmin")
	$tps = "&testprep_id=$testprep_id";	
?>
<!--
<tr>
            <td colspan="2"><br><br>
<form action="hwgrader03.php" method="post" name="more_tests">

 <input type="hidden" name="testprep_id" value="<?=$testprep_id?>">

<fieldset><legend>Grade Another Section</legend>            
            <div align="center">
<?
// just_select_test($test_id);
?>  Section: <input name="section_num" type="text" value="<?=$section_num;?>" size="2" maxlength="2" />
<br /><input name="" type="submit" /> 
</div>
</fieldset> </form>           
        </td>
</tr>
-->
   </table><br>
   
   
   
 <br />
<br />
<br />

<?php
show_test_results($student_id, $test_id);
put_ptts_footer("");
?>