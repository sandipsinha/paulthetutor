<?

$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

setcookie("fid", $HTTP_POST_VARS[fid], time()- 3600 );

$fid = $REQUEST[fid];
echo "fid is now $fid";


$folder  = getfolder("","","");
$tid = $_SESSION['tutor_id'];
echo "session tutor is  $tid <BR><BR>";

$Q = "select * from PT_Tutors";
$R = runquery($Q);
printRS($R);

$Q = "select students, username, password, mother, father from PT_Family_Info order by students";
$R = runquery($Q);
printRS($R);


?>

