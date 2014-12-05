<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");

printarray($_REQUEST);

$folder = getfolder('','','');
if ($folder == 'students') {
	include('.check_login.php');
}	
define('ENG',1);
define('MATH',2);
define('READ',3);
define('SCI',4);

$secs = array(1 => "English","Math","Reading","Science","Essay");

if($_REQUEST[section_num]){
	$section_num = $_REQUEST[section_num];
	$start = $section_num;
	$end = $section_num;
	$end_sa = $section_num;
} else {
	$start = 1;
	$end = 4;
	$end_sa = 5;
}


// printarray($_REQUEST);
if ($x_conf_sid){
	$student = $x_conf_sid;
	$student_id = singlequery("select student_id from PT_TestPrep_Reg where id = $x_conf_sid");
} 
	
if($_REQUEST[student_id]){
	$student_id = $_REQUEST[student_id];
}

if($_REQUEST[test_id]){
	$test_id = $_REQUEST[test_id];
	$testname = singlequery("select name from TP_SAT_Tests where id = $test_id");

	if($student_id){
	// if the student_id is set then get any answers for that test and that student
		
		for($i = $start; $i <= $end; $i++){
			$where = " where student_id = $student_id and section_id IN (select id from TP_SAT_Sections where test_id = $test_id and section_number = $i) ";
			
echo "where is $where <BR>";
			
			$answers[$i] = MySQL_fillArray("problem", "answer", "TP_HW_Answers",$where);
		}
	}
	
}

?>
<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 16px;
}
.nowrap {
	white-space: nowrap;
}
-->
</style>



<table border="2" cellspacing="2" cellpadding="2" width="750" bgcolor="#996600" bordercolor="#996600">
  <tr>
    <td  align="center" height="53"><span class="style2">Insert Answers <?=$title_string;?> 
      <BR>
    </span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td  bgcolor="#FFFFFF" align="center">

<? // determine the form action by wether the test_id is set
	if($_REQUEST[test_id]) {
		$action =  "action = actgradeshow.php";
	} else {
		$action = "";
	}
?>  
  
<form name="form1" method="post" <?=$action;?>>
	 <input name="grade" type="hidden" value=1>
	    <BR>
	    &nbsp;
		<table border="2" bordercolor="#000000" cellpadding="3" margin="0" cellspacing="0" bgcolor="#FFFFFF">
	      <tr><td align="center" colspan="5">
          <table border="0">
          
<? 
$sid_check = "";
$folder = getfolder('','','');
if( $folder == 'admin' or $folder == 'ldsatadmin' ){
	put_student_search ("drop","student_id",  $student_id);
	$sid_check = "frmvalidator.addValidation(\"student_id\",\"req\",\"You must select a student\")";

}
?>
<tr><td align="right">Test: </td><td align="left">
<?
just_select_act($test_id); 

echo "</td></tr></table></td></tr>";


$num[1] = 75;
$num[2] = 60;
$num[3] = 40;
$num[4] = 40;


if($_REQUEST[test_id]) { // if a test has been selected, we put this info
		  
	echo "<div class=\"test_table\">";
	for($i = $start; $i <= $end_sa; $i++){
		echo "<TD width=\"70\"><div align=\"center\"><strong> $secs[$i] </strong></div></TD>";
		
	}
	
	?>
	</tr>    <tr>     
	 <? 
	//get all of the scores for this test for this student
	
	$essay_score = singlequery("SELECT essay_score FROM TP_ACT_Scores WHERE student_id='".$student_id."' AND test_id='".$test_id."' order by id DESC LIMIT 1");
	for($j=$start; $j <= $end; $j++){
		$num[$j] = singlequery("select num_questions from TP_SAT_Sections where test_id = $test_id and section_number = $j");

	?> 
	
	
	
	<td valign="top" align="center">
	<?
	for ($i=1; $i <= $num[$j]; $i++){
		echo "<span class=\"nowrap\"><strong>$i. </strong>";
		?>
		  <input name="arAns[<?=$j;?>][<?=$i;?>]" type="text" value="<?=$answers[$j][$i];?>" size="2" maxlength="1" /></span><br /><br />
		<? } //for i ?>
	</td>
	<? }// for j ?>
	
	<td valign="top" align="center">Essay <br />
	  Score <br />
	(0-6) <br />
	<input name="essay_score" type="text" size="4" maxlength="1" value="<?=$essay_score;?>" /></td>
					   
			  </tr>
<? } // only put this table if the test has been selected
?>
          <TR>
            <TD colspan="5">
              <div align="center">
                <input type="submit" name="Submit" value="Submit">
                <input type="reset" name="Submit2" value="Reset">
              </div>
			</td></tr>
        </table>&nbsp;&nbsp;
      </form></td></tr></table>
      
	
<script language="JavaScript" type="text/javascript">
 var frmvalidator = new Validator("form1");
<?=$sid_check;?>
frmvalidator.addValidation("test_id","req","You must select a test");
</script>
    
      
<?


put_ptts_footer("");
?>
