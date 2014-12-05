<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

$FQStr = "select main_name, students from PT_Family_Info where id = 204";
$FRS = runquery($FQStr);
$far = mysql_fetch_array($FRS);
$fn_str = "$far[main_name] ($far[students])";

echo "fam name is $fn_str";


?>

