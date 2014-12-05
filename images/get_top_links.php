<?
    //this file holds UPlinks object class
    include "uplinks_class.php";

/***********************************************************************
funtion get_top_links2

$links[0] = new Uplinks( $folder, 0, 0, "", FULL_BASE_PATH.".php" );
Uplinks( folder name, position in navbar, position in dropdown menu, label, link );
***********************************************************************/
function get_top_links2( $folder ) {
	$links = array();

	switch( $folder ) {
    case "admin":
    //     $links[1][0] = FULL_BASE_PATH."/admin/index.php";
    // $links[1][1] = "Admin Home";
    //     $links[2][0] = FULL_BASE_PATH."/admin/calendar_action.php";
    // $links[2][1] = "Calendar";
    // $links[3][0] = FULL_BASE_PATH."/admin/billing.php";
    // $links[3][1] = "Accounting";
    //     $links[4][0] = FULL_BASE_PATH."/admin/showbills_new.php";
    // $links[4][1] = "Show Bills";
    //     $links[5][0] = FULL_BASE_PATH."/admin/sendbills_new.php";
    // $links[5][1] = "Send Bills";
    //     $links[6][0] = FULL_BASE_PATH."/admin/families.php";
    // $links[6][1] = "Families";
    //     $links[7][0] = FULL_BASE_PATH."/admin/tutorsinfo.php";
    // $links[7][1] = "Tutors";
    // $links[8][0] = FULL_BASE_PATH;
    //         $links[8][1] = "Paul the Tutor's";
            
        $links[1] = new Uplinks( $folder, 1, 0, "Admin Home", FULL_BASE_PATH."/admin/index.php" );
        $links[2] = new Uplinks( $folder, 2, 0, "Calendar", FULL_BASE_PATH."/admin/calendar_action.php" );
        $links[3] = new Uplinks( $folder, 3, 0, "Accounting", FULL_BASE_PATH."/admin/billing.php" );
        $links[4] = new Uplinks( $folder, 4, 0, "Show Bills", FULL_BASE_PATH."/admin/showbills_new.php" );
        $links[5] = new Uplinks( $folder, 5, 0, "Show Bills", FULL_BASE_PATH."/admin/sendbills_new.php" );
        $links[6] = new Uplinks( $folder, 6, 0, "Families", FULL_BASE_PATH."/admin/families.php" );
        $links[7] = new Uplinks( $folder, 7, 0, "Tutors", FULL_BASE_PATH."/admin/tutorsinfo.php" );
        $links[8] = new Uplinks( $folder, 8, 0, "Paul the Tutor's", FULL_BASE_PATH."FULL_BASE_PATH.php" );
        break;

    case "parents":
    //     $links[1][0] = FULL_BASE_PATH.$folder."/index.php";
    // $links[1][1] = "Paul the Tutor's";
    //     $links[2][0] = FULL_BASE_PATH."/parents";
    // $links[2][1] = "Parent's Home";
    //     $links[3][0] = FULL_BASE_PATH."/parents/viewbill.php";
    // $links[3][1] = "Accounting";
    //     $links[4][0] = FULL_BASE_PATH."/parents/edit_info_full.php";
    // $links[4][1] = "Edit Information";
    //     $links[5][0] = "tutorsinfo.php";
    // $links[5][1] = "Tutor's Info";
    //     $links[6][0] = FULL_BASE_PATH."/parents/login_parents.php?logout=1";
    // $links[6][1] = "Log Out";
    //     $links[7][0] = FULL_BASE_PATH."/contact.php";
    // $links[7][1] = "Book a Session";
    //     $links[8][0] = FULL_BASE_PATH."/contact.php";
    // $links[8][1] = "Contact Us";
    

        $links[1] = new Uplinks( $folder, 1, 0, "Paul the Tutor's", FULL_BASE_PATH."/index.php" );
        $links[2] = new Uplinks( $folder, 2, 0, "Parent's Home", FULL_BASE_PATH."parents.php" );
        $links[3] = new Uplinks( $folder, 3, 0, "Accounting", FULL_BASE_PATH."/parents/viewbill.php" );
        $links[4] = new Uplinks( $folder, 4, 0, "Edit Information", FULL_BASE_PATH."/parents/edit_info_full.php" );
        $links[5] = new Uplinks( $folder, 5, 0, "Tutor's Info", "tutorsinfo.php" );
        $links[6] = new Uplinks( $folder, 6, 0, "Log Out", FULL_BASE_PATH."/parents/login_parents.php?logout=1.php" );
        $links[7] = new Uplinks( $folder, 7, 0, "Book a Session", FULL_BASE_PATH."/contact.php" );
        $links[8] = new Uplinks( $folder, 8, 0, "Contact Us", FULL_BASE_PATH."/contact.php" );

        break;

    case "tutors":
    //     $links[1][0] = "index_tutors.php";
    // $links[1][1] = "Tutors' Home";
    //     $links[2][0] = "calendar_action.php";
    // $links[2][1] = "Calendar";
    //     $links[3][0] = "show_bills.php";
    // $links[3][1] = "Month's Sessions";
    //     $links[4][0] = "comments_inprogress.php";
    // $links[4][1] = "Notes";
    //     $links[8][0] = FULL_BASE_PATH."/tutors/tutlogin.php?logout=1";
    // $links[8][1] = "Log Out";
    //     $links[6][0] = FULL_BASE_PATH."/tutors/schedules.php";
    // $links[6][1] = "Schedules";
    //     $links[7][0] = FULL_BASE_PATH."/tutors/work_hours_list.php";
    // $links[7][1] = "Non-tutoring";
    //     $links[5][0] = FULL_BASE_PATH."/contact.php";
    // $links[5][1] = "Contact Us";


        $links[1] = new Uplinks( $folder, 1, 0, "Tutors' Home", "index_tutors.php" );
        $links[2] = new Uplinks( $folder, 2, 0, "Calendar", "calendar_action.php" );
        $links[3] = new Uplinks( $folder, 3, 0, "Month's Session", "show_bills.php" );
        $links[4] = new Uplinks( $folder, 4, 0, "Notes", "comments_inprogress.php" );
        $links[5] = new Uplinks( $folder, 5, 0, "Log Out", FULL_BASE_PATH."/tutors/tutlogin.php?logout=1.php" );
        $links[6] = new Uplinks( $folder, 6, 0, "Schedules", FULL_BASE_PATH."/tutors/schedules.php" );
        $links[7] = new Uplinks( $folder, 7, 0, "Non-tutoring", FULL_BASE_PATH."/tutors/work_hours_list.php" );
        $links[8] = new Uplinks( $folder, 8, 0, "Contact Us", FULL_BASE_PATH."/contact.php" );
        break;
        
    case "ldsatadmin":
        // $links[1][0] = "index.php";
        // $links[1][1] = "Test Prep Admin";
        // $links[2][0] = "get_grsec.php";
        // $links[2][1] = "Score Section";
        // $links[3][0] = "get_grtest.php";
        // $links[3][1] = "Score Test";
        // $links[4][0] = "score_sum.php";
        // $links[4][1] = "Result Summary";
        // $links[5][0] = "standardized_tests.php";
        // $links[5][1] = "Tests' Info";
        // $links[6][0] = "gettestinfo.php";
        // $links[6][1] = "New Test";
        // $links[7][0] = "class_rosters.php";
        // $links[7][1] = "Classes";
        // $links[8][0] = "homework.php";
        // $links[8][1] = "Homework";

        $links[1] = new Uplinks( $folder, 1, 0, "Test Prep Admin", "index.php" );
        $links[2] = new Uplinks( $folder, 2, 0, "Score Section", "get_grsec.php" );
        $links[3] = new Uplinks( $folder, 3, 0, "Score Test", "get_grtest.php" );
        $links[4] = new Uplinks( $folder, 4, 0, "Results Summary", "score_sum.php" );
        $links[5] = new Uplinks( $folder, 5, 0, "Tests' Info", "standardized_tests.php" );
        $links[6] = new Uplinks( $folder, 6, 0, "New Test", "gettestinfo.php" );
        $links[7] = new Uplinks( $folder, 7, 0, "Classes", "class_rosters.php" );
        $links[8] = new Uplinks( $folder, 8, 0, "Homework", "homework.php" );
        break;

    case "students":
        // $links[1][0] = "index.php";
        // $links[1][1] = "My Homepage";
        // $links[2][0] = "homework.php";
        // $links[2][1] = "Homework";
        // $links[3][0] = "get_grsec.php";
        // $links[3][1] = "Score A Section";
        // $links[4][0] = "get_grtest.php";
        // $links[4][1] = "Score A Test";
        // $links[5][0] = "ans_grader.php";
        // $links[5][1] = "Results Summary";
        // $links[6][0] = "get_grsec.php?action=ans_grader.php";
        // $links[6][1] = "Test Results";
        // $links[7][0] = "get_grsec.php?action=ans_grader.php";
        // $links[7][1] = "Sec Results";
        // $links[8][0] = "login.php?logout=1";
        // $links[8][1] = "Log Out";

        $links[1] = new Uplinks( $folder, 1, 0, "My Homepage", "index.php" );
        $links[2] = new Uplinks( $folder, 2, 0, "Homework", "homework.php" );
        $links[3] = new Uplinks( $folder, 3, 0, "Score A Section", "get_grsec.php" );
        $links[4] = new Uplinks( $folder, 4, 0, "Score A Test", "get_grtest.php" );
        $links[5] = new Uplinks( $folder, 5, 0, "Results Summary", "ans_grader.php" );
        $links[6] = new Uplinks( $folder, 6, 0, "Test Results", "get_grsec.php?action=ans_grader.php" );
        $links[7] = new Uplinks( $folder, 7, 0, "Sec Results", "get_grsec.php?action=ans_grader.php" );
        $links[8] = new Uplinks( $folder, 8, 0, "Log Out", "login.php?logout=1.php" );
        break;

    /**
    default:
        // $links[1][0] = FULL_BASE_PATH."/index.php";
        // $links[1][1] = "Home";
        //     $links[2][0] = FULL_BASE_PATH."/services.php";
        // $links[2][1] = "Services";
        //     $links[3][0] = FULL_BASE_PATH."/newparents.php";
        // $links[3][1] = "Parents";
        //     $links[4][0] = FULL_BASE_PATH."/locations.php";
        // $links[4][1] = "Locations";
        // if (stristr($_SERVER['PHP_SELF'], "index")){
        //        $links[5][0] = FULL_BASE_PATH."/faq.php";
        // $links[5][1] = "FAQ";
        // }else{
        // $links[5][0] = FULL_BASE_PATH."/aboutus.php";
        // $links[5][1] = "About Us";
        // }
        //     $links[6][0] = FULL_BASE_PATH."/login.php";
        // $links[6][1] = "Login";
        //     $links[7][0] = FULL_BASE_PATH."/contact.php";
        // $links[7][1] = "Book a Session";
        //     $links[8][0] = FULL_BASE_PATH."/contact.php";
        // $links[8][1] = "Contact Us";

        $links[1] = new Uplinks( $folder, 1, 0, "Home", FULL_BASE_PATH."/index.php" );
        $links[2] = new Uplinks( $folder, 2, 0, "Services", FULL_BASE_PATH."/services.php" );
        $links[3] = new Uplinks( $folder, 3, 0, "Parents", FULL_BASE_PATH."/newparents.php" );
        $links[4] = new Uplinks( $folder, 4, 0, "Locations", FULL_BASE_PATH."/locations.php" );

        if (stristr($_SERVER['PHP_SELF'], "index")){
        
            $links[5] = new Uplinks( $folder, 5, 0, "FAQ", FULL_BASE_PATH."/faq.php" );
        
        } else {

            $links[5] = new Uplinks( $folder, 5, 0, "About Us", FULL_BASE_PATH."/aboutus.php" );

        }

        $links[6] = new Uplinks( $folder, 6, 0, "Login", FULL_BASE_PATH."/login.php" );
        $links[7] = new Uplinks( $folder, 7, 0, "Book a Session", FULL_BASE_PATH."/contact.php" );
        $links[8] = new Uplinks( $folder, 8, 0, "Contact Us", FULL_BASE_PATH."/contact.php" );
        break;
**/

    //links for index_2012 navbar
	default:
        $n = 1;
        $links[$n++] = new Uplinks( $folder, 0, 0, "HOME", "/index.php" );
        
        //tutoring dropdown
        $links[$n++] = new Uplinks( $folder, 1, 0, "TUTORING",  "/tutoring.php" );
        $links[$n++] = new Uplinks( $folder, 1, 2, "Math and Science",  "/services.php#MathAndScience" );
        $links[$n++] = new Uplinks( $folder, 1, 3, "English and History",  "/services.php#EnglishAndHistory" );
        $links[$n++] = new Uplinks( $folder, 1, 4, "Test Prep",  "/services.php#Test Prep" );
        
        //test prep dropdown
        $links[$n++] = new Uplinks( $folder, 2, 0, "TEST PREP", "/testprep.php" );
        $links[$n++] = new Uplinks( $folder, 2, 1, "SAT Prep", "/testprep.php" );
        $links[$n++] = new Uplinks( $folder, 2, 2, "ACT Prep", "/testprep.php" );
        $links[$n++] = new Uplinks( $folder, 2, 3, "SSAT/ISEE/HSPT", "/testprep.php" );
        
        //locations
        $links[$n++] = new Uplinks( $folder, 3, 0, "LOCATIONS", "/locations.php" );
        $links[$n++] = new Uplinks( $folder, 3, 1, "Piedmont", "/piedmont.php" );
        $links[$n++] = new Uplinks( $folder, 3, 2, "Berkeley", "/berkeley.php" );
        $links[$n++] = new Uplinks( $folder, 3, 3, "Peninsula", "/sanmat.php" );
        $links[$n++] = new Uplinks( $folder, 3, 4, "Lafayatte", "/lafayette.php" );
        $links[$n++] = new Uplinks( $folder, 3, 5, "Davis", "/davis.php" );

        $links[$n++] = new Uplinks( $folder, 4, 0, "LEARNING DIFFERENCES", "/lls_concept.php" );

        //ABOUT US Paul the Tutor The Tutors Why Us? How it Works Locations Rates Hours
        $links[$n++] = new Uplinks( $folder, 5, 0, "ABOUT US", "/aboutus.php" );
        $links[$n++] = new Uplinks( $folder, 5, 1, "Paul the Tutor", "/aboutus.php#Paul" );
        $links[$n++] = new Uplinks( $folder, 5, 2, "The Tutors", "/aboutus.php#Tutors" );
        $links[$n++] = new Uplinks( $folder, 5, 3, "Why us?", "/whyus.php" );
        $links[$n++] = new Uplinks( $folder, 5, 4, "How it Works", "/contact.php" );
        $links[$n++] = new Uplinks( $folder, 8, 5, "Rates", "/rates.php" );
        $links[$n++] = new Uplinks( $folder, 9, 6, "Hours", "/logistics.php" );

        //CONTACT US Initial Contact Contact Information 
        $links[$n++] = new Uplinks( $folder, 6, 0, "CONTACT US", "/contact.php" );
        $links[$n++] = new Uplinks( $folder, 6, 1, "Initial Contact", "/contact.php" );
        $links[$n++] = new Uplinks( $folder, 6, 2, "Contact Information", "/contact.php" );
        
        //GET STARTED
        $links[$n++] = new Uplinks( $folder, 7, 0, "GET STARTED", "/contact.php" );
        $links[$n++] = new Uplinks( $folder, 7, 1, "How it Works", "/contact.php" );
        $links[$n++] = new Uplinks( $folder, 7, 2, "Tutoring", "/tutoring.php" );

        //RATES
        $links[$n++] = new Uplinks( $folder, 8, 0, "RATES", "/rates.php" );

        //HOURS
        $links[$n++] = new Uplinks( $folder, 9, 0, "HOURS", "/logistics.php" );
        break;

	}

	return ( $links );
}

function generate_navbar( $links ) {
    
    ?>
        <ul class="navbar2014">
    <?

    for( $n=1; $n < ( sizeof( $links ) + 1 ); $n++ ): ?>
        
        <?php
        $link = $links[$n];
        if( $link->drop_position == 0 ): ?>

            <li class="spacer">&nbsp;</li>
            <li><a href="<?=$link->link?>"> <?=$link->label ?> </a>

            <?php if( $n+1 < sizeof( $links ) ): ?>
                <?php //check if the next link is in a dropdown menu ?> 
                <?php if( $links[$n+1]->drop_position != 0 ): ?>

                    <ul>

                        <?php for( $n = $n+1; $links[$n]->drop_position != 0; $n++ ): ?>

                            <?php $dropdown = $links[$n]; ?>
                            <li><a href=" <?=$dropdown->link ?> "> <?=$dropdown->label ?> </a></li> 

                        <?php endfor; 
                        $n--; ?>
                    
                    </ul>

                <?php endif; ?>
            <?php endif; ?>

            </li>

        <?php endif; ?>

    <?php endfor; ?>

            <li class="spacer" style="float: right;">&nbsp;</li>

        </ul>

    <?
}
?>
