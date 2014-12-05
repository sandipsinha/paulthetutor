<?
// this is the old page. we now use strippay_action3.php
header( "Location: https://www.paulthetutors.com/parents/strippay_action3.php");


include("../includes/pttec_includes.phtml");
$folder = getfolder('','','');
$son = $_SERVER['HTTPS'];

// echo "$son is son <BR>";

if($son <> "on"){
	if($folder == "parents")
		header( "Location: https://www.paulthetutors.com/parents/strippay_action2.php");
	if($folder == "admin")
		header( "Location: https://www.paulthetutors.com/admin/strippay_action2.php");
	
	die("You are not authorized based on your folder");	

// echo "header is $header ";
// die();	
}
if($folder == "parents"){
	include($strAbsPath . "/includes/.check_login.php");
	$family_id = $_SESSION['fid'];
	$saved = singlequery("select count(*) from PT_Strip_Info where user_id = $family_id");
	if($saved >=1){
		header( "Location: https://www.paulthetutors.com/parents/strip_saved_charge.php");
	}
}

?>
        <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below
            Stripe.setPublishableKey('pk_Dl0C8pKYmwOuzftrg4WCrx9eNb76c');

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }

            $(document).ready(function() {
                $("#payment-form").submit(function(event) {
                    // disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                    return false; // submit from callback
                });
            });

            if (window.location.protocol === 'file:') {
                alert("stripe.js does not work when included in pages served over file:// URLs. Try serving this page over a webserver. Contact support@stripe.com if you need assistance.");
            }
        </script>

<?php
MySQL_PaulTheTutor_Connect();
$folder = getfolder('','','');

// if this is on the normal site
if($folder == 'ccpay') {
	$family_id = $_REQUEST[fid];
	$amount = $_REQUEST[amount];
	$due = $_REQUEST[amount];

}	

put_ptts_header("Payment Processing for Paul the Tutor's", $strAbsPath, $folder, "");

if($folder == "parents"){ // if this is in the family folder, put hello top
	$main_name = getMainName($family_id);
?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">

<span class="Head2_Green">Hello <?= "$main_name (Acct: $family_id)";?></span><span> (<?= "Not $main_name?";?> <a href='login_parents.php?logout=1&referer=/parents/strippay_action2.php'>Logout</a>)<br/><br/></span>
<? } // if this is in the family folder
?>

<table width="650" border="2" cellspacing="2" cellpadding="3" bgcolor="#996600" class=table_1>
  <tr>
    <td class=td_header>Enter Payment Information</td>
  </tr>
  <tr>
    <td >


<table width="100%" bgcolor="#FFFFFF">
        <!-- to display errors returned by createToken -->
        <span class="payment-errors"></span>
        <form action="strippay_process.php" method="POST" id="payment-form">
<?
if($folder == "parents" and $saved >=1) { // if they have a saved card
?>
<tr>
  <td align="center" colspan="2"> <a href="strip_savedcard.php" class="Head2">Use a Saved Card</a></td></tr>

<?
}
	?>
            <div class="form-row">
                <tr><td align="right">Account Number: </td><td>
             
			 <?
			 if($folder == "admin"){
				echo fam_menu("last","family_id",0,"Choose a Family");
			} else if (($folder == "parents") or ($folder == "ccpay")){ ?>
			
				
			 
<? 
// if this is the family folder, let them log out
				if( $folder == "parents") { ?>			
					 <strong><?=$family_id;?> </strong> &nbsp;&nbsp;&nbsp; 
					<span class="form_comments">Wrong account number? <a href='login_parents.php?logout=1&referer=/parents/strippay_action2.php'>Logout</a></span>
				<? } // end give log out option to family folder

// if this is the ccpay folder, let them determine their account number
				if($folder == "ccpay") { ?>
					<input name="family_id" type="text" size="4" maxlength="4"  value="<?=$family_id;?>">
					&nbsp;&nbsp;&nbsp;<a onclick="javascript:popup('get_account_number.php','','500','500')" ><span class="form_little_link">What's my account number? </span></a>
				<? } // end if ccpay folder		
			} // end if parents or ccpay	?>
			 
            </div>
		    <div class="form-row">
                <tr><td align="right">Payment Amount: $</td><td>
<?
// determine what will be the preset amount based on the folder.
$due = NULL;

if($folder == "parents") $due =  get_amount_due($family_id);		
if($folder == "ccpay") $due =  $_REQUEST[amount];		

?>
                <input name="amount" type="text" class="payment_amount" id="Name" size="10" value="<?=$due;?>" autocomplete="off" />
				&nbsp;&nbsp;&nbsp;
<? if($folder == "admin"){ ?>
           <span class="form_little_link"><a onclick="javascript:popup('get_total_due.php','','500','500')" font-weight:bold;">See Total Due for An Account</a></span>
		   
<? }  // end if admin

 if($folder == "ccpay"){ ?>
           <span class="form_comments"><a href="../parents/strippay_action2.php">What is my Total Due?</a></span>
		   
<? }  // end if ccpay



if($folder == "parents"){ ?>

<a href="viewbill.php" target="_blank" class="form_little_link">See Billing Info</a><? } // parents ?>		
			
				
				
				</td>
                </tr>
            </div>
            <div class="form-row">
                <tr><td align="right">Name on Card: </td><td>
                <input type="text" class="payee" id="Name" size="40" autocomplete="off" /></td></tr>
            </div>

            <div class="form-row">
                <tr><td align="right">Card Number: </td><td>
                <input type="text" size="20" autocomplete="off" class="card-number" /></td></tr>
            </div>
            <div class="form-row">
                <tr><td align="right">CVC: </td><td>
                <input type="text" size="4" autocomplete="off" class="card-cvc" /></td></tr>
            </div>
            <div class="form-row">
                <tr><td align="right">Expiration (MM/YYYY): </td><td>
                <input type="text" size="2" class="card-expiry-month"/>
                <span> / </span>
                <input type="text" size="4" class="card-expiry-year"/></td></tr>
            </div>
<!--  
            <div class="form-row">
                <tr><td align="right">store my infomation? </td><td>
                  <input name="store" type="checkbox" id="store" value="1"></td>
                </tr>
            </div>
            <div class="form-row">
                <tr>
                    <td align="right">enroll me in autopay? : </td><td>
                  <input name="autopay" type="checkbox" id="autopay" value="1"></td>
                </tr>
            </div>
-->			
			<tr><td colspan="2" align="center">  
            	<button type="submit" class="submit-button">Submit Payment</button>
			</td></tr>
       
	   
	    </form>
		</table>
		</td></tr></table>
    </body>
</html>
