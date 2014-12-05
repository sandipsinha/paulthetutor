<?php
//check if the user is logged in
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/paulthetutors_com/includes/.check_login.php");
require_once($strAbsPath . "/paulthetutors_com/includes/pttec_includes.phtml");
require_once($strAbsPath . "/includes/PTTIncludes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Paul the Tutor's - Edit Info Page", $strAbsPath, "tutors", "no_banner");

echo"<link rel='stylesheet' type='text/css' href=$strAbsPath . '/paulthetutors_com/includes/paulthetutors.css' />";


$fid=$_SESSION['fid'];

//if the Submit is pressed..
if(isset($_REQUEST['submit_changes']))
{
	$pass=$_REQUEST['pass'];
	$mn=$_REQUEST['mn'];
	$fn=$_REQUEST['fn'];	
	$gn=$_REQUEST['gn'];
	$mea=$_REQUEST['mea'];
	$fea=$_REQUEST['fea'];
	$gea=$_REQUEST['gea'];
	$mpn=$_REQUEST['mpn'];
	$fpn=$_REQUEST['fpn'];
	$gpn=$_REQUEST['gpn'];
	$mcn=$_REQUEST['maincont_sel'];
	$bcn=$_REQUEST['billcont_sel'];
	$mainpn=$_REQUEST['mainpn'];
	
	//setting main and billing contact info
	if(!strcmp($mcn,"mother")){$mname=$mn;$memail=$mea;}
	if(!strcmp($mcn,"father")){$mname=$fn;$memail=$fea;}
	if(!strcmp($mcn,"guardian")){$mname=$gn;$memail=$gea;}
	
	if(!strcmp($bcn,"mother")){$bname=$mn;$bemail=$mea;}
	if(!strcmp($bcn,"father")){$bname=$fn;$bemail=$fea;}
	if(!strcmp($bcn,"guardian")){$bname=$gn;$bemail=$gea;}
	
	
	$update_query="update PT_Family_Info set password='$pass',mother='$mn',father='$fn',guardian='$gn',main_contact='$mcn',billing_contact='$bcn',main_name='$mname',main_email='$memail',billing_name='$bname',billing_email='$bemail',mothers_email='$mea',fathers_email='$fea',guardians_email='$gea',main_phone='$mainpn',mothers_phone='$mpn',fathers_phone='$fpn',guardians_phone='$gpn' where id='$fid'";
//	echo"Update q:".$update_query;
	runquery($update_query);
}
	


$main_name = getMainName($fid);
echo"<span class='Head1_Green'>Hello $main_name</span> (Not $main_name? <a href='login_parents.php?logout=1'>Logout)</a></br><br/>"; 

if(isset($_REQUEST['submit_changes']))
	echo"<h3 class='Head2_Green'>Your information has been changed.</h3>Return to <a href='index_parents.php'>Home Page</a><br/><br/>";
else
	echo"<h3 class='Head2'>You can edit your information here:</h3><br/><br/>";
$query="select * from PT_Family_Info where id='$fid'";
$result=mysql_query($query);
$row=mysql_fetch_row($result);

//retrieve data for preselected items in drop downs(drop down list is programmed so that if parent doesn't choose new main contact an billing info the old ones will rest in db)
$pre_main=$row[4];
$pre_billing=$row[7];

if(!strcmp($pre_main,"mother")){$mpresel_main="selected=selected";$fpresel_main="";$gpresel_main="";}
if(!strcmp($pre_main,"father")){$mpresel_main="";$fpresel_main="selected=selected";$gpresel_main="";}
if(!strcmp($pre_main,"guardian")){$mpresel_main="";$fpresel_main="";$gpresel_main="selected=selected";}

if(!strcmp($pre_billing,"mother")){$mpresel_billing="selected=selected";$fpresel_billing="";$gpresel_billing="";}
if(!strcmp($pre_billing,"father")){$mpresel_billing="";$fpresel_billing="selected=selected";$gpresel_billing="";}
if(!strcmp($pre_billing,"guardian")){$mpresel_billing="";$fpresel_billing="";$gpresel_billing="selected=selected";}

echo"<form action='edit_info.php' name='edit_info' method='post'>";


echo"<table width='50%'>";
echo"<strong>Username and Password Information:</strong><br/><br/>";

echo"<tr><td width='150'>Username:</td><td> $row[10]</td></tr>";
echo"<tr><td width='150'>Password:</td> <td><input type='password' name='pass' value='$row[11]'/></td></tr></table><br/>";
//echo"<tr> <td width='150'>Confirm Password:</td> <td> <input type='password' name='cpass'/></td> </tr></table>";>
echo"<strong>Parent's and Guardian's Names:</strong><br/><br/>";
echo"<table>";
echo"<tr><td>Mother's Full Name:</td><td> <input type='text' value='$row[1]' name='mn'/></td></tr>";
echo"<tr><td>Father's Full Name:</td><td> <input type='text' value='$row[2]' name='fn'/></td></tr>";
echo"<tr><td width='150'>Guardian's Full Name:</td><td> <input type='text' value='$row[3]' name='gn'/></td></tr></table><br/>";

echo"<strong>Phone Numbers Information:</strong><br/><br/>";
echo"<table>";
echo"<tr><td width='150'>Main Phone Number:</td><td> <input type='text' value='$row[12]' name='mainpn'/></td></tr>";
echo"<tr><td width='150'>Mother's Phone Number:</td><td> <input type='text' value='$row[13]' name='mpn'/></td></tr>";
echo"<tr><td width='150'>Father's Phone Number:</td><td> <input type='text' value='$row[14]' name='fpn'/></td></tr>";
echo"<tr><td width='150'>Guardian's Phone Number:</td><td> <input type='text' value='$row[15]' name='gpn'/></td></tr></table><br/>";

echo"<strong>Email Address Information:</strong><br/><br/>";
echo"<table>";
echo"<tr><td width='150'>Mother's Email Address:</td><td> <input type='text' value='$row[16]' name='mea'/></td></tr>";
echo"<tr><td width='150'>Father's Email Address:</td><td> <input type='text' value='$row[17]' name='fea'/></td></tr>";
echo"<tr><td width='150'>Guardian's Email Address:</td><td> <input type='text' value='$row[18]' name='gea'/></td></tr></table><br/>";

echo"<strong>Who Should Be Contacted Information:</strong><br/><br/>";
echo"<table>";
echo"<tr><td width='150'>Main contact should be:</td><td> <select name='maincont_sel'><option value='mother' $mpresel_main>mother</option><option value='father' $fpresel_main>father</option><option value='guardian' $gpresel_main>guardian</option></select></td></tr>";
echo"<tr><td width='150'>Billing contact should be:</td><td> <select name='billcont_sel'><option value='mother' $mpresel_billing>mother</option><option value='father' $fpresel_billing>father</option><option value='guardian' $gpresel_billing>guardian</option></select></td></tr></table><br/><br/>";

echo"<input type='submit' name='submit_changes' value='Submit Changes'/><input type='reset' value='Clear'></form>";


put_new_footer();
?>