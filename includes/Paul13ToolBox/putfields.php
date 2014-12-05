<?php
$strBack = "../";

//$strNotUsed and $strTableName were passed as hidden variables.

include($strBack  . "includes/PTTIncludes.phtml");
require($strBack  . "../Paul13ToolBox/Paul13_comConnect.php");
include($strBack  . "../Paul13ToolBox/MySQL_functions.php");
include($strBack  . "../Paul13ToolBox/Paul13Includes.php");
include($strBack  . "../Paul13ToolBox/FormFunctions.php");

putPTTHeader("PaulTheTutor Info Entered", $strBack);
?>

<table width="600" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" bordercolor="#996600">
  <tr> 
    <td height="53"><span class="pageheader">Please Enter Your Information</span></td>
  </tr>
  <tr>
    <td>
      <table border="0" height="" cellpadding="3" margin=0 cellspacing="3" width="100%" bgcolor="#FFFFFF"><TR><TD>
        
<?php

/*
$arMandFields are all manditory fields (usually blank and found automatically)
$strNotUsed is string of fields not to be used (if any exist, they are sent as a hidden fiels from the GET page)
$tdStyle is style used for each column (usually blank)
*/

if(isset($intTableFieldsid)){

	//set up strWhere so it puts the info in the row where id = $intTableFieldsid
	$strWhere = " where id = $intTableFieldsid ";

	$tester = UpdateFields($strTablename, $HTTP_POST_VARS, $arMandFields, $strNotUsed, $tdStyle, $strWhere);

} else {	

	$tester = InsertFields($strTableName, $HTTP_POST_VARS, $arMandFields, $strNotUsed, $tdstyle);
}
echo $tester; 

?>
 
The Information has been entered. 
</td></TR></table>
    </td>
  </tr></table>