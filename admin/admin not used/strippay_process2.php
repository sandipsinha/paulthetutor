<?php
include("../includes/pttec_includes.phtml");
require_once("../includes/stripe/lib/Stripe.php");

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
if($folder == 'ccpay') {
	if(!(isEmpty($_REQUEST[family_id]))) $family_id = $_REQUEST[family_id];
	if(!(isEmpty($_REQUEST[fam_id]))) $family_id = $_REQUEST[fam_id];

	$fam_id = $family_id;
//	$amount = $_REQUEST[amount];
//	$due = $_REQUEST[amount];

}	

$password = $css_form;
// if they are using their saved information
if($folder == 'parents' or $folder == 'admin'){
	if(!isEmpty($_REQUEST[user_id]))
		$user_id = $_REQUEST[user_id];
		
	$stripeqs = "select stripe_id from PT_Strip_Info where user_id = $user_id and archived = 0";	
	$stripe_id = singlequery($stripe_id);
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
if(!isEmpty($_POST['stripToken'])){
	$token = $_POST['stripeToken'];
}
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
if(isEmpty($stripe_id) and !isEmpty($token)){ 
	$charge = Stripe_Charge::create(array(
	  "amount" => $amount, // amount in cents, again
	  "currency" => "usd",
	  "card" => $token,
	  "description" => $description)
	);
} else if (!isEmpty($stripe_id) and ($folder == "parents" or $folder = "admin") and (($folder = "admin" and $_REQUEST[password] == $password) or $folder == "family")) {
	$customer_id = get_stripe_customer_id($family_id);
	echo "customer is $customer_id <BR>";
	
	
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
 
