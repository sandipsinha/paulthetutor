<?php
include("../includes/pttec_includes.phtml");
require_once("../includes/stripe/lib/Stripe.php");
$charge = 0;
$title = "Payment Didn't Go Through";
$popup = $_REQUEST[popup];


// printarray($_REQUEST);


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
$user_id = NULL;
if($folder == 'parents' or $folder == 'admin'){
	if(!isEmpty($_REQUEST[card_id])){
		$card_id = $_REQUEST[card_id];
		
		$cardqs = "select stripe_id, user_id from PT_Strip_Info where id = $card_id and archived = 0";	
		$saved_card = rowquery($cardqs);
		
		$family_id = $user_id = $saved_card[user_id];
		
		$stripe_id = $saved_card[stripe_id];
	}
}

// echo "si = $stripe_id and qst = $cardqs <BR>";
// printarray( $saved_card);

// exit();

put_ptts_header("Payment Processing", $strAbsPath, $folder, $popup);

//
if(!isEmpty($user_id) and $_REQUEST[password] <> $password and $folder == 'admin'){
	echo "The password is wrong.";
	put_ptts_footer();
	die();
}

// set your secret key: remember to change this to your live secret key in production
// see your keys here https://manage.stripe.com/account
Stripe::setApiKey("leTwS2rWhwJ4RDFuXAMxALZtgpDrIbzF");

// get the credit card details submitted by the form
if(!isEmpty($_REQUEST['stripeToken'])){
	$token = $_REQUEST['stripeToken'];
	// echo "token is $token <BR>";
}
$amount = $_REQUEST[amount] * 100; // multiply the amount by 100 because it is processed in cents

$fam_name = get_fam_name($family_id);
$print_amount = number_format($_REQUEST[amount], 2, '.', ','); 
$description = "($family_id) $fam_name paid \$$print_amount";


// echo "$stripe_id is the stripe id and the token is $token<BR>";

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
	$charged = 1;
	$title = "Payment Processed";

	
	
} else if (!isEmpty($stripe_id) and ($folder == "parents" or $folder == "admin") and (($folder == "admin" and $_REQUEST[password] == $password) or $folder == "family")) {
	$customer_id = $stripe_id;
	$amount = $_REQUEST[amount] * 100; // multiply the amount by 100 because it is processed in cents
	$charge = Stripe_Charge::create(array(
	  "amount"   => $amount,
	  "currency" => "usd",
	  "customer" => $customer_id)
	);
	
	$card_used = "xxxx-xxxx-xxxx-". $charge->active_card->last4;
	
//	if($_REQUEST['popup'] == 'popup' and $folder == "admin")
		//echo '<script type="text/javascript">opener_reload();</script>';

	payment_process($family_id, $_REQUEST[amount], "cc payment with card $card_used");
	
	$charged = 1;
	$title = "Payment Processed";
}
	
?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">

<table width="650" border="2" cellspacing="2" cellpadding="3" bgcolor="#996600" class=table_1>
  <tr>
    <td class=td_header><?=$title;?></td>
  </tr>
  <tr>
    <td >
<table width="100%" bgcolor="#FFFFFF"><tr> <td valign="top" height="300">
<?
if($charged == 1){
		
?>

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
<?
if($folder == "admin"){
	
	$url = "";

	if( isset( $popup ) && $popup == "popup" ) {

		$url = "javascript:popup('strip_saved_charge2.php?popup=popup','','700','700')";

	} else {

		$url = "strip_saved_charge2.php";

	}

	?>
<span class="Head3">
	<a href="<?= $url ?>" >
		Bill Another Saved Account
	</a><br />
</span><br />
<? }  



} 
if($charged == 0){
?>	
<BR><span class="Head2_Green">Something Went Wrong with the Payment</span>
<BR>There was an unspecified error when attempting to make this charge. Please <a href="javascript:history.go(-1)">go back</a> and try again.
<BR /><BR />
Sorry for the inconvenience.
<BR /><BR />
Paul the Tutor's
<?	
}?>
</td>
</tr></table>


</td></tr></table>





<?
put_ptts_footer("");
?>
 