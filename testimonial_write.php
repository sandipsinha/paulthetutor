<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();

put_ptts_header("Write a testimonial", $strAbsPath, "", "");

$strTableName = "PTTestimonials";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : false;

?>

<table  cellspacing="0" cellpadding="0" class="testimonial-table ">
	<tr>
		<td>

			<hr size="2" color="black">
			<div align="center"><span class="Head1">Write a Testimonial</span></div>

		</td>
	</tr>
  
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">

<table cellspacing="0" cellpadding="0" >
<tr><td><fieldset class="testimonial-fieldset">  

<?php
if ($id) {
$QStr = "select * from $strTableName where id = $id";
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == "insert"){
	
	$_REQUEST['date'] = date( "Y-m-d\TH:i:sP" );

  $msg = InsertFields($strTableName, $_REQUEST, null,'id', null, null); 
  if (!$msg || is_int($msg)){
    echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
  } else { 
    echo $msg;
  }
}
putHiddenField("action", "insert");
$strNotUsed = "id";
putHiddenField("strNotUsed", $strNotUsed);
$arFieldsVals = null;
?>



<?php
MySQL_JustForm($strTableName, "", $arFieldsVals, '', '', 'verified, date', ''); 
?>

<?php
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!-- <button type="submit" name="Submit">Save</button> -->
</fieldset></form></td></tr></table>

<?
put_ptts_footer("");
?>
