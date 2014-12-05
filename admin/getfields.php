<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

$strTableName = $_REQUEST[strTableName];
put_ptts_header("Get Informaiton for $strTableName", $strAbsPath, "admin", "");
?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">


<table width="600" border="2"  cellspacing="0" cellpadding="2" bgcolor="#006600" bordercolor="#996600">
  <tr>
    <td height="53" bgcolor="#006600" colspan="2"><span class="Head1_White">Please Enter the <?=$strTableName;?> Information</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>
     <form action="putfields.php" method="post" name="form1" id="form1">

<table >
<?php

//if id was passed then use the info from that user
if(isset($intTableFieldsid)){
	putHiddenField("intTableFieldsid", $intTableFieldsid);

	$QStr = "select * from $strTableName where id = $intTableFieldsid";
	$FieldsRS = mysql_execute($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);
}
// get sid info
$QStrsid = "SHOW COLUMNS FROM $strTableName like 'sid'";
if(!($sidRS = mysql_query($QStrsid))){
	echo "QStr:  $QStrsid <BR>" . mysql_error() . "<BR><BR>";
}

if(mysql_num_rows($sidRS) >0){
	$QStrsi = "select students, billing_name, id from PT_Family_Info order by students";
	if(!($siRS = mysql_query($QStrsi))){
		echo "QStr:  $QStrsi <BR>" . mysql_error() . "<BR><BR>";
	}
	
	if($useAll == "true"){
		$arsis[0] = "All";
	}	
	
	while($arsi = mysql_fetch_array($siRS)){
		$arsis[$arsi[id]] = "$arsi[billing_name] ($arsi[students])";
	}

	putSelectInput('Student', 'sid', $arsis, '', '', 'required');
	$strNotUsed = "fid";

}

// get fid info
$QStrfid = "SHOW COLUMNS FROM $strTableName like 'fid'";
if(!($fidRS = mysql_query($QStrfid))){
	echo "QStr:  $QStrfid <BR>" . mysql_error() . "<BR><BR>";
}

if(mysql_num_rows($fidRS) >0){
	$QStrsi = "select students, billing_name, id from PT_Family_Info order by students";
	if(!($siRS = mysql_query($QStrsi))){
		echo "QStr:  $QStrsi <BR>" . mysql_error() . "<BR><BR>";
	}
	
	if($useAll == "true"){
		$arsis[0] = "All";
	}	
	
	while($arsi = mysql_fetch_array($siRS)){
		$arsis[$arsi[id]] = "$arsi[billing_name] ($arsi[students])";
	}

	putSelectInput('Student', 'fid', $arsis, '', '', 'required');
	$strNotUsed = "fid";

}
echo "</table>";
// do not need to enter id or any auto-increment
$strNotUsed = "id, fid, sid,tid";
MySQL_BlankForm($strTableName, '', $arFieldsVals, $arFieldComments, $strUse, $strNotUsed, $tdStyle);

//if $strNotUsed is  not blank and <> 'sid save as a hidden field for MySQL_Insert function
if((!(isEmpty($strNotUsed))) and ($strNotUsed <> 'sid')){

	$strNotUsed = str_replace('sid', '',$strNotUsed);
	$strNotUsed = str_replace(',,', '',$strNotUsed);
	putHiddenField("strNotUsed", $strNotUsed);
}

?>

     </form></td></tr></table>
<?
put_ptts_footer("");
?>