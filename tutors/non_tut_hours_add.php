<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Non-Tutoring Hours", $strAbsPath, "admin", isset($_REQUEST['popup']) ?"popup":"");
if (stristr($_SERVER['SCRIPT_NAME'], 'admin')) {
  // admin user
  $admin = true;
  $tutor_id = (isset($_REQUEST['tid'])) ? (int) $_REQUEST['tid'] : 0;
  tutorsid_menu($tutor_id,"tid");
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
  $tutor_id = $_SESSION['tutor_id'];
}

// initial stuff done check to see if page has been posted to, else set up the form
if (!isset($_POST['Submit'])) {
  include('../tutors/non_tut_hours_form.php');
} else { // process the submission
  $_REQUEST['tutor_id'] = $tutor_id;
  echo is_int($r = InsertFields("PT_NT_Work_Hours", $_REQUEST, null, 'id', null)) ? "Non-Tutoring Hours added." : $r;
} // if POST


if (!isset($_REQUEST['popup'])) put_ptts_footer("");
