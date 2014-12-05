<?php
die("This page needs to be updated to use the new Google Calendar backend");
$x_conf_timezone = "-07:00";
function add_goog_cal($token, $date, $start_time, $duration, $title, $email=null, $cal_name=null){
	global $x_conf_timezone;
//	 echo "t:".$token."<br>";
//	 echo "d:".$date."<br>";   
//	 echo "t:".$start_time."<br>";   
//	 echo "dur:".$duration."<br>";
//	 echo "tit:".$title."<br>";   
//	 echo "cal:".$cal_name."<br>";
	 if ($token == '')
	 	$token = $GLOBALS['x_conf_cal_token'];
	 	
	$arr_duration= explode(".",$duration);
	if (strlen($arr_duration[1]) == 1)
		$arr_duration[1].="0";
	$sec = $arr_duration[0]*3600+$arr_duration[1]*60;	
	$end_time = date("H:i:s",strtotime($start_time)+$sec);
	$request='<atom:entry xmlns:atom="http://www.w3.org/2005/Atom">
          <atom:title type="text">'.$title.'</atom:title>
	  <gd:when xmlns:gd="http://schemas.google.com/g/2005" 
	    startTime="'.$date.'T'.$start_time.".000".$x_conf_timezone.'" 
	    endTime="'.$date.'T'.$end_time.".000".$x_conf_timezone.'"/>
	</atom:entry>';
	if($cal_name){
		$calendarsList=getCalendarsList($token);
		$calendar=$calendarsList[$cal_name];
		if(!$calendar){
			echo "No calendar with title ".$cal_name." found.";
			return false;
		}
	}else{
		$calendar="default";
		$cal_name="default";
	}
		
	$ch = curl_init("https://www.google.com/calendar/feeds/".$calendar."/private/full");
	curl_setopt($ch, CURLOPT_POST,1);
 	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/atom+xml",
          "Content-Length: ".strlen($request),
          "authorization: GoogleLogin auth=".$token
        ));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$HTTPResponse=curl_exec($ch);
	$info = curl_getinfo($ch);
	if(!$HTTPResponse){
		echo "Adding new event unsuccesful: ".$cal_name.": ".$date." ".$start_time." ".$duration." ".$title;
		curl_close($ch);
		return false;
	}
	//else
	//echo "Aici: ".$HTTPResponse." ".$info['http_code']."<br>";
	$i = 1;	
	while($info['http_code']==302){
		$HTTPResponse=secondRequest($HTTPResponse, $info, $ch);
		$info = curl_getinfo($ch);
		if(!$HTTPResponse){
			echo  "Adding new event unsuccesful.";
			curl_close($ch);
			return false;
		}else
			$info = curl_getinfo($ch);
		$i++;
		if($i == 10)
			break;
	}
	
	curl_close($ch);
	if($info['http_code']==201){
		if($email)
			// ptts_mail($email,"Message from Calendar Script","New event beetwen ".$start_time." and ".$end_time." with title ".$title." was created in ".$cal_name." calendar.");
		return true;
	}
	else
		return false;
}

function del_goog_cal($token, $date, $start_time, $duration, $title, $email=null, $cal_name=null){
	global $x_conf_timezone;
        /* // test stuff
	 echo "t:".$token."<br>";
	 echo "d:".$date."<br>";   
	 echo "t:".$start_time."<br>";   
	 echo "dur:".$duration."<br>";
	 echo "tit:".$title."<br>";   
	 echo "cal:".$cal_name."<br>";
         //*/
	if($cal_name){
		$calendarsList=getCalendarsList($token);
		$calendar=$calendarsList[$cal_name];
	}else
		$calendar="default";
	 if ($token == '')
	 	$token = $GLOBALS['x_conf_cal_token'];
	$events=queryEvents($token, $date, $start_time, $duration, $title, $calendar,$x_conf_timezone);
	if(!$events){
		echo "No events found in Google calendar.";
		return false;
	}
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"DELETE");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("If-Match: *","Authorization: GoogleLogin auth=".$token));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	foreach($events as $event){
		curl_setopt($ch, CURLOPT_URL, $event);
		$HTTPResponse=curl_exec($ch);
		if(!$HTTPResponse){
			echo "Problem during event deleting.".$HTTPResponse."<br>";
			return false;
		}
		$info = curl_getinfo($ch);
		$i = 1;
		while($info['http_code']==302){
			$HTTPResponse=secondRequest($HTTPResponse, $info, $ch);
			if(!$HTTPResponse){
				echo "Problem during event deleting 2.".$HTTPResponse."<br>";
				return false;
				}
				else
					$info = curl_getinfo($ch);
				if($i == 10)
					break;
				}
		}
	if($email)
		@mail($email,"Message from Calendar Script","Event beetwen ".$start_time." and ".$end_time." with title ".$title." was removed from ".$cal_name." calendar.");
	curl_close($ch);
}


