<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");
include("../includes/.check_login.php");

// Contact page for parents 

//check if the user is logged in
MySQL_PaulTheTutor_Connect();
put_ptts_header("Paul the Tutor's - Contact Page", $strAbsPath, "tutors", "");



$fid = $_SESSION['fid'];
$main_name = getMainName($fid);
?>

<span class="Head1_Green">Hello <?echo $main_name;?></span><span> (<?echo "Not $main_name?";?> <a href='login_parents.php?logout=1'>Logout</a>)<br/><br/></span>

<!--<link href="/home/paulth40/public_html/NewPTTcss.css" rel="stylesheet" type="text/css">
<style type="text/css">-->
<!--
.plain {
	font-weight: normal;
}
.style1 {font-weight: normal; font-size: 10px; }
.style3 {font-weight: normal; font-size: 12px; }
.style4 {font-size: 12px}
.book_position {
	left: 5px;
	top: 450px;
	position: absolute;
}

</style>
</head> -->
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<body>
<table width="731" border="0" cellpadding="5" cellspacing="0">
  <tr>
 <!--   <td height="25" colspan="2"" valign="top"><span class="Head1_Green">
      Welcome 
    <?//=$main_name;?>--><!--</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="logout.php">&nbsp;not
    <?//=$main_name;?>
    ?</a> </td>-->
    <td width="150" rowspan="2"" valign="top"><div align="right">
	<a href="strip_autopay.php">Sign Up for AutoPay </a><br/>
	<a href="viewbill.php">View Bill</a><br/>
	<a href="strippay_action2.php">Pay Bill</a><br/>
	<a href="testprepreg.php">Sign Up for SAT Prep</a>

	<a href="http://paulthetutors.com/contact.php">Contact Paul</a><br/>
	<br/>    <!--is this page for contact?-->
	
	</div>
      <br>
      <span class="Head2">Schedule</span>
      <br>
<?
$qstr = "select date, start_time from PTAddedApp where family_id = $fid and date >= NOW() order by date DESC, start_time DESC";
$ScRS = runquery($qstr);

while($ses = mysql_fetch_array($ScRS)){
	$start_time = format_time_print($ses[start_time]);
	$show_date = format_date_print($ses[date]);
	echo "$show_date - $start_time<BR>";
 }


?>

      <br>
 <!--     <span class="Head2"><img src="../images/374wspacer.gif" width="120" height="2"><img src='/images/gradanddad.gif' width="150" height="225"></span>-->
    </div></td>
  </tr>
  <tr>
    <td width="10" height="131" align="center" valign="top"><div align="center"><br>
          <br>
    </div>      <div align="left"></div></td>
    <td width="541" valign="top">
	

   <span class="Head2"> Students On File <br>
      </span>
        <? 
$SQStr = "select first_name,last_name from PTStudentInfo_New where fid = '$fid'";
$SRS = mysql_query($SQStr);
//echo $_SESSION['fid'];
$num_kids = 0;
while ($sAr = mysql_fetch_array($SRS)){
	$num_kids = $num_kids + 1;
	echo "&nbsp;&nbsp;-$sAr[first_name] $sAr[last_name]<BR>";
}
if($num_kids = 0){
	echo "No students on file<br>";
}	
?>
        <BR>
   To enter information about a new student <a href="getstudentinfo.php"> click here</a>    <!--getstudentinfo.php doesn't work well-->
  <hr align="left" width="50%" noshade>           
  <form name="form1" method="post" action="viewbillaction.php">

	  <span class="Head2">See  Bill Details for a Month </span>
        <table width="42%"  border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="39%"><div align="right"><strong>Month</strong></div></td>
            <td width="61%"><? putMonthsSelect('month'); ?>
            </td>
          </tr>
          <tr>
            <td><div align="right"><strong>Year</strong></div></td>
            <td><? putYearsSelect(year); ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">
                <input type="submit" name="Submit" value="Submit">
&nbsp;&nbsp;
        <input type="reset" name="Submit2" value="Reset">
            </div></td>
          </tr>
        </table>
      </form>
	  
<!--            <a href="clientcal.php" class="Head2">Client Calendar</a><br>
 -->           <br>
	  <span class="Head3"> <a href="strippay_action2.php">Pay Your Bill Online</a> </span><br>
      <span class="Head3"><a href="strip_autopay.php">Sign Up for AutoPay</a> <span class="style1">Save $10/hr when you pay with autopay</span></span> (<a href="../autopay.php" target="_blank">learn more</a>)<br>
	  <BR>
	  <span class="Head3">See a record of your account<a href="viewbill.php"> Click Here </a></span><br>

            <hr align="left" width="50%" noshade>      <br>
<?
//PUT SAT INFORMATION HERE!!!!!!

$res = runquery("select * from PT_TestPrep_Reg where fid = '".$_SESSION['fid']."' GROUP BY class");
$i = 0;
while($row=mysql_fetch_array($res)){
	if($i == 0){
		$i =1; ?>
		<span class='Head2'> SAT Prep Class Information<BR></span>
		
<?	}
	$class_id = $row['class'];
	if ($class_id <> 1){
		$class_name = singlequery("select class_name from PT_SAT_Class_Info where id = $class_id");
		$class_name = "Class " . $class_name;
	} else if ($class_id == 1) {
		$class_name = "One on One Prep";
	}		
	
	echo "<BR><strong>- " . $class_name."</strong> - ".$row[student_name] ." (<a href='../ldsatprep/parents/ldsatpar_index.php?sat_id=".$row[id]."'>Click Here</a>)";
}

?>
 <br> <br>
<!--$HTTP_COOKIE_VARS[fid] -->
	</p></td>
  </tr>
</table>
<?
put_ptts_footer("");


?>