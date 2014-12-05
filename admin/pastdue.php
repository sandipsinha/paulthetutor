<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
reqToVars();

$titlestring = "Show All Past due Bills";

put_ptts_header($titlestring, $strAbsPath, "admin", "");
?>
<form name="form" method="get">
<table width="100%" border="0" height="0" cellpadding="3" margin="0" cellspacing="3" bgcolor="#FFFFFF">
 <?
$res = runquery("SELECT b.*, f.billing_name, f.main_name, f.main_phone, f.billing_email, f.students FROM  PT_Family_Info f LEFT JOIN  PT_Billing b ON b.fid=f.id WHERE b.status!='paid'  AND b.date<='".adddate(date("Y-m-d"),0,-1)."' ORDER BY b.fid ASC,b.date DESC");
$last_fam = 0; $total_due = 0; $global_due = 0;
while ($row=mysql_fetch_array($res)){ 
if ($last_fam!=$row['fid']){
	if ($tab_open){?>
	 		<tr>
                <td colspan=4 align="center"><b>Total Due&nbsp;&nbsp;</b></td>
   				<td>
                  <strong style="<?php echo $style2?>">$<?=number_format($total_due,2);?></strong>
                </td>
              </tr>
              </table></td>
	  </tr>
<?php
	}
	$total_due = 0;
?>
  <tr>
	    <td align="center" height="12">
	        <table width="100%" border="1" height="" cellpadding="3" margin=0 cellspacing="0" bgcolor="#FFFFFF" class="table_1">
	          <tr>
		    	<td class=td_header colspan="8"><?php echo "Passed Due Bills for ($row[fid]) ".$row['main_name'].' ('.$row['students'].')'; ?>  &nbsp;&nbsp;<?
$isin = inautopay($row[fid]);
if($isin > 0){
?>
<img src="../images/credit_card.png" width="32" height="32" /> &nbsp;&nbsp;&nbsp;
<? } ?>        </td>
		  	</tr>
		  	  <tr style="height:35px">
		    	<td colspan="8">
                

<div style="float:right">
                
        
        <a target=_blank  style="font-size:13px" href="allbills_action.php?fid=<?php echo $row[fid] ?>">All Months</a>&nbsp;&nbsp;&nbsp;<a target=_blank  style="font-size:13px" href="billinghistory_action.php?fid=<?php echo $row[fid] ?>">Billing History</a>&nbsp;&nbsp;<u> 

<?php echo fam_contact($row['fid']).'</u></div>';
		    	echo 'Billing name: <b>'.$row['billing_name']."</b>, Email: <b><a href='mailto:".$row['billing_email']."'>".$row['billing_email']."</a></b>, Phone: <b>".$row['main_phone'].'</b>';
		    	
                
                ?>
                
		                
                </td>
		      </tr>
              <tr>
              	<td><strong>Month</strong></td>
              	<td><strong>Year</strong></td>
              	<td><strong>Amount</strong></td>
              	<td><strong>Amount Paid</strong></td>
              	<td><strong>Due</strong></td>
              </tr>
<?php $tab_open = 1;
}?>
<?php $total_due+= $row['amount'] - $row['paid_amount']; $global_due+=$row['amount'] - $row['paid_amount'];?>
			
			<tr>
				<td><?php echo date("F", strtotime($row['date']));?></td>
				<td><?php echo $row['year'];?></td>
				<td><?php echo  number_format($row['amount'],2);?></td>
				<td><?php echo  number_format($row['paid_amount'],2);?></td>
				<td><?php echo number_format($row['amount'] - $row['paid_amount'],2);?></td>
			</tr>
	
<?php 
    $last_fam = $row['fid'];
}

if ($tab_open){?>
	 		<tr>
                <td colspan=4 align="center"><b>Total Due&nbsp;&nbsp;</b></td>
   				<td>
                  <strong style="<?php echo $style2?>">$<?=number_format($total_due,2);?></strong>
                </td>
              </tr>
              </table></td>
	  </tr>
<?php
	}
?>	  
<tr>
	<td align="right" style='color:red; padding-top:10px; border:solid 1px #888; font-weight:bold'>TOTAL DUE: <?php echo '$'.number_format($global_due,2);?></td>
</tr>
</table>
<?
put_ptts_footer("");
?>