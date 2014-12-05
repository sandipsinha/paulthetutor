<?php
	include("includes/gc_updater.php");
// gc_login('calendars@paulthetutors.com','paulthetutors')


	$googleAccount="calendars@paulthetutors.com";
	$password="paulthetutors";
echo "is 	$token=gc_login($googleAccount,$password)<BR>";
	$token=gc_login($googleAccount,$password);
	
	
	add_goog_cal($token, '2010-11-29', '15:00:00', 1.75, 'foo',$googleAccount,'paulo');
//	del_goog_cal($token, '2010-11-30', '15:00:00', 1.75, 'foo',$googleAccount,'paulo');
?>
