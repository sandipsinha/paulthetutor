<?
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
reqToVars();
// printarray($_REQUEST);


$mon = $_REQUEST[mon];
$year = $_REQUEST[year];

// echo "requ armon is $_REQUEST[armon] ";

if(!(isEmpty($_REQUEST[armon]))){// if the month is sent as a pick array

// echo "in request armon<BR>";
  
  $armon = $_REQUEST[armon];
  $mon = $armon[month];
}

// echo "the month after armon is $mon <BR>";

if($_REQUEST[mon_hidden]){// if the month is sent as a pick array
  $mon = $_REQUEST[mon_hidden];
}
if($_REQUEST[year_hidden]){// if the month is sent as a pick array
  $year = $_REQUEST[year_hidden];
}


// echo "About to check PIN<BR>";    




if(!($mon)){ //if the date isn't set b/c it is the first time
  $lastmonth = time()-(29*24*60*60);
  $arDate = getdate($lastmonth);
  $mon = $arDate[mon];
  $year = $arDate[year];
} else {

  $timeint = mktime(0, 0, 0, $mon, 15, $year);
  $arDate = getdate($timeint);

}
$str_header = "billings $arDate[month] $year ";
put_ptts_header($str_header, $strAbsPath, "admin", "");
?>
<style type="text/css">
<!--
.style2 {
  font-weight: bold;
  font-size: 16px;
}
-->
.styleB {
  font-weight: bold;
}
.notpaid {
  font-weight: bold;
  color: #FF0000;
}
.partpaid {
  font-weight: bold;
  color: #0000FF;
}
.paid {
  font-weight: bold;
  color: #009933;
}
-->
</style>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
  	<td align="right" style="padding-bottom:5px"><button onclick="javascript:popup('add_payment.php','Add A Payment','600','600')">Add New Payment</button></td>
  </tr>

  <tr height="40">
    <td  class=td_header>Billing Information for
          <?
echo "$arDate[month] and $arDate[year]";

?>
</td>
  </tr>
  <tr>
    <td>
      <table border=1 class=table_1 width="100%" cellpadding="6" cellspacing="0" align="center">
  <tr valign="middle">
    <td height="44" colspan=10>
         
<?
$nextmonth = $mon + 1;
$prevmonth = $mon - 1;

?>
        <div align="center" class="style2">
     <form  method="post" name="form1" >
     Choose           <? putMonthsSelect("armon");
    echo "&nbsp;&nbsp";
    putYearsSelect("year");
    ?>
          <input type="submit" name="Submit" value="Submit"></form>

    <a href="billing.php?mon=<?=$prevmonth;?>&year=<?=$year;?>"><-- Prev Month</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    
    <a href="billing.php?mon=<?=$mon;?>&year=<?=$year;?>"><? echo "$arDate[month] $arDate[year]"; ?></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="billing.php?mon=<?=$nextmonth;?>&year=<?=$year;?>">Next Month --></a></div>
</td>
  </tr>
          <TR><td align="center"  width="5%" class="styleB"><a href="billing.php?mon=<?=$mon;?>&year=<?=$year;?>&orderby=fid">ID</a></td>
      <td width="15%" align="center" class="styleB"><a href="billing.php?mon=<?=$mon;?>&year=<?=$year;?>&orderby=last_name">Name</a></td>
<?
$j = 0;
for($i = -3;$i < 2; $i++){
  $timeint_tit = mktime(0, 0, 0, $mon + $i, 15, $year);
  $arMonths[$i]['month'] = date(M, $timeint_tit);
  $arMonths[$i]["mon"]= date(n, $timeint_tit);
  $arMonths[$i]["mom"]= date(m, $timeint_tit);
  $arMonths[$i]["year"]= date(Y, $timeint_tit);
  $arMonths[$i]["date"]= $arMonths[$i]["year"]."-".$arMonths[$i]["mon"]."-15";
  $arMonths[$i]["datem"]= $arMonths[$i]["year"]."-".$arMonths[$i]["mom"]."-15";


  if($i == 0){
    echo "<td align=\"center\" class=\"styleB\" > ". $arMonths[$i]['month'] . "</td>";
  } else {
    echo "<td align=\"center\" width=\"11%\" class=\"styleB\"> ". $arMonths[$i]['month'] . "</td>";
  }
  $j = $j + 1;
}

 ?>        </tr>

