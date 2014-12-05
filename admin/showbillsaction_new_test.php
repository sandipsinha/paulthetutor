<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

printarray($_REQUEST);
$folder = getfolder('','','');
if($folder == "tutors"){ // if this page is being included by a page in the tutors folder
	$tutor_id = $_SESSION['tutor_id'];
//	echo "folder does equal tutors <BR>";
}
?>
 <script language="JavaScript" src="/includes/utils.js" type="text/javascript"></script>
<?



$fid = $_REQUEST[fid];
$tid = $_REQUEST[tid];
$month = $_REQUEST[month];
$year = $_REQUEST[year];
$numday = $_REQUEST['numday'];
$del_fid = $_REQUEST['del_fid'];
$del_id = $_REQUEST['del_id'];
$hours = $_REQUEST['hours'];
$rate = $_REQUEST['rate'];
$addname = $_REQUEST[addname];
$delname = $_REQUEST[delname];
$anchor = 0;

// if a delete command has been given, insert the info into PTMissedApp
If (isset($del_id) && $del_id){
	$Str_Mess = "<strong>Deleted Session $del_id</strong><BR><BR>";
// echo "we would delete $del_id<br>";
	session_del($del_id,'','');
//	client_tut_del($del_date, $del_fid, $del_tid, '');
} // end if	 delete


$strMonth = date("F", mktime (0,0,0,$month,15,$year));
$shortMonth = date("M", mktime (0,0,0,$month,15,$year));
// echo "$strMonth <br>";
$arFields = array("Date, Hours, Rate, Special, Amount");

$titlestring = "Show $strMonth $year Bills";

put_ptts_header($titlestring, $strAbsPath, "admin", $_REQUEST["popup"]);
$style1 = 'color:#00b050'; $style2 = 'color:#7030a0';
?>
<h1 style="padding:10px; background:#eee; border:1px solid #999; text-align:center;" ><?=$strMonth;?> Bills Summary</h1>
<form name="form" action="showbillsaction_new.php" method="get">
<input name="month" type="hidden" value="<?=$month;?>">
<input name="tid" type="hidden" value="<?=$tid;?>">
<input name="fid" type="hidden" value="<?=$fid;?>">
<input name="year" type="hidden" value="<?=$year;?>">
<input name="delname" type="hidden">
<input name="del_fid" type="hidden">
<input name="del_tid" type="hidden">
<input name="del_id" type="hidden">
<input name="numday" type="hidden">
<input name="todo" type="hidden" value="delete">
<input type="submit" style="display:none">
<table width="100%" border="0" height="0" cellpadding="3" margin="0" cellspacing="3" bgcolor="#FFFFFF">

<tr>
  <td>


<?
if($folder <> "tutors"){
?>
<div style="float:right"><table cellspacing="0" cellpadding="0"><tr><td><img src="../images/printButton.png"></td><td style="padding-left:6px"><a target="_blank" href="invoice_printable.php?fid=<?php echo $fid?>&tid=<?php echo $tid?>&month=<?php echo $month?>&year=<?php echo $year?>">Printable Invoice</a></td></tr></table></div><div style="clear:both"></div>
<BR>
<? } ?>
   <? echo $Str_Mess;
// if fid is 0 we get all students info!
if ($fid != 0){
	$QStrWhere = " where id = $fid";
} else {
	$QStrWhere = "";
}

$QStr = "select billing_name, id as fid, username, password from PT_Family_Info $QStrWhere order by billing_name";
if(!($StudentInfoRS = mysql_query($QStr))){
	//echo "$QStr <br>" . mysql_error();

}

//get each students info
while($arStudentInfo = mysql_fetch_array($StudentInfoRS)){
	$arStudentsInfo[$arStudentInfo[fid]] = $arStudentInfo;
}

//printarray($arStudentsInfo);

reset($arStudentsInfo);

