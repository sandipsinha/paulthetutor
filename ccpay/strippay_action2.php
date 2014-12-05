<?php
$son = $_SERVER['HTTPS'];
if($son <> "on"){
	header( 'Location: https://www.paulthetutors.com/ccpay/strippay_action2.php' );
} else {
	include("../admin/strippay_action3.php");
}
?>