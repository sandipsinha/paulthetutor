<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Resync Google Calendars", $strAbsPath, "admin", "");

function connectToGoogleCal() {
  $service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
  $user = "ptts.docs@gmail.com";
  $pass = "paul_the_tutor";

  // Create an authenticated HTTP client
  $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);

  // Create an instance of the Calendar service
  $service = new Zend_Gdata_Calendar($client);
  var_dump($service);
}

connectToGoogleCal();

echo "<h3>Resync Google Calendars</h3><br><br>";

if (!isset($_POST['cals'])) {
  echo "<h4>Check all calendars you want synced</h4>";

  echo '<form method="post">';
  // first, get the list of tutors
  $q = "SELECT id, nickname, gc_name FROM PT_Tutors WHERE gc_name IS NOT NULL";
  $r = mysql_query($q);
  while ($r && $row = mysql_fetch_assoc($r)) {
    echo '<input type="checkbox" name="cals[]" value="'.$row['id'].'"> '.$row['nickname'].'<br>';
  }
  echo '<br>clear Google Calendars first? <input type="checkbox" name="clear" value="1"><br>';
  echo '<br><input type="submit" name="submit">';
  echo '</form>';
} else { // submission; do the sync
  $date = new DateTime(date("Y-m-d",strtotime("-1 month")));
  $tuts=Array();
  for($i=0; $i<count($_POST['cals']); $i++)
    $tuts[$i] = array('id'=>$_POST['cals'][$i]);
  $tutno=count($tuts);
  for($i=0; $i<$tutno;$i++) {
    // get appointments
    $tuts[$i]['days'] = get_tutor_appointments($tuts[$i]['id'], date("Y-m-d",strtotime("-1 month")), date("Y-m-d",strtotime("+2 year")));
  }

  $gcal= new Gcal();
  //var_dump($gcal);
  foreach($tuts AS $tut) {
    $opts = (isset($_POST['clear']) && $_POST['clear']) ? array('start'=>date("Y-m-d",strtotime("-1 month")),'end'=>date("Y-m-d",strtotime("+2 year"))): null;
    $gcal->getCal(get_tutor_name($tut['id'],array('cal'=>true)),$opts);
    if (isset($_POST['clear']) && $_POST['clear']) {
      echo "<h4>Clearing ". get_tutor_name($tut['id']) ."'s calendar of old entries</h4>\n";
      foreach ($gcal->events as $event)
        $event->delete();
    } // if clear
    echo "<h4>Syncing ". get_tutor_name($tut['id']) ."'s calendars</h4>";
    $msg = '';
    $send=false;
    foreach($tut['days'] AS $day) {
      foreach($day AS $apt) {
        switch($apt['type']) {
          case "tut":
            $type="Tutoring: ";
            break;
          case "other":
            $type="Other: ";
            break;
        }
        $send=true;
        $msg .= $apt['type'] . " " . $apt['name'].' @ ';
        $msg .= date("g:i a", strtotime($apt['start_time'])). ' ('.(float) $apt['hours'].")\n";
        $gcal->addEvent(
          strtotime($apt['date'] . " " . $apt['start_time'].date('P')),
          strtotime($apt['date'] . " ". $apt['start_time'].date('P') ." +".$apt['hours']." hours"),
          $apt['name'],
          $apt['comments']
        );
      }
    }
    if ($send) {
      echo "<pre>$msg</pre>";
    }
  }
}
put_ptts_footer('');