do {
	$arSInfo = current($arStudentsInfo);
	// get the scheduling information for the student
	$arBillInfo = gettutBillInfo($month, $year,$arSInfo[fid], $tid,'');
	//sort $arBillInfo based on the date
	if(is_array($arBillInfo)){
    $arSInfo[students] = get_family_sname($arSInfo[fid]);
    $billtitle = "[$arSInfo[fid]] $arSInfo[billing_name] - $arSInfo[students]";
		$temptitle = "$shortMonth $year: $billtitle";
    $anchor = $arSInfo[fid] + 1;

?>
<a name="g<?=$anchor;?>"></a>
		<div align="right"><button onclick="javascript:popup('addsess_loc.php?popup=popup','','500','500')"  style="cursor:pointer">Add New Session</button></div>


    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#996600">
	  <tr>
	    <td class=td_header><?=$temptitle; ?>&nbsp;&nbsp;&nbsp;
<?
$isin = inautopay($arSInfo[fid]);
if($isin > 0){
?>
<img src="../images/credit_card.png" width="32" height="32" /> &nbsp;&nbsp;&nbsp;
<? } ?>

        <a target=_blank class="a_white"  style="font-size:13px" href="allbills_action.php?fid=<?php echo $arSInfo[fid] ?>">All Months</a>&nbsp;&nbsp;&nbsp;
        <a target=_blank class="a_white"  style="font-size:13px" href="billinghistory_action.php?fid=<?php echo $arSInfo[fid] ?>">Billing History</a>&nbsp;&nbsp;&nbsp;
        <a class="a_white"  style="font-size:13px" onclick="javascript:popup('recalc_rates_test.php?popup=popup&month=<?=$month;?>&year=<?=$year;?>&fid=<?php echo $arSInfo[fid] ?>&sid=<?php echo $arTempInfo[student_id] ?>','','500','500')">Recalculate Rates: <?= $arSInfo[fid] ?></a>
        <!-- <a target=_blank class="a_white"  style="font-size:13px" href="billinghistory_action.php?fid=<?php echo $arSInfo[fid] ?>">Recalculate Rates</a> -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </tr>
	  <tr>
	    <td align="center" height="12">
	        <table width="100%" border="1" height="" cellpadding="3" margin=0 cellspacing="0" bgcolor="#FFFFFF" class="table_1">
              <tr><td>
                <div align="left"><strong>Date</strong></div></td>
              <td>
                <div align="left"><strong>Student</strong></div></td>
              <td>
                 <div align="left"><strong>Tutor</strong></div></td>
              <td>
                <div align="left"><strong>Location</strong></div></td>
              <td>
                <div align="left"><strong>Hours</strong></div></td>
              <td>
                <div align="left"><strong style="<?php echo $style1?>">Rates</strong></div></td>
              <td>
                <div align="left"><strong style="<?php echo $style1?>">Total</strong></div></td>
              <td>
                <div align="left"><strong>Special</strong></div></td>


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
//			printarray($arTempInfo);
			$studentstr = "$arTempInfo[student_name] ($arTempInfo[student_id])";

			echo "<td>" . $arTempInfo[date] . "(". $arTempInfo[id]. ")</td>\r";
			echo "<td>" .  $studentstr . "</td>\r";
			echo "<td>" . $arTempInfo[t_name] . "</td>\r";
			echo "<td>" .  $arTempInfo[location] . "</td>\r";
			echo "<td>" .  $arTempInfo[hours] . "</td>\r";


if($folder == 'admin'){
	$rate_hr = " / $arTempInfo[rate] ";
}
			echo "<td> $arTempInfo[pay] $rate_hr </td>\r";


if($folder == 'admin'){
	$rate_prt = number_format($arTempInfo[rate]*$arTempInfo[hours],2);
	$rate_tot = " / $rate_prt ";
}

$pay_prt = number_format($arTempInfo[pay]*$arTempInfo[hours],2);

			echo "<td> $pay_prt $rate_tot  </td>";
			echo "<td>" .  $arTempInfo[special] . "</td>\n\r";

		$text_del = "Removed $arTempInfo[printday] $strMonth $year bill for $billtitle";
		$del_id = $arTempInfo[id];
?>
<td align=center><a href=#void onclick="<?="if (confirm('Are u sure you want to cancel this appointment ?')){document.form.action='showbillsaction_new.php#g".$anchor."';document.form.delname.value='$text_del'; document.form.del_id.value='".$del_id."';document.form.del_tid.value='".$arTempInfo[tid]."';document.form.numday.value='".$arTempInfo[printday]."'; document.form.submit()}";?>"><img  SRC="../images/del_x.gif" ALT="remove" border="0"></a>&nbsp;&nbsp;

<? if($arTempInfo['id']){?>
<a href="javascript:popup('appoint_edit_loc.php?appntId=<?=$arTempInfo['id']?>','Details','460','460')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>
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
                <td colspan=5 align="center"><b>Total&nbsp;&nbsp;</b></td>
   				<td>
                  <strong style="<?php echo $style2?>">$<?=number_format($total_wages,2);?></strong>
                </td>
                <td>  <strong style="<?php echo $style2?>">$<? echo number_format($total,2);?></strong></td>
               <td></td>
			    <td><div align="center" style="color:<?php echo $a_color?>"><strong><?php echo $status;?></strong></div></td>
              </tr>
    <? /* if ($folder == "tutors"){?>
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

              <tr>
<form name="form1" method="post" action="showbillsaction_new.php#g<?=$anchor;?>">
				<input name="month" type="hidden" value="<?=$month;?>">
				<input name="year" type="hidden" value="<?=$year;?>">
				<input name="addname" type="hidden" value="<?="$strMonth $year bill for $billtitle"?>">
				<input name="tid" type="hidden" value="<?=$tid;?>">
				<input name="fid" type="hidden" value="<?=$fid;?>">
				<input name="add_fid" type="hidden" value="<?=$arSInfo[fid];?>">

                <td>
                  <div align="center"><?="$year - $month - ";?>
                    <input name="numday" type="text" id="add_day" size="2" maxlength="2">
                  </div></td>
                <td><div align="center">
                  <input name="hours" type="text" id="hours" size="5" maxlength="5">
                </div></td>
                <td><div align="center">
                  <input name="rate" type="text" id="rate" size="5">
                </div></td>
                <td><div align="center">
				<INPUT  name="action" value="add" TYPE="IMAGE" SRC="../images/add_plus.gif" ALT="add" border="0" >
				</div></td>
                <td><div align="center">&nbsp;
                </div></td>
                <td colspan="2"><div align="center">&nbsp;</div></td>

				</form>
              </tr>
    <?   } */?>
            </table>

    </td>
	  </tr></table><BR><BR>
            <?
	$total = 0;
	} //end if is array Bill Info
} while(next($arStudentsInfo));
?>
</form>
<?php

if ((!$_REQUEST["not_mothh_view"]) and ($folder <> "tutors")) {

    $my = $year."-".($month<10 ? '0'.$month : $month);
    $strMonth = date("F", mktime (0,0,0,$month,15,$year));
    if ($tid)
        $where = 'AND t.id='.$tid;
    $sort = $_REQUEST[sort];
    if(isEmpty($sort))  $sort = "id";
    $order = $_REQUEST[order];
    if(isEmpty($order)) $order = "ASC";

    $sortby = "Order by $sort $order";

    $QStr = "   select ts.id,CONCAT(ts.first_name, ' ', ts.last_name) as employee,
     (    select ROUND(COALESCE(SUM(hours*pay),0),2)

       from
     PTAddedApp aa
       where
       aa.tid = ts.id
       and year(aa.date) = $year
       and month(aa.date) = $month
       and (aa.family_id in (select id from PT_Family_Info) or family_id in (select id from PT_Family_Info2))


     ) as tutoring,
     (select ROUND(COALESCE(SUM(hours*rate),0),2)
       from PT_NT_Work_Hours nt
       where
       nt.tutor_id = ts.id
    and year(nt.date) = $year
       and month(nt.date) = $month

     ) as admin


    from PT_Tutors ts where (ts.id in (select DISTINCT tid from PTAddedApp where MONTH(date) = $month and Year(date) = $year) or ts.id in (select DISTINCT tutor_id from PT_NT_Work_Hours where MONTH(date) = $month and Year(date) = $year)) and ts.id<> 1 $where $sortby";
    //if the data is not there, just output no data available
    //$RS = runquery($QStr);
    $RS = mysql_query($QStr);
    if($RS == false) {
        echo "No data available!";
    }

    month_overview($month,$year,$tid);

}


?>

<?php
//echo "hello";
//
// if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == "YES") {
//     //rerate_sessions($family_id, $start_date);
//     echo "<script>alert('hello');</script>";
// }

?>


<?
put_ptts_footer($_REQUEST["popup"]);
?>
