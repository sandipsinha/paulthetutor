<?php
session_name("paulthetutor");
session_start();
if(isset($_REQUEST['logout'])&&$_REQUEST['logout']=="1")
{
	session_destroy();
	setcookie("fid", "", time()+60*60*24*365);
	echo "Logged Out!";
}
else
{
	if(isset($_SESSION["fid"])&&$_SESSION["fid"]!="")
		$fid=$_SESSION["fid"];
	else if(isset($_COOKIE["fid"])&&$_COOKIE["fid"]!="")
	{
		$_SESSION["fid"]=$_COOKIE["fid"];
		$fid=$_SESSION["fid"];
	}
	else
	{
		$filename=$_SERVER["REQUEST_URI"];
		$filename=str_replace("/","---",$filename);
		header("Location: tutlogin.php?next=$filename");
	}
}	
?>