<?php

include("../includes/pttec_includes.phtml");

put_ptts_header("Register", $strAbsPath, "parents", ""); 

$strTableName = 'PT_Family_Info2';

MySQL_PaulTheTutor_Connect();
//put_ptts_header("Register", $strAbsPath, "parents", ""); 

if (!isset($_GET['status'])) {

	$sql = "INSERT INTO PT_Family_Info2 (`id`) VALUES (NULL);";

	$new_fam_id = runquery($sql);

}

?>

<div class="form-container">

	<form method="post" action="fam_reg2.php?page=<?php echo $new_fam_id;?>">

		<fieldset><legend><strong>Registration</strong></legend><table  cellspacing="4" cellpadding="4" width="25%">

			<h1 class="center-text">Choose a username and password</h1>

			<?php if (isset($_GET['status']) && $_GET['status'] == 'invalid') { ?>

			<p style="color: red;">The username is not available, please choose another.</p>

			<?php } ?>

  <tr bgcolor="#FFFFFF">
    
    <td  colspan="2">
     
  </td></tr>

<?php 

MySQL_JustForm($strTableName, NULL, NULL, NULL,NULL, 'id,main_guard_id,main_name,main_phone,main_email,billing_guard_id,billing_name,billing_email,heard_about_us,hear_more' ); 

MySQL_JustForm_End($arRequired, "form1",""); ?>

	</td></tr></table></fieldset></form>

</div>

<?php

//header("Location: fam_reg2.php?page=" . $new_fam_id);

put_ptts_footer(""); 

?>
