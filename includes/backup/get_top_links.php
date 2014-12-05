<?
    //this file holds UPlinks object class
    include "uplinks_class.php";

/***********************************************************************
funtion get_top_links2

$links[0] = new Uplinks( $folder, 0, 0, "", FULL_BASE_PATH.".php" );
Uplinks( folder name, position in navbar, position in dropdown menu, label, link, 
        is_in_drop_down=false );
*************************************echo**********************************/
function get_top_links2( $folder ) {
	$links = array();

	switch( $folder ) {
    case "admin":
            
        $n = 1;
        $links[$n++] = new Uplinks( $folder, 1, 0, "Admin Home", FULL_BASE_PATH."/admin/index.php" );
        
        /**
        Communication
            New Calls/Emails
            Mail Room
        **/
        $communication = new Uplinks( $folder, 0, 0, "Communication", "#" );
        $communication->addDropDownLink( $folder, "New Calls/Emails", "new_ce.php" );
        $communication->addDropDownLink( $folder, "Add New Contact", 
            "javascript:popup('edit_new_ce.php?strTable=PT_First_Contact','Details','600','820')" );
        $communication->addDropDownLink( $folder, "Mail Room", "mail_room.php" );

        $links[$n++] = $communication;

        /**
        Calendar (calendar_action.php)
            for each active tutor, have a link to the calendar with their tutor_id selected 
            Paul the Tutor calendar_action.php?j_tid=1)
            Craig Anderson (calendar_action?j_tid=xxx)
        **/
        $calendar = new Uplinks( $folder, 2, 0, "Calendar", FULL_BASE_PATH."/admin/calendar_action.php" );
        //"2014-07-00" format date needs to be for mysql query
        $month = date('Y-m', strtotime("-60 days"));
        ;//'2014-09-25'; //date( strtotime("-60 days") ); //date( "Y-m" ) . "-00";

        $calendar_link = FULL_BASE_PATH."/admin/calendar_action.php?j_tid=";
        
        $query = "SELECT DISTINCT PT_Tutors.id, PT_Tutors.first_name, PT_Tutors.last_name 
                    FROM PT_Tutors 
                    INNER JOIN PTAddedApp on PTAddedApp.tid = PT_Tutors.id
                    WHERE PTAddedApp.date >= '$month'AND 
                    PT_Tutors.position in ( 'tutor', 'tutor,admin' ) LIMIT 0, 6 ";
        
        $results = runquery( $query );
        $tutors = 0;
        while( $row = mysql_fetch_array( $results ) ) {

            $link_label = $row["first_name"]." ".$row["last_name"];
            $calendar->addDropDownLink( $folder, $link_label, $calendar_link.$row["id"] );

        }

        $links[$n++] = $calendar;

        /**
        Schedules (no link)
            Add a Session (pop-up)
            Weekly Overview
            Recurring Sessions
            Non-Tutoring Appointments
            Non-Tutoring Work
        **/
        $schedules = new Uplinks( $folder, 3, 0, "Schedules", "#" );
        $schedules->addDropDownLink( $folder, "Add a Session", 
             "javascript:popup('addsess_loc.php?popup=popup','','700','700')" );
        $schedules->addDropDownLink( $folder, "Weekly Overview", 
            FULL_BASE_PATH."/admin/week_overview.php"  );
        $schedules->addDropDownLink( $folder, "Recurring Sessions", 
            FULL_BASE_PATH."/admin/schedules.php"  );
        $schedules->addDropDownLink( $folder, "Non-Tutoring Appointments", 
            FULL_BASE_PATH."/admin/non_tutoring_appointments.php"  );
        $schedules->addDropDownLink( $folder, "Non-Tutoring Work", 
            FULL_BASE_PATH."/admin/work_hours_list.php" );

        $links[$n++] = $schedules;

        /**
        Tutoring
            Student Comments
            LD SAT Prep Admin
            Add a Note
            Class List
        **/
        $tutoring = new Uplinks( $folder, 0, 0, "Tutoring", "#" );
        $tutoring->addDropDownLink( $folder, "Student Comments", "comments_inprogress.php" );
        $tutoring->addDropDownLink( "ldsatadmin", "LD SAT Prep Admin", FULL_BASE_PATH.
            "/ldsatprep/ldsatadmin" );
         $url = FULL_BASE_PATH."/tutors/comment_edit_inprogress.php";
        $tutoring->addDropDownLink( "tutors", "Add a Note",  
            "javascript:popup( '$url', '', '700', '700' )" );
        $tutoring->addDropDownLink( $folder, "Class List", "classes_list.php" );
        
        $links[$n++] = $tutoring;

        /**
        Accounting
            Payment
            Past Due
            Autopay Families
            Add AutoPay Family (In admin homepage)
            Family’s Finances?
            All Sessions for a Family?
        **/        
        $accounting = new Uplinks( $folder, 4, 0, "Accounting", FULL_BASE_PATH."/admin/billing.php" );
        $accounting->addDropDownLink( $folder, "Monthly Overview", FULL_BASE_PATH."/admin/monthoverview.php" );
        $accounting->addDropDownLink( $folder, "Expenses", FULL_BASE_PATH."/admin/view_expenses.php" );
        $accounting->addDropDownLink( $folder, "Payment", FULL_BASE_PATH."/admin/payments.php" );
        $accounting->addDropDownLink( $folder, "Past Due", FULL_BASE_PATH."/admin/pastdue.php" );
        $accounting->addDropDownLink( $folder, "Autopay Families", FULL_BASE_PATH."/admin/cc_fams.php" );
        $accounting->addDropDownLink( $folder, "Add Autopay Families", FULL_BASE_PATH."/admin/index.php" );
        $accounting->addDropDownLink( $folder, "Charge Autopay Family", 
            FULL_BASE_PATH."/admin/strip_saved_charge2.php" );
        $accounting->addDropDownLink( $folder, "Family’s Finances", FULL_BASE_PATH."/admin/billinghistory.php" );
        $accounting->addDropDownLink( $folder, "All Sessions for a Family", FULL_BASE_PATH."/admin/allbills.php" );
        $links[$n++] = $accounting;

        /**
        Billing (NOTHING)
            Show Bills
            Send Bills
            All Sessions for Family(need link)
            Charge Autopay Family
        **/
        $billing = new Uplinks( $folder, 5, 0, "Billing", "#" );
        $billing->addDropDownLink( $folder, "Show Bills", FULL_BASE_PATH."/admin/showbills_new.php" );
        $billing->addDropDownLink( $folder, "Send Bills", FULL_BASE_PATH."/admin/sendbills_new.php" );
        $billing->addDropDownLink( $folder, "All Sessions for Family", FULL_BASE_PATH."/admin/allbills.php" );
        $links[$n++] = $billing;
        
        /**
        Families
            Students?
            Email All?
            Add a Student
            Rates for Families
        **/
        $families = new Uplinks( $folder, 6, 0, "Families", '#' /*FULL_BASE_PATH."/admin/families.php" LH 9-25-14 */ );
        $families->addDropDownLink( $folder, "Familes", FULL_BASE_PATH."/admin/families.php" );
        $families->addDropDownLink( $folder, "Students", FULL_BASE_PATH."/admin/studentinfo.php" );
        $families->addDropDownLink( $folder, "Email All", FULL_BASE_PATH."/admin/get_current_emails.php" );
        $families->addDropDownLink( $folder, "Add a Student", FULL_BASE_PATH."/admin/student_edit.php" );
        $families->addDropDownLink( $folder, "Rates for Families", FULL_BASE_PATH."/admin/rates_fam.php" );
        $links[$n++] = $families;

        /**
        Admin?
            Rates (loc_rates.php - does not exist)
                Rates for Family
                Rates for Tutor
                Rates for Location?
            Locations
            Notes on Students
                Classes
            Add A Student?
            Test Prep Admin
        **/
        $admin = new Uplinks( $folder, 7, 0, "Admin", FULL_BASE_PATH."/admin/" );
        $admin->addDropDownLink( $folder, "Rates", FULL_BASE_PATH."/admin/loc_rates.php" );

        $rates = $admin->getDropDownLink( "Rates" );
        $rates->addDropDownLink( $folder, "Rates for Family", FULL_BASE_PATH."/admin/rates_fam.php" );
        $rates->addDropDownLink( $folder, "Rates for Tutor", FULL_BASE_PATH."/admin/rates_tut.php" );
        $rates->addDropDownLink( $folder, "Rates for Location", FULL_BASE_PATH."/admin/rates_loc.php" );
        $admin->updateDropDownLink( $rates );

        $admin->addDropDownLink( $folder, "Locations", FULL_BASE_PATH."/admin/locations.php" );
        $admin->addDropDownLink( $folder, "Notes on Students", FULL_BASE_PATH."/admin/comments_inprogress.php" );
        $admin->addDropDownLink( $folder, "Classes", FULL_BASE_PATH."/admin/classes_list.php" );

        $classes = $admin->getDropDownLink( "Classes" );
        $classes->addDropDownLink( $folder, "Add A Student", "javascript:popup( 
            '/admin/student_edit.php?popup=popup','','700','700') " );
        $admin->updateDropDownLink( $classes );

        $admin->addDropDownLink( $folder, "Test Prep Admin", FULL_BASE_PATH.
            "/ldsatprep/ldsatadmin" );
        $links[$n++] = $admin;

        /**
        Tutors
            Email All?
            Weekly Schedules
            Rates for Tutors
            Tutoring Applicants
            Admin Applicants
            Interview Manager?
        **/
        $tutors = new Uplinks( $folder, 8, 0, "Tutors", FULL_BASE_PATH."/admin/tutorsinfo.php" );
        $tutors->addDropDownLink( $folder, "Email All", FULL_BASE_PATH."/admin/get_current_emails.php" );
        $tutors->addDropDownLink( $folder, "Weekly Schedules", FULL_BASE_PATH."/admin/week_overview.php" );
        $tutors->addDropDownLink( $folder, "Rates for Tutors", FULL_BASE_PATH."/admin/rates_tut.php" );
        $tutors->addDropDownLink( $folder, "Tutoring Applicants", FULL_BASE_PATH."/admin/applicants.php" );
        $tutors->addDropDownLink( $folder, "Admin Applicants", FULL_BASE_PATH."/admin/admin_applicant.php" );
        $tutors->addDropDownLink( $folder, "Interview Manager", FULL_BASE_PATH."/admin/interview_appts.php" );
        $links[$n++] = $tutors;
        break;

    case "tutors":

        /**
            Home
            Calendar
            Check Time Cards (Month’s Sessions)
        **/

        $n = 1;
        $month = date( m );
        $year = date( Y );
        $links[$n++] = new Uplinks( $folder, 0, 0, "Tutors' Home", "index_tutors.php" );
        $links[$n++] = new Uplinks( $folder, 0, 0, "Calendar", "calendar_action.php" );     
        $links[$n++] = new Uplinks( $folder, 0, 0, "Check Time Cards ", "show_bills.php" );
        
        /**
        Schedules
            add a tutoring session
            non-tutoring sessions
            add a non-tutoring session
            recurring sessions
            add a recurring session
            Check Time Cards
        **/
        $schedules = new Uplinks( $folder, 0, 0, "Schedules", "schedules.php" );
        $schedules->addDropDownLink( $folder, "add a tutoring session", 
            "javascript:popup( '/tutors/addsess_loc.php?popup=popup', '', '700', '700' )" );
        $schedules->addDropDownLink( $folder, "non-tutoring sessions", "non_tutoring_appointments.php" );
        $schedules->addDropDownLink( $folder, "add a non-tutoring session", 
            "javascript:popup( '/tutors/miviram_non_tutoring_appointment_edit.php?popup=popup', '', '700', '700' )" );
        $schedules->addDropDownLink( $folder, "recurring sessions", "/tutors/schedules.php" );
        $schedules->addDropDownLink( $folder, "add a recurring session", 
        "javascript:popup( '/tutors/schedule_edit.php?popup=popup', '', '700', '700' )" );
        $schedules->addDropDownLink( $folder, "check time cards", "show_bills.php" );
        $links[$n++] = $schedules;

        /**
        Notes (notes)
            add a note
            see notes
        **/
        $notes = new Uplinks( $folder, 0, 0, "Notes", "#" );
        $notes->addDropDownLink( $folder, "add a note", 
            "javascript:popup( 'comment_edit_inprogress.php', '', '700', '700' )" );
        $notes->addDropDownLink( $folder, "see note", "comments_inprogress.php" );
        $links[$n++] = $notes;

        /**
            Tutoring Resources
                Handouts
                Protocols
                    tutoring
                    tests prep
                    admin
                Test Prep Admin
                Test Prep Material
        **/
        $tutoring_resources = new Uplinks( $folder, 0, 0, "Tutoring Resources", "#" );
        $tutoring_resources->addDropDownLink( $folder, "Handouts", "http://www.dropbox.com/" );
        $tutoring_resources->addDropDownLink( $folder, "Protocols", "http://www.dropbox.com/" );

        $protocols = $tutoring_resources->getDropDownLink( "Protocols" );
        $protocols->addDropDownLink( $folder, "tutoring", "index.php" );
        $protocols->addDropDownLink( $folder, "tests prep", "index.php" );
        $protocols->addDropDownLink( $folder, "admin", "index.php" );
        $tutoring_resources->updateDropDownLink( $protocols );

        $tutoring_resources->addDropDownLink( $folder, "Test Prep Admin", 
            FULL_BASE_PATH."/ldsatprep/ldsatadmin" );
        $tutoring_resources->addDropDownLink( $folder, "Test Prep Material", "index.php" );
        $links[$n++] = $tutoring_resources;

        /**
        Contacts
            families
            students
            tutors
        **/
        $contacts = new Uplinks( $folder, 0, 0, "Contact Us", FULL_BASE_PATH."/contact.php" );
        $contacts->addDropDownLink( $folder, "families", "families.php" );
        $contacts->addDropDownLink( $folder, "students", "students.php" );
        $contacts->addDropDownLink( $folder, "tutors", "tutors.php" );
        $links[$n++] = $contacts;

        $links[$n++] = new Uplinks( $folder, 0, 0, "Log Out", FULL_BASE_PATH."/tutors/tutlogin.php?logout=1.php" );


        break;

    case "parents":
    
        $n = 1;
        /**
        Parents
        **/
        $links[$n++] = new Uplinks( $folder, 0, 0, "Paul the Tutor's", FULL_BASE_PATH."/index.php" );
        $links[$n++] = new Uplinks( $folder, 0, 0, "Parent's Home", "index_parents.php" );

        /**
        Accounting
            Billing History(https://www.paulthetutors.com/parents/viewbill.php)
            All Sessions
            Autopay
            Pay Bill
        **/
        $accounting = new Uplinks( $folder, 0, 0, "Accounting", FULL_BASE_PATH."/parents/viewbill.php" );
        $accounting->addDropDownLink( $folder, "Billing History", "viewbill.php" );
        $accounting->addDropDownLink( $folder, "All Sessions", "#" );
        $accounting->addDropDownLink( $folder, "Autopay", "strip_autopay.php" );
        $accounting->addDropDownLink( $folder, "Pay Bill", "strippay_action2.php" );
        $links[$n++] = $accounting;
        
        /**
        Schedules
        **/
        $links[$n++] = new Uplinks( $folder, 0, 0, "Schedules", "#" );

        /**
        Account Information
            Add a Student
            Edit Information
            MISSING LABEL???

        **/
        $account_information = new Uplinks( $folder, 0, 0, "Account Information", "viewbill.php" );
        $account_information->addDropDownLink( $folder, "Add a Student", "getstudentinfo.php" );
        $account_information->addDropDownLink( $folder, "Edit Information", 
            FULL_BASE_PATH."/parents/edit_info_full.php" );
        $links[$n++] = $account_information;
        
        /**
        Tutor’s Notes
        Tutor’s Information
        Contact Us
        Log Out
        Moved To Contact 9-30-14 per Paul .LH
        **/
        /*$tutors_notes = new Uplinks( $folder, 0, 0, "Tutor's Notes", "#" );
        $tutors_notes
        //$links[$n++] = new Uplinks( $folder, 0, 0, "Tutor's Info", "tutorsinfo.php" );
        $links[$n++] = $tutors_notes;*/

        $contact = new Uplinks( $folder, 0, 0, "Contact Us", FULL_BASE_PATH."/contact.php" );
        $contact->addDropDownLink( $folder, "Tutor's Info", "tutorsinfo.php" );
        $contact->addDropDownLink( $folder, "Book a Session", FULL_BASE_PATH."/contact.php" );
        //$links[$n++] = new Uplinks( $folder, 0, 0, "Book a Session", FULL_BASE_PATH."/contact.php" );
        $links[$n++] = $contact;

        $links[$n++] = new Uplinks( $folder, 0, 0, "Log Out", 
            FULL_BASE_PATH."/parents/login_parents.php?logout=1.php" );

        break;

    case "students":

        /**
        Test Prep Students 
            Home(http://www.paulthetutors.com/ldsatprep/students/index.php)
            Homework (homework page)(http://www.paulthetutors.com/ldsatprep/students/homework.php)
            Grade a Section(http://www.paulthetutors.com/ldsatprep/students/get_grsec.php)
            Grade a Test(http://www.paulthetutors.com/ldsatprep/students/get_grtest.php)
            Results
                Section Results(http://www.paulthetutors.com/ldsatprep/students/get_grsec.php?action=ans_grader.php)
                Test Results(http://www.paulthetutors.com/ldsatprep/students/get_grsec.php?action=ans_grader.php)
                All Results(http://www.paulthetutors.com/ldsatprep/students/ans_grader.php)
        **/

        $n = 1;
        $links[$n++] = new Uplinks( $folder, 0, 0, "Home", "index.php" );
        $links[$n++] = new Uplinks( $folder, 0, 0, "Homework", "homework.php" );
        $links[$n++] = new Uplinks( $folder, 0, 0, "Grade a Section", "get_grsec.php" );
        $links[$n++] = new Uplinks( $folder, 0, 0, "Grade a Test", "get_grtest.php" );

        $results = new Uplinks( $folder, 0, 0, "Results", "#" );
        $results->addDropDownLink( $folder, "Section Results", "get_grsec.php?action=ans_grader.php" );
        $results->addDropDownLink( $folder, "Test Results", "get_grsec.php?action=ans_grader.php" );
        $results->addDropDownLink( $folder, "All Results", "ans_grader.php" );
        $links[$n++] = $results;

        $links[$n++] = new Uplinks( $folder, 0, 0, "Log Out", "login.php?logout=1.php" );
        break;

    case "ldsatadmin":

        /**
        Test Prep Admin
            Home 
        **/
        $n = 1;
        $links[$n++] = new Uplinks( $folder, 0, 0, "Home", "index.php" );

        /**
            Students
                Classes
                One on One Students
                Add a Student
        **/
        $students = new Uplinks( $folder, 0, 0, "Students", "#" );
        $students->addDropDownLink( $folder, "Classes", "view_rosters.php" );
        $students->addDropDownLink( $folder, "One on One Students", "#" );
        $students->addDropDownLink( $folder, "Add a Student", "class_student_edit.php" );
        $links[$n++] = $students;

        /**
            Grader
                Grade a Test
                Grade a Section
        **/
        $grader = new Uplinks( $folder, 0, 0, "Grader", "#" );
        $grader->addDropDownLink( $folder, "Score Section", "get_grsec.php" );
        $grader->addDropDownLink( $folder, "Score Test", "get_grtest.php" );
        $links[$n++] = $grader;

        /**
            Results
                Student Section
                Student Test
                Student All Results
        **/
        $results = new Uplinks( $folder, 0, 0, "Results", "score_sum.php" );
        $results->addDropDownLink( $folder, "Student Section", "get_grsec.php?action=ans_grader.php&type=sec" );
        $results->addDropDownLink( $folder, "Student Test", "get_grtest.php?action=ans_grader.php&type=test" );
        $results->addDropDownLink( $folder, "Student All Results", "score_sum.php" );
        $links[$n++] = $results;

        /**
            Tests
                All Tests
                Edit Test
                Edit Answers
                Add a Test
        **/
        $tests = new Uplinks( $folder, 0, 0, "Tests", "#" );
        $tests->addDropDownLink( $folder, "All Tests", "standardized_tests.php" );
        $tests->addDropDownLink( $folder, "Edit Test", "edit_test_parts.php" );
        $tests->addDropDownLink( $folder, "Edit Answers", "#" );
        $tests->addDropDownLink( $folder, "Add a Test", "gettestinfo.php" );
        $links[$n++] = $tests;

        /**   
            Homework
                Homeword Summary
                Enter HW Summary
                Gradable HW
                Enter Gradable HW
        **/    
        $homework = new Uplinks( $folder, 8, 0, "Homework", "hwsum.php" );
        $homework->addDropDownLink( $folder, "Homeword Summary", "hwsum.php" );
        $homework->addDropDownLink( $folder, "Enter HW Summary", "gethwsum.php" );
        $homework->addDropDownLink( $folder, "Gradable HW", "hwgradable.php" );
        $homework->addDropDownLink( $folder, "Enter Gradable HW", "gethwgradable.php" );
        $links[$n++] = $homework;

        /**
            Notes (links bring as new page notes page from admin or tutor’s folder)
                Admin Notes
                Tutor’s Notes
                Add A Note (tutor’s add a note page)
        **/
        $notes = new Uplinks( $folder, 0, 0, "Notes", "#" );
        $url = FULL_BASE_PATH."/admin/comments_inprogress.php";
        $notes->addDropDownLink( "admin", "Admin Notes", "javascript:openInNewTab( '$url' )" );
        $url = FULL_BASE_PATH."/tutors/comments_inprogress.php";
        $notes->addDropDownLink( "tutors", "Tutor’s Notes", "javascript:openInNewTab( '$url' )" );
        $url = FULL_BASE_PATH."/tutors/comment_edit_inprogress.php";
        $notes->addDropDownLink( "tutors", "Add A Note",  "javascript:popup( '$url', '', '700', '700' )" );
        $links[$n++] = $notes;

        break;

    //links for index_2012 navbar
	default:
        $n = 1;
        $links[$n++] = new Uplinks( $folder, 0, 0, "Home", "/index.php" );
        
        //tutoring dropdown
        $tutoring = new Uplinks( $folder, 0, 0, "Tutoring",  "/tutoring.php" );
        $tutoring->addDropDownLink( $folder, "Math and Science",  "/services.php#MathAndScience" );
        $tutoring->addDropDownLink( $folder, "English and History",  "/services.php#EnglishAndHistory" );
        $tutoring->addDropDownLink( $folder, "Test Prep",  "/services.php#Test Prep" );
        $links[$n++] = $tutoring;
        
        //test prep dropdown
        $test_prep = new Uplinks( $folder, 0, 0, "Test Prep", "/testprep.php" );
        $test_prep->addDropDownLink( $folder, "SAT Prep", "/testprep.php" );
        $test_prep->addDropDownLink( $folder, "ACT Prep", "/testprep.php" );
        $test_prep->addDropDownLink( $folder, "SSAT/ISEE/HSPT", "/testprep.php" );
        $links[$n++] = $test_prep;
        
        //locations
        $locations = new Uplinks( $folder, 0, 0, "Locations", "/locations.php" );
        $locations->addDropDownLink( $folder, "Piedmont", "/location.php?id=1" );
        $locations->addDropDownLink( $folder, "Berkeley", "/location.php?id=9" );
        $locations->addDropDownLink( $folder, "Peninsula", "/location.php?id=5" );
        $locations->addDropDownLink( $folder, "Lafayatte", "/location.php?id=4" );
        $locations->addDropDownLink( $folder, "Davis", "/location.php?id=8" ); 
        $links[$n++] = $locations;

        //ABOUT US Paul the Tutor The Tutors Why Us? How it Works Locations Rates Hours
        $about_us = new Uplinks( $folder, 0, 0, "About Us", "/aboutus.php" );
        $about_us->addDropDownLink( $folder, "Paul the Tutor", "/aboutus.php#Paul" );
        $about_us->addDropDownLink( $folder, "The Tutors", "/aboutus.php#Tutors" );
        $about_us->addDropDownLink( $folder, "Why us", "/whyus.php" );
        $about_us->addDropDownLink( $folder, "How it Works", "/contact.php" );
        $about_us->addDropDownLink( $folder, "Rates", "/rates.php" );
        $about_us->addDropDownLink( $folder, "Hours", "/logistics.php" );
        $links[$n++] = $about_us;

        //CONTACT US Initial Contact Contact Information 
        $contact_us = new Uplinks( $folder, 0, 0, "Contact Us", "/contact.php" );
        $contact_us->addDropDownLink( $folder, "Initial Contact", "/contact.php" );
        $contact_us->addDropDownLink( $folder, "Contact Information", "/contact.php" );
        $links[$n++] = $contact_us;
        
        //GET STARTED
        $get_started = new Uplinks( $folder, 0, 0, "Get Started", "/contact.php" );
        $get_started->addDropDownLink( $folder, "How it Works", "/contact.php" );
        $get_started->addDropDownLink( $folder, "Tutoring", "/tutoring.php" );
        $links[$n++] = $get_started;

        //RATES
        $links[$n++] = new Uplinks( $folder, 0, 0, "Rates", "/rates.php" );

        //HOURS
        $links[$n++] = new Uplinks( $folder, 0, 0, "Hours", "/logistics.php" );

        //CAREERS
        $links[$n++] = new Uplinks( $folder, 0, 0, "Careers", "/apply.php" );

        break;

	}

	return ( $links );
}

