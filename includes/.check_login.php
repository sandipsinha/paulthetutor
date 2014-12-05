<?php
  session_start();
  $x_login_key = "paul_key123_xx{_";

  if ( isset($_SESSION['fid']) && $_SESSION['fid']!='' && $_SESSION['token'] == md5($x_login_key.$_SESSION['fid'])){
	  $famid = $_SESSION['fid'];
  }elseif(isset($_COOKIE['fid']) && $_COOKIE['fid']!='' && $_COOKIE['token'] == md5($x_login_key.$_COOKIE['fid'])){
	  $_SESSION['fid'] = $_COOKIE['fid'];
	  $famid = $_SESSION['fid'];
  }
  else{
  	  	if (!$x_from_login_page)
	  	header("Location: login_parents.php?referer=".$_SERVER['REQUEST_URI']);
  }
  
  if (isset($famid) && isset($x_from_login_page) && $x_from_login_page && !$_REQUEST['logout']){
	  	header("Location: index_parents.php");
  }
  
?>
