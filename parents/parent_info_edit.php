<?php
/* ============================================= */
// This is a pop-up page called from fam_reg2.php

// Created in part by Leo H 10-14-2013 leo@radbitt.com
/* ============================================= */
ob_start();

include("../includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "admin",'popup');

$strTableName = "PT_Parent_Info";

//another strTableName = PT_Family_Info2
$fid = $_GET['id']; 

?>



<form method="post"  name="form1">

<fieldset><legend><strong>Parent Info</strong></legend><table  cellspacing="4" cellpadding="4" width="100%">

<tr bgcolor="#FFFFFF">

<td  colspan="2">

</td></tr>

<?php
//$Info_QStr = "select * from $strTableName where id = $id";
//echo "$QStr is qstr<BR>";

if ($_POST['action'] == "update" and isset($_REQUEST['id']) and isset($_REQUEST['strTableName'])) {

	$strWhere = " id = $_REQUEST[id]";

	//$id = $_REQUEST['id'];

	$msg = UpdateFields($strTableName, $_REQUEST, $arMandFields, 'id', null, $strWhere); 

} elseif ($_POST['action'] == "insert") { 

// Need to change this, to insert with family ID. 

	$msg = InsertFields($strTableName, $_POST, '', '', ''); 

	var_dump($msg);

	if ( $_POST['main_contact'] == TRUE ) {

		$main_contact_sql = "UPDATE
		PT_Family_Info2
		SET main_guard_id = $msg, main_name = '$_POST[first_name]', main_phone = '$_POST[home_phone]', main_email = '$_POST[email]' 
		WHERE id = $_POST[family_id];";

		runquery($main_contact_sql); 

	}

}

/*if(!(isEmpty($_REQUEST['fid']))){  // if this person is a member of a family, enter the fid

$fid=$_REQUEST['id'];

$sid = isset($_REQUEST['id']) ? $_REQUEST['id'] : $msg;

$strStudents = get_family_snames($fid);

$QStr = "Update PT_Family_Info SET students = '$strStudents' where id = $fid";

//echo "the update string is $QStr<BR>";
mysql_query($QStr);
//echo mysql_error();
} //if fid is set */


if (isset($msg) && is_int($msg) ) { var_dump($msg); ?>
	
	<script type="text/javascript">

		//This functions uses the 'opener' object to call a function from the parent window to make the check marks. The function 'makeMarks_CheckMarks is defined in the parent window's code.

		function passBackCondition() {

			opener.makeMarks_CheckMarks('parent'); 

		}	

		passBackCondition();

	</script> 

	<?php echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";

	echo '<script type="text/javascript">opener_reload();</script>';

} else {

	echo $msg; 

}

/*if ($id) {

putHiddenField("id", $id);

$strNotUsed = "date,student";

putHiddenField("strNotUsed", $strNotUsed);

putHiddenField("action", "update");

$Info_QStr = "select * from $strTableName where id = $id";

$FieldsRS = runquery($Info_QStr);

$arFieldsVals = mysql_fetch_array($FieldsRS);

} else {

putHiddenField("action", "insert");

$strNotUsed = "id,date,student";

putHiddenField("strNotUsed", $strNotUsed);

}*/

MySQL_JustForm($strTableName, NULL, NULL, NULL,NULL, 'family_id' );

if ($_GET['id']){

putCheckBoxInput('Check here if this is also the main contact information', 'main_contact', 'checked');

putCheckBoxInput('Check here if this is also the main billing information', 'billing_contact', 'checked');

putHiddenField("family_id",$_GET['id']);

putHiddenField("action", "insert"); 	

}

$arRequired = array();

MySQL_JustForm_End($arRequired, "form1",""); ?>


</td></tr></table></fieldset></form>

<?php put_ptts_footer("popup"); ?>
