<?php
//check if the user is logged in
//$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/config.php");
include($strAbsPath . "/includes/.check_login.php");
$acn = $_SESSION['fid'];
echo "Account Number: $acn";
?>
