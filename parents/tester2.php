<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

/*
$insert_str="insert into PT_Billing
(fid,name,month,year,amount,status,paid_amount,date)
 values(206,'testJG','12','2010',3,'notpaid',0,'')";
runquery($insert_str);
echo mysql_affected_rows();*/

/*
//$FQStr = "select * from PTStudentInfo_New";
$FQStr = "select * from PTAddedApp order by id desc";

$FRS = runquery($FQStr);
echo mysql_field_type($FRS,3); 
//echo"numrows" . mysql_num_rows($FRS). "   ";

while($far = mysql_fetch_row($FRS))
	echo"$far[0] $far[1] $far[2] $far[3] $far[4] $far[5] $far[6] $far[7] $far[8] $far[9] $far[10] $far[11]<br/> ";
//echo mysql_num_rows();
*/

//$FQStr = "delete from PTAddedApp where sid=223";

//$FRS = runquery($FQStr);
//echo mysql_field_type($FRS,3); 
//echo"numrows" . mysql_num_rows($FRS). "   ";
/*
while($far = mysql_fetch_row($FRS))
	echo"$far[0] $far[1] $far[2] $far[3] $far[4] $far[5] $far[6] $far[7] $far[8] $far[9] $far[10] $far[11]<br/> ";
//echo mysql_num_rows();
*/
/*
$res=mysql_query("select * from PTMissedApp");
echo mysql_field_name($res,0);
echo mysql_field_name($res,1);

echo mysql_field_name($res,2);
echo mysql_field_name($res,3);

echo mysql_field_name($res,4);
echo mysql_field_name($res,5);
echo mysql_field_name($res,6);
echo mysql_field_name($res,7);
echo mysql_field_name($res,8);
echo mysql_field_name($res,9);
echo mysql_field_name($res,10);
echo mysql_field_name($res,11);
echo mysql_field_name($res,12);
echo mysql_field_name($res,13);
echo mysql_field_name($res,14);
echo mysql_field_name($res,15);
*/
$query="select * from PTAddedApp order by id desc";
$result=runquery($query);
echo mysql_num_rows($result);
while($row=mysql_fetch_row($result))
{	
	echo"$row[0] $row[1] $row[2] $row[3] $row[4] $row[5] $row[6] $row[7] $row[8] $row[9] <br/>";
}
$month=12;
$year=2010;
/*$QStr = "select date, hours, rate, start_time, comments from PTAddedApp where month(date)='12' and year(date)='2010' and tid=1 order by date desc";*/
/*$QStr=  "SELECT date as start_date, date as end_date, start_time, end_time FROM PT_Other_Appt WHERE tutor_id = 1 AND date >= '23-11-2010' AND date <='06-01-2011'";

	if(!($AdARS = mysql_query($QStr))){
		echo "$QStr <br>" . mysql_error();
	}
	while($arAdA = mysql_fetch_row($AdARS)){

		echo $arAdA[0] ." " . $arAdA[1] ." " . $arAdA[2] ." " . $arAdA[3] ." " . $arAdA[4]." " . $arAdA[5] ." " . $arAdA[6] . "<br/>" ;
	}
	echo mysql_num_rows($AdARS);
*/
?>