<form  method="post">
 <input name="mon" type="hidden" value="<?=$mon;?>">
 <input name="year" type="hidden" value="<?=$year;?>">
 
 <?
 //if the user clicks on a header title, sort table by that
 $orderby = $_REQUEST[orderby];
  if(isEmpty($orderby)){
   $orderby = "last_name";
} 
 
 $QStr = "Select distinct fid, name, SUBSTRING_INDEX(name, ' ', -1) as last_name, SUBSTRING_INDEX(name, ' ', 1) as first_name from PT_Billing where date >= '" . $arMonths[-3]["date"] . "' and date <= '" . $arMonths[1]["date"] . "' order by $orderby";
 $fidRS = runquery($QStr);
 while($arRow = mysql_fetch_array($fidRS)){
  echo "<tr><td>" . $arRow["fid"] . "</td><td>" . $arRow["last_name"].", " .$arRow["first_name"]. "</td>";
  for($i = -3;$i < 2; $i++){
    $FQStr = "select amount, status, month, year, paid_amount from PT_Billing where fid = $arRow[0] and name = '$arRow[1]' and date = '" . $arMonths[$i]["date"] . "'";
    $mbRS = runquery($FQStr);
    $armb = mysql_fetch_array($mbRS);
    if($armb["amount"]){
      if ($i==0){
        $temp_due = $armb["amount"];

        echo "<td align=\"center\"><span class=\"" . $armb["status"] ."\">" . $armb["amount"];
        if($armb["status"] == "partpaid") {
          $temp_due = $armb["amount"] - $armb["paid_amount"];
          echo " </span><span class=\"notpaid\">($temp_due)";
        }
        if($armb["status"] <> "paid") {
?>
         </td>
<?           } else {
          echo "</span>";
        }
        continue;
      }



      echo "<td $strcol align=\"center\" class=\"" . $armb["status"] ."\"> ". $armb["amount"];
      if($armb["status"] <> "paid") {
      
      $amount_pif = $armb["amount"];  //this gets a variable with the paid in full amount.
      
      }
?>

       </b>
       </td>
<?
    } else {
      $colspan = ""; //initiate
      echo "<td align=\"center\"> - </td>";

    }


  } //for
  echo "</tr>";
} //while


 ?>

 <tr><td colspan="6" align="center"><input type="submit" name="Submit2" value="Submit"> </td></tr>
 </form> </tr>
 <?
 $TQStr = "select sum(amount) as tot,sum(paid_amount) as paid_amount, date from PT_Billing where date >= '" . $arMonths[-3]["date"] . "' and date <= '" . $arMonths[1]["date"] . "' group by date order by date";
 $TRS = runquery($TQStr);
 $i = -3;
 
?>  
 <?
 while($arTot = mysql_fetch_array($TRS)){
  while($arTot["date"] <> $arMonths[$i]["datem"]){
    $tot_billed.="<td align=\"center\"><b>-</b></td>";
    $tot_paid.="<td align=\"center\"><b>-</b></td>";
    $tot_owed.="<td align=\"center\"><b>-</b></td>";
    $i = $i + 1;
  }
  $tot_billed.="<td align=\"center\"><b>".number_format($arTot["tot"],2)."</b></td>";
  $tot_paid.="<td align=\"center\"><b>".number_format($arTot["paid_amount"],2)."</b></td>";
  $tot_owed.="<td align=\"center\" style='color:red'><b>".number_format($arTot["tot"]-$arTot["paid_amount"],2)."</b></td>";
  $i = $i + 1;
 }  ?>
 <tr>
   <td align="center" colspan="2"><b>Total Billed</b></td>
   <?php echo $tot_billed?>
 </tr>
  <tr>
   <td align="center" colspan="2"><b>Total Paid</b></td>
   <?php echo $tot_paid?>
 </tr>
  <tr>
   <td align="center" colspan="2"><b>Total Owed</b></td>
   <?php echo $tot_owed?>
 </tr>

      </table>
 <br>
<?
put_ptts_footer("");
?>