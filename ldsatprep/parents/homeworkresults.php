<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
if (!stristr($_SERVER[REQUEST_URI],'admin'))
	include($strAbsPath . "/includes/.check_login.php");
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$strTableName = "TP_HW_Answers";
put_ptts_header("", $strAbsPath, "parents", "");
if (!$test_id)
	$test_id = $_REQUEST[test_id];
$res_test = runquery("select name from TP_SAT_Tests where id = '$test_id'");
$row_test = mysql_fetch_array($res_test);
if ($_REQUEST[sat_id])
	$sat_id = $_REQUEST[sat_id];
else
	$sat_id = $_SESSION['sat_id'];
if ($_REQUEST[sat_class_id])
	$class_id = $_REQUEST['sat_class_id'];
else
	$class_id = $_SESSION['sat_class_id'];
$res_student = runquery("select * from PT_TestPrep_Reg where id = '".$sat_id."' LIMIT 1");
$row_student = mysql_fetch_array($res_student);
?>
<table width="100%" border="0" cellpadding="7" cellspacing="0" style="border:solid 1px #999">
  <tr height="40">
    <td class="td_header">Score reporter for <?=$row_student[student_name]." on ".$row_test[name]?></td>
  </tr>

 <?
 $math_score = getSecRawScore_New($test_id, $sat_id, "math");
 $reading_score = getSecRawScore_New($test_id, $sat_id, "reading");
 $writing_score = getSecRawScore_New($test_id, $sat_id, "writing");
 $scar['math_reported'] = getReportedScore_New($math_score, "math",'','');
 $scar['reading_reported'] = getReportedScore_New($reading_score, "reading",'','');
 $scar['writing_reported'] = getReportedScore_New($writing_score, "writing",'','');
 ?>
  <tr>
  	<td><table border="0" cellspacing="3" cellpadding="2" align="center">
  <tr>
    <td class="news_header"><div align="right">Math: </div></td>
    <td class="news_header"><?=$scar['math_reported'];?></td>
  </tr>
  <tr>
    <td><div align="right"  class="news_header">Reading: </div></td>
    <td class="news_header"><?=$scar['reading_reported'];?></td>
  </tr>
  <tr>
    <td><div align="right" class="news_header">Writing: </div></td>
    <td class="news_header"><?=$scar['writing_reported'];?></td>
  </tr>
  <tr>
    <td><div align="right"  class="news_header">Essay: </div></td>
    <td class="news_header"><?=$scar['essay_score'];?></td>
  </tr>
</table></td>
</tr>
<? 
 
 
 
 
$secq = "select section_number, section_type from TP_SAT_Sections where test_id = $test_id order by section_type, section_number";
$secrs = runquery($secq);
$oldsec = ""; //use to 

while($sec = mysql_fetch_array($secrs)){
	$txt_pr = ""; $txt_your_ans = ""; $txt_corr_ans = "";
	if($sec['section_type'] <> $oldsec){
		$oldsec = $sec['section_type']; 
		$sec_type = ucfirst($sec['section_type']);
		
		?>
		
		<table width="100%"  border="1" cellspacing="0" cellpadding="2" class=table_1 style="border-top:none">
		  <tr style="background: #eee; height: 35px">
			<th  colspan="2" scope="col" bgcolor=""><?=$sec_type;?> Sections</th>
		  </tr>
		  <tr height=20>
		  	<td width="100"><div align="center"><strong> Section </strong></div></td>
		  	<td><div align="center"><strong> Results</strong></div></td>
		  </tr>
		  
 	<? } // if this is the first math, reading or writing section, start a new table
	$secnum = $sec['section_number'];
	?>
	<TR><TD valign="middle"><div align="center"><span class="style2">
	    <?=$secnum;?></span></div></TD>
<td><table border="1" cellspacing="0" cellpadding="5" class="table_1">
<?
    $res = runquery("select * from $strTableName WHERE section_num=$secnum AND test_id=$test_id AND testprep_id=$sat_id ORDER BY problem ASC");
    while($row=mysql_fetch_array($res)){
		$text_style = $row['result'];
		$txt_pr.="<td class=\"styleNum\" align=\"center\">".$row[problem]."</td>";	
		$tempres = $row[answer];
		if(isEmpty($tempres)) $tempres = "-";
		$txt_your_ans.="<td class=\"$text_style\" align=\"center\">" .  $tempres . "</td>";
		$txt_corr_ans.="<td class=\"$text_style\" align=\"center\">";
		if($text_style == "correct")
			$txt_corr_ans.='<img src="../../images/check_green.jpg" height="15" width="15">';
		else
			$txt_corr_ans.=$row[corect_answer];
		$txt_corr_ans.='</td>';
}
?>
<tr><td align="right"><span class="style1"><strong>Problem</strong></span></td><?=$txt_pr?></tr>
<tr><td align="right"><span class="style1"><strong>Student Answer</strong></span></td><?=$txt_your_ans?></tr>
<tr><td align="right"><span class="style1"><strong>Correct Answer</strong></span></td><?=$txt_corr_ans?></tr>
</table></td></TR>
		  

		
<? }
?>

  
<tr height=30>
    <td></td>
</tr>
</table>
<?php
put_ptts_footer("");
?>