<?php

include("../includes/pttec_includes.phtml");
    require_once("../includes/stripe/lib/Stripe.php");


// printarray($_REQUEST);

MySQL_PaulTheTutor_Connect();
$error = "none";
$folder = getfolder('','','');
if($folder == 'parents') {
	include("../includes/config.php");
	include($strAbsPath . "/includes/.check_login.php");
	$family_id = $_SESSION['fid'];
}	

// if this is on the admin site
if ($folder == "admin"){
	if(!(isEmpty($_REQUEST[family_id]))) $family_id = $_REQUEST[family_id];
	if(!(isEmpty($_REQUEST[fam_id]))) $family_id = $_REQUEST[fam_id];
}		

put_ptts_header("Auto Pay Enrollment", $strAbsPath, $folder, "");


// strip info 1
// set your secret key: remember to change this to your live secret key in production
// see your keys here https://manage.stripe.com/account
Stripe::setApiKey("leTwS2rWhwJ4RDFuXAMxALZtgpDrIbzF");

// get the credit card details submitted by the form
$token = $_POST['stripeToken'];
$fam_name = get_fam_name($family_id);

$customer = Stripe_Customer::create(array(
  "card" => $token,
  "description" => "$fam_name ($family_id)")
);

// printarobj($customer);

$cvc_check = $customer->active_card->cvc_check;

// echo "<br> with $cvc_check<BR>";

if($cvc_check <> "pass"){  // if the cvc number is wrong
	
			$error = "card";
// echo 
			?>
            <span class="Head2_Green">Problem Processing Your Card</span>
            <br />
            Error: Invalid CVC Code<BR />
            It appears that there was an error processing this card. Please <a href="javascript:history.go(-1)">go back</a> and reenter your information. If you have any questions, please don't hesitate to contact us, and sorry for any inconveniece. <BR /><BR />Thanks,<BR /><BR /><BR /> Paul the Tutor's<BR /><a href="mailto:info@paulthetutors.com">info@paulthetutors.com</a><br />(510) 730-0390

            
            <?
			
			$error = "card";
			echo "</td></tr></table>";
			put_ptts_footer("");

			die();
}

if($error == "none"){
	saveStripeCustomerId($family_id, $customer,1);

	
// printarray($_REQUEST);
// printarray($_POST);
	
	
?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">

<table width="650" border="2" cellspacing="2" cellpadding="3" bgcolor="#996600" class=table_1>
  <tr>
    <td class=td_header>Thanks for Enrolling in AutoPay</td>
  </tr>
  <tr>
    <td height="314" >
<table width="100%" bgcolor="#FFFFFF"><tr> <td valign="top" height="260">
<BR>
<? if($folder == 'parents'){ ?>

<span class="Head2_Green">Thanks! We've Enrolled You in AutoPay</span><BR>
Your credit card information has been saved and will be automatically billed each month. You can also use your saved credit card information to bill whenever you like. You will receive an automatic $10/hr discount on every session. To read more about autopay <a href="../autopay.php">click here</a>. Please note that autopay will not take effect until after the next billing cycle. If you have a due bill you can pay it directly by going to <a href="https://www.paulthetutors.com/parents/strippay_action2.php">Pay Your Bill</a> and you can pay using your saved card. <BR><BR>
<span class="Head3">What would you like to do now?</span><BR>
<BR>
<a href="https://www.paulthetutors.com/parents/strippay_action2.php">Pay Your Bill</a><BR>
<a href="viewbill.php">See Your Bill</a><BR>
<a href="viewbill.php">See Billing History</a><br>
<a href="index_parents.php">Return to Homepage</a><br>

<? } ?>
<? if($folder == 'admin'){ ?>
<span class="Head2_Green"><?="$fam_name ($family_id)"?> Has Been Enrolled  in AutoPay</span><BR>
Their information has been saved and they will be charged 3 days after bills go out. <BR><BR>

<a href="strip_autopay.php">Enroll Another Family in Auto Pay</a><br>




<? } ?>

<BR></td>
</tr></table>


</td></tr></table>





<?
put_ptts_footer("");
} // ONLY PUT THE PAGE IF THERE IS NO ERROR $ERROR == "NONE"
?>
 
