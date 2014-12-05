<?php
include("../includes/pttec_includes.phtml");
//MySQL_PaulTheTutor_Connect();

$con=mysqli_connect("mysql.paulthetutors.com","vworker","vw0rker","paulth40_db");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
put_ptts_header("Parent's Emails", $strAbsPath, "admin", "");

$end_date = date ("Y-m-d");
$last_month = time() - (31*24*60*60);
$start_date = date('Y-m-d', $last_month );

$result = mysqli_query($con,"SELECT main_email FROM PT_Family_Info WHERE archived = 0");
if(!$result){echo "bad query";}
while($row = mysqli_fetch_array($result)) {
echo "<div style='text-align:justify'>".$row['main_email'].";"."</div>";
}
?>
<link href="../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />
<span class="Head1">Email Addresses<br /><br /></span> <span class="Head2_Green">Parents' Emails<br />
</span>
<?
echo "$emails; info@paulthetutors.com  <BR /><br />";
?>

<span class="Head2_Green"><br />
Tutor's Emails</span><br />
<p align="left">
<?php
$where = " where position like '%tutor%' and archived <> 1 ";

$result = mysqli_query($con,"SELECT email FROM PT_Tutors $where order by position DESC,id ASC");
while($row = mysqli_fetch_array($result)) {
echo "<div style='text-align:justify'>".$row['email'].";"."</div>";
}
?>

<br />
<br />
</p>
<?

put_ptts_footer("");
?>
