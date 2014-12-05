<?php
include($strAbsPath . "../includes/.check_login.php");
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

put_ptts_header("Paul the Tutor's - Contact Page", $strAbsPath, "tutors", "");

$famid=$_SESSION['fid'];
$main_name = getMainName($famid);
?>
<span class="Head1_Green">Hello <?echo $main_name;?></span><span> (<?echo "Not $main_name?";?> <a href='login_parents.php?logout=1'>Logout</a>)<br/><br/></span>
<span class='Head2'>Here is the list of our tutors:</span>
<table border='2'><tr><th>Tutor's name</th><th>Tutor's subjects</th><th>Tutor's phone</th><th>Tutor's email address</th></tr>
<?
$query="select first_name, last_name, gvoice_phone, email, subjects 
		from PT_Tutors";
$result=mysql_query($query);

while($row=mysql_fetch_row($result))
{	

	?><tr><td width='15%'><?echo "$row[0] $row[1]";?></td><td width='70%'><?echo "$row[4]";?></td><td width='15%'><?echo "$row[2]";?></td><td width='10%'><?echo $row[3];?></td></tr><br/><?
}

?></table><?

put_ptts_footer("");
?>