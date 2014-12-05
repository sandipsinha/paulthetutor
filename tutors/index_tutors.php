<?php
ob_start();

$strAbsPath = "../../../../";
include("../includes/pttec_includes.phtml");
include("../includes/tut_auth.php");
MySQL_PaulTheTutor_Connect();
$tutor_id = $_SESSION['tutor_id'];
$tar = tutor_info($tutor_id);

$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "tutors", "");
?>
<style type="text/css">
<!--
.plain {
	font-weight: normal;
}
-->
</style>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
</head>

<body>

<table width="686" border="0" cellpadding="3" cellspacing="0" background="../images/flowbg.gif">
  <tr>
    <td height="25" colspan="2" valign="top"><span class="Head1_Green">
        Hello 
<?= $tar['first_name']; ?>
</span>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(not 
<? 
echo $tar['first_name'] . " " . $tar['last_name'] . "?"; 
?>

<a href="tutlogin.php?logout=1">Log
Out</a>)
    <div align="right"></div></td>
    
  <tr>
    <td width="36" height="51" valign="top">&nbsp;</td>
    <td width="509" height="51" valign="top"><p><span class="Head2">Most Common Links </span><br>
&nbsp;&nbsp;- <a href="calendar_action.php">View Your Calendar</a> - &nbsp;(<a onClick="javascript:popup('addsess_loc.php?popup=popup','','600','700')" class="underline" >Add Tutoring</a> or
<a onClick="javascript:popup('schedule_edit.php?popup=popup','','600','700')" class="underline" >Add Recurring Tutoring</a>
 )<br>
&nbsp;&nbsp;- <a href="comments_inprogress.php">Notes On Students</a> -  (<a onClick="javascript:popup('comment_edit_inprogress.php?popup=popup','','600','700')" class="underline" >Add a Note</a>)<br>
&nbsp;&nbsp;- <a href="show_bills.php">Month's Tutoring Sessions</a><br>
&nbsp;&nbsp;- <a href="non_tutoring_apps.php">Non-Tutoring Schedule//Work</a> -  (<a onClick="javascript:popup('miviram_non_tutoring_appointment_edit.php?popup=popup','','600','700')" class="underline" >Add  Non-Tutoring Schedule/Event/Work</a>)<br>
<span class="Head3"><br>
Scheduling</span><br>
&nbsp;&nbsp;- <a href="calendar_action.php">View Your Calendar</a> - &nbsp;(<a onClick="javascript:popup('addsess_loc.php?popup=popup','','600','700')" class="underline" >Add Tutoring</a> or
<a onClick="javascript:popup('schedule_edit.php?popup=popup','','600','700')" class="underline" >Add Recurring Tutoring</a>
 )<br>
&nbsp;&nbsp;- <a href="set_times.php">Regular In/Out Hours </a> - (<a href="set_special_times.php">Special In/Out Hours</a>)<BR>
&nbsp;&nbsp;- <a href="non_tutoring_appointments.php">Non-Tutoring Schedule//Work</a> -  (<a onClick="javascript:popup('miviram_non_tutoring_appointment_edit.php?popup=popup','','600','700')" class="underline" >Add  Non-Tutoring Schedule/Event/Work</a>)<br>
&nbsp;&nbsp;- <a href="schedules.php">View Recurring Tutoring Schedules </a><br>
&nbsp;&nbsp;- <a href="vacation_list.php">Vacations</a> <p><span class="Head3">
  Families</span> <br>
&nbsp;&nbsp;- <a href="families_new.php">Families</a><br>
&nbsp;&nbsp;- <a href="studentinfo.php">Student Info</a> <br>
&nbsp;&nbsp;- <a href="comments_inprogress.php">Notes on Student</a> <br>
  <br>
  <span class="Head3">Test Prep</span> <br>
&nbsp;&nbsp;- <a href="view_rosters.php">Class Rosters</a><br>
&nbsp;&nbsp;- <a href="../ldsatprep/ldsatadmin" target="_blank">Test Prep  Admin</a> (<strong>U:</strong> proctor  <strong>P:</strong> paulthetutors)<br>
  
<br>
<span class="Head3">Admin</span><br>
&nbsp;&nbsp;- <a href="Tutoring%20Time%20Card.pdf">Time Cards </a> (<a href="Time%20Card%20Explanation.pdf" target="_blank">Instructions</a>)<br>
&nbsp;&nbsp;- <a href="gmail_pttsemail.pdf">Using GMail to view ptts email </a><br>
&nbsp;&nbsp;- <a href="gettutorinfo.php">Enter Your Info</a><br>
&nbsp;&nbsp;- <a href="tutedit02.php">Edit Your Info</a><br>
<br>
<span class="Head3">Resources</span><br>
&nbsp;&nbsp;- <a href="http://drive.google.com" target="_blank">Google Docs</a> (<strong>U:</strong> ptts.tutors@gmail.com <strong>P:</strong> paulthetutors)<br>
&nbsp;&nbsp;-  <a href="../ldsatprep/ldsatadmin">Test Prep Admin</a> (<strong>U:</strong> proctor <strong>P:</strong> paulthetutors)<br>
<br>
<br>
<br>
      </td>
	  
	  
  </tr>
<tr>
  <td height="138" colspan="3">&nbsp;</td>
</tr>  
</table>

<?


put_new_footer();

?>
