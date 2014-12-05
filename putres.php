<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();
reqToVars();

put_ptts_header("", $strAbsPath, "", "");
$page_name = phptohtm();

$QStr = "update PT_interview_res set name = '$name', email = '$email', taken = 1 where id = $slotid";
$RS = runquery($QStr);

$QStr = "select time, date from PT_interview_res where id = $slotid";
$resRS = runquery($QStr);
$resAR = mysql_fetch_row($resRS);
$date_num = strtotime($resAR[1]);	
$show_date = date('D, F jS',$date_num);
$time_num = strtotime($resAR[0]);
$end_time_num = $time_num + (30*60);
$end_time_str = date('H:i:s', $end_time_num);
$distime = date('g:i a', $time_num);
$comment = "position: $_POST[comment]";

//                  date       start_time end_time    tutor_id name email  phone   comments
non_tut_session_add($resAR[1], $resAR[0], $end_time_str, 1, $name, $email, $phone, $comment);
// non_tut_session_add($resAR[1], $resAR[0], $end_time_str, 5, $name, $email, $phone, $comment);

// @IQS = "INSERT INTO `PT_Other_Appt` (`name`, `date`, `start_time`, `end_time`, `tutor_id`,`email`, `phone`, `comments`) VALUES ('$name', '2011-08-23', '14:30:00', '15:00:00', '1', '0', 'testemail', 'testphone', 'this is an interview');

$strB =  "$name,

You have an interview with Paul the Tutor at $distime on $show_date.  
Interview Locations-

Piedmont -  Paul the Tutor's Education Center at 4235 Piedmont Ave. Oakland, CA 94611 
Lafayette - Paul the Tutor's Education Center at 91 Lafayette Circle, Lafayette CA 94549
Davis - TBA



If this is your first interview, please show up 5 minutes early to fill out paperwork and bring contact information for 3 references.  

If you are applying for a tutoring position, two of you references should be parents of students you have tutored, or the students themselves, if they are over 18.  Understand that you will be asked to perform mock tutorials in the subjects which you hope to tutor.  Be sure to refresh your memory as the topics you will be asked to tutor will be somewhat challenging.

Thanks,

Paul the Tutor's
4235 Piedmont Ave.
Oakland, CA 94611
(510)730-0390
info@paulthetutors.com";
$psub = "$name is coming at $distime on $show_date";
mail('info@paulthetutors.com', $psub, '','from: paul@paulthetutor.com','-finfo@paulthetutors.com');
mail($email, "You have an interview at $distime on $show_date",$strB,'from: noreply@paulthetutor.com','-fnoreply@paulthetutors.com');

?>
<link href="NewPTTcss.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.plain {
	font-weight: normal;
}
-->
</style>
<link href="includes/paulthetutors.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="850" border="0" cellpadding="3" cellspacing="0" background="images/flowbg.gif">
  <tr>
    <td height="29" colspan="2" valign="top"><span class="Head1_Green"> Your
        Appointment has Been Recorded </span>
      <div align="right"></div></td>
    <td width="149" rowspan="2" align="center" valign="bottom">	  <div align="center"><a href="http://www.tinyurl.com/ldsatstudyguide"><img src="images/ldsat_cover_108_pix.jpg" width="149" height="188" border="0"></a><br>
    </div></td>
  </tr>
  <tr>
    <td width="37" height="279" valign="top">&nbsp;</td>
    <td width="482" height="279" valign="top">You have an interview with Paul
      the Tutor at <?=$distime;?> on <?=$show_date;?>. <br /><br />
      <span class="Head2">Interview Locations</span><br /> Piedmont -  Paul the Tutor's Education Center at 4235 Piedmont Ave. Oakland, CA 94611 <BR />
Lafayette - Paul the Tutor's Education Center at 91 Lafayette Circle, Lafayette CA 94549
<BR />Davis - TBA <br />
<BR>
      If this is your first interview, please show up 5 minutes early to fill out paperwork and bring contact information for 3 references.  <br><br>

<B>If you are applying for a tutoring position</B> two of you references will be parents of students you have tutored, or the students themselves, if they are over 18.  Understand that you will be asked to perform mock tutorials in the subjects which you hope to tutor.  Be sure to refresh your memory as the topics you will be asked to tutor will be somewhat challenging.<br><br>

Thanks,<br><br>

Paul the Tutor's<br>
4235 Piedmont Ave.<br>
Oakland, CA 94611<br>
(510)730-0390<br>
info@paulthetutors.com<br>  
	  
	</td>
  </tr>  
</table>
</body>
</html>


<?
put_ptts_footer("");

?>
