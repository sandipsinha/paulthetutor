<?php
ob_start();
include("../includes/maven_pttec_includes.phtml");
// printarray($_REQUEST);
MySQL_PaulTheTutor_Connect();
// echo "$folder is the folder <BR>";
if($_GET['id']!="")
{
$arTutor_Info = tutor_info($_GET['id']);

echo $arTutor_Info['first_name']." ".$arTutor_Info['last_name'];
}
if($_GET['s_id']!="")
{
$student_info=get_student_info($_GET['s_id']);

echo $html= $student_info['first_name']."*";
echo $html1=$student_info['last_name'];
}
?>
