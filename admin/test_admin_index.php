<?php
$strBack = "../";
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
//put_ptts_header("", $strAbsPath, "admin", "index");
put_header_2014("", $strAbsPath, "admin", "index");

$money = $_REQUEST[money];

?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">

<table border="1" cellspacing="2" cellpadding="0" width="100%" class="table_1">
  <tr>
    <td class="td_header">Admin Home</td>
  </tr>
  <tr>
    <td align="center" height="148">
      <table width="100%" border="0" height="" cellpadding="7" margin=0 cellspacing="0" bgcolor="#FFFFFF">
        <tr>
<? // if there is any unread mail, put the icon
$MQS = "select id from PT_Emails where viewed = 0";
$MRS = runquery($MQS);
$rows_mail = mysql_num_rows($MRS);

function makeCurrency( $money ) {

  return preg_replace( "/[^0-9\.]/", "", $money );

}

echo "input: $money converted: " . makeCurrency( $money );


// see if any new contact has to be attended to
$MQS = "select id from PT_First_Contact where needs_attention = 1";
$MRS = runquery($MQS);
$rows_newce = mysql_num_rows($MRS);

if($rows_mail > 0) { ?>
<TR>
  <td>
<a href="mail_room.php" style="font-weight:bold" class="red_font"> New Mail <img src="../images/mail-box-icon.png" width="24" height="24" /></a>

</td></TR>
<? }  ?>            
            
        
        
          <td><span style="font-weight:bold">Scheduling -</span> <a href="calendar.php" style="font-weight:bold">Calendar</a> - <a href="addsess.php" style="font-weight:bold">Add
          a  Session</a> - <a href="schedules.php" style="font-weight:bold">Repeating
           Sessions</a> - <a href="non_tutoring_appointments.php" style="font-weight:bold">Non-Tutoring
          Appoinments</a> - <a href="work_hours_list.php" style="font-weight:bold">Non-Tutoring
          Work</a> - <a href="week_overview.php" style="font-weight:bold">Week Overview</a>
          - <a href="vacation_list.php" style="font-weight:bold">Vacations</a>
          </td></tr><tr><td>
            <span style="font-weight:bold">Families</span>
            - <a href="families.php" style="font-weight:bold">Family List</a>
             - <a href="get_current_emails.php" style="font-weight:bold">All Emails</a> 
            - <a href="returnfamilies.php" style="font-weight:bold">Restore Archived Family</a>
            - <a href="childless_family.php" style="font-weight:bold">view childless families</a>
            - <a href="student_edit.php" style="font-weight:bold">Add a student</a>
           - <a href="rates_fam.php" style="font-weight:bold">Rates for Family</a></td></tr><tr>
            <td>
            <span style="font-weight:bold">Students</span>
            - <a href="studentinfo.php" style="font-weight:bold">Student Info</a>
            - <a href="comments_inprogress.php" style="font-weight:bold"> Student's Comments</a> - <a href="archivestudents.php" style="font-weight:bold">Archive Students</a>            - <a href="returnstudents.php" style="font-weight:bold">Restore Archived Students</a>
            - <a href="stranded_student.php" style="font-weight:bold">View Students with no Family</a>
          </td>
          </tr>
           <tr>
            <td><span style="font-weight:bold">Admin</span> - <a href="view_table.php" style="font-weight:bold">View Table</a> - <a href="locations.php" style="font-weight:bold"> Locations</a> - <a href="new_ce.php"  
<? 
if ($rows_newce > 0)
	echo " class=\"red_font\" ";
?>	            
            style="font-weight:bold"> New Call/Email </a>- <a href="mail_room.php" 
<? 
if ($rows_mail > 0)
	echo " class=\"red_font\" ";
?>	              
            
            style="font-weight:bold"> Mail Room
<? // if there is any unread mail, put the icon

if($rows_mail > 0) { ?>
<img src="../images/new-mail.png" width="16" height="16" alt="NEW MAIL" />
<? }  ?>            
            
            </a> - <a href="get_current_emails.php" style="font-weight:bold">All Emails</a> - <a href="carrier_list.php" style="font-weight:bold">Cell Carriers</a> - <a href="testimonial_list.php" style="font-weight:bold">Testimonials</a> - <a href="resync_gcal.php" style="font-weight:bold">Resync Google Calendars</a></td>
        </tr>
          <tr>
            <td><span style="font-weight:bold">Rates</span> -  <a href="rates_loc.php" style="font-weight:bold">General Rates</a> - <a href="rates_fam.php" style="font-weight:bold">Rates for Family</a> - <a href="rates_tut.php" style="font-weight:bold">Rates for a Tutor</a></td>
          </tr>
          <tr><td>
           <span style="font-weight:bold">Classes</span>
           - <a href="classes_list.php" style="font-weight:bold">Classes List</a>
           - <a onclick="javascript:popup('class_student_edit.php?tab=PT_TestPrep_Reg&popup=popup','','700','700')" style="cursor:pointer; font-weight:bold; text-decoration:underline;">Add a Student </a>
           - <a href="seminars_list.php" style="font-weight:bold">Seminars List</a>
           - <a href="view_rosters.php" style="font-weight:bold">See Class Rosters</a>
           - <a href="../ldsatprep/ldsatadmin" target="_blank" style="font-weight:bold">LD SAT Prep Admin</a>
         </td></tr>
          <tr>
            <td><span style="font-weight:bold">Billing</span> - <a href="sendbills_new.php" style="font-weight:bold">Send Bills</a> - <a href="showbills_new.php" style="font-weight:bold">Show Bills</a> - <a href="billinghistory.php" style="font-weight:bold">Billing History</a> - <a href="allbills.php" style="font-weight:bold">All Bills</a> - <a href="monthoverview.php" style="font-weight:bold">Monthly Overview</a> - <a href="cc_fams.php" style="font-weight:bold">Stored CC Info</a>  - <a href="strip_autopay.php" style="font-weight:bold">Add AutoPay</a> </td>
          </tr>
		  <tr>
            <td><span style="font-weight:bold">Accounting</span> - <a href="billing.php" style="font-weight:bold">Accounting</a> - <a href="https://www.paulthetutors.com/admin/strippay_action3.php" target="_blank" style="font-weight:bold">Credit Card Payment</a> - <a href="strip_saved_charge2.php" style="font-weight:bold">Bill Saved Account</a> - <a href="payments.php" style="font-weight:bold">Payments</a> - <a href="pastdue.php" style="font-weight:bold">Past due</a> - <a href="zeromoney.php" style="font-weight:bold">Zero Money Appoinments</a> - <a href="view_expenses.php" style="font-weight:bold">Expenses</a>  - <a href="credits.php" style="font-weight:bold">Credits</a></td>
          </tr>
		  		  
        <tr>
          <td><span style="font-weight:bold">Tutors -</span><a href="tutorsinfo.php" style="font-weight:bold">Tutors Info</a> - <a href="rates_tutor.php" style="font-weight:bold">Rates for a Tutor</a>  - <a href="get_current_emails.php" style="font-weight:bold">All Emails</a> - <a href="tutorarchive.php" style="font-weight:bold">Archives
          Tutors</a> - <a href="applicants.php" style="font-weight:bold">Applicants</a> - <a href="admin_applicant.php" style="font-weight:bold">Admin Applicants</a> - <a href="interview_appts.php" style="font-weight:bold">Interview Times</a></td>
        </tr>
      </table>

    </td>
  </tr>
</table>
<?
put_footer_2014("");
?>
