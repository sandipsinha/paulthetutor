<?
include("/home/paulth40/public_html/paulthetutors_com/includes/.check_login.php");
$strAbsPath="/home/paulthetutor/paulthetutors.com";
$strBack = "../includes"; 
require_once($strAbsPath . "/paulthetutors_com/includes/pttec_includes.phtml");
require_once($strAbsPath . "/paulthetutors_com/includes/PTTIncludes.phtml");
include($strAbsPath . "/paulthetutors_com/includes/clientcal.phtml");

MySQL_PaulTheTutor_Connect();

$month = $_REQUEST[month];
$year = $_REQUEST[year];
$type = $_REQUEST[type];
$day = $_REQUEST[day];
$famid=$_SESSION['fid'];
if(isset($_REQUEST['tutor_id']))
	$tid=$_REQUEST['tutor_id'];

if(isEmpty($month)){
	$str_month = date(F);
	$month = date(n);
}
else
{
	$str_month = date(F, mktime(0, 0, 0, $month, 11, 2000));
}	

if(isEmpty($year)){
	$year = date(Y);
}		

if(isEmpty($day)){
	$day = date(d) - date(w);
}	



if ($_GET['newdate']) {
	$y=date("Y",$_GET['newdate']);
	$m=date("m",$_GET['newdate']);
	$d=date("d",$_GET['newdate']);
	$fulldate = $y . '-' . $m . '-' . $d;
	echo $_GET['newdate'];
	echo $fulldate;
	//client_add($add_date, $start_time, $add_fid, $hours, $rate)
	$msg = client_add($fulldate, $_GET['newtime'], $_GET['newfid'],$rate, 1,$_GET['newtid']);
} elseif ($_GET['deldate']) {
	$y=date("Y",$_GET['deldate']);
	$m=date("m",$_GET['deldate']);
	$d=date("d",$_GET['deldate']);
	$fulldate = $y . '-' . $m . '-' . $d;
	$msg = client_del($fulldate, $_GET['deltime'], $_GET['delfid'], $_GET['deltid']);
}

put_ptts_header("Calendar for $str_month $year", $strAbsPath,"", "");
$main_name = getMainName($famid);

?>
<span class="Head1_Green">Hello <?echo $main_name;?></span><span> (<?echo "Not $main_name?";?> <a href='login_parents.php?logout=1'>Logout</a>)<br/><br/></span>
<?
$page_name = phptohtm();

include("$page_name");

put_ptts_footer("");
?>