function generate_navbar( $links = "" ) {
    
    if( is_string( $links ) ) $links = get_top_links2( $links );

    ?>
        <ul class="navbar2014">
    <?

    //add one to sizeof links because $n is 1
    for( $n=1; $n < ( sizeof( $links ) + 1 ); $n++ ) {

        printLink( $links[ $n ] );

    }
    
    ?>
            <li class="spacer" style="float: right;">&nbsp;</li>
        </ul>
    <?
}

function printLink( $link, $print_drop_down_parent = false ) {

    if( $print_drop_down_parent ) {

        ?>
            <li><a href="<?=$link->link?>"> <?=$link->label ?> </a>
        <?

        return false;

    }

    if( !$link->is_in_drop_down ) {

        ?>
            <li class="spacer">&nbsp;</li>
        <?

    }

    if( $link->is_drop_down ) {

        printLink( $link, true )

        ?> <ul> <?

        for( $n=0; $n < ( sizeof( $link->drop_down_links ) ); $n++ ) {

            $dropdown = $link->drop_down_links[ $n ];
            printLink( $dropdown );

        } 

        ?> </ul> 
        </li> <?

    } else {

        ?>
            <li><a href=" <?=$link->link ?> "> <?=$link->label ?> </a></li>
        <?

    }

}

?>
