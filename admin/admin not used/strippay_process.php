<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$folder = getfolder('','','');
if($folder == 'parents') {
	include("../includes/config.php");
	include($strAbsPath . "/includes/.check_login.php");
	$family_id = $_SESSION['fid'];
}	

// if this is on the normal site
if($folder == 'ccpay') {
	if(!(isEmpty($_REQUEST[family_id]))) $family_id = $_REQUEST[family_id];
	if(!(isEmpty($_REQUEST[fam_id]))) $family_id = $_REQUEST[fam_id];

	$fam_id = $family_id;
//	$amount = $_REQUEST[amount];
//	$due = $_REQUEST[amount];

}	


put_ptts_header("Payment Processing", $strAbsPath, $folder, "");


    require_once("../includes/stripe/lib/Stripe.php");
	
//printarray($_REQUEST);
// printarray($_POST);
	

// set your secret key: remember to change this to your live secret key in production
// see your keys here https://manage.stripe.com/account
Stripe::setApiKey("leTwS2rWhwJ4RDFuXAMxALZtgpDrIbzF");

// get the credit card details submitted by the form
$token = $_POST['stripeToken'];
$amount = $_REQUEST[amount] * 100; // multiply the amount by 100 because it is processed in cents

if ($folder == "parents") {
	$fam_id = $_SESSION[fid];
} else if ($folder == "admin"){
	$fam_id = $_REQUEST[family_id];
	$family_id = $fam_id;
}		

$fam_name = get_fam_name($family_id);
$print_amount = number_format($_REQUEST[amount], 2, '.', ','); 
$description = "($fam_id) $fam_name paid \$$print_amount";




// create the charge on Stripe's servers - this will charge the user's card
$charge = Stripe_Charge::create(array(
  "amount" => $amount, // amount in cents, again
  "currency" => "usd",
  "card" => $token,
  "description" => $description)
);
?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">

<table width="650" border="2" cellspacing="2" cellpadding="3" bgcolor="#996600" class=table_1>
  <tr>
    <td class=td_header>Payment Processed</td>
  </tr>
  <tr>
    <td >
<table width="100%" bgcolor="#FFFFFF"><tr> <td valign="top" height="300">
<BR><span class="Head2_Green">Thanks! We have processed your payment</span><BR>We have processed a payment of $<?=$print_amount;?> towards Account #:<?=$family_id;?>. Please note that it may take a few days for the payment to show up on your account.<BR><BR>
<span class="Head3">Print for Your Records
</span><BR>Please print this page and keep a copy as a receipt.
<br>
Account: <?=$family_id;?><br>
Amount: $<?=$print_amount;?><BR>
<? 
$today = date("F j, Y");
?>
Date: <?=$today;?><BR><BR>
<br>
<br>
<br>
<br>

<form><input type="button" value=" Print this page "
onclick="window.print();return false;" /></form>
<BR>

</td>
</tr></table>


</td></tr></table>





<?
put_ptts_footer("");
?>
 
