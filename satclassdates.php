<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();


put_ptts_header("", $strAbsPath, "", "");
?>

<link href="NewPTTcss.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.plain {
	font-weight: normal;
}
.book_position {
	left: 5px;
	top: 450px;
	position: absolute;
}
.style6 {font-weight: normal; font-size: 11px; }
.pic_location {
	position: absolute;
	left: 450px;
	top: 175px;
}
-->
</style>
</head>

<body>
<table width="686" border="0" cellpadding="2" cellspacing="0" background="images/flowbg.gif">
  <tr >
    <td height="25" colspan="2"" valign="top" class="Head1_Green">Test Prep Classes
      Offered </td>
    <td width="140" rowspan="2"" valign="top"><div align="right">      
      <br>
      <p>        <a href="http://www.paulthetutor.com/testprepreg.php">Register for a Class</a><br>
      </p>
	 
	  <p>&nbsp;</p>
	 
    </div></td>
  </tr>
  <tr>
    <td width="27" height="308" valign="top"><div align="left"></div></td>
    <td width="507" valign="top"> <p align="left">
    
<? 
// put the links to the classes for various test dates
$tdqstr = "select DISTINCT SAT_date, test_type from PT_SAT_Class_Info where end_date >= curdate() and enrolled < max_students  order by SAT_date ASC";
$tdRS = runquery($tdqstr);  ?>
<link href="includes/paulthetutors.css" rel="stylesheet" type="text/css">

<span class="Head2_Brown">Jump to a Test Date</span><BR>
Click on a date below to jump to classes for that test<BR>
<? 
while($row = mysql_fetch_array($tdRS)){ 
	$test_abr = get_test_ini($row[test_type]);
	$satint = strtotime($row['SAT_date']);

	?>
	<a href="#<?="$row[0]_$row[1]";?>">
	<? echo date("M jS Y", $satint);
	echo " $test_abr";?></a><BR>
<? } 

$old_date = 0;
$QStr = "select * from PT_SAT_Class_Info where end_date >= curdate() and enrolled < max_students  order by SAT_date ASC";
$marRS = runquery($QStr);
while($marAr = mysql_fetch_array($marRS)){
	if($old_date <> $marAr['SAT_date']){
		$old_date = $marAr['SAT_date'];
		$satint = strtotime($marAr['SAT_date']);
		$test_ini = get_test_ini($marAr[test_type]);
	
?>
      <HR>
<span class="Head1"><a name="<?="$marAr[SAT_date]_$marAr[test_type]";?>"><? echo date("M jS Y", $satint);?>, <?=$test_ini;?> 
</a><br>
</span>
The following class(es) are scheduled to prepare students for the <? echo date("M jS", $satint);?> <?=$test_ini;?>.&nbsp;<br>
<? } //end the if
?>
<BR>
<? $space_av = $marAr['max_students'] - $marAr['enrolled']; ?>

<span class="uline"><strong>Class 
<?=$marAr['class_name']?>
</strong></span> (
<?
if($space_av > 3){
?>
<a href="testprepreg.php">Register </a> 
<?
} else {
if($space_av > 0){
?>
<a href="testprepreg.php">Register </a> 
<?
echo " Only $space_av space(s) left";
} else {
echo "Class is Full";
}}
?>)<br>
<strong>Location:</strong> <?=$marAr['location']?><br>
<strong> Schedule:</strong>
<?=$marAr['dow']?> <?=$marAr['class_time']?><br>
<strong>Dates:</strong>
<?
$startint = strtotime($marAr['start_date']);
$endint = strtotime($marAr['end_date']);
echo date("M jS ", $startint) .' - '. date("M jS ", $endint); ?> 
<br>


<?
$dateint1 = strtotime($marAr['practice_test_1']);
$dateint2 = strtotime($marAr['practice_test_2']);
?>
<strong>Practice Tests:</strong> <? echo date("g:i a l M jS ", $dateint1); ?>  <strong>and</strong>  <? echo date("g:i a l M jS ", $dateint2); ?> <BR>
<strong>Cost:</strong> $<?=$marAr['cost']?><br>
<? 	if(!(isEmpty($marAr['Comment']))){
		echo $marAr['Comment'];
		echo "<br>";
	}	
?>	
<? } //while ?>

<table width="100%">
 
	  
 
</table>

	</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" class="style6"> <HR>
<span class="Head2"> Don't see a class that fits your schedule?  <a href="contact.php">Contact us</a> about creating one that works for you!</span><BR><br></td>
  </tr>
</table>
	 
<?

put_ptts_footer("");

?>
