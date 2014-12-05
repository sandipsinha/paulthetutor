<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="unawIL1y5LuUsTZ1mQiUnNzCruL_L1mktNdyqCjBQIg" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="keywords" content="Tutoring, LD tutoring, Learning Disability, Learning Disability SAT, LD SAT, SAT, SAT Prep, LD SAT Prep, LD Test Prep, LD SAT Tutoring" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Paul the Tutor's Education Center</title>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.7.0/build/cssreset/cssreset-min.css" />
<link href="includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script src="includes/js_files/slides.min.jquery.js"></script>
<script type="text/javascript" src="includes/js_files/ddaccordion.js">

/***********************************************
* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/

</script>
<script type="text/javascript">
//Initialize first demo:
ddaccordion.init({
	headerclass: "accordion_header", //Shared CSS class name of headers group
	contentclass: "accordion_section", //Shared CSS class name of contents group
	revealtype: "mouseover", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content.
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	scrolltoheader: false, //scroll to header each time after it's been expanded by the user?
	persiststate: false, //persist state of opened contents within browser session?
	toggleclass: ["", "openpet"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["none", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

</script>
<script type="text/javascript">
    $(function(){
		
			$("#accordion").bind('mouseleave', function()
			{
				ddaccordion.collapseall("accordion_header");
			});
    	
		$("#slides").slides({
			preload: true,
				slideSpeed: 2000, 
				preloadImage: 'includes/images/loading.gif',
				play: 5000,
				pause: 2000,
				hoverPause: true,
				animationStart: function(current){
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
				}
		});
    });
	
</script>

</head>

<body>
<div class="page_container">
    <div class="header">
    	<div class="login_info">
        	<ul>
            	<li id="register_link"><a href="parents/">Register</a></li>
                <li id="login_link"><a href="login.php">Login</a></li>
                <li id="start_link"><a href="start.php">Get Started</a></li>
	            <li id="pay_link"><a href="https://www.paulthetutors.com/ccpay/">Pay your bill</a></li>
            </ul>
        </div>
    	<div class="logo_container">
            <a href="http://www.paulthetutors.com"><img src="includes/images/logo.png" alt="Paul the Tutor's Education Center Logo" class="logo"></a>
            <span class="quick_contact_info">
                <p>(510) 730-0390</p>
                <p>4235 Piedmont Ave.</p>
                <p>Oakland, CA 9461</p>
            </span>
        </div>
      <div class="main_menu">
        	<ul>
                <li class="spacer">&nbsp;</li>
            	<li><a href="#">HOME</a></li>
                <li class="spacer">&nbsp;</li>
            	<li><a href="tutoring.php">TUTORING</a>
                	<ul>
                    	<li><a href="mathscience.php">Math and Science</a></li>
                        <li><a href="enghist.php">English and History</a></li>
                        <li><a href="testprep.php">Test Prep</a></li>
                    </ul>
                </li>
                <li class="spacer">&nbsp;</li>
                <li><a href="testprep.php">TEST PREP</a>
                	<ul>
                    	<li><a href="satprep.php">SAT Prep</a></li>
                        <li><a href="actprep.php">ACT Prep</a></li>
                        <li><a href="hsex.php">SSAT/ISEE/HSPT</a></li>
                    </ul>
                </li>
                <li class="spacer">&nbsp;</li>
                <li><a href="ld.php">LOCATIONS</a>                
                	<ul>
                    	<li><a href="piedmont.php">Piedmont</a></li>
                        <li><a href="lafayette.php">Berkeley</a></li>
                        <li><a href="san_mateo.php">San Mateo</a></li>
                        <li><a href="berkeley.php">Lafayette</a></li>
                        <li><a href="davis.php">Davis</a></li>
                    </ul>
                </li>
                <li class="spacer">&nbsp;</li>
                <li><a href="ld.php">LEARNING DIFFERENCES</a></li>
                <li class="spacer">&nbsp;</li>
                <li><a href="#">ABOUT US</a>
                	<ul>
                    	<li><a href="paul.php">Paul the Tutor</a></li>
                        <li><a href="tutors.php">The Tutors</a></li>
                        <li><a href="whyus.php">Why Us?</a></li>
                        <li><a href="howitworks.php">How it Works</a></li>
                        <li><a href="locations.php">Locations</a></li>
                        <li><a href="rates.php">Rates</a></li>
                        <li><a href="hours.php">Hours</a></li>
                    </ul>
                </li>
                <li class="spacer">&nbsp;</li>
                <li><a href="contact.php">CONTACT US</a>
                      <ul>
                    	<li><a href="initial_contact.php">Initial Contact</a></li>
                        <li><a href="contact.php">Contact Information</a></li>
                      </ul>         
                </li>
                <li class="spacer">&nbsp;</li>
                <li><a href="get_started.php">GET STARTED</a></li>
				<li class="spacer">&nbsp;</li>
                <li><a href="#">RATES</a></li>
				<li class="spacer">&nbsp;</li>
                <li><a href="#">HOURS</a></li>
                <li class="spacer">&nbsp;</li>
            </ul>
        </div>
        
    </div>
    <div class="main_container">
        <div class="nav_bar">
            <p class="Head2_Green">Locations</p>
            <div id="accordion">      	
            
                <h3 class="accordion_header"><a href="piedmont.htm" class="nav_bar_ac_title">Piedmont - Main</a></h3>
                <div class="accordion_section">
                    <ul>
                        <li>4235 Piedmont Ave.<br />
                          Oakland, CA 94611 (<a href="https://maps.google.com/maps?q=4235+piedmont+ave.+oakland+ca&amp;ie=UTF-8&amp;hq=&amp;hnear=0x80857df6c5ebab8b:0xe0aa769b143fc95d,4235+Piedmont+Ave,+Oakland,+CA+94611&amp;gl=us&amp;ei=AqSJUNOuBpCUigLtrYDoCQ&amp;ved=0CCAQ8gEwAA" target="_blank">map</a>)</li>
                          <li>
                          (510) 730-0390</li>
                      <LI><a href="logistics.php#piedmont">More Information</a></li>
                     </ul>
                </div>
                
                <h3 class="accordion_header"><a href="lafayette.php" class="nav_bar_ac_title">Lafayette</a></h3>
                <div class="accordion_section">
                    <ul>
                        <li>91 Lafayette Circle</li>
                        <li>Lafayette, CA 94549 (<a href="https://maps.google.com/maps?oe=&amp;q=91+Lafayette+cir+lafayette+ca&amp;ie=UTF-8&amp;hq=&amp;hnear=0x8085625affc008b9:0xf56d238c15bdec5e,91+Lafayette+Cir,+Lafayette,+CA+94549&amp;gl=us&amp;ei=l6CJUJDLNIK3iwL8xYEY&amp;ved=0CCQQ8gEwAA" target="_blank">map</a>)</li>
                        <li>(510) 730-0390</li>
                        <li><a href="lafayette.php">More Informaiton</a></li>
                        <li></li>
                    </ul>
                </div>
                
                <h3 class="accordion_header"><a href="berkeley.htm" class="nav_bar_ac_title">Berkeley</a></h3>
                <div class="accordion_section">
                    <ul>
                        <li>Discounted In-Home Tutoring</li>
                        <li>Starting at $65/hr (<a href="rates.php#berkeley">rates</a>) </li>
                      
                        <li>(510) 730-0390</li>
                        <li><a href="berkeley.php">More Information</a></li>
                      
                  </ul>
                </div>

              <h3 class="accordion_header"><a href="pen.htm" class="nav_bar_ac_title">San Mateo</a></h3>
                <div class="accordion_section">
                    <ul>
                        <li>161 W. 25th Ave. #205</li>
                        <li> San Mateo, CA 94403 (<a href="http://maps.google.com/maps?q=161+W.+25th+St.+San+Mateo,+CA+94403&amp;um=1&amp;ie=UTF-8&amp;sa=X&amp;ei=xOUKUZmVDImJiwK6jIDYCg&amp;ved=0CAsQ_AUoAA" target="_blank">map</a>)</li>
                        <li>650-918-0970 </li>
                        <li><a href="peninsula.php">More Information</a></li>
                        <li></li>
                  </ul>
                </div>
                
                <h3 class="accordion_header"><a href="davis.htm" class="nav_bar_ac_title">Davis</a></h3>
                <div class="accordion_section">
                    <ul>
                        <li></li>
                        <li>Special Rate - $40/hr (<a href="logistics.php">rates</a>)</li>
                        <li><a href="davis.php">More Information</a></li>
                        
                    </ul>
                 </div>
                 
                <h3 class="accordion_header"><a href="online.htm" class="nav_bar_ac_title">Online</a></h3>
                <div class="accordion_section">
                    <ul>
                        <li><a href="distance.php">How it Works</a></li>
                        <li></li>
                        <li>Online Rates - $60/hr (<a href="logistics.php">rates</a>)</li>
                     </ul>
                </div>
            </div>
            <p>&nbsp;</p>
          <p>
          <hr> 
           <p class="Head2_Green">Testimonials</p>         
         

            <span class="left_bar_test"> <div id="yelp"><a target="_blank" href=http://www.yelp.com/biz/paul-the-tutors-education-center-oakland><img src='/images/yelp-logo.jpg' /><img class='stars' src=http://s3-media1.ak.yelpcdn.com/assets/2/www/img/f1def11e4e79/ico/stars/v1/stars_5.png alt='Yelp 5 Stars' title='Read what people are saying about us on Yelp!' /></a>
          </div> 
          <!--End Yelp Review -->
          <br />
          <p class="BPN"><a href="http://www.google.com/cse?cx=003626926757047839349:pskr98qzpuk&amp;cof=FORID:0&amp;q=%22paul+the+tutor%22&amp;sa=Search+BPN#gsc.tab=0&amp;gsc.q=%22paul%20the%20tutor%22&amp;gsc.page=1" target="_blank">Berkeley Parents Network</a></p>
            <p class="left_bar_test">Read the BPN Love (<a href="http://www.google.com/cse?cx=003626926757047839349:pskr98qzpuk&amp;cof=FORID:0&amp;q=%22paul+the+tutor%22&amp;sa=Search+BPN#gsc.tab=0&amp;gsc.q=%22paul%20the%20tutor%22&amp;gsc.page=1" target="_blank">click here</a>)</p>
                                </span>

          <hr> 
          <br /> <table class="get_started_left" style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="199">
              <!-- fwtable fwsrc="get_started.png" fwpage="Page 1" fwbase="get_started.jpg" fwstyle="Dreamweaver" fwdocid = "1580965677" fwnested="0" -->
              <tr>
                <td><img src="images/spacer.gif" alt="" name="undefined_2" width="199" height="1" id="undefined_2" border="0" /></td>
                <td><img src="images/spacer.gif" alt="" name="undefined_2" width="1" height="1" id="undefined_2" border="0" /></td>
              </tr>
              <tr>
                <td><img name="get_started_r1_c1" src="images/get_started_r1_c1.jpg" width="199" height="86" border="0" id="get_started_r1_c1" usemap="#m_get_started_r1_c1" alt="" /></td>
                <td><img src="images/spacer.gif" alt="" name="undefined_2" width="1" height="86" id="undefined_2" border="0" /></td>
              </tr>
              <tr>
                <td><img name="get_started_r2_c1" src="images/get_started_r2_c1.jpg" width="199" height="10" border="0" id="get_started_r2_c1" alt="" /></td>
                <td><img src="images/spacer.gif" alt="" name="undefined_2" width="1" height="10" id="undefined_2" border="0" /></td>
              </tr>
          </table>
            <map name="m_get_started_r1_c1" id="m_get_started_r1_c1">
              <area shape="poly" coords="0,0,-1,57,116,59,140,86,163,83,162,58,198,56,197,2,197,2" href="get_started.php" alt="" />
            </map>
<p>&nbsp;</p>
        </div>
        <div class="main_content">

<link href="includes/paulthetutors.css" rel="stylesheet" type="text/css">

<div align="center">

<table width="610" border="0">
<tr>
<td>
<hr size="2" color="black">
<div align="center"><span class="Head1">LD SAT Prep</span></div>
<hr size="1" color="black">

		<table width="100%" border="0" cellpadding="10">
		<TR><td align="right" width="40%">
		<a href="http://www.amazon.com/Study-Guide-Ed-M-Paul-Osborne/dp/159257887X/ref=tag_stp_st_edpp_url" target="_book"><img src="images/ldsat_cover_108_pix.jpg" alt="LD SAT Test Prep Book" width="100" height="126.4" border="0"></a>
		</td>
		<td>
		<span class="Head2_Green">Register for Test Prep Class</span><br> (<a href="testprepreg.php">Click Here</a>)
		<p>
		<span class="Head2_Green">See the Schedule of Available Classes</span> <br>(<a href="http://www.paulthetutors.com/satclassdates.php">Click Here</a>)



		<span class="Head2_Green"><!Interested in a FREE SAT Prep Seminar?></span> <!br><a href="http://www.paulthetutor.com/ldsatsem.php"><!Click Here></a>        
		<p>		<span class="Head2_Green">SAT Prep at Serra High School</span>          <br>
          (<a href="http://www.serrahs.com/page.cfm?p=2505" target="_blank">Click Here</a>) 
		</td></tr>
		</table><br>


<span class="Head2_Green">Test Prep Classes</span><br>

Paul the Tutor's is known for providing quality SAT Preparation to students with learning disabilities.  Paul has tutored students who learn differently for over 20 years, and received an Ed.M. in Cognition from the Harvard Graduate School of Education. As a dyslexic test taker himself, Paul understands the unique challenges LD students face.  He and his staff work closely with students to help them overcome these challenges and reach their target score on test day.
<p>
Students gain exposure to real SAT tests and questions while following a curriculum based on Paul's LD SAT Prep Study Guide, the only SAT manual designed for students with learning disabilities.  Tutors provide disability-specific advice for tackling each SAT section and teach strategies for students with extended time. 


<p>
<ul><strong>Classes include:</strong>
<li>Curriculum based on the <a href="http://www.amazon.com/Study-Guide-Ed-M-Paul-Osborne/dp/159257887X/ref=tag_stp_st_edpp_url" target="_book">
    LD SAT Study Guide</a> by Paul Osborne</li>
<li>More than 12 real SAT Practice tests</li>
<li>Unlimited Practice problems</li>
<li>At least 2 proctored exams with extended or traditional time</li>
<li>Taught by Paul and his trained instructors </li>
</ul>

<br>
<hr>
<br>

<span class="Head2_Green">Current LD SAT Prep classes and rates:</span>

<ul><strong>Private Tutoring</strong>
<li>Suggested 12 to 24 hours of instruction</li>
<li>Proctored exams taken with other students</li>
<li>$85 per hour with our trained instructors</li>
<li>$185 per hour with Paul the Tutor </li>
</ul>

<ul><strong>Full Class</strong>
<li>8 to 12 students</li>
<li> 25 - 35 hours of prep time and proctored exams</li>
<li>$549 - 699 (varies depending on class) </li>
</ul>

</td>
</tr>
</table>
<?
put_footer_2013();

?>
