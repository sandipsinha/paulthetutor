<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");
include("../includes/.check_login.php");

// Contact page for parents 

//check if the user is logged in
MySQL_PaulTheTutor_Connect();
put_ptts_header("Sign Up for LD Test Prep at Paul the Tutor's", $strAbsPath, "parents", "");

$fid=$_SESSION['fid'];
$main_name = getMainName($fid);
?>

<link href="includes/paulthetutors.css" rel="stylesheet" type="text/css">
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
.red_bold {
	font-weight: bold;
	color: #F00;
}
-->
</style>
</head>

<body>
<table width="686" border="0" cellpadding="2" cellspacing="0" background="images/flowbg.gif">
  <tr >
    <td height="25" colspan="2"" valign="top" class="Head1_Green">Sign Up for
      Test Prep </td>
    <td width="85" rowspan="2"" valign="top"><div align="right">      
      <br>
      <p><a href="http://www.paulthetutor.com/contact.php">Contact Paul</a><br>
        <a href="http://www.paulthetutor.com/testprepreg.php">Sign Up</a><br>
      </p>
	  <p>&nbsp;      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;        </p>
      <p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td width="30" valign="top"><div align="left"></div></td>
    <td width="559" valign="top"> <p align="left">
	
	<span class="Head1">Choose Your Class</span></span> <br>
Pick the class you would like to attend  
      <table width="100%">

</table>
<?
// printArray($_POST);
?>


<form action="testprepreg3_02.php" method="post">
<? // create hidden values for all of the values input.
// THE STUDENT DATA IS NOW BEING PASSED AS AN ARRAY VALUE, I AM PRETTY SURE!
$PostVars = $_POST;

while(list($key,$val) = each($PostVars)){
	if($key <> 'Submit'){ ?>
		<input name="<?=$key?>" type="hidden" value="<?=$val?>">
	<?} // if
} // while 

$student_id = $_POST[student_id];
$SStr = "select first_name, last_name from PTStudentInfo_New where id = $student_id";
// echo "qstr is $SStr <BR>";
$res = runquery($SStr);
$row = mysql_fetch_array($res);
$student_name = "$row[first_name] $row[last_name]";
$username = ucfirst(strtolower($row[first_name]));
$password = ucfirst(strtolower($row[last_name]));
// echo "$username $password is the name<BR>";

?>
<input name="student_name" type="hidden" value="<?=$student_name?>">
<input name="username" type="hidden" value="<?=$username?>">
<input name="password" type="hidden" value="<?=$password?>">
<?


$old_date = 0;
$QStr = "select * from PT_SAT_Class_Info where end_date >= curdate() order by SAT_date";
$marRS = runquery($QStr);
while($marAr = mysql_fetch_array($marRS)){
if($old_date <> $marAr['SAT_date']){
$old_date = $marAr['SAT_date'];
$satint = strtotime($marAr['SAT_date']);
$test_ini = get_test_ini($marAr[test_type]);
?><HR>
<span class="Head2"><? echo date("M jS Y", $satint);?>,</span><span class="Head2 red_bold">
<?=$test_ini;?> </span><span class="Head2">Test </span><br>

The following class(es) are scheduled to prepare students for the <? echo date("M jS", $satint);?> 
<?=$test_ini;?>
.&nbsp;<br>
<? } //end the if
?>
<BR>
<? $space_av = $marAr['max_students'] - $marAr['enrolled']; 
if($space_av > 0){ ?>
<input name="class" type="radio" id="class" value="<?=$marAr['id']?>">
<? } ?>
<span class="uline"><strong>Class 
<?=$marAr['class_name']?>
</strong></span> (
<?
if($space_av > 3){
echo "Space is Available";
} else {
if($space_av > 0){
echo "Only $space_av spaces left";
} else {
echo "Class is Full";
}}
?>)<br>
<strong>Schedule:</strong>
<?=$marAr['dow']?> <?=$marAr['class_time']?>
<br> 
<strong>Location:</strong>
<?=$marAr['location']?>
<br>
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
<strong>Practice Tests 1:</strong> <? echo date("g:i a l M jS ", $dateint1); ?> <BR>
<strong>Practice Tests 2:</strong> <? echo date("g:i a l M jS ", $dateint2); ?> <br>
<strong>Cost:</strong> $<?=$marAr['cost']?><br>
<? } //while ?>
<HR>
<span class="Head1">Or, Create Your Own Class</span><br>
Don't See the Class You Want?  Email me to let me know the
type of class, size, dates and schedule of class you would like, and I will do
everything I can to make it happen.&nbsp; Especially with small group classes,
I can usually accomidate almost any schedule. (<a href="http://www.paulthetutor.com/contact.php">Click
Here to Email Me</a>)
<table width="100%">
 

	  <tr>
		<td>
		  <div align="center">
		    <input type="submit" name="Submit" value="Submit">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    <input type="reset" name="clear" value="Clear">
		   </div>
		</td>
	  </tr>
 
</table>
</form>	
	</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" class="style6">&nbsp;</td>
  </tr>
</table>
	 

<?

put_ptts_footer("");
?>
