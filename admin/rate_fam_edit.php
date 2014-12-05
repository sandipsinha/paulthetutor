<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$strTableName = "PT_Rates_Fam";
$id = isset($_REQUEST['id']) ? $_REQUEST['id']:null;
?>

     <form method="post"  name="form1">
<fieldset> 
<legend>Tutoring Rates</legend>  
<table bgcolor="#FFFFFF"  cellspacing="1" cellpadding="6" border="2" bordercolor="#000000" width="100%">
 

<?php
$QStr = "select * from $strTableName where id = $id";
if (isset($_REQUEST['action'])){
	If($_REQUEST['action'] == "update" and isset($_REQUEST['id']) and isset($_REQUEST['strTableName'])){
	$strWhere = " id = $_REQUEST[id]";
	$msg = UpdateFields($strTableName,$_REQUEST, $arMandFields, 'id', $tdStyle, $strWhere); 
	
	if (!(isEmpty($_REQUEST[purchase_date])) and !(isEmpty($_REQUEST[rate]))){
		$start_date = $_REQUEST[purchase_date];
		$rate = $_REQUEST[rate];
		
echo "should rerate 		rerate_sessions($_REQUEST[family_id], $start_date, $_REQUEST[end_date], $_REQUEST[student_id])";
		
		rerate_sessions($_REQUEST[family_id], $start_date, $_REQUEST[end_date], $_REQUEST[student_id]);
	}
	
} elseif ($_REQUEST['action'] == "insert"){
	 	 $msg = InsertFields($strTableName, $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
		 
// update fields if necessary
		if (!(isEmpty($_REQUEST[purchase_date])) and !(isEmpty($_REQUEST[rate]))){
			$start_date = $_REQUEST[purchase_date];
			$rate = $_REQUEST[rate];
//			echo "start date is $start_date <BR />";
			
			rerate_sessions($_REQUEST[family_id], $start_date, $_REQUEST[end_date], $_REQUEST[student_id]);
		}
	// singlequery($uqs);		 
}

if (!$msg || is_int($msg)){
		echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
		echo '<script type="text/javascript">opener_reload();</script>';
}
	else 
		echo $msg;
}
if ($id){
	putHiddenField("id", $id);
	$strNotUsed = "";
	putHiddenField("strNotUsed", $strNotUsed);
	putHiddenField("action", "update");
}else {
	putHiddenField("action", "insert");
	$strNotUsed = "id";
	putHiddenField("strNotUsed", $strNotUsed);

}
$arFieldsVals = array();	
if ($id){
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
}

$strNotUsed = "$strNotUsed,name, hours_purchased, hours_remaining"; 

$arFieldNames = array(purchase_date => "Start Date");

MySQL_JustForm($strTableName, $arFieldNames, $arFieldsVals, "", null, $strNotUsed, null);
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
?>

</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button>
<?
if ($popup <> 'popup') { ?>

 &nbsp;&nbsp;&nbsp;&nbsp;&laquo;<a href='rate_list.php'>Back to Rate list</a>
 
 <? } ?>
 
</fieldset></td>
</tr> 
</form></td></tr></table>

<?
put_ptts_footer("popup");
?>
