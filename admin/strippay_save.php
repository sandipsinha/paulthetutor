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
if($folder == 'none') {
	$family_id = $_REQUEST[fid];
}	

$amount = $_REQUEST[amount];
$due = $_REQUEST[amount];



put_ptts_header("", $strAbsPath, "", "");

Stripe::setApiKey("u8a5M9gbqwOLCdXwpmy54qwch3Tz7YWk");

// get the credit card details submitted by the form
$token = $_POST['stripeToken'];

// create a Customer
$customer = Stripe_Customer::create(array(
  "card" => $token,
  "description" => "payinguser@example.com")
);

// charge the Customer instead of the card
Stripe_Charge::create(array(
  "amount" => 1000, # amount in cents, again
  "currency" => "usd",
  "customer" => $customer->id)
);

// save the customer ID in your database so you can use it later
saveStripeCustomerId($family_id, $customer->id);

// later
$customerId = getStripeCustomerId($family_id);

Stripe_Charge::create(array(
    "amount" => 1500, # $15.00 this time
    "currency" => "usd",
    "customer" => $customerId)
);



?>

<table width="450" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" class=table_1>
  <tr>
    <td class=td_header>Please Enter the Information</td>
  </tr>
  <tr>
    <td>

	&nbsp;

            </TD>
</TR>
  <TR>
            <TD>
&nbsp;
        
		</td></tr></table>
<?
put_ptts_footer("");
?>
