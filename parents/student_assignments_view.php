<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/.check_login.php");

include("../admin/student_assignments_view.php");
?>
