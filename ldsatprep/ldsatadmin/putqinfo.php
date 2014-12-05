<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

// printarray($_REQUEST);
$_REQUEST[section_id] = NULL;
req2testsec($_REQUEST);

$section_id = $_REQUEST[section_id];

$iqs = "insert into TP_Test_Questions (section_id, test_id, question_num, answer, spr, checkable) values ";
$correct_answer = $_REQUEST[correct_answer];
foreach($correct_answer as $sec_id => $answers) {
	foreach($answers as $q_num => $answer) {
			$iqs .=  " 
			( $sec_id, $test_id, $q_num, '$answer', 0, 'yes' ), ";
	}

}
$iqs = substr($iqs, 0, -2);
runquery($iqs);

put_ptts_header("Test $test_id Information Complete", $strAbsPath, "", "");
?>
<link href="../../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />
<table width="50%" cellspacing="2" cellpadding="3" class=table_1>
<tr>
    <td class=td_header>Test Information Entered <?=$ans_title;?></td>
</tr>
<tr><td>
What would you like to do now?
<ul><a href="gettestinfo.php">Enter information about another test</a>
</ul>
<ul><a href="index.php">Go to Test Prep Admin Homepage</a>
</ul>




