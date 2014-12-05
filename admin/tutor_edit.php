<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$strTableName = "PT_Tutors";
$id = $_REQUEST['id'];
// printarray($_REQUEST);
?>

<table  cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">
<fieldset>  
<legend>Tutor Info</legend>
<table border="3"  cellspacing="0" cellpadding="0"  width="100%">

<?php
$QStr = "select * from $strTableName where id = $id";

if(isset($id)){
	If($_REQUEST[action] == "update" and isset($_REQUEST['id']) and isset($_REQUEST['strTableName'])){
	$strWhere = " id = ".$_REQUEST['id'];
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
	if (!$_REQUEST['password'])
		$_REQUEST['password'] = $arFieldsVals['password'];
	if (!$_REQUEST['gc_password'])
		$_REQUEST['gc_password'] = $arFieldsVals['gc_password'];
	$_REQUEST['strNotUsed'] = str_replace(array("nickname","gc_name"),array("",""),$_REQUEST['strNotUsed']);
	
	//verify if the nickname already exists
	$index_nickname = 1;
	$nickname = trim(strtolower($_REQUEST['first_name'])).substr(trim(strtolower($_REQUEST['last_name'])),0,1);
	$sw = 1;
	while($sw == 1){
		$row_n1 = singlequery("SELECT id FROM $strTableName WHERE nickname=\"".addslashes($nickname.($index_nickname > 1 ? $index_nickname : ''))."\" AND id!='".$_REQUEST['id']."' LIMIT 1");
		$row_n2 = singlequery("SELECT id FROM ZZ_".$strTableName."_Archive WHERE nickname=\"".addslashes($nickname.($index_nickname > 1 ? $index_nickname : ''))."\" LIMIT 1");
		if ($row_n1['id'] || $row_n2['id']){
			$index_nickname++;
		}
		else
			$sw = 0;
	}
	
	if ($index_nickname>1){
		$nickname=$nickname.$index_nickname;
	}
		
	$_REQUEST['nickname'] = $nickname;
	$_REQUEST['gc_name'] = $nickname;
	$msg = UpdateFields($_REQUEST['strTableName'], $_REQUEST, $arMandFields, $_REQUEST['strNotUsed'], $tdStyle, $strWhere); 
	if (!$msg){
		echo "<div class=text_success style='text-align:center'>The data has been saved.</div>";
		echo '<script type="text/javascript">opener_reload();</script>';
	}
	else 
		echo $msg;
} 
	putHiddenField("id", $id);
	putHiddenField("action", "update");
	$strNotUsed = "id, nickname, gc_name, cell_carrier";
	putHiddenField("strNotUsed", $strNotUsed);
	
if ($id){
	$FieldsRS = runquery($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
}

MySQL_JustForm($strTableName, "", $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
}
?>

<?php
$arRequired = array();
MySQL_JustForm_End($arRequired, "form1","");
?>

<tr>
	<td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button>
<button onclick="popup_close()">Close</button>
</fieldset></td>
</tr> </table></fieldset>
</form>
</td></tr></table>
<?
put_ptts_footer("popup");
?>
