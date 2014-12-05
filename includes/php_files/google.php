<?php 
# This file uses the Zend Framework g_data classes to interface with google services (currently just Calendar)
# The idea is that this is a sane replacement for the old gc_updater mess. -PC

Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Calendar');


class Gcal {
  protected $user = 'ptts.docs@gmail.com';
  protected $pass = 'paul_the_tutor';
  protected $cxn;
  public    $cals = array();
  public    $cal;
  public    $events;

  function __construct($initcal=null) {
    $this->cxn = new Zend_Gdata_Calendar(Zend_Gdata_ClientLogin::getHttpClient($this->user, $this->pass, Zend_Gdata_Calendar::AUTH_SERVICE_NAME));

    try {
      $listFeed= $this->cxn->getCalendarListFeed();
    } catch (Zend_Gdata_App_Exception $e) {
      echo "Error: " . $e->getMessage();
    } // try
    foreach ($listFeed as $calendar) {
      $url = explode('/', $calendar->content->src);
      #echo "<li>" . $calendar->title . " (Event Feed: " . $calendar->content->src . ")</li>";
      $this->cals[(string) $calendar->title] = array('title'=>$calendar->title, 'url'=>$calendar->content->src, 'id'=>$url[5]);
    } // foreach
    $initcal && $this->getCal($initcal);
  }

  public function getCal($user, $opts=null) {
    is_array($opts) || $opts = array();
    $q = $this->cxn->newEventQuery();
    foreach ($this->cals as $k => $cal) 
    $this->cal = $this->cals[$user];
    $q->setUser($this->cal['id']);
    $q->setVisibility('private');
    $q->setProjection('full');
    $q->setOrderBy('starttime');
    (isset($opts['start']) || isset($opts['end'])) || $q->setFutureevents('true');
    (isset($opts['start'])) && $q->setStartMin($opts['start']);
    (isset($opts['end'])) && $q->setStartMax($opts['end']);
    (isset($opts['query'])) && $q->setQuery($opts['query']);

    try {
          return $this->events = $this->cxn->getCalendarEventFeed($q);
    } catch (Zend_Gdata_App_Exception $e) {
          echo "Error: " . $e->getMessage();
    } // try
  } // function getCal
  
  /*
   $start and $end are unix timestamps
   returns a copy of the event as it was saved on the server
  */

  public function addEvent($start, $end, $title, $content=false, $where=false) {
    $event= $this->cxn->newEventEntry();
    $event->title = $this->cxn->newTitle($title);
    !!$where && $event->where = array($this->cxn->newWhere($where));
    !!$content && $event->content = $this->cxn->newContent($content);
    $when = $this->cxn->newWhen();
    $when->startTime = date('c', $start);
    $when->endTime = date('c', $end);
    $event->when = array($when);
    #echo "Cal: ". $this->cal['title'] . " (".$this->cal['url'].")";
    return $this->cxn->insertEvent($event,$this->cal['url']);
  } // function addEvent
} // class Gcal

// translation functions to keep stuff working 
function gc_login() {
  #trigger_error("depricated gcal function gc_login() called");
  if (!isset($GLOBALS['gcal'])) {
    $GLOBALS['gcal'] = new Gcal();
  }
  return true;
} // function gc_login

function add_goog_cal($token, $date, $start_time, $duration, $title, $email=null, $cal_name='default') {
// end this early because it does not work
}
function add_goog_cal_NOTWORKING(){

  #trigger_error("depricated gcal function add_goog_cal() called");
  $start_array = explode(":", $start_time);
  $start_array[0] %= 24;
  $start_array[1] %= 60;
  $start_array[2] = isset($start_array[2]) ? $start_array[2] % 60 : 0;
  $start_time = implode(":", $start_array);
  if (!isset($GLOBALS['gcal'])) { gc_login(); }
  $GLOBALS['gcal']->getCal($cal_name);
  $start = strtotime("$date $start_time");
  $end = strtotime("+".(float)$duration." hours",   $start);
  ptts_mail('packetcollision@gmail.com', 'add_goog_cal called', var_export(array('vars'=>array('start'=>$start,'end'=>$end,'duration'=>$duration), 'backtrace'=>debug_backtrace()), true));
  $GLOBALS['gcal']->addEvent($start, $end, $title);
  return true;
} // function add_goog_cal

function del_goog_cal($token, $date, $start_time, $duration, $title, $email=null, $cal_name='default') {
// kill this until it is fixed
	return('');

  #trigger_error("depricated gcal function del_goog_cal() called");
  #trigger_error("Note that this function is unsafe (it deletes all events on a given day mentioning the title). Don't use it.");
  $start_array = explode(":", $start_time);
  $start_array[0] %= 24;
  $start_array[1] %= 60;
  $start_array[2] = isset($start_array[2]) ? $start_array[2] % 60 : 0;
  $start_time = implode(":", $start_array);
  ptts_mail('packetcollision@gmail.com', 'del_goog_cal called', var_export(debug_backtrace(), true));
  $start = strtotime("$date $start_time");
  $end = date("Y-m-d", strtotime("+1 day",   $start));
  $GLOBALS['gcal']->getCal($cal_name, array('start'=>$start, 'end'=>$end, 'query'=>$title));
  foreach ($GLOBALS['gcal']->events as $event) {
    $event->delete();
  }
  return true;
}


