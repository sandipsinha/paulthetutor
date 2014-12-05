<?php
include("../includes/pttec_includes.phtml");
require_once("../includes/stripe/lib/Stripe.php");

printarray($_REQUEST);


MySQL_PaulTheTutor_Connect();
$password = "test_info";
$css_form = get_css_forms();
$folder = getfolder('','','');

if($folder == 'parents') {
	include("../includes/config.php");
	include($strAbsPath . "/includes/.check_login.php");
	$family_id = $_SESSION['fid'];
}	

// if this is on the normal site
if(!(isEmpty($_REQUEST[family_id]))) $family_id = $_REQUEST[family_id];
	

$password = $css_form;

// echo "password is $password <BR>";

// if they are using their saved information
if($folder == 'parents' or $folder == 'admin'){
	if(!isEmpty($_REQUEST[user_id])){
		$family_id = $user_id = $_REQUEST[user_id];
		
		
		$stripeqs = "select stripe_id from PT_Strip_Info where user_id = $user_id and archived = 0";	
		$stripe_id = singlequery($stripeqs);
	}
}




put_ptts_header("Payment Processing", $strAbsPath, $folder, "");

//
if(!isEmpty($user_id) and $_REQUEST[password] <> $password and $folder == 'admin'){
	echo "The password is wrong.";
	put_ptts_footer();
	die();
}

	
//printarray($_REQUEST);
// printarray($_POST);
	

// set your secret key: remember to change this to your live secret key in production
// see your keys here https://manage.stripe.com/account
Stripe::setApiKey("u8a5M9gbqwOLCdXwpmy54qwch3Tz7YWk");

// get the credit card details submitted by the form
if(!isEmpty($_REQUEST['stripeToken'])){
	$token = $_REQUEST['stripeToken'];
}
$amount = $_REQUEST[amount] * 100; // multiply the amount by 100 because it is processed in cents

$fam_name = get_fam_name($family_id);
$print_amount = number_format($_REQUEST[amount], 2, '.', ','); 
$description = "($family_id) $fam_name paid \$$print_amount";


echo "$stripe_id is the stripe id and the token is $token<BR>";

// create the charge on Stripe's servers - this will charge the user's card
if(isEmpty($stripe_id) and !isEmpty($token)){ 

// "in the payment direct if <BR>";



	$charge = Stripe_Charge::create(array(
	  "amount" => $amount, // amount in cents, again
	  "currency" => "usd",
	  "card" => $token,
	  "description" => $description)
	);
	
	$card_used = "xxxx-xxxx-xxxx-". $charge->card->last4;
	
//	echo "card is $card_used <BR>";
	
	payment_process($family_id, $_REQUEST[amount], "cc payment with card $card_used");
	
	
	
} else if (!isEmpty($stripe_id) and ($folder == "parents" or $folder = "admin") and (($folder = "admin" and $_REQUEST[password] == $password) or $folder == "family")) {
	$customer_id = getStripeCustomerId($family_id);
	$charge = Stripe_Charge::create(array(
	  "amount"   => 100,
	  "currency" => "usd",
	  "customer" => $customer_id)
	);
	
	$card_used = "xxxx-xxxx-xxxx-". $charge->active_card->last4;
	
	
	payment_process($family_id, $_REQUEST[amount], "cc payment with card $card_used");

	
}
	
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
 
