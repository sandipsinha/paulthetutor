/*-------------------------------------------------------------------	*/
/* set the key and Values for common table fields						*/
/* MUST BE PUT BACK INTO SPECIAL.php									*/
/*-------------------------------------------------------------------	*/

Function setDisplayFieldVals($strField){

//echo "string field $strField<br>";

	$strField = str_replace("no_","Number of ", $strField);
	$strField = str_replace("num_","Number of ", $strField);
	$strField = str_replace("username","Username", $strField);
	$strField = str_replace("password","Password", $strField);
	$strField = str_replace("firstname","First Name",$strField);
	$strField = str_replace("lastname","Last Name", $strField);
	$strField = str_replace("phone","Phone Number", $strField);
	$strField = str_replace("address1","Address", $strField);
	$strField = str_replace("address2","Address 2", $strField);
	$strField = str_replace("_"," ", $strField);

	$arField = explode( " ", $strField);
//echo $strField . "1<BR>";
	while(list($key,$field) = each($arField)){
//		echo "$key $field $arField[$key]<BR>";
		$arField[$key] = ucfirst($field);
//		echo "$key $field $arField[$key]<BR>";
	}
//echo $strField . "2<BR>";

	$strField = implode(" ", $arField);

//echo $strField . "3<BR><BR><BR>";

	$return = $strField;
	return $return;
}


