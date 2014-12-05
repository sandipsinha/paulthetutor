<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

//MySQL_PaulTheTutor_Connect();

//var_dump($_POST);

reqToVars();
$strHeader = "From: $name<$email>";

//echo $email;

function my_mail($email, $subject, $msg, $cc,$opts=null) {
  is_string($opts) && $opts=array('headers'=>$opts); //convert to array
  if (!$opts['from']) // opts not sent, use default from
    $opts['from'] = array('name'=>'nore@paulthetutors.com', 'email'=>'nore@paulthetutors.com');
  if (is_array($opts) && isset($opts['headers'])) { // attempt to parse From name and address from headers
    preg_match('/from: .+<(\w+@\w+\.[a-z]+)>/i', $opts['headers'], $test);
    $opts['from']['email']=$test[1];
    preg_match('/from: (.*)</i', $opts['headers'], $test);
    $opts['from']['name']=trim($test[1]);
  } // end parse attempt
    $mail= new Zend_Mail(); //Zend mail object allows complex messages to be sent easily.
    // set who the email is from
    if (is_array($opts['from'])) { //from is an array, set address and name
      $mail->setFrom($opts['from']['email'], $opts['from']['name']);
    } else { // from is simply an address
      $mail->setFrom($opts['from']);
    }
    // development server code
  if (getenv('APPLICATION_ENV') && getenv('APPLICATION_ENV')== 'development') {
    if (isset($opts['html']) && $opts['html']) // html email
      $mail->setBodyHtml("HTML email to: $email<br><br>$msg");
    else // plaintext email
      $mail->setBodyText("Text email to: $email\n\n". $msg);
//    $mail->addTo('packetcollision@gmail.com');
    $mail->setSubject("PTTS-Dev: ".$subject);
    $mail->send();
    return true;
    // end development server code
  } else { // production server code
    if (isset($opts['html']) && $opts['html']) // html email
      $mail->setBodyHtml($msg);
    else // plaintext email
    $mail->setBodyText($msg);
    $mail->addTo($email);
    $mail->setSubject($subject);
    $mail->addCc($cc);
    //$mail->setReplyTo('contact@company.com', 'Company');
    $mail->addHeader('MIME-Version', '1.0');
    $mail->addHeader('Content-Transfer-Encoding', '8bit');
    $mail->addHeader('Content-Type', 'text/html');
    $mail->addHeader('X-Mailer:', 'PHP/'.phpversion());
    $mail->send();
    return true;
  }
}

$todays_date = date('Y-m-d');
// $IQStr = "insert into PT_Emails (from_name, email_address, subject, body, date, phone) values ('$name', '$email', '$subject', '$message', '$todays_date', '$phone')";
//  if(!(mysql_query($IQStr))){
// 		echo "Something may have gone wrong with the email.  To be safe, you might want to hit the back button, and send the email again.  Alternately, you can give Paul a call at (510) 730-0390.";
// 		die();
// }		

$message = stripslashes($message);
$pttmess = "From the website of Paul the Tutor's:\n\n" . $message . "\n\n Phone: $phone" . "\n\n Email: $email";
$sendermess = "Please do not reply to this email as noreply@paulthetutors.com is not monitored.  The following message has been received, and we will reply within 48 hours.\nBe sure to put the domain 'paulthetutors.com' in your friends list.\n\n" . $message;
//$email = "";
//$email = $email2;
$strHeader = "From: website@paulthetutors.com.\r\nReply-to: $email";
$famparam = "-fnoreply@paulthetutors.com"; 
$paulparam = "-fsrisreed@gmail.com";
//my_mail2("info@paulthetutors.com", $subject, $pttmess, "From: $name $email");
//my_mail2("srisreed@gmail.com", $subject, $pttmess, "From: $name $email", $paulparam);
//ptts2_mail("paul@paulthetutor.com", $subject, $pttmess, "From: $name <$email>", $paulparam);
//ptts2_mail($email, $subject, $sendermess, "From: noreply@paulthetutors.com", $famparam);

// $email_to = (string)$email;
// $name_to = (string)$name;
// echo gettype($email_to);
// echo gettype($name_to);
// echo gettype($email);
// echo gettype($name);

//
// Email to paul
//
$opts[from][email] = "noreply@paulthetutors.com";
$opts[from][name] = "noreply@paulthetutors.com";
my_mail("newcontact@paulthetutors.com", $subject, $pttmess, "", $opts); //

//
// Email to customer
//
$opts[from][email] = "noreply@paulthetutors.com";
$opts[from][name] = "noreply@paulthetutors.com";
my_mail($email, $subject, $sendermess, "newcontact@paulthetutors.com", $opts); //

//
// Notify new message has been received at newcontact
//
$opts[from][email] = "newcontact@paulthetutors.com";
$opts[from][name] = "newcontact@paulthetutors.com";
$newmailmsg = "You have new mail";
$newmailsubject = "New mail from customer.";
my_mail("info@paulthetutors.com", $newmailsubject, $newmailmsg, "", $opts);

// ptts2_mail($email_address,$subject,$message,$other_h=NULL,$other_p=NULL)
// mail("info@paulthetutor.com",$subject,$message,$strHeader,$addparameters);



put_ptts_header("Thanks for Contacting Paul the Tutors", $strAbsPath, "", "");
?>
<link href="includes/paulthetutors.css" rel="stylesheet" type="text/css">


<table width="500" border=0>
  <tr bgcolor="#FFECC6">
    <td height="25" valign="top" bgcolor="#FFFFFF"><span class="Head1">Thank You for Contacting
        Paul The Tutor's </span></td>
  </tr>
  <tr>
    <td height="70" valign="top" bgcolor="#FFFFFF"><div align="left">
        <p>An email from
            <?=$name;?>
        at
        <?=$email;?>
        has been sent. <strong>Make sure this is the correct e-mail address</strong> </p>
        <p>You should also receive a copy of the email. If you do not receive
          a copy,please check your spam filter. You can always call us at 
          (510) 730-0390.</p>
        <p>Thanks,</p>
        <p>Paul the Tutor's </p>
    </div></td>
  </tr>

<tr>
<td>&nbsp;</td>
</tr>

</table>


<?
put_ptts_footer("");

?>
