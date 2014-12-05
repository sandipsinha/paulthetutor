<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/paulthetutors_com/includes/.check_login.php");
$strBack = "../includes"; 
include($strAbsPath . "/paulthetutors_com/includes/pttec_includes.phtml");
include($strAbsPath . "/paulthetutors_com/includes/clientcal.phtml");

MySQL_PaulTheTutor_Connect();
/*if(isset($_SESSION['fid']))
	$famid=$_SESSION['fid'];
else
	echo"$fid doesn't exist";	*/

put_ptts_header("Paul the Tutor's - Edit Info Page", $strAbsPath, "parents", "");

echo"<link rel='stylesheet' type='text/css' href=$strAbsPath . '/paulthetutors_com/includes/paulthetutors.css' />";

?>
</head>
<body>

	<br/><br/><br/>
	<span class="Head3">Choose a tutor you want to see the calendar for from the drop down menu. Click <a href='contact_page.php'>here</a>  if you want to see information about all tutors.</span>
	<br/><br/><br/>
<?	
	echo"<form name='choose_tutor_form' action='clientcal.php' method='post'>";
	$query="select first_name, last_name, id from PT_Tutors";
	$result=runquery($query);
	echo "<select name='tutor_select' class='form_style'>";
	while($row=mysql_fetch_row($result))
	{
		if($row[2]==1)
			$tname= $row[0] . " T.";
		else	
			$tname=$row[0] . " ".substr($row[1],0,1) . ".";
		echo"<option value='$row[2]|$tname'>$tname</option>";	
	}
?>	
	</select>

	<input type='submit' name='choose_tutor_submit' class='form_style' />
	</form>
	<br/><br/><br/>
	<br/><br/><br/>
<?
put_ptts_footer("");
?>
