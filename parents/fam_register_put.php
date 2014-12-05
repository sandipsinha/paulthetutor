<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

//if they came to this page not from the form, kill the page
if(isEmpty($_REQUEST[main_contact]) or isEmpty($_REQUEST[username])){ 

echo "It appears that you did not fill out the form <BR> If you did, some data is missing. Please go back and re-enter the necessary data";

die();


}



MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "", "");

/*jana's changes*/
function sendParentRegisteredMail($fid){
	//take parent's info so it could be sent in an email
	$query="select main_name, main_email, main_phone from PT_Family_Info where id='$fid'";
	$result=mysql_query($query);
	$row=mysql_fetch_row($result);
	$parents_name=$row[0];
	$parents_email=$row[1];
	$parents_phone=$row[2];


	$to="info@paulthetutors.com";
	$from="reg@paulthetutors.com"; 		
	$subject="New parent's registration";
	$message="New parent has been registered. Contact information is below:<br/>";
	$message.="<br/><b>Name: </b>$parents_name<br/><b>Email: </b>$parents_email<br/><b>Address: </b>$parents_phone<br/>";

	//send mail
		$headers = "From: reg@paulthetutors.com \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
        ptts2_mail($to, $subject, $message, $headers);
}

function sendMailToParent($fid) {
  //take parent's info so it could be sent in an email
  $query="select main_name, main_email, main_phone from PT_Family_Info where id='$fid'";
  $result=mysql_query($query);
  $row=mysql_fetch_row($result);
  $parents_name=$row[0];
  $parents_email=$row[1];
  $parents_phone=$row[2];
  $body = "<p>Welcome to Paul the Tutor's Education Center!<p>Your family/account number is: $fid</p>";
  $body .= file_get_contents('welcome_email.html');
  
  		$headers = "From: reg@paulthetutors.com \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

  
  
  ptts2_mail($parents_email, "Welcome to Paul the Tutor's Education Center!", $body, $headers );
}

?>


<style type="text/css">
<!--
.plain {
	font-weight: normal;
}
.style1 {font-weight: normal; font-size: 10px; }
.style3 {font-weight: normal; font-size: 12px; }
.style4 {font-size: 12px}
.book_position {
	left: 5px;
	top: 450px;
	position: absolute;
}
-->
</style>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="750" border="2" cellpadding="5" cellspacing="0" background="../images/flowbg.gif">
  <tr >
    <td height="25" colspan="2"" valign="top" class="Head1_Green">Your  Information Has Been Entered </td>
  </tr>
  <tr>
    
    <td width="448" height="66" valign="top" colspan="2"> <p>
