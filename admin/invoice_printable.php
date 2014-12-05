<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();


$fid = isset($_REQUEST['fid']) ? $_REQUEST['fid'] : null;
$tid = isset($_REQUEST['tid']) ? $_REQUEST['tid'] : null;
$month = isset($_REQUEST['month']) ? $_REQUEST['month'] : date('n');
$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : date('Y');
$numday = isset($_REQUEST['numday']) ? $_REQUEST['numday'] : null;
$strMonth = date('F', mktime(0,0,0,$month,1,$year));


put_ptts_header('Invoice', $strAbsPath, "admin", "popup");
$style1 = 'color:#00b050'; $style2 = 'color:#7030a0';
// echo "string month is $strMonth and month is $month, $year and request is $_REQUEST[month]";

?>
<table width="100%" border="0" height="0" cellpadding="3" margin="0" cellspacing="3" bgcolor="#FFFFFF">

<tr>
  <td>    
	<div><img src="../images/logo_print.jpg"></div>  
<BR> 
   <? isset($Str_Mess) && print($Str_Mess);
// if fid is 0 we get all students info!
if ($fid != 0){
	$QStrWhere = " where id = $fid";
} else {
	$QStrWhere = "";
}

$QStr = "select students, billing_name, id as fid, username, password from PT_Family_Info $QStrWhere order by students";
if(!($StudentInfoRS = mysql_query($QStr))){
	echo "$QStr <br>" . mysql_error();
}
//get each students info
while($arStudentInfo = mysql_fetch_array($StudentInfoRS)){
	$arStudentsInfo[$arStudentInfo['fid']] = $arStudentInfo;
}

reset($arStudentsInfo);
do {
	$arSInfo = current($arStudentsInfo);
	// get the scheduling information for the student
	$arBillInfo = gettutBillInfo($month, $year,$arSInfo['fid'], $tid,'');
	//sort $arBillInfo based on the date
	if(is_array($arBillInfo)){

$billtitle = $arSInfo['billing_name'] ." (" .$arSInfo['students'].")";
		$temptitle = "$strMonth $year bill for $billtitle";

$anchor = $arSInfo['fid'] + 1; 

?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td align="center" height="12">
	        <table width="100%" border="1" height="" cellpadding="3" margin=0 cellspacing="0" bgcolor="#FFFFFF" class="table_1">
	         <tr>
	    		<td class=td_header style='background:#ffffff; color:#000;' colspan="6"><?=$temptitle; ?>&nbsp;&nbsp;&nbsp;</td>
	  		</tr>
              <tr><td>
                <div align="left"><strong>Date</strong></div></td>
              <td>
                <div align="left"><strong>Hours</strong></div></td>
              <td>
                <div align="left"><strong>Rate</strong></div></td>
              <td>
                <div align="left"><strong>Special</strong></div></td>
              <td>
                 <div align="left"><strong>Tutor</strong></div></td>
              </td>
              <td>
                <div align="left"><strong style="<?php echo $style1?>">Bill</strong></div></td>
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

			echo "<td>" . $arTempInfo['date'] . "</td>\r";
			echo "<td>" .  $arTempInfo['hours'] . "</td>\r";
			echo "<td>" .  $arTempInfo['rate'] . "</td>\r";
			echo "<td>" .  $arTempInfo['special'] . "</td>\n\r";
			echo "<td>" . $arTempInfo['t_name'] . "</td>\r";
		echo "<td>\n\r $ " . $arTempInfo['hours'] * $arTempInfo['rate'] . "</td>";
		$text_del = "Removed ".$arTempInfo['printday']." $strMonth $year bill for $billtitle";
?>
</tr>
<?php
			$total += $arTempInfo['hours'] * $arTempInfo['rate'];
			$total_wages += $arTempInfo['hours'] * $arTempInfo['pay'];
		} while(next($arBillInfo));
		
		$arr_status = array("paid"=>"Paid","notpaid"=>"Not Paid");
		$res_bill = runquery("SELECT * FROM PT_Billing WHERE month='".(int)$month."' AND year='".$year."' AND fid='".$arSInfo['fid']."' LIMIT 1");
		$row_bill = mysql_fetch_array($res_bill);
		if ($row_bill['status'] == 'partpaid')
			$status = 'Owe '.'$'.number_format($row_bill['amount'] - $row_bill['paid_amount'],2);
		else
			$status = (isset($row_bill['status']) && isset($arr_status[$row_bill['status']])) ? $arr_status[$row_bill['status']] : null;
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
                <td><div style="float:right;color:<?php echo $a_color?>"><strong><?php echo $status;?></strong></div>  <strong style="<?php echo $style2?>">$<? echo number_format($total,2);?></strong></td>
              </tr>
            </table>

    </td>
	  </tr></table><BR><BR>
            <?
	$total = 0;
	}
} while(next($arStudentsInfo));

put_ptts_footer("popup");
?>
<script language="javascript">window.print()</script>
