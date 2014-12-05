<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
printarray($_REQUEST);
reqToVars();
$anchor = 0;

If (isset($del_id) && $del_id){
	$Str_Mess = "<strong>$delname </strong><BR><BR>";
	$del_date = $year . "-" . $month . "-" . $_REQUEST['numday'];
	session_del($del_id,'','');
} // end if	 delete

$titlestring = "Show All Bills";

put_ptts_header($titlestring, $strAbsPath, "admin", $_REQUEST["popup"]);
$style1 = 'color:#00b050'; $style2 = 'color:#7030a0';
?>
<form name="form" method="get">
<input name="tid" type="hidden" value="<?=$tid;?>">
<input name="fid" type="hidden" value="<?=$fid;?>">

<table width="100%" border="0" height="0" cellpadding="3" margin="0" cellspacing="3" bgcolor="#FFFFFF">

<tr>
  <td>
    <div style="float:left"><?php echo '<a href="billinghistory_action.php?fid='.$fid.'">Billing History</a>';?>&nbsp;</div>
    <div style="float:right"><?php echo '<u>'.fam_contact($fid).'</u>';?>&nbsp;</div><div style="clear:both"></div>
<BR>	 
   <? isset($Str_Mess) && print($Str_Mess);

$QStr = mysql_query("select students, billing_name, id as fid, username, password from PT_Family_Info where id = $fid order by students");
$arSInfo = mysql_fetch_array($QStr);

$cur_year = date("Y"); $cur_month = date("n");
$res_min_date = runquery("SELECT date FROM PTAddedApp WHERE date!='0000-00-00' AND sid='".$fid."' ORDER BY id ASC LIMIT 1");
$row_min_date = mysql_fetch_array($res_min_date);
$min_date = $row_min_date['date'];
$year_min = date("Y",strtotime($min_date));
$month_min = date("n",strtotime($min_date));
$year = $cur_year;
$month = $cur_month;
$nr_bills = 0;

while ($year>=$year_min || ($year == $year_min && $month>=$month_min)){
$arBillInfo = gettutBillInfo($month, $year,$arSInfo[fid], $tid,'');
	//sort $arBillInfo based on the date
if(is_array($arBillInfo)){
$nr_bills++;
$billtitle = "$arSInfo[billing_name] ($arSInfo[students]) $arSInfo[fid]";
$strMonth = date("F", mktime (0,0,0,$month,7,$year));
$temptitle = "$strMonth $year bill for $billtitle";
$anchor = $arSInfo[fid] + 1; 

?>
<a name="g<?=$anchor;?>"></a>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#996600">
	  <tr>
	    <td class=td_header><?=$temptitle; ?></td>
	  </tr>
	  <tr>
	    <td align="center" height="12">
	        <table width="100%" border="1" height="" cellpadding="3" margin=0 cellspacing="0" bgcolor="#FFFFFF" class="table_1">
              <tr><td>
                <div align="left"><strong>Date</strong></div></td>
              <td>
                <div align="left"><strong>Student</strong></div></td>
              <td>
                <div align="left"><strong>Hours</strong></div></td>
              <td>
                <div align="left"><strong>Rate</strong></div></td>
              <td>
                <div align="left"><strong style="<?php echo $style1?>">Wages</strong></div></td>
              <td>
                <div align="left"><strong>Location</strong></div></td>
              <td>
                 <div align="left"><strong>Tutor</strong></div></td>
              </td>
              <td>
                <div align="left"><strong style="<?php echo $style1?>">Bill</strong></div></td>
              <td><div align="center"><strong>Action</strong></div></td>
              </tr>
			  
			  
			  
              <?

		$countsize = count($arBillInfo);
		$i = 0; $total = 0; $total_wages = 0;
		do{
			$arTempInfo = current($arBillInfo);
//printarray($arTempInfo);
?>

<?
			echo "<tr>\n\r";
			$studentstr = "$arTempInfo[student_name] ($arTempInfo[student_id])";

			echo "<td>" . $arTempInfo[date] . "</td>\r";
			echo "<td>" .  $studentstr . "</td>\r";
			echo "<td>" .  $arTempInfo[hours] . "</td>\r";
			echo "<td>" .  $arTempInfo[rate] . "</td>\r";
			echo "<td>" .  $arTempInfo[pay] . "</td>\r";
			echo "<td>" .  $arTempInfo[location] . "</td>\n\r";
			echo "<td>" . $arTempInfo[t_name] . "</td>\r";
		echo "<td>\n\r $ " . $arTempInfo[hours] * $arTempInfo[rate] . "</td><td align=center>";
		$text_del = "Removed $arTempInfo[printday] $strMonth $year bill for $billtitle";
?>
<a href=allbills_action.php?del_id=<?=$arTempInfo[id]?> onclick="<?="if (confirm('Are u sure you want to cancel this appointment ?')){document.form.action='allbills_action.php'; document.form.submit()}";?>"><img  SRC="../images/del_x.gif" ALT="remove" border="1"></a>&nbsp;&nbsp;

<? if($arTempInfo['id']){?>
<a href="javascript:popup('added_appoint_edit.php?appntId=<?=$arTempInfo['id']?>','Details','460','460')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>
	<?}	echo"</td></tr>"; ?>
<?
			$total += $arTempInfo[hours] * $arTempInfo[rate];
			$total_wages += $arTempInfo[hours] * $arTempInfo[pay];
		} while(next($arBillInfo));
		
		$arr_status = array("paid"=>"Paid","notpaid"=>"Not Paid");
		$res_bill = runquery("SELECT * FROM PT_Billing WHERE month='".(int)$month."' AND year='".$year."' AND fid='".$arSInfo[fid]."' LIMIT 1");
		$row_bill = mysql_fetch_array($res_bill);
		if ($row_bill['status'] == 'partpaid')
			$status = 'Owe '.'$'.number_format($row_bill['amount'] - $row_bill['paid_amount'],2);
		else
			$status = $arr_status[$row_bill['status']];
		if ($status == '')
			$status = $arr_status['notpaid'];
		if ($row_bill['status'] != 'paid')
		   	$a_color = 'red';
		else
		   	$a_color = 'black';
		
	?>
              
			  <tr>
                <td colspan=7>&nbsp;</td>
              </tr>
              <tr>
                <td colspan=3 align="center"><b>Total&nbsp;&nbsp;</b></td>
   				<td>
                  <strong style="<?php echo $style2?>">$<?=number_format($total_wages,2);?></strong>
                </td>
                <td></td>
                <td></td>
                <td>  <strong style="<?php echo $style2?>">$<? echo number_format($total,2);?></strong></td>
                <td><div align="center" style="color:<?php echo $a_color?>"><strong><?php echo $status;?></strong></div></td>
              </tr>
            </table>

    </td>
	  </tr></table><BR><BR>
            <?
	$total = 0;
}
$month-=1;
if ($month == 0){
	$year--;
	$month = 12;
	}
}
if ($nr_bills == 0)
	echo "No Bills found<br>";
?>
</form>
<?
put_ptts_footer($_REQUEST["popup"]);
?>
