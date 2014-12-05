<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$not_link_logout = 1;
include('.check_login.php');
$today = date("Y-m-d");
$student_id = singlequery("select student_id from PT_TestPrep_Reg where id = $x_conf_sid");

// echo "Student id is $student_id and sat id is $x_conf_sid<BR><BR>";

?>
<form method="post" name=form2 action="hwgrader03.php"><input type=hidden name="test_id"><input type=hidden name="section_num"></form>
<table width="100%" border="0" cellpadding="7" cellspacing="0" style="border:solid 1px #999">
  <tr height="40">
    <td class="td_header">Student Homepage </td>
  </tr>
  <tr><td><span class="Head2_Green">Hello, <?echo $x_conf_name;?></span><span> (<?echo "Not $x_conf_name?";?> <a href='login.php?logout=1'>Logout</a>)</span></td></tr>
  
<tr>
  <td><span class="news_header">Test and Homework Grader</span><br />
    - <a href="hwgrader01.php">Click Here</a> to grade a single section of a test<br />
    - <a href="satgrader.php">Click Here</a> to grade AN ENTIRE practice test<br /></td>
  </tr>
<tr>
  <td><span class="news_header">View Homework Results</span><br />
    - <a href="hwsum_student02.php">Click Here</a> to see the results are all sections<br />
  </tr>

<?
 	$SSQstr = "SELECT * FROM TP_SAT_Tests WHERE id in (Select test_id from TP_SAT_Scores where student_id= $x_conf_sid) ";
    $res = runquery($SSQstr);
	
// printRS($res);
// echo "the rs is $SSQstr<BR>";	

// if the student has completed at least one test, let them pick that test to see the results.	
	$res_num = mysql_num_rows($res); 
if ($res_num >= 1 ) {
	?>
	<tr><td>
	<span class="news_header">View Test Results</span><BR>
	View results from the following tests
	<?	
	while($row = mysql_fetch_array($res)){ ?>
		
			<a href="satscorereporter02.php?test_id=<?=$row[id];?>" target="_blank"><?=$row[name_report];?></a>
	<?
	}
}
	
			
?>
</td></tr>
<?
// if there is hw assigned for a student, or a class that the student is in, show it

$HWSQStr = "select count(*) from TP_HW_Summary WHERE class_id='$x_conf_class' or sat_id = '$x_conf_sid' order by due_date desc";
$HW1 = singlequery($HWSQStr);
if($HW1 > 0){ 
?>

  
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
    <div class="news_header" style="padding-bottom:5px">Homework Assignments</div>
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" cellpadding="2" cellspacing="0" width="100%">
  <tr style="background: #eee; height: 35px">
      <td class="text_grey" width="80"><b>Week number</b></td>
      <td class="text_grey" width="100"><b>Assigned date</b></td>
      <td class="text_grey" width="100"><b>Due date</b></td>
      <td class="text_grey"><b>Assignment</b></td>
  </tr>

  <? 
  $HWSQStr = "select * from TP_HW_Summary WHERE class_id='$x_conf_class' or sat_id = '$x_conf_sid' order by due_date desc";
  $H2RS = runquery($HWSQStr);
  
  // put all of the homework in the table
  while($row = mysql_fetch_array($H2RS)){
   echo '<tr>
       <td>'.$row['week_number'].'&nbsp;</td>
       <td>'.format_date_print($row[assigned_date],'yy-mm-dd','-','mm/dd/yy','/').'&nbsp;</td>
       <td>'.format_date_print($row[due_date],'yy-mm-dd','-','mm/dd/yy','/').'&nbsp;</td>
       <td>'.nl2br($row[assignment]).'&nbsp;</td>
   </tr>';
  }  // while
  
  ?>
  
</table>
</td>
</tr> 

<?
} // end if there is hw in the summary table put it

// check to see if there is gradeable homework for this students class or just the student.  If so, put it
$HWGQStr = "select count(*) from TP_HW_Gradable WHERE class_id='$x_conf_class' or sat_id = '$x_conf_sid' order by due_date desc";
$HW1 = singlequery($HWGQStr);
if($HW1 > 0){ 
?>  

<tr>
    <td></td>
</tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
    <div class="news_header" style="padding-bottom:5px">Gradable Homework</div>
<table border=1 cellpadding="6" cellspacing="0" class="table_1" cellpadding="2" cellspacing="0" width="100%">
  <tr style="background: #eee; height: 35px">
      <td class="text_grey" width="80"><b>Week number</b></td>
      <td class="text_grey" width="100"><b>Assigned date</b></td>
      <td class="text_grey" width="100"><b>Due date</b></td>
      <td class="text_grey"><b>Test</b></td>
      <td class="text_grey"><b>Section</b></td>
      <td class="text_grey"><b>Action</b></td>
  </tr>

<? 

$QStr = "select a.*, b.name as test_name from TP_HW_Gradable a LEFT JOIN TP_SAT_Tests b ON a.test=b.id  WHERE a.class_id='$x_conf_class' or a.sat_id='$x_conf_sid' order by a.due_date asc";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
         <td>'.$row['week_number'].'&nbsp;</td>
         <td>'.format_date_print($row[assigned_date],'yy-mm-dd','-','mm/dd/yy','/').'&nbsp;</td>
         <td>'.format_date_print($row[due_date],'yy-mm-dd','-','mm/dd/yy','/').'&nbsp;</td>
         <td>'.$row[test_name].'</td>
         <td>'.$row[section].'</td>
         <td><a style="text-decoration:underline" onclick="document.form2.test_id.value=\''.$row[test].'\'; document.form2.section_num.value=\''.$row[section].'\'; document.form2.submit() ">Enter Answers</a></td>
 </tr>';
}

?>
</table>
</td>
</tr>
<?
} // end if radable hw is entered
?>

<tr>
    <td></td>
</tr>
<tr>
  <td><span class="news_header"> Homework Grader</span>   
  <BR>
  <a href="hwgrader01.php">Click Here</a> to enter your answers for homework assigned in practice tests
  
  
  </td>
</tr>
<tr height=30>
    <td></td>
</tr>
</table>
<?php

// echo "x_conf_sid is $x_conf_sid <BR>";

put_ptts_footer("");
?>