<?php
$ok_double_registration = 0;
if (isset($_REQUEST['mother'])){



  $res = runquery("select * from PT_Family_Info where ('".addslashes($_REQUEST['mothers_phone'])."'!='' AND mothers_phone='".addslashes(trim($_REQUEST['mothers_phone']))."') OR ('".addslashes($_REQUEST['fathers_phone'])."'!='' AND fathers_phone='".addslashes(trim($_REQUEST['fathers_phone']))."') OR ('".addslashes($_REQUEST['guardians_phone'])."'!='' AND guardians_phone='".addslashes(trim($_REQUEST['guardians_phone']))."') OR ('".addslashes($_REQUEST['mothers_email'])."'!='' AND mothers_email='".addslashes(trim($_REQUEST['mothers_email']))."') OR ('".addslashes($_REQUEST['fathers_email'])."'!='' AND fathers_email='".addslashes(trim($_REQUEST['fathers_email']))."') OR ('".addslashes($_REQUEST['guardians_email'])."'!='' AND guardians_email='".addslashes(trim($_REQUEST['guardians_email']))."') OR ('".addslashes($_REQUEST['mother'])."'!='' AND mother='".addslashes(trim($_REQUEST['mother']))."') OR ('".addslashes($_REQUEST['father'])."'!='' AND father='".addslashes(trim($_REQUEST['father']))."') OR ('".addslashes($_REQUEST['guardian'])."'!='' AND guardian='".addslashes(trim($_REQUEST['guardian']))."') OR username='".addslashes(trim($_REQUEST['username']))."'");

  if (mysql_num_rows($res)){
	$msg_double="Field with the value <b>";
	$row = mysql_fetch_array($res);
	if ($row['mother'] == trim($_REQUEST['mother']) && $_REQUEST['mother']!='')
		$msg_double.= $row['mother'];
	elseif ($row['father'] == trim($_REQUEST['father']) && $_REQUEST['father']!='')
		$msg_double.= $row['father'];
	elseif ($row['guardian'] == trim($_REQUEST['guardian'])  && $_REQUEST['guardian']!='')
		$msg_double.= $row['guardian'];
	elseif ($row['username'] == trim($_REQUEST['username']))
		$msg_double.= $row['username'];
	elseif ($row['mothers_phone'] == trim($_REQUEST['mothers_phone']) && $_REQUEST['mothers_phone']!='')
		$msg_double.= $row['mothers_phone'];
	elseif ($row['fathers_phone'] == trim($_REQUEST['fathers_phone']) && $_REQUEST['fathers_phone']!='')
		$msg_double.= $row['fathers_phone'];
	elseif ($row['guardians_phone'] == trim($_REQUEST['guardians_phone'])  && $_REQUEST['guardians_phone']!='')
		$msg_double.= $row['guardians_phone'];
	elseif ($row['mothers_email'] == trim($_REQUEST['mothers_email']) && $_REQUEST['mothers_email']!='')
		$msg_double.= $row['mothers_email'];
	elseif ($row['fathers_email'] == trim($_REQUEST['fathers_email']) && $_REQUEST['fathers_email']!='')
		$msg_double.= $row['fathers_email'];
	elseif ($row['guardians_email'] == trim($_REQUEST['guardians_email'])  && $_REQUEST['guardians_email']!='')
		$msg_double.= $row['guardians_email'];
	$msg_double.='</b> is already in the database.';
  }else
	$ok_double_registration = 1;

if (!$ok_double_registration){ 
	echo '<form name="form" method="post" action="fam_register.php">';
//        if (!$captcha->is_valid) putHiddenField("bad_captcha",1);
	putHiddenField("ok_double_registration", 0);
	putHiddenField("msg_double", $msg_double);
	foreach($_REQUEST as $k=>$v)
		echo '<input type=hidden name="'.$k.'" value="'.$v.'">';
	echo '</form>';
	echo '<script>document.form.submit()</script>';
	}
else{
	$billing_email = $_REQUEST['billing_contact']."s_email";
	$main_email = $_REQUEST['main_contact']."s_email";
	//echo $_REQUEST[$main_contact] .$_REQUEST[$main_email];
	$billing_name = $_REQUEST['billing_contact'];
	$main_name = $_REQUEST['main_contact'];
//	echo "mc:".$main_email;
//	echo "me:" .$_REQUEST[$main_email];		
	$main_contact=$_POST['main_contact'];
	$main_name=$_POST[$main_contact];
//	echo "main name: ".$main_name;
	$_REQUEST['billing_name'] = $_REQUEST[$billing_name];
	$_REQUEST['billing_email'] = $_REQUEST[$billing_email];
	$_REQUEST['main_email'] = $_REQUEST[$main_email];
	$_REQUEST['main_name'] = $_REQUEST[$main_contact];
	$strTableName = $_REQUEST['strTableName'];

	//janag's change: "" 4th arg
	$fid = InsertFields($strTableName, $_REQUEST, '', '', '');
//	$fid = $tester;

        sendMailToParent($fid);
	sendParentRegisteredMail($fid);
//	sendParentvCards($fid);
	//add registrar to mailing list
	if (isset($_REQUEST['add_to_mailing_list'])){
		web_send_email(stripslashes($_REQUEST['main_name'])."<".$_REQUEST['main_email'].">", "news@paulthetutors.com", $_REQUEST['main_email']." has been added to mailing list", "Hello, <br>".$_REQUEST['main_email']." has been added to your mailing list.");
		}
	}
}


?>
        <span class="Head2">Please Enter Your Student's Information</span> <br>
        For those with multiple students, please enter one student at a time.<br>
        Registration is not complete until you enter information for at least one student.
      <form name="form1" method="post" action="putstudentinfo.php">
<?
putHiddenField('fid', $fid);
 
//$strNotUsed = getIgnoreColumns('PTStudentInfo_New', 'PT_Table_Info');
$strNotUsed = "fid,tid,archived,birthday";

$arFieldComments['mother'] = "first and last name";

MySQL_BlankForm('PTStudentInfo_New', '', $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $tdStyle);
?>	
      </form>            </td>
  </tr>
  <tr>
    <td height="40" valign="top">&nbsp;</td>
  </tr>
</table>




<?
put_ptts_footer("");
?>
