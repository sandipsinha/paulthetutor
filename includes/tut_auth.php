<?php 
session_start();

if(isset($_COOKIE["paulthetutorlogin"]))
{
	$_SESSION['tutor_id'] = $_COOKIE["paulthetutorlogin"];
	$tutor_id= $_SESSION['tutor_id'];
}

if(!isset($_SESSION['tutor_id']))
	header("Location: /tutors/tutlogin.php?next=".curPageURL());
	
	
	
	
	
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

?>
