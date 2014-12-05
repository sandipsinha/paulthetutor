<?php
include("includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$date = new DateTime();

// get list of tutors
$query = "select distinct id, first_name, last_name, alert_preference from PT_Tutors";
if(!($res = mysql_query($query))){
  echo "<br>Query:  $query <BR>" . mysql_error() . "in ".__FILE__. " on line ".__LINE__."<br>\n";
}
$tuts=Array();
$tutno=mysql_num_rows($res);
$i = 0;
while($tut = mysql_fetch_array($res)) {
  $tuts[$i]['info'] = $tut;
  $tuts[$i]['alert'] = $tut['alert_preference'];
  $tuts[$i]['id'] = $tut['id'];
  $tuts[$i]['name'] = "$tut[first_name] ".strtoupper(substr($tut['last_name'],0,1));
  // get in/out hours
  $query = "SELECT * FROM PT_SchedSS_Norm WHERE tutor_id=".$tut['id'] ." AND start_date <= '".$date->format('Y-m-d')."' AND end_date >= '".$date->format('Y-m-d')."' ORDER BY start_date";
  if(!($schres = mysql_query($query)))
    echo "<br>Query:  $query <BR>" . mysql_error() . "in ".__FILE__. " on line ".__LINE__."<br>\n";
  while ($sched=mysql_fetch_assoc($schres)) {
    $tuts[$i]['sched'][$sched['dow']][]=$sched;
  }

  // get appointments
  $query = "(SELECT 'tut' AS type, a.id, a.date, a.start_time, a.hours, a.rate, a.pay, a.name, a.tid AS tutor_id, t.first_name AS t_first_name, t.last_name AS t_last_name  FROM PTAddedApp a LEFT JOIN PT_Tutors t ON a.tid = t.id WHERE a.date >= '".$date->format('Y-m-d')."' AND a.date <= '".$date->format('Y-m-d')."' AND a.tid = ".$tuts[$i]['id'].") UNION ALL (SELECT 'other' AS type, o.id, o.date, o.start_time, HOUR(SUBTIME(o.end_time, o.start_time))+(MINUTE(SUBTIME(o.end_time, o.start_time))/60) as hours, 0 as rate, 0 as pay, o.`name`, o.tutor_id, t.first_name as t_first_name , t.last_name as t_last_name  FROM PT_Other_Appt o LEFT JOIN PT_Tutors t ON o.tutor_id=t.id WHERE o.date >= '".$date->format('Y-m-d')."' AND o.date <= '".$date->format('Y-m-d')."' AND o.tutor_id = ".$tuts[$i]['id'].") ORDER by date, start_time ASC";
  if(!($aptres = mysql_query($query)))
    echo "<br>Query:  $query <BR>" . mysql_error() . "in ".__FILE__. " on line ".__LINE__."<br>\n";
  while ($apt=mysql_fetch_assoc($aptres)) {
    $tuts[$i]['days'][$apt['date']][]=$apt;
  }
  ++$i;
}

foreach($tuts AS $tut) {
  $msg = '';
  $send=false;
  for($i=new DateTime($date->format('Y-m-d')); $i<=$date; $i->modify('+1DAY')) {
    if(isset($tut['days'][$i->format('Y-m-d')])) {
      foreach($tut['days'][$i->format('Y-m-d')] AS $apt) {
        switch($apt['type']) {
          case "tut":
            $type="T-";
            break;
          case "other":
            $type="O-";
            break;
        }
        $send=true;
        $msg .= $type . $apt['name'].' @ '. date("g:i a", strtotime($apt['start_time'])). ' ('.(float) $apt['hours'].")\n";
      }
    }
  }
  if ($send) {
    echo $tut['name'].' via '.$tut['alert'].'<br>';
    echo "<pre>$msg</pre>";
    echo '<hr>';
  }
}
