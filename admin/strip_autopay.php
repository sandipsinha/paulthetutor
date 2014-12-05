<?
include("../includes/pttec_includes.phtml");
$son = $_SERVER['HTTPS'];

// This is where we enroll people in autopay

if($son <> "on"){
	$folder = getfolder('','','');
	if($folder == "parents")
		header( "Location: https://www.paulthetutors.com/parents/strip_autopay.php");
	if($folder == "admin")
		header( "Location: https://www.paulthetutors.com/admin/strip_autopay.php");
	
	die("You are not authorized based on your folder");	

// echo "header is $header ";
// die();	
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

if($folder == 'parents') {
	include("../includes/config.php");
	include($strAbsPath . "/includes/.check_login.php");
	$family_id = $_SESSION['fid'];
}	

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

<table width="751" border="2" cellspacing="2" cellpadding="3" bgcolor="#996600" class=table_1>
  <tr>
    <td width="737" class=td_header> Enroll in AutoPay
    
    
    </td>
  </tr>
  <tr>
    <td >


<table width="100%" bgcolor="#FFFFFF">
        <!-- to display errors returned by createToken -->
        <span class="payment-errors"></span>
        <form action="stripauto_process.php" method="POST" id="payment-form" name="payment-form" onSubmit=" return validate_form();">
		    <div class="form-row">
                <tr><td width="32%" height="32" align="right">Account Number: </td><td width="68%">
             
			 <?
			 if($folder == "admin"){
				 if(!isEmpty($_REQUEST[family_id]) and isEmpty($family_id)) {
					 $family_id = $_REQUEST[family_id];
				 }
				 
				 just_fam_search("hidden","family_id",$_REQUEST[family_id]);
			} else if (($folder == "parents")){ ?>
			
				
			 
 

					 <strong><?=$family_id;?> </strong> &nbsp;&nbsp;&nbsp; 
					<span class="form_comments">Wrong account number? <a href='login_parents.php?logout=1&referer=/parents/strippay_action2.php'>Logout</a></span>
<?
// if this is the ccpay folder, let them determine their account number
			} // end if parents or ccpay	?>
			 
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
            <div class="form-row">
                <tr>
                  <td colspan="2">
                    <input type="checkbox" name="terms_conditions" id="terms_conditions" /> I Agree to the Autopay Terms and Conditions 
                    <a onclick="javascript:popup('../autopay_terms.php','Details','800','600')"><span class="underline"><span class="form_comments">see terms and conditions</span></span>
                </td></tr>
            </div>
 
		
			<tr><td colspan="2" align="center">  
            	<button type="submit" class="submit-button">Enroll in AutoPay</button>
			</td></tr>
       
	   
	    </form>
		</table>
		</td></tr></table>
    </body>
</html>

