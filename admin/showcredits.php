<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

$strTableName = $_REQUEST[strTableName];
put_ptts_header("Get Informaiton for $strTableName", $strAbsPath, "admin", "");

$Qstr = "select * from PT_Credits order by date asc";
$RS = runquery($Qstr);
printRS($RS);

?>

