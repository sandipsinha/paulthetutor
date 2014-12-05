<html>
<head>
<META HTTP-EQUIV="refresh" CONTENT="0; url=strippay_action2.php">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Paul the Tutor's Tutors</title>
</head>


<?php
include($strAbsPath . "../includes/.check_login.php");
include($strAbsPath . "../includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

put_ptts_header("Paul the Tutor's - Contact Page", $strAbsPath, "tutors", "");

$famid=$_SESSION['fid'];
$main_name = getMainName($famid);
?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">


<div align="center"><span class="Head1"><BR>
  <BR>
  <BR>
If you do not get redirected <br><br><a href="strippay_action.php">Click Here for Credit Card Payments</a></body>
  <BR>
  <BR>
  <BR>
  </span>
  <?

put_ptts_footer("");
?>
</div>
