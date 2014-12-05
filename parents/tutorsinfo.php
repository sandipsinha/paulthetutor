<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");
include("../includes/.check_login.php");
MySQL_PaulTheTutor_Connect();
put_ptts_header("View Current Tutors for Paul The Tutor's", $strAbsPath, "admin", "");
$order = isset($_REQUEST['order']) ? $_REQUEST['order'] : null;
$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : null;  
$tablename = "PT_Tutors";

?>
<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Tutors</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<td class="text_grey"><b>Name</b></td>
  	<!-- <td class="text_grey"><b>Phone</b></td>
    <td class="text_Grey"><b>Work Phone</b></td> -->
  	<td class="text_grey"><b>Email</b></td>
  </tr>

<? 

$QStr = "SELECT * FROM $tablename WHERE position LIKE '%tutor%' AND password NOT LIKE '%archived%' ORDER BY id ASC;";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){

  /*$row['mobile_phone'] = format_phoneN($row['mobile_phone']);
  $row['gvoice_phone'] = format_phoneN($row['gvoice_phone']);*/

 echo '<tr>
 		<td>'.$row['first_name'].' '.$row['last_name'].'&nbsp;</td>' .
    //<td>' .$row['mobile_phone']. '&nbsp;</td>
 		//<td>'.$row['gvoice_phone'].'&nbsp;</td>
 		'<td>'.$row['email'].'&nbsp;</td>
 </tr>';
}

?>
</table>
</td>
</tr>	
</table>
</form>
<?
put_ptts_footer("");
?>
