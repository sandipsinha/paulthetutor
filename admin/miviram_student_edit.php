<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$strTableName = "PTStudentInfo_New";
$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">

<table cellspacing="0" cellpadding="0"  width="100%">
<tr><td><fieldset>  
<legend>Edit Student</legend>  
<?php
$QStr = "select * from $strTableName where id = $id";
if (isset($_REQUEST['action']) && $_REQUEST['action']){
  if($_REQUEST['action'] == "update" and isset($_REQUEST['id']) and isset($_REQUEST['strTableName'])){
    $strWhere = " id = $_REQUEST[id]";
    $msg = UpdateFields($strTableName, $_REQUEST, $arMandFields, 'id', null, $strWhere); 
  } elseif ($_REQUEST['action'] == "insert"){
    $msg = InsertFields($strTableName, $_REQUEST, $arMandFields, '', null, null); 
	
	
			if(!(isEmpty($_REQUEST['fid']))){  // if this person is a member of a family, enter the fid
			$fid=$_REQUEST['fid'];
			$sid = isset($_REQUEST['id']) ? $_REQUEST['id'] : $msg;
			$stu_name = $_REQUEST['first_name'];
			$RS = mysql_query("select students, number_of_students from PT_Family_Info where id = $fid");
			$arFI = mysql_fetch_array($RS);
			$stidnum = $arFI['number_of_students'] + 1;
			$strStudents = "$arFI[students] $stu_name";
			$strStudents = trim($strStudents);
		
			$QStr = "Update PT_Family_Info SET number_of_students = $stidnum, sid".$stidnum." = $sid, students = '$strStudents' where id = $fid";
		
			//echo "the update string is $QStr<BR>";
			mysql_query($QStr);
			//echo mysql_error();
		} //if fid is set
  }

  


if (!$msg || is_int($msg)){
		echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
		echo '<script type="text/javascript">opener_reload();</script>';
}
	else 
		echo $msg;
}
//echo $QStr;
if ($id){
	putHiddenField("id", $id);
	$strNotUsed = "date,student";
	putHiddenField("strNotUsed", $strNotUsed);
	putHiddenField("action", "update");
	$FieldsRS = runquery($QStr);
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
</fieldset></td></tr>
</form></td></tr></table>

<?
put_ptts_footer("popup");
?>
