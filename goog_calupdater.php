<?php
	include("includes/goog_calendar.php");

	$googleAccount="calendars@paulthetutors.com";
	$password="paulthetutors";
	$token=login($googleAccount,$password);
	
	
	add_goog_cal($token, '2010-11-30', '10:00pm', '11:00pm', 'foo',$googleAccount,'paulo');
//	add_goog_cal($token, '2010-11-30', '16:00', '17:00', 'bar',$googleAccount,'paulo');
//	add_goog_cal($token, '2010-11-30', '17:00', '18:00', 'boo',$googleAccount,'paulo');
//	del_goog_cal($token, '2010-11-30', '16:00', '17:00', 'bar',$googleAccount,'paulo');


echo "should have updated calendar";
?>
