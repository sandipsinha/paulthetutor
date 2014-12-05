<?php
// $intTableFieldsid is the id of the info we are to update

$strBack = "../";

include($strBack  . "includes/PTTIncludes.phtml");
require($strBack  . "../Paul13ToolBox/Paul13_comConnect.php");
include($strBack  . "../Paul13ToolBox/MySQL_functions.php");
include($strBack  . "../Paul13ToolBox/Paul13Includes.php");
include($strBack  . "../Paul13ToolBox/FormFunctions.php");

putPTTHeader("PaulTheTutor.com", $strBack);
?>

<table width="600" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" bordercolor="#996600">
  <tr> 
    <td height="53"><span class="pageheader">Please Enter the Information</span></td>
  </tr>
  <tr>
    <td>
     <form method="post" action="putfields.phtml">
	  <table border="0" height="" cellpadding="3" margin=0 cellspacing="3" width="100%" bgcolor="#FFFFFF">
            
        
<?php

//if id was passed then use the info from that user
if(isset($intTableFieldsid)){
	putHiddenField("intTableFieldsid", $intTableFieldsid);
	
	$QStr = "select * from $strTableName where id = $intTableFieldsid";
	$FieldsRS = mysql_execute($QStr);
	$arFieldsVals = mysql_fetch_array($FieldsRS);	
}

	
$QStrsid = "SHOW COLUMNS FROM $strTableName like 'sid'";
if(!($sidRS = mysql_query($QStrsid))){
	echo "QStr:  $QStrsid <BR>" . mysql_error() . "<BR><BR>";
}

if(mysql_num_rows($sidRS) >0){
	$QStrsi = "select firstname, lastname, id from PTStudentsInfo";
	if(!($siRS = mysql_query($QStrsi))){
		echo "QStr:  $QStrsi <BR>" . mysql_error() . "<BR><BR>";
	}
	
	while($arsi = mysql_fetch_array($siRS)){
		$arsis[$arsi[id]] = "$arsi[firstname] $arsi[lastname]";
	}
	
	putSelectInput('Student', 'sid', $arsis, '', '', 'required'); 
	$strNotUsed = "sid";
		
}

// do not need to enter id or any auto-increment
$strNotUsed = "sid,tid";

MySQL_BlankForm($strTableName, '', $arFieldsVals, $arFieldComments, $strUse, $strNotUsed, $tdStyle);

//if $strNotUsed is  not blank and <> 'sid save as a hidden field for MySQL_Insert function
if((!(isEmpty($strNotUsed))) and ($strNotUsed <> 'sid')){
	
	$strNotUsed = str_replace('sid', '',$strNotUsed);
	$strNotUsed = str_replace(',,', '',$strNotUsed);
	putHiddenField("strNotUsed", $strNotUsed);
}


putSubmitClear();
?>
 
</table></form></td></tr></table>
