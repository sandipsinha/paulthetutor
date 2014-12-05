<?php
ob_start();
include("../../includes/pttec_includes.phtml");

if($_REQUEST[test_id] == 37){
	$folder = getfolder('','','');
	$linkadd = '';
	if($folder == 'ldsatadmin')
		$linkadd = "&ldsat_sid=$_REQUEST[ldsat_sid]";
	header("Location: satdiaggrader02.php?test_id=$_REQUEST[test_id]$linkadd");

}

MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
if ($x_admin <> 1) {
	include('.check_login.php');
}	
reqToVars();
// printarray($_REQUEST);
if ($x_conf_sid)
	$student = $x_conf_sid;
else
	$student = $_REQUEST['ldsat_sid'];
$testid = $_REQUEST['test_id'];


$res_name = runquery("SELECT student_name,class FROM PT_TestPrep_Reg WHERE id='".$student."' LIMIT 1");
$row_name = mysql_fetch_array($res_name);
$student_name = $row_name['student_name'];
$class_name = 'Class '.$row_name['class'];
// get the test's name
$TQStr = "select name from TP_SAT_Tests where id = $testid";
$TRS = runquery($TQStr);
$testAR = mysql_fetch_array($TRS);
$testname = $testAR[0];

// if there are answers to put into the database, put them.
if($answers == 1) {
	for($i = 1; $i <= $numas; $i++){
		$tempA = $answer[$i];
		$IQS = "INSERT into `TP_SAT_Questions` (`section_id`, `test_id`, `number`, `answer`) values ($ent_sec, $testid, $i, '$tempA')";
		//echo "$IQS <BR>";
		runquery($IQS);
		
	} // end inputing answers	

	echo "<strong> Your answers were submitted for section $ent_sec </strong><BR><BR>";
	
	// not that answerrs have been submitted for the test and section
	$UQS = "Update TP_SAT_Sections set answers_stored = 1 where test_id = $testid and section_number = $ent_sec";
	// echo "$UQS <BR>";
	runquery($UQS);
	 	
	
} // end if there are answers to input	



//get the name of the test
$TQStr = "select name from TP_SAT_Tests where id = $testid";
$TRS = runquery($TQStr);
$testAR = mysql_fetch_array($TRS);
$testname = $testAR[0];

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
    <td  align="center" height="53"><span class="style2">Insert Answers for <?=$student_name.' ('.$class_name.')';?> on  
      <?=$testname;?> 
      <BR>
    </span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td  bgcolor="#FFFFFF" align="center">
<form method="post" action="satgrader03.php">
	 <input name="testid" type="hidden" value="<?=$testid;?>">
	 <input name="student" type="hidden" value="<?=$student;?>">
	    <BR>&nbsp;&nbsp;
		<table border="2" bordercolor="#000000" cellpadding="3" margin="0" cellspacing="0" bgcolor="#FFFFFF">
	      <TR> <TD width="70"><div align="center"><strong>Section 1</strong></div></TD>
<? 
$SecCompQS = "select section_number as 'sec', num_questions as 'qs', student_produced_response as 'spr' from TP_SAT_Sections where test_id = $testid order by section_number";
// echo "$SecCompQS <BR>";
$SCRS = runquery($SecCompQS);

while($sec = mysql_fetch_array($SCRS)){ //go through the array and put a header for each section         
?>		   
		 <TD width="70"><div align="center"><strong>Section <?=$sec['sec'];?></strong></div></TD>
 <? 
} // end while.  Header for each section is placed.

$res_essay_score = runquery("SELECT essay_score FROM TP_SAT_Scores WHERE student_id='".$student."' AND test_id='".$testid."' LIMIT 1");
$row_essay_score = mysql_fetch_array($res_essay_score);
$essay_score = $row_essay_score['essay_score'];
?> </tr><tr>

<td valign="top" align="center"> Essay <BR>Score <BR> 
(0-6) <BR>
<input name="essay_score" type="text" size="4" maxlength="1" value="<?php echo $essay_score?>">    </td>


<?

mysql_data_seek($SCRS,0); // reset the record set of the sectional information
$numsecs = 0;
while($sec = mysql_fetch_array($SCRS)){ //go through the array and put input tables         
 	?> <td valign="top" align="center"> <?
	$numsecs = $numsecs + 1;
	$numqs = $sec['qs'];
	$spr = $sec['spr'];
	if(!($spr)) $spr = $numqs +1; //set spr equal to numqs if there are no spr questions so that none of the q's will be spr
	$secnum = $sec['sec'];
	 for($i=1; $i <= $numqs; $i++){ //get values for each questions
		$chq = "select checkable from TP_SAT_Questions where section_id = $secnum and test_id = $testid and number = $i";
		$chbl = singlequery($chq);
		
		$res_found = runquery("SELECT id,answer FROM TP_SAT_Answers WHERE sid='".$student."' AND test='".$testid."' AND section='".$secnum."' AND problem='".$i."' LIMIT 1");
		$row_found = mysql_fetch_array($res_found);
		
		if($i < $spr) {
			?> <span class="nowrap"><?=$i;?> &nbsp;<input name="answer[<?=$secnum;?>][<?=$i;?>]" type="text" size="1" maxlength="1" value="<?php echo $row_found['answer']?>"></span><BR><BR>
		<? } else { ?>
			 <span class="nowrap"><?=$i;?> &nbsp;<input name="answer[<?=$secnum;?>][<?=$i;?>]" type="text" size="6" maxlength="20" value="<?php echo $row_found['answer']?>"></span><BR>
			<? if($chbl == 'no') { // if the problem is not checkable by the computer
					$aq = "select answer from TP_SAT_Questions where section_id = $secnum and test_id = $testid and number = $i";
					$ans = singlequery($aq);
					
					echo "<span class=\"nowrap\">Computer can not Grade this.<BR>Mark as correct, wrong or blank<BR> Answer:<BR>$ans<BR>"; ?>
					
					<select name="answer[<?=$secnum;?>][<?=$i;?>]">
					  <option value="">&nbsp;</option>
					  <option value="correct">correct</option>
					  <option value="wrong">wrong</option>
					  <option value="blank">blank</option>
					</select><BR>
			<? } // end if it is not checkable
			echo "<BR>";
 			} //end else
		
		} //end for ?>	  
    </td>
<? } // end while ?>	
				   
          </tr>

          <TR>
            <TD colspan="<?=$numsecs;?>">
              <div align="center">
                <input type="submit" name="Submit" value="Submit">
                <input type="reset" name="Submit2" value="Reset">
              </div>
			</td></tr>
        </table>&nbsp;&nbsp;
      </form></td></tr></table>
	  
<?
put_ptts_footer("");
?>
