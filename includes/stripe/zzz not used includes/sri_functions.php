<?php
//include("pttec_includes.phtml");
// GOOGLE CALENDAR FUNCTION START

$x_conf_timezone = "-07:00";
function sri_add_goog_cal($token, $date, $start_time, $duration, $title, $email=null, $cal_name=null){
  global $x_conf_timezone;
  echo "t:".$token."<br>";
  echo "d:".$date."<br>";
  echo "t:".$start_time."<br>";
  echo "dur:".$duration."<br>";
  echo "tit:".$title."<br>";
  echo "cal:".$cal_name."<br>";
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

  // $create_calendar_request = "<entry xmlns='http://www.w3.org/2005/Atom' xmlns:gd='http://schemas.google.com/g/2005' //just addedxmlns:gCal='http://schemas.google.com/gCal/2005'>
  //           <title type='text'>'. $cal_name .'</title>
  //           <gCal:timezone value='America/Los_Angeles'></gCal:timezone>
  //           <gCal:color value='#2952A3'></gCal:color>
  //           </entry>";

   // $cal_ch = curl_init("https://www.google.com/calendar/feeds/default/owncalendars/full"); //just added
   //      curl_setopt($ch, CURLOPT_POST,1);
   //      curl_setopt($ch, CURLOPT_POSTFIELDS, $create_calendar_request);
   //      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   //              "Content-Type: application/atom+xml",
   //              "Content-Length: ".strlen($create_calendar_request),
   //              "authorization: GoogleLogin auth=".$token
   //            ));
   //      curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
   //      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   //      curl_setopt($ch, CURLOPT_HEADER, 1);

  if($cal_name){
    $calendarsList=sri_getCalendarsList($token);
    $calendar=$calendarsList[$cal_name];
    if(!$calendar){
      //$HTTPResponse_cal=curl_exec($cal_ch); // just added
      //$info_cal = curl_getinfo($cal_ch); // just added
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
    $HTTPResponse=sri_secondRequest($HTTPResponse, $info, $ch);
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

// COMMENTED OUT - 8/12/14
// function del_goog_cal($token, $date, $start_time, $duration, $title, $email=null, $cal_name=null){
//   global $x_conf_timezone;
//         /* // test stuff
//    echo "t:".$token."<br>";
//    echo "d:".$date."<br>";
//    echo "t:".$start_time."<br>";
//    echo "dur:".$duration."<br>";
//    echo "tit:".$title."<br>";
//    echo "cal:".$cal_name."<br>";
//          //*/
//   if($cal_name){
//     $calendarsList=getCalendarsList($token);
//     $calendar=$calendarsList[$cal_name];
//   }else
//     $calendar="default";
//    if ($token == '')
//     $token = $GLOBALS['x_conf_cal_token'];
//   $events=queryEvents($token, $date, $start_time, $duration, $title, $calendar,$x_conf_timezone);
//   if(!$events){
//     echo "No events found in Google calendar.";
//     return false;
//   }
//   $ch = curl_init();
//   curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"DELETE");
//   curl_setopt($ch, CURLOPT_HTTPHEADER, array("If-Match: *","Authorization: GoogleLogin auth=".$token));
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
//   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//   curl_setopt($ch, CURLOPT_HEADER, 1);
//   foreach($events as $event){
//     curl_setopt($ch, CURLOPT_URL, $event);
//     $HTTPResponse=curl_exec($ch);
//     if(!$HTTPResponse){
//       echo "Problem during event deleting.".$HTTPResponse."<br>";
//       return false;
//     }
//     $info = curl_getinfo($ch);
//     $i = 1;
//     while($info['http_code']==302){
//       $HTTPResponse=secondRequest($HTTPResponse, $info, $ch);
//       if(!$HTTPResponse){
//         echo "Problem during event deleting 2.".$HTTPResponse."<br>";
//         return false;
//         }
//         else
//           $info = curl_getinfo($ch);
//         if($i == 10)
//           break;
//         }
//     }
//   if($email)
//     @mail($email,"Message from Calendar Script","Event beetwen ".$start_time." and ".$end_time." with title ".$title." was removed from ".$cal_name." calendar.");
//   curl_close($ch);
// }


function sri_gc_login(){
  //$username = "calendars@paulthetutors.com";
  //$password = "paulthetutors";
  $username = 'ptts.docs@gmail.com';
  $password = 'paul_the_tutor';
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

function sri_getCalendarsList($token){
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
      $HTTPResponse=sri_secondRequest($HTTPResponse, $info, $ch);
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

function sri_queryEvents($token, $date, $start_time, $duration, $title, $calendar,$timezone){
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
    $HTTPResponse=sri_secondRequest($HTTPResponse, $info, $ch);
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

function sri_secondRequest($HTTPResponse,$info,$ch){
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

// GOOGLE CALENDAR FUNCTION END


//ADD TUTORING SESSION
function sri_session_add($add_date, $location_id, $student_id, $tutor_id, $start_time, $hours, $rate_id=NULL , $sched_id=-1,$comments='',$name='',$rate=NULL, $pay=NULL, $opts=null) {

// echo "opts is <BR>";
// printarray($opts);


  $family_id = get_student_fid($student_id);
  $name = get_student_name($student_id);

  if(($opts[set_money] <> 1) or ((isEmpty($pay)) or (isEmpty($rate)))){
    $RPar = calc_sess_rate($hours, $location_id,"",$student_id,$tutor_id);

// echo "$RPar = calc_se_rate($hours, $location_id,'',$student_id,$tutor_id);";
// printarray($RPar);

  }


// printarray($RPar);

  if(isEmpty($pay) or ($opts[set_money] <> 1))
    $pay = $RPar[pay];
  if(isEmpty($rate) or ($opts[set_money] <> 1))
    $rate = $RPar[rate];

  $rate_id = $RPar[rate_id];

  $tid = $tutor_id;


  //    session_add($add_date,$start_time,'',$hours,$rate,$pay,$tutor_id,$student_name, $sched_id, $comments, $opts, $student_id,$location_id);
  //function session_add($add_date, $start_time, $family_id, $hours, $rate, $pay, $tid, $name='', $sched_id='',$comments = '', $opts=NULL, $student_id='', $location_id=0) {

    //
    // TEMPORARILY BLOCKED INSERTION INTO DATABASE
    //
    // $AQStr = "INSERT INTO PTAddedApp (sid,family_id, student_id, date, hours, rate, start_time, pay, tid, name, sched_id,comments,location_id,rate_id) VALUES ('$family_id','$family_id','$student_id', '$add_date', '$hours', '$rate', '$start_time', '$pay', $tid, '".addslashes($name)."', '$sched_id','$comments',$location_id,'$rate_id')";

    // $temp_ses_id = runquery($AQStr);

    // echo "insert session qs is $AQStr <BR>";
// runquery returns the insertion id if it inserts a value
//   $temp_ses_id =  mysql_insert_id($ARS);

    //
    // TEMPORARILY BLOCKED INSERTION INTO DATABASE
    //
    // $AQStr2 = "INSERT INTO ZZ_PTAddedApp_All (sess_id,sid,family_id, student_id, date, hours, rate, start_time, pay, tid, name, sched_id,comments,location_id,rate_id) VALUES ($temp_ses_id,'$family_id','$family_id','$student_id', '$add_date', '$hours', '$rate', '$start_time', '$pay', $tid, '".addslashes($name)."', '$sched_id','$comments',$location_id,'$rate_id')";
    // $ARS2 = runquery($AQStr2);



// echo "insert quesry is $AQStr <BR><BR>";

  // put the google calendar functions
    //$tar = get_tut_info($tid);
    $tar = tutor_info($tid);
    //var_dump($tar);
    $start_time = explode(":", $start_time);
    $start_time = $start_time[0] . ":" . $start_time[1];
  // get the tutors information
    set_time_limit(0);
    $gc_name = $tar['gc_name']; //name of the calendar
    $tut_email = $tar['email'];
    $tut_name = $tar['first_name'];
    if (!$GLOBALS['x_conf_cal_token'])
    $gc_token=sri_gc_login(); // get's login info
  // get family name
    $fam_name = get_fam_name($family_id);
  // add the informatoin to the google calendar
  // #echo "<br><br>".__FILE__.":".__LINE__."sri_add_goog_cal($gc_token, '$add_date', '$start_time', $hours, $fam_name,null,$gc_name)<BR><BR>";
     sri_add_goog_cal($gc_token, $add_date, $start_time.":00", $hours, $fam_name,null,$gc_name);
     //var_dump($cal_response);
     set_time_limit(10);

  //send an email
    $snames = getstudentsname($family_id);
    $msgtopaul = "$fam_name added an appointment on $add_date at $start_time for $hours hours of tutoring with $tut_name";
  $adminmsg = "Add $snames w/ $tut_name ".date("d/n", strtotime($add_date))."@$start_time ($hours) $rate/$pay";
  if(!(isset($opts['email_paul']) && !$opts['email_paul'])) // default to sending email
    mail_alert('paul@paulthetutors.com', $adminmsg , $adminmsg, 'add');
//  if(!(isset($opts['email_tut']) && !$opts['email_tut'])) // default to sending email
//    mail_alert($tut_email, $msgtopaul, $msgtopaul, 'add');

return $temp_ses_id;

}


//ADD NON TUTORING SESSION
function sri_non_tut_session_add($add_date, $start_time, $end_time, $tutor_id, $name, $email, $phone, $comments, $sched_id = '', $paid = 0, $rate = 0, $opts = null) {
  if (!isset($tid) || isEmpty($tid)) {
    $tid = 1;
  }

  // fix formatting

  $start_time.= ':00';
  $end_time.= ':00';

  // // //  $AQStr = "INSERT INTO PT_Other_Appt SET name=\"".$name."\",  date=\"".$add_date."\", start_time=\"".$start_time."\", end_time=\"".$end_time."\", tutor_id=\"".$tutor_id."// // //\", sched_id=\"".$sched_id."\", email=\"".$email."\", phone=\"".$phone."\", comments=\"".$comments."\", paid=\"".$paid."\", rate=\"".$rate."\"";
  // // //
  // // //// echo "This is the query $AQStr <br /><br />";
  // // //
  // // //  $ARS = runquery($AQStr);
  // // //  $rid = mysql_insert_id();
  // echo "start time is $start_time and end time is $end_time<br />";

  $startar = explode(":", $start_time);
  $endar = explode(":", $end_time);

  // printarray($startar);
  // printarray($sendar);
  // if it is a paid job, add the hours to ppppp <-- temp comment out for testing sri_goog_add
  //  if ($paid == 1) {
  //     $hours = (( ( $endar[0] - $startar[0] ) * 60 ) + ($endar[1] - $startar[1]))/60; // time worked in hours
  // //echo "hours is $hours<br />";
  //     $hoursid = non_tut_hours('add',array(
  //             'tutor_id'=>$tutor_id,
  //             'date'=>$add_date,
  //             'hours'=>$hours,
  //             'rate'=>$rate,
  //             'name'=>'Non-Tut Work: '.$name,
  //             'comments'=>$comments,
  //             'other_appt_id'=>$rid,
  //           ), '', 'id', '', '');
  //         // // // mysql_query('UPDATE PT_Other_Appt SET work_hours_id = '.$hoursid.' WHERE id='.$apptid);
  //         // // // mysql_query($query);
  // }
  // put the google calendar functions

  $tar = tutor_info($tutor_id);

  // get the tutors information

  $gc_name = $tar['gc_name']; //name of the calendar
  $tut_name = $tar['first_name'];
  set_time_limit(0);
  if (!isset($GLOBALS['x_conf_cal_token'])) {
    $gc_token = gc_login(); // get's login info
  }

  $hours = time_diff($end_time, $start_time);
  $gc_username = null; // Why is this used below but never set?
  sri_add_goog_cal($gc_token, $add_date, $start_time, $hours, $name, $gc_username, $gc_name);
  set_time_limit(60);
  $msg = "Appointment: $name\nDate: $add_date\nStart Time: $start_time\nHours: $hours\n";

  if (!(isset($opts['email_tut']) && !$opts['email_tut'])) { // default to sending
    mail_alert($tar['email'], "Appointment added: " . $name, $msg, 'nth');
  }
    // if (!(isset($opts['email_paul']) && !$opts['email_paul'])) {// default to sending
    //  mail_alert('paul@paulthetutors.com', "NTH Add ".$name ." w/ $tut_name on $add_date at $start_time ($hours)",'' , 'nth');
    // }
    // return "Added an event on $add_date at $start_time";

    return $rid;
}

/*-------------------------------------------------------------------*/
/*      get_loc_rate - gets the session rate and pay for a session   */
/*      takes                                                        */
/*      $process determines whether or not to delete
                sessions if packages were purchases                  */
/*      returns array[rate],array[pay] and array[hours_remaining]    */
/*-------------------------------------------------------------------*/
// ///determines the rate and pay for a session based on family,tutor, location. //added now
function calc_sess_rate_test($hrs, $location_id=NULL, $family_id="", $student_id="", $tutor_id=NULL, $process=1, $ses_id=NULL, $other="") {
// set all return values to NULL
    echo "in cacl sess rate test!"; //added now

    $ses[rate] = NULL;
    $ses[pay] = NULL;
    $ses[error] = NULL;
    $ses[unbilled_hours] = 0;
    $ses[hours_purchased] = 0;
    $ses[rate_id] = NULL;

    $calc_rate = 0;

// if $session id is provided, get all of the other id values from there
if(!isEmpty($ses_id)){

    $sesQS = "select * from PTAddedApp where id = $ses_id";
    $sesAR = rowquery($sesQS);
    $ses[old_rate] = $sesAR[rate];
    $ses[old_pay] = $sesAR[pay];
    $family_id = $sesAR[family_id];
    $student_id = $sesAR[student_id];
    $location_id = $sesAR[location_id];
    if($location_id == 0)
        $location_id = 1;
    $tutor_id = $sesAR[tid];

// printarray($sesAR);

}
// throw an error if the student_id and family_id are both NULL
    if(isEmpty($student_id) and isEmpty($family_id)){
        $ses[error] = "No Family or Student was provided";
        return($ses);
    }
    if(isEmpty($location_id)){
        $ses[error] = "No location was provided";
        return($ses);
    }
// get the family_id if the student_id is sent.
    If(isEmpty($family_id)){
        $family_id = get_student_fid($student_id);
    }


//determine if the family is in autopay
    $autopay = inautopay($family_id);


$num_rows = 0;
// if the family has a special rate for the tutor and location, use that rate and pay. Don't do this if they just have a general rate, the tutor id has to match
    $where = " ";
    $QStr = "Select id, rate, pay, hours_purchased, hours_remaining from PT_Rates_Fam where family_id = $family_id and tutor_id = $tutor_id and location_id = $location_id and archived = 0 order by id DESC";
    $RS = runquery($QStr);
// echo "tutor quesry string is $QStr ";

    $num_rows = mysql_num_rows($RS);

    if($num_rows >= 1 and $calc_rate == 0) {    // if there is a rate for this family and this tutor
        $rateAR = mysql_fetch_assoc($RS);


        $ses[rate] = $rateAR[rate];
        $ses[pay] = $rateAR[pay];
        $ses[rate_id] = $rateAR[id];

        $calc_rate = 1;

        return $ses;

    }

// If the tutor has a special rate for this location, use that rate
    $where = " where tutor_id = $tutor_id and location_id = $location_id and archived = 0";
    $QStr = "Select id, rate, pay from PT_Rates_Tut $where and archived = 0 order by id DESC limit 1";
    $RS = runquery($QStr);

// echo "the tut location qs is $QStr <BR>";

    $num_rows = mysql_num_rows($RS);
    if($num_rows >= 1 and $calc_rate == 0) {

// echo "found loc tut rate <BR>";

        $rateAR = mysql_fetch_assoc($RS);

        // if the family is in autopay, deduct $10/hr
        if($autopay > 0){
            $rateAR[rate] = $rateAR[rate] - 10.00;
            $rateAR[rate] = number_format($rateAR[rate],2);
        }

        $rateAR[old_rate] = $ses[old_rate];
        $rateAR[old_pay] = $ses[old_pay];
        $calc_rate = 1;
        return $rateAR;

    }

// get any special rates based on a family
    $where = " where family_id = $family_id and location_id = $location_id ";// NEED TO ADD END DATE
    $QStr = "Select id, rate, pay , hours_purchased, hours_remaining from PT_Rates_Fam $where and archived = 0 order by id DESC";

// echo "qst is $QStr <BR>";

    $RS = runquery($QStr);
    $num_rows = mysql_num_rows($RS);
    if($num_rows >= 1 and $calc_rate == 0) {    // if there is a rate for this family and this tutor
        $ses = mysql_fetch_assoc($RS);

        $calc_rate = 1;
        return $ses;
    }

// if no special rates exist, get the standard rate
    if(is_null($ses[rate]) and $calc_rate == 0){
         $calc_rate = 1;
         if($location_id == 0)
             $location_id = 1;

         $ses[rate] = singlequery("select rate from PT_Rates_Loc where location_id = $location_id");

//If they are in autopay, subtract $10
        if($autopay > 0){
            $ses[rate] = $ses[rate] - 10;
            $ses[rate] = number_format($ses[rate],2);
        }

    }

    if(is_null($ses[pay])) $ses[pay] = singlequery("select pay from PT_Rates_Loc where location_id = $location_id");

    return $ses;

}  // end session


function rerate_test_sessions($family_id = NULL, $start_date, $end_date = NULL, $student_id = 1, $month = NULL, $rerate = 0){
    echo ' Start date is ' . $start_date;
    echo ' End date is ' . $end_date;
    if(!isEmpty($start_date)) {
    if(substr($start_date, 2, 1) == '-'){
        $start_date = format_date_db($start_date);
    }

    $uqs = " select id from PTAddedApp where family_id = $family_id and date >= '$start_date' ";

    if(!isEmpty($_REQUEST[end_date])){
    if(substr($end_date, 2, 1) == '-'){
    $end_date = format_date_db($end_date);
    }
    $uqs .= " and date <= '$end_date' ";
    }
    } elseif(!isEmpty($month)){
    $uqs = "select id from PTAddedApp where family_id = $family_id and month(date) = $month ";
    }



    if(!isEmpty($_REQUEST[student_id]) and $_REQUEST[student_id] <> 0 )
    $uqs .= " and student_id = $_REQUEST[student_id] ";

    $ids_rs = runquery($uqs);
    //echo $uqs;
    //echo "the qs is $uqs <BR>";
    //printRS($ids_rs);


    while($ar_ids = mysql_fetch_array($ids_rs)){
        //echo "HERE";
        //var_dump($ar_ids); //added now
        // echo "re rating $ar_ids[id] <BR>";
        $ar_ids[rate] = calc_sess_rate_test('','','','','','',$ar_ids[id]); //modified now
        //printarray($ar_ids);
        $rateAR = $ar_ids[rate];

        // printarray($rateAR);
        $rate = $rateAR[rate];
        $old_rate = $rateAR[old_rate];

        $pay = $rateAR[pay];
        $old_pay = $rateAR[old_pay];

        // printarray($rateAR);

         echo "$rate is $old_rate not equal  or $pay <> $old_pay for $ar_ids[id]<BR>";
        //echo 'r ' . $rate;
        //echo 'o_r ' . $old_rate;
        //echo 'p ' . $pay;
        //echo 'o_p ' . $old_pay;

    if($rate <> $old_rate or $pay <> $old_pay){
    //          echo "update PTAddedApp set rate = $rate and pay = $pay where id = $ar_ids[id]<BR>";
        //$rqs = "update rerate_test set rate = $rate, pay = $pay where id = $ar_ids[id]";

        $rqs = "insert into rerate_test
                    (id, rate, pay)
                VALUES
                    ($ar_ids[id], $rate, $pay)";

        runquery($rqs);
        echo "RQS is " . $rqs;
    }

    }
}
