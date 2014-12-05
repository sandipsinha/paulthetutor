<?php
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

//MySQL_PaulTheTutor_Connect();

//var_dump($_POST);

mail("paul@paulthetutors.com","test mail","test body");
mail("courtneyandpaul2313@gmail.com", "test gamil","gmail body");

echo "should send email";


?>
