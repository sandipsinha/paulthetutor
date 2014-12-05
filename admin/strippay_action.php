<html lang="en">
    <head>
	<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript">
    // this identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_74C8BBTqLtTCXohorB4OzsqTeCpbp');
   
   function stripeResponseHandler(status, response) {
		if (response.error) {
			// show the errors on the form
			$(".payment-errors").text(response.error.message);
		} else {
			var form$ = $("#payment-form");
			// token contains id, last4, and card type
			var token = response['id'];
			// insert the token into the form so it gets submitted to the server
			form$.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
			// and submit
			form$.get(0).submit();
		}
	}
   
   $(document).ready(function() {
  $("#payment-form").submit(function(event) {
    // disable the submit button to prevent repeated clicks
    $('.submit-button').attr("disabled", "disabled");

    Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
    }, stripeResponseHandler);

    // prevent the form from submitting with the default action
    return false;
  });
});
</script>
 </head>
<body>

<table width="450" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" class=table_1>
  <tr>
    <td class=td_header>Enter Payment Information</td>
  </tr>
  <tr>
    <td>
     
<form action="strippay_process.php" method="POST" id="payment-form">
    <div class="form-row">
        <label>Card Number</label>
        <input type="text" size="20" autocomplete="off" class="card-number"/>
    </div>
    <div class="form-row">
        <label>CVC</label>
        <input type="text" size="4" autocomplete="off" class="card-cvc"/>
    </div>
    <div class="form-row">
        <label>Expiration (MM/YYYY)</label>
        <input type="text" size="2" class="card-expiry-month"/>
        <span> / </span>
        <input type="text" size="4" class="card-expiry-year"/>
    </div>
    <button type="submit" class="submit-button">Submit Payment</button>
</form>
	 
	 
	 </td></tr></table>
</body>

