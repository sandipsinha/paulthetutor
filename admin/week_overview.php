<?php
include("../includes/pttec_includes.phtml");
$folder = getfolder('','','');
if ($folder != "admin")
		
      die("You are not authorized to view this page");

MySQL_PaulTheTutor_Connect();
put_ptts_header("Week Overview", $strAbsPath, "admin",'');
$week = isset($_REQUEST['week']) ? $_REQUEST['week'] : date('W', time());
$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : date('Y', time());
if($week > 0 && $week < 53 ) {
  $week--;
} elseif($week >= 53) {
  $week=0;
  $year++;
} else {
  $year--;
  $week=51;
}
$start_date = new DateTime(date('Y-m-d',strtotime(date('Y-m-d' ,strtotime("next Sunday",mktime(0,0,0,12,31,$year-1))).'+'.$week.'WEEK')));
$end_date = new DateTime(date('Y-m-d',strtotime($start_date->format('Y-m-d').'+6DAY')));
$week++;
#echo "s:".$start_date->format('Y-m-d'). ' e:'.$end_date->format('Y-m-d') ."<br>";
?>
<script type="text/javascript">
function openWin(id) { 
  window.open('other_appoint.php?appntId='+id+'','Details','status=1 ,width=446,height=446');
}
function openRecurWin(id) {
  window.open('../includes/recur_appoint.php?appntId='+id+'','Details','status=1 ,width=446,height=446');
}
</script>
<?php
// get list of tutors
$query = "select distinct id, first_name, last_name from PT_Tutors where position like '%tutor%' and archived = 0";
if(!($res = mysql_query($query))){
  echo "<br>Query:  $query <BR>" . mysql_error() . "in ".__FILE__. " on line ".__LINE__."<br>\n";
}
$tuts=Array();
$tutno=mysql_num_rows($res);
$i = 0;
while($tut = mysql_fetch_array($res)) {
  $tuts[$i]['info'] = $tut;
  $tuts[$i]['id'] = $tut['id'];
  $tuts[$i]['name'] = "$tut[first_name] ".strtoupper(substr($tut['last_name'],0,1));
  // get in/out hours
  $query = "SELECT * FROM PT_SchedSS_Norm WHERE tutor_id=".$tut['id'] ." AND start_date <= '".$start_date->format('Y-m-d')."' AND end_date >= '".$end_date->format('Y-m-d')."' ORDER BY start_date";
  if(!($schres = mysql_query($query)))
    echo "<br>Query:  $query <BR>" . mysql_error() . "in ".__FILE__. " on line ".__LINE__."<br>\n";
  while ($sched=mysql_fetch_assoc($schres)) {
    $tuts[$i]['sched'][$sched['dow']][]=$sched;
  }

  // get appointments
  $query = "(SELECT 'tut' AS type, a.id, a.date, a.start_time, a.hours, a.rate, a.pay, a.name, a.tid AS tutor_id, t.first_name AS t_first_name, t.last_name AS t_last_name  FROM PTAddedApp a LEFT JOIN PT_Tutors t ON a.tid = t.id WHERE a.date >= '".$start_date->format('Y-m-d')."' AND a.date <= '".$end_date->format('Y-m-d')."' AND a.tid = ".$tuts[$i]['id'].") UNION ALL (SELECT 'other' AS type, o.id, o.date, o.start_time, HOUR(SUBTIME(o.end_time, o.start_time))+(MINUTE(SUBTIME(o.end_time, o.start_time))/60) as hours, 0 as rate, 0 as pay, o.`name`, o.tutor_id, t.first_name as t_first_name , t.last_name as t_last_name  FROM PT_Other_Appt o LEFT JOIN PT_Tutors t ON o.tutor_id=t.id WHERE o.date >= '".$start_date->format('Y-m-d')."' AND o.date <= '".$end_date->format('Y-m-d')."' AND o.tutor_id = ".$tuts[$i]['id'].") ORDER by date, start_time ASC";
  if(!($aptres = mysql_query($query)))
    echo "<br>Query:  $query <BR>" . mysql_error() . "in ".__FILE__. " on line ".__LINE__."<br>\n";
  while ($apt=mysql_fetch_assoc($aptres)) {
    $tuts[$i]['days'][$apt['date']][]=$apt;
  }
  ++$i;
}


?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css" />

<table>
  <tr>
    <td class=td_header colspan="2">Week Overview</td>
  </tr>
  <tr><td colspan="2" align="center" class="Head2"><a href="?week=<?=$week-1?>&year=<?=$year?>">&lt;&lt;&lt;</a>Week of <?=$start_date->format('m/d/Y');?> <a href="?week=<?=$week+1?>&year=<?=$year?>">&gt;&gt;&gt;</a></td></tr>
  <tr>
    <td  valign="top"  colspan="2">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  <th>Tutor</th>
<?php
for($i=new DateTime($start_date->format('Y-m-d')); $i<=$end_date; $i->modify('+1DAY'))
  echo '<th class="text_date" nowrap align=center>'.$i->format('D m/d').'</td>';
?>
  </tr>
<?php
foreach($tuts AS $tut) {
  echo '<tr valign="top" class="tutsched"><td class="tutsched" nowrap>'.$tut['name'].'&nbsp;</td>';
  for($i=new DateTime($start_date->format('Y-m-d')); $i<=$end_date; $i->modify('+1DAY')) {
    echo '<td class="week_day">';
    #echo "<i>".$i->format('Y-m-d')."</i><br>";
    if(isset($tut['sched']) && isset($tut['sched'][$i->format('N')])) {
      echo '<div class="sched_container">';
      foreach($tut['sched'][$i->format('N')] AS $sched) {
        echo '<span class="sched">In: '.date("g:i a", strtotime($sched['clock_in'])).'<br>Out: '. date("g:i a", strtotime($sched['clock_out'])).'</span><br>';
      }
      echo '</div>';
    }
    if(isset($tut['days'][$i->format('Y-m-d')])) {
      foreach($tut['days'][$i->format('Y-m-d')] AS $apt) {
        switch($apt['type']) {
          case "tut":
            $href = "javascript:popup('added_appoint.php?appntId=".$apt['id']."','Details','500','500')";
            break;
          case "other":
            $href = "javascript:openWin(".$apt['id'].")";
            break;
        }
            
        echo '<span class="'.$apt['type'].'"><b><a class="'.$apt['type'].'" href="'.$href.'">'.$apt['name'].'</a></b> : '. date("g:i a", strtotime($apt['start_time'])). ' (' . (float) $apt['hours'].')</span><br>';
      }
    }
    echo '</td>';
  }
  echo '</tr>';
}
?>
</table>
</td>
</tr>	
</table>
</form>
<?php
put_ptts_footer("");
