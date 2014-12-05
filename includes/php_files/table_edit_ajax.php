<?php
include($strAbsPath . "../pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$sql = 'The id is ' + $_POST['id'] + $_POST['tablename'];
if($_POST['id'])
{
$id=mysql_escape_String($_POST['id']);
$tablename=mysql_escape_String($_POST['tablename']);
$fieldname=mysql_escape_String($_POST['fieldname']);
$fieldvalue=mysql_escape_String($_POST['fieldvalue']);

$sql = "update ". $tablename ." set " . $fieldname . "="."'".$fieldvalue."'"." where id=".$id;
runquery($sql);
}
echo  $fieldvalue;
?>