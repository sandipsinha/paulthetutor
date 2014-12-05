<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

// printarray($_REQUEST);

MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$folder = getfolder('','','');
$email_username = $_REQUEST[email_username];
$email_sent = 0;
if ($_GET[email_sent])
	$email_sent = 1;
if ($email_username!=''){
	if ($folder == "parents")
		$res = runquery("select username, id, password FROM PT_Family_Info where billing_email='".addslashes($email_username)."' OR main_email='".addslashes($email_username)."' LIMIT 1");
	elseif($folder == "tutors")
		$res = runquery("select username, password from PT_Tutors where username='".addslashes($email_username)."' OR email='".addslashes($email_username)."' LIMIT 1");
	if (mysql_num_rows($res)){
		$row = mysql_fetch_array($res);
		if ($folder == "parents")
			$account_info = "Account: $row[id]";
		
		$content_email = "Here is your www.paulthetutors.com information
		
Username: $row[username]
Password: $row[password]
$account_info
		
If this doesn't solve the problem, let us know.
		
Paul The Tutor's
info@paulthetutors.com
510-730-0390";
		
		$headers = "From: noreply@paulthetutors.com";
//		$headers .= "\r\nCc: info@paulthetutors.com";
		$headers .= "\r\nBcc: paul@paulthetutor.com";
		$headers .= "\r\nX-Mailer: PHP/" . phpversion();
//		$headers .= "Reply-To: noreply@paulthetutors.com" . "\r\n";
//		$headers .= "Bcc: info@paulthetutors.com" . "\r\n";
//		$headers .= "X-Mailer: PHP/" . phpversion();

		$strParam = "-fnoreply@paulthetutors.com";
	
$paulemail = "paul@paulthetutors.com";
//		mail($paulemail, "Account Information for www.paulthetutors.com",$content_email,$headers,$strParam);

	
		if (mail($email_username, "Account Information for www.paulthetutors.com",$content_email,$headers,$strParam)){
		

// echo "$msg is message for mail($email_username, 'Account Information for www.paulthetutors.com',$content_email,$headers,$strParam)";
		
			header_location("getlostinfo.php?email_sent=1");
		}else
			$msg='<div class="div_error">The message has not been sent.</div>';
	}else{
		$msg='<div class="div_error">Information not found in the database.</div>';
	}
}

if ($email_sent)
	$msg='<div class="text_success" style="text-align:center">A message with your www.paulthetutors.com informations has been sent.</div>';

?>
<table  border="0" cellpadding="5" cellspacing="5" align=center width=100%> 
<tr>
<td>
  <form name="form1" method="post">
	<fieldset>
	<legend class="Head2_Brown" style="text-decoration:none">Get Paul the Tutor's Account Information</legend>  
	<table width=100% align="center" border="0" cellpadding="5" cellspacing="10"> 
	<?php if ($msg!=''){?>
	<tr>
		<td colspan="2"><? echo $msg?></td>
	</tr>
	<?php }
	if (!$email_sent){
		putTextField("Please enter you email or username", "email_username", '',40, '', '', '');
		?>	
		<tr>
			<td align=center  colspan="2"><input class="submit" type="submit" value="Submit" style="cursor:pointer"/> </td>
		</tr>
		<tr>
			<td align=center  colspan="2">
		Don't remember information? &nbsp;<a alt="Forgot information" title="Forgot information" href="../contact.php" />Contact us</a></td>
	</tr>
	<?}?>
	</table></fieldset>
</form>
	</td>
  </tr>
</table>
<?
put_new_footer();
if (!$email_sent){
?>
	<script language="JavaScript" type="text/javascript">
 		var frmvalidator2 = new Validator("form1");	
 		frmvalidator2.addValidation("email_username","req","Please enter your email/username");  		    
	</script>	
<?}?>