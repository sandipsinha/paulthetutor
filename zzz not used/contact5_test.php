<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

reqToVars();

function my_mail($email, $from, $from_name, $subject, $msg, $cc,$opts=null) {
    $mail= new Zend_Mail(); //Zend mail object allows complex messages to be sent easily.
    $mail->setBodyText($msg);
    $mail->addTo($email);
    $mail->setSubject($subject);
    $mail->setFrom($from, $from_name);
    $mail->addCc($cc);
    //$mail->setReplyTo('contact@company.com', 'Company');
    $mail->addHeader('MIME-Version', '1.0');
    $mail->addHeader('Content-Transfer-Encoding', '8bit');
    $mail->addHeader('Content-Type', 'text/html');
    $mail->addHeader('X-Mailer:', 'PHP/'.phpversion());
    try{
        $mail->send();
        } catch(Exception $e){ 
            echo 'OUCH';
        }

    return true;
}


$strHeader = "From: $name<$email>";

$message = "Helllo!";

$infoparam = "-finfo@paulthetutors.com";
$newcontactsparam = "-fnewcontact@paulthetutors.com";

//$my_header = "From: newcontacts@paulthetutors.com \r\n";
//$my_header .= "MIME-Version: 1.0\r\n";
//$my_header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//$my_header .= 'Cc: paul@paulthetutors.com' . "\r\n";
$message = "Helllo $name, $phone, $email, $subject from newcontacts #1";
//$mail_to = "srisreed@gmail.com";
//mail($mail_to, "FROM NEWCONTACTS MAIL FUNCTION TO $mail_to", $message, $my_header, $newcontactsparam); //CHANGE TO VARIABLE $TO
//my_mail("srisreed@gmail.com", "srisreed@gmail.com", $name, "FROM NEWCONTACTS ZEND MAIL FUNCTION TO $mail_to", $message . " from newcontacts #1", "paul@paulthetutors.com");
my_mail("srisreed@gmail.com", "newcontacts@paulthetutors.com", "PTTS", "FROM NEWCONTACTS ZEND MAIL FUNCTION TO $mail_to", $message . " from newcontacts #1", "paul@paulthetutors.com");

//$my_header2 = "From: info@paulthetutors.com \r\n";
//$my_header2 .= "MIME-Version: 1.0\r\n";
//$my_header2 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//$my_header2 .= 'Cc: paul@paulthetutors.com' . "\r\n";
$message = "Helllo $name, $phone, $email, $subject from info";
//$mail_to = "newcontacts@paulthetutors.com";
//mail($mail_to, "FROM INFO MAIL FUNCTION TO $mail_to", $message, $my_header2, $infoparam); //CHANGE TO VARIABLE $TO
my_mail("newcontacts@paulthetutors.com", "info@paulthetutors.com",  "PTTS", "FROM INFO ZEND MAIL FUNCTION TO $mail_to", $message, "");

//$my_header3 = "From: newcontacts@paulthetutors.com \r\n";
//$my_header3 .= "MIME-Version: 1.0\r\n";
//$my_header3 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//$my_header3 .= 'Cc: paul@paulthetutors.com' . "\r\n";
$message = "Helllo $name, $phone, $email, $subject from newcontacts #2";
//mail("newcontacts@paulthetutors.com", "FROM NEWCONTACTS MAIL FUNCTION", $message, $my_header3, $newcontactsparam); //Keep hardcoded
my_mail("newcontacts@paulthetutors.com", "newcontacts@paulthetutors.com", "PTTS" , "FROM NEWCONTACTS ZEND MAIL FUNCTION", $message, "");


?>