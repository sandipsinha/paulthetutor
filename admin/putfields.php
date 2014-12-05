<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

put_ptts_header("Get Informaiton for $strTableName", $strAbsPath, "admin", "");
?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">


<table width="600" border="2" cellspacing="2" cellpadding="0" bgcolor="#996600" bordercolor="#996600">
  <tr>
    <td height="53" bgcolor="#003300"><span class="Head1_White">Entered <?=$strTableName;?> Information</span></td>
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
$strTableName = $_POST[strTableName];
$intTableFieldsid = $_POST[intTableFieldsid];
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

<BR><BR> Enter More Information <A HREF="javascript://" onClick="history.go(-1); return false">Go Back</A>

</td></TR></table>
    </td>
</tr></table>
  <?
put_ptts_footer("");
?>