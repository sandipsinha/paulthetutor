<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
printarray($_REQUEST);
reqToVars();
$anchor = 0;
$fid=$_REQUEST['fid'];
$tid=$_REQUEST['del_tid'];
$del_fid=$_REQUEST['del_fid'];
$del_tid=$_REQUEST['del_tid'];
$delname=$_REQUEST['delname'];
$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
// if a delete command has been given, insert the info into PTMissedApp
If (isset($del_fid) && $del_fid){
	$Str_Mess = "<strong>$delname </strong><BR><BR>";
	$del_date = $year . "-" . $month . "-" . $_REQUEST['numday'];
	
	client_tut_del($del_date, $del_fid, $del_tid, '');
} // end if	 delete

$titlestring = "Show All Bills";

put_ptts_header($titlestring, $strAbsPath, "admin", $_REQUEST["popup"]);
$style1 = 'color:#00b050'; $style2 = 'color:#7030a0';
?>

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
//echo "++".$month."++";
?>
<form name="form" method="get">
<input name="tid" type="hidden" value="<?=$tid;?>">
<input name="fid" type="hidden" value="<?=$fid;?>">
<input name="delname" type="hidden">
<input name="del_fid" type="hidden">
<input name="del_tid" type="hidden">
<input name="year" type="hidden" value="<?=$year;?>">
<input name="month" type="hidden" value="<?=$month;?>">
<input name="numday" type="hidden">
<input name="todo" type="hidden" value="delete">
<input type="submit" style="display:none">
<?php
while ($year>=$year_min || ($year == $year_min && $month>=$month_min)){
	//echo "^^^^".$month."^^^^^";
$arBillInfo = gettutBillInfo($month, $year,$arSInfo[fid], $tid,'');
	//sort $arBillInfo based on the date
	
if(is_array($arBillInfo)){
$nr_bills++;
$billtitle = "$arSInfo[billing_name] ($arSInfo[students])";
$strMonth = date("F", mktime (0,0,0,$month,7,$year));
$temptitle = "$strMonth $year bill for $billtitle";
$anchor = $arSInfo[fid] + 1; 
//echo "**".$month."<br/>";
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
                <div align="left"><strong>Special</strong></div></td>
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
			echo "<td>" .  $arTempInfo[special] . "</td>\n\r";
			echo "<td>" . $arTempInfo[t_name] . "</td>\r";
		echo "<td>\n\r $ " . $arTempInfo[hours] * $arTempInfo[rate] . "</td><td align=center>";
		$text_del = "Removed $arTempInfo[printday] $strMonth $year bill for $billtitle";
?>

<? if($arTempInfo['id']){?><a onclick="javascript:popup('added_appoint_edit.php?appntId=<?=$arTempInfo['id']?>','Details','460','460')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;&nbsp;<? }?>	
<?php /*?><a onclick="if (confirm(\'Are you sure you want to delelte this bill?\')) {document.form.delete_id.value='.$row[id].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a><?php */?>
<a href=#void onclick="<?="if (confirm('Are u sure you want to cancel this appointment ?')){document.form.action='miviram_allbills_action.php#g".$anchor."';document.form.delname.value='$text_del';document.form.month.value='$month';document.form.year.value='$year';document.form.del_fid.value='".$arSInfo[fid]."';document.form.del_tid.value='".$arTempInfo[tid]."';document.form.numday.value='".$arTempInfo[printday]."'; document.form.submit()}";?>"><img  SRC="../images/del_x.gif" ALT="remove" border="0"></a>&nbsp;
<?	echo"</td></tr>"; ?>
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
