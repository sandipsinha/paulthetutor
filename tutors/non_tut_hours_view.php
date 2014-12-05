<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Non-Tutoring Hours", $strAbsPath, "admin", "");
if (stristr($_SERVER['SCRIPT_NAME'], 'admin')) {
  // admin user
  $admin = true;
  $tutor_id = (isset($_REQUEST['tid'])) ? (int) $_REQUEST['tid'] : 0;
  tutorsid_menu($tutor_id,"tid",'',array('all'=>true));
  ?>
<script>
    $(function(){
      // bind change event to select
      $('#tutor_menu_tid').bind('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              var burl = window.location.href.replace(/[\?&]tid=\d+/,"");
              var args = burl.split('?');
              var sep = (args.length > 1) ? '&' : '?';
              window.location = burl+sep+"tid="+url; // redirect
          }
          return false;
      });
    });
</script>

<?php
} else { // tutor
  include("../includes/tut_auth.php");
  $admin = false;
  $tutor_id = $_SESSION['tutor_id'];
}

// initial stuff done check to see if page has been posted to, else set up the form
$year = (isset($_GET['year'])) ? (int) $_GET['year'] : date('Y');
$month = (isset($_GET['month'])) ? (int) $_GET['month'] : null;

  ?><style type="text/css">
   #hours th { text-align:left; border-right: 1px dotted #ddd; }
   #hours td { border-right: 1px dotted #ddd };
  </style>
  <?php

if ($month) { // Display detailed month view
  $QStr = 'SELECT id, hours , rate, hours*rate as pay, DAYOFMONTH(date) as day, description, comments FROM PT_NT_Work_Hours WHERE tutor_id = '.$tutor_id." AND MONTH(date) = ".$month." ORDER BY day ASC";

  $RS = runquery($QStr);
  if(!$RS) {put_ptts_footer(""); die(); } // display and die if there was an error
  // breadcrumb
  echo "<h3>".date('F', mktime(0,0,0,$month,1)). ' <a href="?year='. $year .(($admin)? '&tid='.$tutor_id : '') . '">'.  $year .'</a></h3>';
  echo "<table id=hours width=600><tr><th>Day</th><th>Hours</th><th>Rate</th><th>Pay</th><th>Description</th><th>Comments</th></tr>";
  $thours=0;
  $tpay=0;
  while ($row = mysql_fetch_assoc($RS)) {
    echo "<tr><td>".$row['day']."</td><td>".$row['hours']."</td><td>$".$row['rate']."/hr</td><td>$".$row['pay']."</td>";
    echo "<td>".$row['description']."</td><td>".$row['comments']."</td>";
    echo "<td><a onclick=\"javascript:popup('work_hours_edit.php?id=".$row['id']."','Details','700','820');return false;'\"><img SRC=\"../images/edit_pencil.gif\" ALT=\"edit\" border=\"0\"></a>&nbsp;";
    echo "<a onclick=\"if (confirm(\'Are you sure you want to delete this work hours?\')) {document.form.move_id.value='".$row['id']."'; document.form.submit()}\"><img SRC=\"../images/del_x.gif\" ALT=\"delete\" border=\"0\"></a>&nbsp;</td></tr>";
    #echo "<td><a href=\"work_hours_edit.php?id=".$row['id']."\"><img href=\"../images/edit_pencil.gif\"></a><a </td></tr>";
    $thours+=$row['hours'];
    $tpay+=$row['pay'];
  } // while results
  echo "<tr><td><strong>Totals:</strong></td><td>".$thours."</td><td></td><td>$".$tpay."</td></tr>";

  } else { // Display overview for year
  // allow user to change year
  echo '<h3><a href="?year='. ($year - 1) . (($admin)? '&tid='.$tutor_id : '') .'">'. ($year - 1) .'</a> - '. $year;
  if ($year < date('Y')) {
    echo ' - <a href="?year='. ($year+1). (($admin)? '&tid='.$tutor_id : '').'">'. ($year+1) ."</a>";
  }
  echo '</h3>';
  // end year-changer

  $QStr = 'SELECT SUM(hours) as hours, SUM(pay) AS pay, month FROM (SELECT SUM(hours) AS hours, SUM(hours)*rate as pay, MONTH(date) as month FROM PT_NT_Work_Hours WHERE tutor_id = '.$tutor_id." AND date BETWEEN '".$year."-01-01' AND '".$year."-12-31' GROUP BY MONTH(date), rate) AS A";

  $RS = runquery($QStr);
  if(!$RS) {put_ptts_footer(""); die(); } // display and die if there was an error

  echo "<table id=hours width=400><tr><th>Month</th><th>Hours</th><th>Pay</th></tr>";
  while ($row = mysql_fetch_assoc($RS)) {
    if ($row['month']) {
      echo '<tr><td><a href="?year='.$year.'&month='.$row['month']. (($admin)? '&tid='.$tutor_id : '') .'">'.date('F', mktime(0,0,0,$row['month'],1))."</a></td><td>".$row['hours']."</td><td>".$row['pay']."</td></tr>";
    } else {
      echo '<tr><td colspan=3>No Non-Tutoring Hours exist for this year</td></tr>';
    }
  } // while results
} // end if month
  ?>
  </table>
  <h3><a href="work_hours_edit.php">Add Non-Tutoring Hours</a></h3>
  <?php
put_ptts_footer("");
