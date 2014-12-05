<?php

function getYelpImage () {
// Enter the path that the oauth library is in relation to the php file
require_once ('includes/Oauth.php');

// For example, request business with id 'the-waterboy-sacramento'
$unsigned_url = "http://api.yelp.com/v2/business/paul-the-tutors-education-center-oakland";

// For examaple, search for 'tacos' in 'sf'
//$unsigned_url = "http://api.yelp.com/v2/search?term=tacos&location=sf";


// Set your keys here
$consumer_key = "oxiN0AvNiVnlIzz40O1LbA";
$consumer_secret = "c7u0kZfM6b_IG59VqGkVO9bJIaA";
$token = "SJYrQCNkDX7V-xAZoR8xoAY72HFAcHYP";
$token_secret = "r9epNFeJj6t8qYLyvjlXei2qC5M";

// Token object built using the OAuth library
$token = new OAuthToken($token, $token_secret);

// Consumer object built using the OAuth library
$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

// Yelp uses HMAC SHA1 encoding
$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

// Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

// Sign the request
$oauthrequest->sign_request($signature_method, $consumer, $token);

// Get the signed URL
$signed_url = $oauthrequest->to_url();

// Send Yelp API Call
$ch = curl_init($signed_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch); // Yelp response
curl_close($ch);

// Handle Yelp response data
$response = json_decode($data);

// Get URL of star image and Yelp page from json data

$img_url = $response->{'rating_img_url'}; 
$yelp_url = $response->{'url'};

$HTMLoutput = "<a href=$yelp_url><img src='/images/yelp-logo.jpg' /><img class='stars' src=$img_url alt='Yelp 5 Stars' title='Read what people are saying about us on Yelp!' /></a>";

echo $HTMLoutput;

}


getYelpImage();





?>