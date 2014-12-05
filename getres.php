<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();
reqToVars();
put_ptts_header("", $strAbsPath, "", "");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<style type="text/css">
<!--
.plain {
	font-weight: normal;
}
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style2 {font-size: 9px}
-->
</style>
<link href="includes/paulthetutors.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="850" border="0" cellpadding="3" cellspacing="0" background="images/flowbg.gif">
  <tr>
    <td height="29" colspan="2" valign="top"><span class="Head1_Green"> <br>
Schedule an Interview </span>
      <div align="right"></div></td>
    <td width="151" rowspan="2" align="center" valign="bottom">	  <div align="center"><a href="http://www.tinyurl.com/ldsatstudyguide"><img src="images/ldsat_cover_108_pix.jpg" width="149" height="188" border="0"></a><br>
    </div></td>
  </tr>
  <tr>
    <td width="37" height="279" valign="top">&nbsp;</td>
    <td width="480" height="279" valign="top">    <form name="form1" method="post" action="putres.php">
      <table width="466" border="2" cellpadding="2" cellspacing="0" bordercolor="#000000">
        <tr>
          <td colspan="2" scope="col"><strong>Pick a Time Slot <br>
            </strong>Interviews are 20 minutes unless otherwise noted              
        </tr>
        <tr>
          <td width="43%" scope="col"><div align="right"><strong>Date and Time</strong></th>
    
		  
		    </div>
          <td width="57%" scope="col">&nbsp;</th>
		    <select name="slotid" id="slotid">
		      <option value=" "> </option>
			  
<?
$QStr = "select id, time, date, location from PT_interview_res where date >= curdate()and not taken order by date,time ASC";
$RS = runquery($QStr);
while ($arid = mysql_fetch_array($RS)){
		
		$date_num = strtotime($arid[2]);
		$date_str = date('D jS, Y', $date_num);
		$time_num = strtotime($arid[1]);
		$distime = date('g:i a', $time_num);
		$location = $arid[location];
		
		echo "<option value=\"$arid[0]\">$date_str at $distime ($location)</option>";
}	     
?>			 
			  </select>
			  
		  
        </tr>
        <tr>
          <td scope="col"><div align="right"><strong>Name         </strong></div>
          <td scope="col"><input name="name" type="text" id="name" maxlength="30">        
        </tr>
        <tr>
          <td scope="col"><div align="right"><strong>Email</strong></div>
          <td scope="col"><input name="email" type="text" id="email" maxlength="30">
                </tr>
        <tr>
          <td scope="col"><div align="right"><strong>Phone</strong></div>
          <td scope="col"><input name="phone" type="text" id="phone" maxlength="30">        
        </tr>
        <tr>
          <td scope="col"><div align="right"><strong>Job<br>
                <span class="style2">For what job are you applying? </span></strong></div>
          <td scope="col"><input name="comment" type="text" id="comment" maxlength="30">        
        </tr>
        <tr>
          <td colspan="2"><div align="center">
<? 
$QStr = "select count(*) from PT_interview_res where date >= curdate() and not taken order by time ASC";
$avail = singlequery($QStr);  
if ($avail==0){  
	  
?>
<span class="style1">All of the time slots have been taken for 
<?=$show_date;?>
</span>
<? } else { ?>

<input type="submit" name="Submit" value="Submit">
 <? } ?>
          </div></td>
          </tr>
      </table>
    </form>  <br><br>
      <span class="Head2">Interview Locations</span><br />
Piedmont -  Paul the Tutor's Education Center at 4235 Piedmont Ave. Oakland, CA 94611 <BR />
Lafayette - Paul the Tutor's Education Center at 91 Lafayette Circle, Lafayette CA 94549 <BR />
Davis - TBA </td>
  </tr>  
</table>
</body>
</html>




<?
put_ptts_footer("");

?>
