<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
reqToVars();


$titlestring = "Send $strMonth $year Bills";
put_ptts_header($titlestring, $strAbsPath, "admin", "");

$grandtotal = 0;
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$strMonth = date("F", mktime (0,0,0,$month,7,$year));
$arFields = array("Date, Hours, Rate, Special, Amount");
$tid = $_REQUEST['tid'];

?>
<h1 style="padding:10px; background:#eee; border:1px solid #999; text-align:center;" >Show Bills</h1>

<table width="100%" border="0" height="0" cellpadding="3" margin="0" cellspacing="3" bgcolor="#FFFFFF">

<tr>
  <td>    <form name="form1" method="post" action="sendbillsaction2_new.php">

     <table width="100%" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" class=table_1>
	  <tr>
	    <td class="td_header">Message To All Parents</td>
	</tr><tr></tr>	
	    <td>
		<table width="100%" border="2" cellpadding="2" margin=0 cellspacing="0" bgcolor="#FFFFFF" class=table_1>
             <tr>
			  <td>
                <div>
                  <textarea name="allparents" cols="50" rows="4" id="allparents"></textarea>
                </div>
              </td>
			 </tr>
	 </table> 
</td>
	  </tr>
	 </table> 
	  
<BR><BR>	 
   <?
// if fid is 0 we get all students info!
	if ($fid != 0){
		$QStrWhere = " where id = $fid";
	} else {
		$QStrWhere = "";
	}

$QStr = "select students, billing_name, id as fid, username, password from PT_Family_Info $QStrWhere order by billing_name";
if(!($StudentInfoRS = mysql_query($QStr))){
	echo "$QStr <br>" . mysql_error();
}
//get each students info
while($arStudentInfo = mysql_fetch_array($StudentInfoRS)){
	$arStudentsInfo[$arStudentInfo[fid]] = $arStudentInfo;
}

reset($arStudentsInfo);
do {


	$arSInfo = current($arStudentsInfo);
	// get the scheduling information for the student
	$arBillInfo = gettutBillInfo($month, $year,$arSInfo[fid], $tid,'');

	if(is_array($arBillInfo)){
$billtitle = "$arSInfo[billing_name] ($arSInfo[students])";

		$temptitle = "$strMonth $year bill for $billtitle";

?>
    <table width="100%" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" class=table_1>
	  <tr>
	    <td class="td_header"><?=$temptitle; ?></td>
	  </tr>
	  <tr>
	    <td align="center" height="12">
	        <table width="100%" border="2" height="" cellpadding="4" margin=0 cellspacing="0" bgcolor="#FFFFFF" class=table_1>
              <td>
                <div align="left"><b>Date</b></div>
              </td>
              <td>
                <div align="left"><b>Hours</b></div>
              </td>
              <td>
                <div align="left"><b>Rate</b></div>
              </td>
              <td>
                <div align="left"><b>Special</b></div>
              </td>
               <td>
                <div align="left"><b>Tutor</b></div>
              </td>
              <td>
                <div align="left"><b>Amount</b></div>
              </td>
              </tr>
              <?

		$countsize = count($arBillInfo);
		$i = 0;
		do{
			$arTempInfo = current($arBillInfo);

			echo "<tr>\n\r";

			echo "<td>" . $arTempInfo[date] . "</td>\r";
			echo "<td>" .  $arTempInfo[hours] . "</td>\r";
			echo "<td>" .  $arTempInfo[rate] . "</td>\r";
			echo "<td>" .  $arTempInfo[special] . "</td>\n\r";
			echo "<td>" . $arTempInfo[t_name] . "</td>\r";
			echo "<td>" . $arTempInfo[hours] * $arTempInfo[rate] . "</td>\r";
			echo"</tr>\r";

			$total += $arTempInfo[hours] * $arTempInfo[rate];
		} while(next($arBillInfo));
	?>
              <tr>
                <td colspan=6>&nbsp;</td>
              </tr>
              <tr>
                <td colspan=5>
                  <div align="center"><b>Total</b></div>
                </td>
                <td>
                  <?=$total;
				  $grandtotal = $grandtotal + $total;
				  
				  ?>
                </td>
              </tr>
              <tr>
                <td colspan=6>&nbsp;</td>
              </tr>
              <tr>
                <td colspan=6><b>Comments For The Parents:</b><br>
                  <textarea name="arComments[<?=$arSInfo[fid]?>]" cols="50" rows="3"></textarea>
                  <input type="hidden" name="arTotals[<?=$arSInfo[fid]?>]" value="<?=$total?>">

                </td>
              </tr>
            </table>

            </td></tr></table><BR><BR>
            <?
	$total = 0;
	} //end if is array Bill Info
} while(next($arStudentsInfo));
?>
            <input type="hidden" name="month" value="<?=$month?>">
            <input type="hidden" name="year" value="<?=$year?>">
    <table width="500" border="2" cellspacing="2" cellpadding="0" bgcolor="#FFFFFF" bordercolor="#FFFFFF">
	  <tr>
	    <td><div align="center">
				<input type="submit" name="Submit" value="Send Bills" onclick="if (confirm('Are you sure you want to send bills?')){document.form1.submit()} else return false;">
				<input type="reset" name="Submit2" value="Reset">
            </div></td>
	  </tr>	</table>
<?= "<br><b>Total = $grandtotal</b>";?>
    </form>
<?
put_new_footer();
?>
