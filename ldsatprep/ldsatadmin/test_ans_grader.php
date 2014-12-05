<?php
/*******************************************************
Inputs
$answers[qid] = student_answer - if this is passed, we grade these
$test_id - if this is passed we are grading an entire test
$sections - this includes all of the sections that were passed, or the sections to be showed
$section_id -
********************************************************/
ob_start();
include("../../includes/pttec_includes.phtml");
// printarray($_REQUEST);

$student_id = $_REQUEST[ "student_id" ];
$student_id = isset( $student_id ) ? $student_id : 505;

$section_id = $_REQUEST[ "section_id" ];
$section_id = isset( $section_id ) ? $section_id : 205;

MySQL_PaulTheTutor_Connect();
$folder = getfolder('','','');
if ($folder <> 'ldsatadmin') {
//	include('.check_login.php');
}	
// $student_id = 505;//$_REQUEST[student_id];
$student_name = get_student_name($student_id);

// if answers were passed, process them
if(!isEmpty($_REQUEST[answers])){
	$answers = $_REQUEST[answers];
	$instr = process_answers($student_id, $answers);
}
// Get test and section information
req2testsec($_REQUEST);

//echo "sec and test ids are $section_id, $test_id <BR>";

// printarray($_REQUEST);

//if only a student_id is passed get all of the sections they have done
//sort by test_id or date depending on $_REQUEST[ORDER]
if (isEmpty($test_id) and isEmpty($section_id) and isEmpty($answers) and !isEmpty($student_id)){
	
	$sec_qs = "select s.id, max(a.date) from TP_Test_Questions q 
RIGHT JOIN TP_Student_Answers a ON a.student_id = $student_id and q.id = a.question_id and a.date IS NOT NULL
JOIN TP_Test_Sections s ON s.id = q.section_id 
Group BY s.id Order BY max(a.date) DESC "; 
	
	$sec_rs = runquery($sec_qs);
// echo "qs is $sec_qs <BR>";
	
	while($row = mysql_fetch_array($sec_rs)){
		$sections[$row[id]] = $row[id];
	}
}

// if a test_id is passed, get the information about the test
if(!isEmpty($_REQUEST[section_id])){ // if no test_id was passed, only a single section_id was passed
		$link[section_id] = $_REQUEST[section_id];
		$page_title = " Section $section_info[name] ";
} else { // if no section_id was passed
	if ((!isEmpty($_REQUEST[test_id]))){
		 $link[test_id] = $test_id;
		 $page_title = " Test $test_info[name] ";
	}
}

if(isEmpty($_REQUEST[test_id]) and isEmpty($_REQUEST[section_id])){
	$link[no_id] = 1;
	$page_title = "";
}

// if no sections were passed or test_id, get the sections from the answers
if(isEmpty($sections) and !isEmpty($answers)){
	$str_qids = implode(",",array_keys($answers));
	$secwhere = " where id in ($str_qids) ";
	$sections = MySQL_fillArray("section_id", "section_id", " TP_Test_Questions ", $secwhere, "section_id");
}

// end getting test and section_info
$page_title = " $student_name $page_title"; 

//put_ptts_header("Scores For $page_title", $strAbsPath, "", "");
put_ptts_header("Scores for Section $section_id", $strAbsPath, $folder, $_REQUEST['popup']);


?>
<style type="text/css">
  /** some pages have tables with widths=800px, this overwrites
  those styles and makes sure the table fits in the page**/
  table {
  	margin: 0;
  }

  .cell {
  	width: 20px;
  }
</style>

<link href="../../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />
<link href="../../includes/paulthetutors.css" rel="stylesheet" type="text/css" />

<br /><br />
<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class="td_header">Score Report for <?=$page_title?> </td>
</tr>
<tr style="background: #eee;">
<td height ="100" align="center">

 
 <br><table border="0" cellpadding="5" margin="0" align="center" cellspacing="0" bgcolor="#FFFFFF" 
 class="table_1">   
 
 
<?
//show the section for the student
// 	foreach( $sections as $section_id => $sec_num){
// 		if($link[no_id] == 1)
// 			$link[section_id] = $section_id;
// 		echo "<tr><td style=\"background: #eee;\">";
// 		show_test_sec2($student_id, $section_id, $link );
// //		echo"show_test_sc($student_id,NULL,$test_id,$section_num)";
// //		printarray($link);
// 		echo "<BR><BR></td></tr>";

// 	}

	echo "<tr><td style=\"background: #eee;\">";
	show_test_sec2($student_id, $section_id, $link );
	echo "<BR><BR></td></tr>";

if(!isEmpty($section_id)){	
?>
<tr>
            <td colspan="2"><br><br>
<form action="testans_get.php" method="post" name="more_tests">

 <input type="hidden" name="student_id" value="<?=$student_id?>">

<fieldset><legend>Grade Another Section</legend>            
            <div align="center">
<?
just_select_test($section_info[test_id]);

?>  Section: <input name="section_num" type="text" value="<?=$section_info[section_num];?>" 
size="2" maxlength="2" />
<br /><input name="" type="submit" /> 
</div>
</fieldset> </form>           
        </td>
</tr>
<? } ?>
   </table><br>
   
   
   
 <br />
<br />
<br />

<script type="text/javascript">

	// $( ".show-button" ).click( function() { 
		
	// 	var tableid = "#" + $( this ).data( "tableid" );
	// 	$( tableid ).toggleClass( "folded" );

	// 	if( $( tableid ).hasClass( "folded") )
	// 		$( this ).text( "Show all Section Tests" );
	// 	else
	// 		$( this ).text( "Hide all Section Tests" );

	// } );

</script>

<?php
if(!isEmpty($test_id)){
	show_test_results($student_id, $test_id);
?>
<br />
<a href="http://www.paulthetutors.com/ldsatprep/students/ans_grader.php?test_id=<?$test_id;?>" 
	target="_parent">Student Link to Results </a><br />
http://www.paulthetutors.com/ldsatprep/students/ans_grader.php?test_id=<?=$test_id;?>

<?
}
put_ptts_footer("");
?>