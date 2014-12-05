<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

reqToVars();


$strHeader = "From: $name<$email>";



$todays_date = date('Y-m-d');
$IQStr = "insert into PT_Emails (from_name, email_address, subject, body, date, phone) values ('$name', '$email', '$subject', '$message', '$todays_date', '$phone')";
 if(!(mysql_query($IQStr))){
		echo "Something may have gone wrong with the email.  To be safe, you might want to hit the back button, and send the email again.  Alternately, you can give Paul a call at (510) 730-0390.";
		die();
}		

$message = stripslashes($message);
$pttmess = "From the website of Paul the Tutor's:\n\n" . $message . "\n\n Phone: $phone";
$sendermess = "Please do not reply to this email as noreply@paulthetutors.com is not monitored.  The following message has been received, and we will reply within 48 hours.\nBe sure to put the domain 'paulthetutors.com' in your friends list.\n\n" . $message;

$strHeader = "From: website@paulthetutors.com.\r\nReply-to: $email";
$famparam = "-fnoreply@paulthetutors.com"; 
$paulparam = "-f$email";
// ptts2_mail("info@paulthetutors.com", $subject, $pttmess, "From: $name <$email>");
ptts2_mail("info@paulthetutors.com", $subject, $pttmess, "From: $name <$email>", $paulparam);
//ptts2_mail("paul@paulthetutor.com", $subject, $pttmess, "From: $name <$email>", $paulparam);
ptts2_mail($email, $subject, $sendermess, "From: noreply@paulthetutors.com", $famparam);

$opts[from][name] = $name;
$opts[from][email] = $email;
ptts_mail("info@paulthetutors.com", $subject, $pttmess, $opts);


$opts[from][email] = "noreply@paulthetutors.com"; 
$opts[from][name] = "noreply@paulthetutors.com";
ptts_mail($email, $subject, $sendermess, $opts);

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
