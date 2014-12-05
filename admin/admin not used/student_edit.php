<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$strTableName = "PTStudentInfo_New";
$id = isset($_REQUEST['id'])? $_REQUEST['id']:null;
?>
<form method="post"  name="form1">

<fieldset><legend><strong>Student Info</strong></legend><table  cellspacing="4" cellpadding="4" width="100%">
  <tr bgcolor="#FFFFFF">
    <td  colspan="2">
     

  
  </td></tr>
<?php
$Info_QStr = "select * from $strTableName where id = $id";
//echo "$QStr is qstr<BR>";
if (isset($_REQUEST['action']) && $_REQUEST['action']){
  if($_REQUEST['action'] == "update" and isset($_REQUEST['id']) and isset($_REQUEST['strTableName'])){
    $strWhere = " id = $_REQUEST[id]";
	$id = $_REQUEST[id];
    $msg = UpdateFields($strTableName, $_REQUEST, $arMandFields, 'id', null, $strWhere); 
  } elseif ($_REQUEST['action'] == "insert"){
    $msg = InsertFields($strTableName, $_REQUEST, $arMandFields, '', null, null); 
  }

  if(!(isEmpty($_REQUEST['fid']))){  // if this person is a member of a family, enter the fid
    $fid=$_REQUEST['fid'];
    $sid = isset($_REQUEST['id']) ? $_REQUEST['id'] : $msg;
    $strStudents = get_family_snames($fid);

    $QStr = "Update PT_Family_Info SET students = '$strStudents' where id = $fid";

    //echo "the update string is $QStr<BR>";
    mysql_query($QStr);
    //echo mysql_error();
} //if fid is set


if (!$msg || is_int($msg)){
		echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
		echo '<script type="text/javascript">opener_reload();</script>';
}
	else 
		echo $msg;
}
if ($id){
	putHiddenField("id", $id);
	$strNotUsed = "date,student";
	putHiddenField("strNotUsed", $strNotUsed);
	putHiddenField("action", "update");
	$Info_QStr = "select * from $strTableName where id = $id";
	$FieldsRS = runquery($Info_QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
}else
	putHiddenField("action", "insert");
	$strNotUsed = "id,date,student";
	putHiddenField("strNotUsed", $strNotUsed);
	
MySQL_JustForm($strTableName, "", isset($arFieldsVals)?$arFieldsVals:null, null, null, $strNotUsed, '');


?>

<?php
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
?>

</td></tr></table></fieldset></form>

<?
put_ptts_footer("popup");
?>
