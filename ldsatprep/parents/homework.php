<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/.check_login.php");
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "parents", "");
$today = date("Y-m-d");
if ($_REQUEST['sat_id'])
	$sat_id = $_REQUEST['sat_id'];
else
	$sat_id = $_SESSION['sat_id'];
$class_id = $_SESSION['sat_class_id'];

?>
<table width="100%" border="0" cellpadding="7" cellspacing="0" style="border:solid 1px #999">
  <tr height="40">
    <td class="td_header">LD SAT Prep Class Number <?echo $class_id?></td>
  </tr>
  <tr height=10>
    <td></td>
</tr>
<? 

$QStr = "select * from TP_HW_Summary WHERE class_id='".$class_id."' order by due_date desc";
$RS = runquery($QStr);
if (mysql_num_rows($RS)){
?>
<tr>
    <td  valign="top" bgcolor="#FFFFFF">
    <div class="news_header" style="padding-bottom:5px">Homework Assignments for the week</div>
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" cellpadding="2" cellspacing="0" width="100%">
  <tr style="background: #eee; height: 35px">
      <td class="text_grey" width="80"><b>Week number</b></td>
      <td class="text_grey"><b>Assignment</b></td>
      <td class="text_grey" width="100"><b>Due date</b></td>
  </tr>

<?
$i=-1;
while($row = mysql_fetch_array($RS)){
$i++;
 echo '<tr '.($i>0 ? 'class="tr_hide1"' : '').'>
         <td>'.$row['week_number'].'&nbsp;</td>
         <td>'.nl2br($row[assignment]).'&nbsp;</td>
         <td>'.format_date_print($row[due_date],'yy-mm-dd','-','mm/dd/yy','/').'&nbsp;</td>
 </tr>';
}

?>
</table>
<?
if ($i)
	echo '<div style="margin-top:10px"><a class="div1" href=#>Show all homework</a></div>';
}
?>
</td>
</tr>   
<tr>
    <td></td>
</tr>
<?
$QStr = "select a.*, b.name as test_name from TP_HW_Gradable a LEFT JOIN TP_SAT_Tests b ON a.test=b.id  WHERE b.id IS NOT NULL AND a.class_id='".$class_id."' order by a.due_date DESC";
$RS = runquery($QStr);
if (mysql_num_rows($RS)){
?>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
    <div class="news_header" style="padding-bottom:5px">See how student is doing with homework</div>
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" cellpadding="2" cellspacing="0" width="100%">
  <tr style="background: #eee; height: 35px">
      <td class="text_grey" width="80"><b>Week number</b></td>
      <td class="text_grey" width="100"><b>Due date</b></td>
      <td class="text_grey"><b>Test</b></td>
      <td class="text_grey"><b>Section</b></td>
      <td class="text_grey"><b>Date completed</b></td>
      <td class="text_grey"><b>Results</b></td>
  </tr>

<? 

$i = -1;
while($row = mysql_fetch_array($RS)){
	$i++;
	$resc= runquery("select date FROM TP_HW_Answers WHERE class_id='".$class_id."' AND testprep_id='".$sat_id."' AND test_id='".$row[test]."' AND section_num='".$row[section]."'  order by date ASC LIMIT 1");
	$rowc = mysql_fetch_array($resc);
	$res_res = runquery("select * from TP_HW_Answers where testprep_id = '".$sat_id."' AND test_id='".$row[test]."' AND section_num='".$row[section]."'");
	if (mysql_num_rows($res_res))
		$results = 1;
	else
		$results = 0;
 echo '<tr '.($i ? 'class=tr_hide2' : '').'>
         <td>'.$row['week_number'].'&nbsp;</td>
         <td>'.format_date_print($row[due_date],'yy-mm-dd','-','mm/dd/yy','/').'&nbsp;</td>
         <td>'.$row[test_name].'</td>
         <td>'.$row[section].'</td>
         <td>'.($rowc[date]!='' ?  format_date_print(substr($rowc[date],0,10),'yy-mm-dd','-','mm/dd/yy','/')." ".substr($rowc[date],11,8) : '').'&nbsp;</td>
         <td>'.($results ? "<a href='homeworkresults03.php?test_id=".$row[test]."&section=".$row[section]."'>View results</a>" : "").'</td>
 </tr>';
}

?>
</table>
<?
if ($i)
	echo '<div style="margin-top:10px"><a class="div2" href=#>Show all homework</a></div>';
}
?>
</td>
</tr>
<tr height=30>
    <td></td>
</tr>
</table>
<?php
put_ptts_footer("");
?>
<script language="javascript">
	$(document).ready(function(){
		$(".tr_hide1").hide();
		$(".tr_hide2").hide();
		$('.div1').click(function(){
			if ($(".tr_hide1").css('display') == 'none'){
				$(".tr_hide1").show();
				$(".div1").html('Hide last homework');
			}else{
				$(".tr_hide1").hide();
				$(".div1").html('Show last homework');
			}
	    });
	    $('.div2').click(function(){
			if ($(".tr_hide2").css('display') == 'none'){
				$(".tr_hide2").show();
				$(".div2").html('Hide last homework');
			}else{
				$(".tr_hide2").hide();
				$(".div2").html('Show last homework');
			}
	    });
	});
</script>