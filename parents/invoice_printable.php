<?php
include("../includes/config.php");
include($strAbsPath . "/includes/.check_login.php");
require_once($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
reqToVars();
$famid=$_SESSION['fid'];
$fid = $famid;
$main_name = getMainName($fid);;

// put_ptts_header($titlestring, $strAbsPath, "admin", "popup");
$main_name = getMainName($famid);
$bill_ready = 0;

$SName = getStudentsName($famid);
$strMonth = date("F", mktime (0,0,0,$month,7,$year));
$arFields = array("Date, Hours, Rate, Special, Amount");
$titlestring = "$strMonth $year Bill for $main_name";


// get the scheduling information for the student
// printarray($_REQUEST);
// echo "fid: $fid  y: $year   m:  $month <BR>" ;
$BillRS = runquery("select * from PT_Billing where month = $month and year = $year and fid = $famid");

if($arPay = mysql_fetch_array($BillRS)){

	$bill_ready = 1;
	
	$arBillInfo = gettutBillInfo($month, $year, $famid, '', '');
//	$Notice = "Please make your check out to: Paul the Tutor's<BR/><BR/>Mail check to:<BR>Paul the Tutor's<BR>4235 Piedmont Ave.<BR>Oakland, CA 94611";
} else {
	
//	$Notice = "Your bill for $strMonth $year is not ready yet."; 
}
?>
<table width="900" border="0" cellpadding="5" cellspacing="0">
<tr><td width="524">
<div><img src="../images/logo_print.jpg"></div>  
<BR> 
    <span class="Head1_Green" style="color:#000">
    <?=$titlestring; ?></span>	<br>
<br>
<? if($bill_ready == 1){ ?>
    <table width="100%" border="2" height="" cellpadding="3" margin=0 cellspacing="0"  class="table_1">
            <td>
              <div align="center"><b>Date</b></div>
            </td>
            <td>
              <div align="center"><b>Hours</b></div>
            </td>
            <td>
              <div align="center"><b>Rate</b></div>
            </td>
            <td>
              <div align="center"><b>Student</b></div>
            </td>
            <td>
              <div align="center"><b>Tutor</b></div>
            </td>
            <td>
              <div align="center"><b>Comment</b></div>
            </td>
            <td>
              <div align="center"><b>Amount</b></div>
            </td>
            </tr>
            <?

	
	$countsize = count($arBillInfo);
//	echo"count".$countsize;
	$i = 0;
	do{
		$arTempInfo = current($arBillInfo);

		echo "<tr>";

		echo "<td>" . $arTempInfo[date] . "</td>";
		echo "<td>" .  $arTempInfo[hours] . "</td>";
		echo "<td>" .  $arTempInfo[rate] . "</td>";
		echo "<td>" .  $arTempInfo[student_name] . "</td>";
		echo "<td>" .  $arTempInfo[t_name] . "</td>";
		echo "<td>" .  $arTempInfo[comments] . "&nbsp;</td>";
		echo "<td> $ " . $arTempInfo[hours] * $arTempInfo[rate] . "</td>";

		echo"</tr>";

		$total += $arTempInfo[hours] * $arTempInfo[rate];
	} while(next($arBillInfo));
	?>
              <tr>
              <td colspan=6>&nbsp;</td>
            </tr>
          <tr>
              <td colspan=6>
              <div align="right"><b>Total&nbsp;&nbsp;</b></div></td>
              <td> $
                <?=$total;?>
              </td>
      </tr>
    </table>
	
	
<? }?>
</td>
</tr>
    </table>

<script language="javascript">window.print()</script>