<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
reqToVars();

$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$arTotals = $_REQUEST['arTotals'];
$strMonth = date("F", mktime (0,0,0,$month,7,$year));
$titlestring = "Sent $strMonth $year Bill(s)";


put_ptts_header($titlestring, $strAbsPath, "admin", "");

?>

<h1 style="padding:10px; background:#eee; border:1px solid #999; text-align:center;" >Send Bills</h1>
<table width="100%" border="0" height="" cellpadding="3" margin="0" cellspacing="3" bgcolor="#FFFFFF">

<tr>
  <td>
    

    <table width="500" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" bordercolor="#996600">
	  <tr>
	    <td><span class="pageheader"> <?="Bills for $strMonth $year"; ?></span></td>
	  </tr>
	  <tr>
	    <td align="center" height="12">
	        <table width="100%" border="2" height="" cellpadding="2" margin=0 cellspacing="0" bgcolor="#FFFFFF" bordercolor="#000000">
                  <td>


<?
// find all students info
$num_students = 0;
while(list($sid,$total) = each($arTotals)){
$num_students = $num_students + 1;
$TBill = 0;	
$PDStr = "";
$CStr = "";

$TStr ="";
	$QStr = "select students, billing_email, username, password, billing_name from PT_Family_Info where id = $sid";
	if(!($StudentInfoRS = mysql_query($QStr))){
		echo "$QStr <br>" . mysql_error();
	}
	
	$arStudentInfo = mysql_fetch_array($StudentInfoRS);
echo "<strong>$arStudentInfo[billing_name] </strong> <BR>";	
// get credits
$arC["credit"]  = 0;
$temp_credit = 0;
$CRS = runquery("select sum(amount) as credit from PT_Credits where fid = $sid");
$arC = mysql_fetch_array($CRS);
if($arC["credit"] > 0){
	

	$temp_credit = $arC['credit'];
	$CStr = "\n   You have a credit in the amount of $temp_credit\n\n";
	
//	$TBill = $arTotals[$sid] - $temp_credit;
//	$TBillstr = number_format($TBill,2,".",",");
//	$TStr = "Your total bill is: \$$TBillstr \n-------------------------\n";


}	
	

// get any past due bills
$past_due = "";
$PDBill = 0;
$PDStr = "";
$PDQStr = "select month, year, (amount-paid_amount) as amount, paid_amount, status from PT_Billing where fid = $sid and status in ('notpaid', 'partpaid') and (year < $year or (month < $month and year = $year)) and amount > 0 order by year, month";
$PDRS = runquery($PDQStr);
$num_rows = mysql_num_rows($PDRS);
if($num_rows > 0){
	$past_due = " Consolidated ";
	$PDStr = "\n   You also have the following bills from previous months\n";
	while($PDar = mysql_fetch_array($PDRS)){
		$timeint = mktime(0, 0, 0, $PDar["month"], 15, $PDar["year"]);

		$PDmonth = $PDar["month"];
		$PDyear = $PDar["year"];
		$strMY =  date("M - Y", $timeint);  
	
// PDBill is the total passed due bills.		   
		$PDBill = $PDBill + $PDar["amount"];     
		    
//		$TBill = $TBill + $PDar["amount"];
		$PDamount = number_format($PDar["amount"],2,".",",");
		$PDStr = $PDStr . "      $strMY: \$$PDamount";
		if($PDar["status"] == "partpaid"){
			$PDStr = $PDStr . " (after your payment of \$" . $PDar["paid_amount"] . ")";
			$PDStr = $PDStr . "-------------------------\n";

		} // end if
		$PDStr = $PDStr . "\n";
	}
//	$TBill = $TBill + $arTotals[$sid];
//	$TBillstr = number_format($TBill,2,".",",");
//	$TStr = "Your total bill is: \$$TBillstr \n-------------------------\n";
}	

// Tally the total bill
$TBill = $TBill + $PDBill + $arTotals[$sid] - $temp_credit;
if($TBill < 0){
	$TBillstr = number_format((-1* $TBill),2,".",",");
	$TStr = "You have a credit in the amount of  \$$TBillstr \n-------------------------\n";
}

if($TBill > 0) {
	
	$TBillstr = number_format($TBill,2,".",",");
	$TStr = "Your total bill is: \$$TBillstr \n-------------------------\n";
}

if($TBill == 0) {
	$TStr = "You do not owe anything. \n-------------------------\n";
}


	
// deal with the billings table	
	$CQStr = "select id, amount from PT_Billing where fid = $sid and month = $month and year = $year";
	$CRS = runquery($CQStr);
	if(mysql_num_rows($CRS) > 0){

		$CAr = mysql_fetch_array($CRS);
		$iid = $CAr[0];

		if($CAr[1] <> $arTotals[$sid]){
//	update the amount if it has changed		
			$UQStr = "update PT_Billing set amount = $arTotals[$sid] where id = $CAr[0]";
			$URS =runquery($UQStr);

//	echo $UQStr . "<BR>";
			echo "Record for $arStudentInfo[billing_name] has been update from \$$CAr[1] to \$$arTotals[$sid]<br>";
			
		} // end if the amounts are different	
	} else { // this means that the billing record does not yet exists, so insert it
$i_date = "$year-$month-15";	
		$IQStr = "Insert into PT_Billing (fid, name, month, year, amount, status, date) values ($sid, '$arStudentInfo[billing_name]', $month, $year, $arTotals[$sid], 'notpaid', '$i_date')"; 
		$iid = runquery($IQStr);
//		$iid = mysql_insert_id($BRS);
//		echo "the iid is $iid<BR>";

		echo "Record for $arStudentInfo[billing_name] has been added for \$$arTotals[$sid]<br>";
	}	

	if($temp_credit > 0){ //if there is a credit, update the billing table to reflect if
// echo 	"artot is $arTotals[$sid]<BR>";
		if($temp_credit < $arTotals[$sid]) { // if the credit is less than is due
			$UQStr = "update PT_Billing set status = 'partpaid', paid_amount = (paid_amount + $temp_credit) where id = $iid";
// echo "$the credit update string is:<BR>$UQStr<BR><BR>";
			$UBRS = runquery($UQStr);
			// then delete the credits
			 $DCRS = runquery("delete from PT_Credits where fid = $sid");
// echo "the delete string is delete from PT_Credits where fid = $sid <BR>";			 
		}
		
		if($temp_credit == $arTotals[$sid]){ // if the credit equals what is due
			$UQStr = "update PT_Billing set status = 'paid', paid_amount = $arTotals[$sid] where id = $iid";
// echo "$the credit update string would be:<BR>$UQStr<BR><BR>";
			$UBRS = runquery($UQStr);
			// then delete the credits
			 $DCRS = runquery("delete from PT_Credits where fid = $sid");  
		}
		
		
		if($temp_credit > $arTotals[$sid]){ // if the credit is greater than what is due
			$UQStr = "update PT_Billing set status = 'paid', paid_amount = $arTotals[$sid] where id = $iid";
echo "$the credit update string would be:<BR>$UQStr<BR><BR>";
			$UBRS = runquery($UQStr);
			// then update the credits
			$new_credit = $temp_credit - $arTotals[$sid];
			$DCRS = runquery("update PT_Credits set amount = $new_credit where fid = $sid");  
		}

	}   // if there is a credit, make the changes to the table


// done with the billing table.
$student_names = get_fam_sfnames($sid);


	$strSubject = "$strMonth $year $past_due Bill for $student_names from Paul The Tutor ";

	$paulSubject = "$arStudentInfo[billing_name] ($arStudentInfo[students]) ". $strSubject;
	$strEmail = $arStudentInfo['billing_email'];
	$strPaul = "paul@paulthetutor.com";

	$strBody = "Dear $arStudentInfo[billing_name],\n\n";

// put in the comments to this parent, and to all of the parents 
	if(!(isEmpty($allparents))){
		$strBody .= "$allparents\n\n";
	}
	if(!(isEmpty($arComments[$sid]))){
		$strBody .= "$arComments[$sid]\n\n";
	}
	$month_tot = number_format($arTotals[$sid],2,".",",");

//note who was billed

echo "A bill for \$$arTotals[$sid] was sent to $arStudentInfo[billing_name] $i_date<br><BR>";
	
$autopayqs = " select count(*) from PT_Strip_Info where user_id = $sid ";
$autopay = singlequery($autopayqs);

if ($autopay > 0) {
	$strBody .= "You are signed up for AutoPay. Your card on file will be billed in 1 to 3 days. 
	
	";
}	else {
	$strBody .= "Our records indicate that you are not signed up for AutoPay. You could be saving $10/hr by signing up for AutoPay. See instructions for signing up below. 
	
	";
}
	
	$strBody .= "Please find your current e-bill for Paul the Tutor’s Education Center below. To view your invoice, log on to www.paulthetutors.com/parents and enter your username and password. If you do not remember your username or password, please click on the following link: http://www.paulthetutors.com/parents/getlostinfo.php

	$TStr   Your bill for $strMonth is \$$month_tot \n$PDStr $CStr

";
if ($autopay > 0) {
	$strBody .= "
	Auto-Pay:
	It appears you are signed up for autopay, so you don't have to take any action. Your card will be charged automatically.  ";
} else {
	$strBody .=
	"
	Auto-Pay:
	You do not appear to be signed up for autopay (if you did sign up then ignore this note). You could be saving \$10 per session if you signed up for autopay. Autopay discount can not be combined with any other discounts. To sign up, go to www.paulthetutors.com/autopay and enter your information. You can also sign up by calling us at (510) 730-0390.
	
	If you don't want to sign up for autopay, you can pay your bill either by check or by credit card. 
	
	To Pay By Credit Card:
	To pay be credit card go to www.paulthetutors.com/parents/strippay_action2.php or to pay without logging in, go to www.paulthetutors.com/ccpay and enter your account number $sid and amount you want to pay.
	
	To Pay By Check:
	Please make your check payable to Paul the Tutor's Education Center. Remember to put your account number $sid on your check. You may drop the check off at, or mail it to:
	 Paul the Tutor's
	 4235 Piedmont Ave.
	 Oakland, CA 94611
	
";
}
$strBody .= "
	
	If you have any questions, please do not hesitate to call or e-mail us.  As always, we appreciate your business and thank you for choosing Paul the Tutor's.
        
        Thanks,

        Paul The Tutor's Education Center
        www.paulthetutors.com
        Email: info@paulthetutors.com
        Office: (510) 730-0390
";

	$paulBody = "the following was sent to $strEmail \n\n" . $strBody;

	$strHeader = "From: billing@paulthetutors.com<billing@paulthetutors.com>\r\nReply-to: billing@paulthetutors.com\r\ncc:billing@paulthetutors.com";

$strSubject = stripslashes($strSubject);
$strBody = stripslashes($strBody);
$addparameters = "-fbilling@paulthetutors.com";

  	$mail_res = mail($strEmail, $strSubject, $strBody, $strHeader, $addparameters);
	
	echo "mailing result is $mail_res <BR>";
//	mail("billing@paulthetutor.com", $strSubject, $paulBody, $strHeader,$addparameters);


}

//send out passed due notices if it is a bill everyone send

if ($num_students > 1){
	$PDQStr = "SELECT fid FROM `PT_Billing` where fid > 0 and status <> 'paid' and (year < $year or (month < $month and year = $year)) group by fid order by fid";
	$PDRS = runquery($PDQStr);
	$num_rows = mysql_num_rows($PDRS);
	if($num_rows > 0){
		while($arfid = mysql_fetch_array($PDRS)){
			if(!(array_key_exists($arfid['fid'],$arTotals))){
			send_passed_due($arfid['fid'],$month,$year)	;
// echo $arfid['fid'] . "   we would have run this sendPasseddue function   ( $arfid[fid], $month,$year)	<BR>";

			}
		}
	}		
// echo "<BR> num_students is $num_students <BR>";	
	
} else {

echo "No late bills sent <BR><BR>";

}


?>
                   
	        </td>
              </tr>
            </table>
          </td>
  </tr>
</table>
    </form>
<?
put_ptts_footer("");
?>
