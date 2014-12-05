<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

reqToVars();

$strHeader = "From: $name<$email>";

$message = "Helllo!";

$infoparam = "-finfo@paulthetutors.com";
$newcontactsparam = "-fnewcontact@paulthetutors.com";

$my_header = "From: newcontacts@paulthetutors.com \r\n";
$my_header .= "MIME-Version: 1.0\r\n";
$my_header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$my_header .= 'Cc: paul@paulthetutors.com' . "\r\n";
$message = "Helllo $name, $phone, $email, $subject from newcontacts #1";
$mail_to = "srisreed@gmail.com";
mail($mail_to, "FROM NEWCONTACTS MAIL FUNCTION TO $mail_to", $message, $my_header, $newcontactsparam); //CHANGE TO VARIABLE $TO

$my_header2 = "From: info@paulthetutors.com \r\n";
$my_header2 .= "MIME-Version: 1.0\r\n";
$my_header2 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$my_header2 .= 'Cc: paul@paulthetutors.com' . "\r\n";
$message = "Helllo $name, $phone, $email, $subject from info";
$mail_to = "newcontacts@paulthetutors.com";
mail($mail_to, "FROM INFO MAIL FUNCTION TO $mail_to", $message, $my_header2, $infoparam); //CHANGE TO VARIABLE $TO

$my_header3 = "From: newcontacts@paulthetutors.com \r\n";
$my_header3 .= "MIME-Version: 1.0\r\n";
$my_header3 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$my_header3 .= 'Cc: paul@paulthetutors.com' . "\r\n";
$message = "Helllo $name, $phone, $email, $subject from newcontacts #2";
mail("newcontacts@paulthetutors.com", "FROM NEWCONTACTS MAIL FUNCTION", $message, $my_header3, $newcontactsparam); //Keep hardcoded


?>