function gc_login(){
	$username = "calendars@paulthetutors.com";
	$password = "paulthetutors";
	if($username && $password){
		$queryAPI="Email=".urlencode($username)."&Passwd=".urlencode($password)."&source=paulthetutor-meetings-1&service=cl";
		$ch = curl_init("https://www.google.com/accounts/ClientLogin");
		curl_setopt($ch, CURLOPT_POST,1);
 		curl_setopt($ch, CURLOPT_POSTFIELDS, $queryAPI);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content: application/x-www-form-urlencoded"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$HTTPResponse=curl_exec($ch);
		curl_close($ch);
		if($HTTPResponse){
			$start=strpos($HTTPResponse,"Auth=")+5;
			return trim(substr($HTTPResponse,$start));
		}
	}
	return false;
}

function getCalendarsList($token){
	 	if ($token == '')
	 		$token = $GLOBALS['x_conf_cal_token'];
		$ch = curl_init("https://www.google.com/calendar/feeds/default/owncalendars/full?alt=json");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: GoogleLogin auth=".$token));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$HTTPResponse=curl_exec($ch);
		if(!$HTTPResponse){
			echo "Problem during fetching calendar list.";
			return false;
		}
		$info = curl_getinfo($ch);
		if($info['http_code']==302){
			$HTTPResponse=secondRequest($HTTPResponse, $info, $ch);
			$info = curl_getinfo($ch);
			if(!$HTTPResponse){
				echo "Problem during fetching calendar list.";
				return false;
			}
		}
		curl_close($ch);
		$body = str_replace("$","_",substr($HTTPResponse, $info['header_size'])); //$ in names gives a lot of problems
		$response=json_decode($body);
		$response=$response->feed->entry;
		if(!$response)
			return false;
		foreach ($response as $calendar)
			$result[$calendar->title->_t]=substr($calendar->id->_t,strrpos($calendar->id->_t,"/")+1);
		return $result;
}

function queryEvents($token, $date, $start_time, $duration, $title, $calendar,$timezone){
	global $x_conf_timezone;
	if ($token == '')
	 		$token = $GLOBALS['x_conf_cal_token'];
	 		
	$arr_duration= explode(".",$duration);
	if (strlen($arr_duration[1]) == 1)
		$arr_duration[1].="0";
	$sec = $arr_duration[0]*3600+$arr_duration[1]*60;
	 		
	$start=strtotime($date."T".$start_time.$x_conf_timezone);
	$end=$start+$sec;
	$start=gmdate("Y-m-d\TH:i:s",$start);
	$end=gmdate("Y-m-d\TH:i:s",$end);
	
	$url="https://www.google.com/calendar/feeds/".$calendar."/private/full?start-min=".$start."&alt=json";
	if($start!=$end)
		$url.="&start-max=".$end;
	$ch=curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: GoogleLogin auth=".$token));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$HTTPResponse=curl_exec($ch);
	if(!$HTTPResponse){
		echo "1E:".$start." ".$end."<br>";
		return false;
		curl_close($ch);
	}
	$info = curl_getinfo($ch);
	if($info['http_code']==302){
		$HTTPResponse=secondRequest($HTTPResponse, $info, $ch);
		$info = curl_getinfo($ch);
		if(!$HTTPResponse){
			echo "2E:".$start." ".$end."<br>";
			echo "No events found.";
			curl_close($ch);
			return false;
		}
	}
	//echo $HTTPResponse." ".$info['header_size']."<br>";
	curl_close($ch);
	$header = substr($HTTPResponse, 0, $info['header_size']);
	$body = str_replace("$","_",substr($HTTPResponse, $info['header_size'])); //$ in names gives a lot of problems
	$response=json_decode($body);
	$response=$response->feed->entry;
	if(!$response){
		echo "No response.<br>";
		return false;
	}
	foreach ($response as $event)
		if(strtotime($event->gd_when[0]->startTime)==strtotime($start."Z") 
			&& strtotime($event->gd_when[0]->endTime)==strtotime($end."Z")
			&& strtolower($event->title->_t)==strtolower($title))
				foreach($event->link as $link)
					if($link->rel=="edit")
						$result[]=$link->href;
	return $result;
}

function secondRequest($HTTPResponse,$info,$ch){
	$header = substr($HTTPResponse, 0, $info['header_size']);
	$rows=split("\r\n",$header);
	foreach($rows as $row){
		$divider=strpos($row,": ");
		$data[substr($row,0,$divider)]=trim(substr($row,$divider+2));
	}
	curl_setopt($ch, CURLOPT_URL, $data['Location']);
	$HTTPResponse=curl_exec($ch);
	if(!$HTTPResponse){
		curl_close($ch);
		return false;
	}
	return $HTTPResponse;
}
?>
