<?php 
    include "get_top_links.php";

/***********************************************************************
funtion put header for paulthetutors.com 2014
***********************************************************************/
function put_header_2014($page_title="Paul the Tutor's Education Center", $strBack=NULL, $folder=NULL,$other=NULL){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="unawIL1y5LuUsTZ1mQiUnNzCruL_L1mktNdyqCjBQIg" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="keywords" content="Tutoring, LD tutoring, Learning Disability, Learning Disability SAT, LD SAT, SAT, SAT Prep, LD SAT Prep, LD Test Prep, LD SAT Tutoring" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$page_title;?></title>
<link href="includes/css_files/styles_main_2014.css" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script src="includes/js_files/slides.min.jquery.js"></script>
<script type="text/javascript" src="includes/js_files/ddaccordion.js">

<?php if( $other != "popup" ):  ?>

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
<script>
    $(function(){
		
			$("#accordion").bind('mouseleave', function()
			{
				ddaccordion.collapseall("accordion_header");
			});
</script>
<style type="text/css">
  /** some pages have tables with widths=800px, this overwrites
  those styles and makes sure the table fits in the page**/
  table {
    width: 100% !important;
  }
</style>

<style type="text/css">

td img {display: block;}td img {display: block;}
</style>
</head>

<body>
<div class="page_container">
    <div class="header">
    	<div class="login_info">
        	<ul>
            	<li id="register_link"><a href="parents/">Register</a></li>
                <li id="login_link"><a href="login.php">Login</a></li>
	            <li id="pay_link"><a href="https://www.paulthetutors.com/ccpay/">Pay your bill</a></li>
                <li id="start_link"><a href="start.php">Get Started</a></li>
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

        <!-- NAVBAR start -->
      <div class="main_menu">

          <?php $links = get_top_links2( "index_2012" ); 
          generate_navbar( $links ); ?>

      </div>
      <!-- NAVBAR end -->
        
    </div>
    <div class="main_container">
        <div class="nav_bar" style="width: 150px;" >
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
                        <li><a href="sanmat.php">More Information</a></li>
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
            <p>&nbsp;</p>
          <p>
          <hr> 
           <p class="Head2_Green">Testimonials</p>         
         

            <span class="left_bar_test"> <div id="yelp"><a target="_blank" href=http://www.yelp.com/biz/paul-the-tutors-education-center-oakland><img src='/images/yelp-logo.jpg' /><img class='stars' src=http://s3-media1.ak.yelpcdn.com/assets/2/www/img/f1def11e4e79/ico/stars/v1/stars_5.png alt='Yelp 5 Stars' title='Read what people are saying about us on Yelp!' /></a>
          </div> 
          <!--End Yelp Review -->
          <br />
          <p class="BPN"><a href="http://www.google.com/cse?cx=003626926757047839349:pskr98qzpuk&amp;cof=FORID:0&amp;q=%22paul+the+tutor%22&amp;sa=Search+BPN#gsc.tab=0&amp;gsc.q=%22paul%20the%20tutor%22&amp;gsc.page=1" target="_blank">Berkeley Parents Network</a></p>
            <p class="left_bar_test">
              <a href="http://www.google.com/cse?cx=003626926757047839349:pskr98qzpuk&amp;cof=FORID:0&amp;q=%22paul+the+tutor%22&amp;sa=Search+BPN#gsc.tab=0&amp;gsc.q=%22paul%20the%20tutor%22&amp;gsc.page=1" target="_blank">Read the BPN Love </a></p>
                                </span>

          <hr> 
          <br /> 

<img name="get_started_r1_c1" src="images/get_started_r1_c1.gif" 
  width="150" height="86" border="0" id="get_started_r1_c1" usemap="#get_started_r1_c1" alt="" />

<map name="get_started_r1_c1" id="get_started_r1_c1">
  <area shape="poly" coords="0,0,150,86" href="get_started.php" alt="" />
</map>

<p>&nbsp;</p>
        </div>

<div class="content_wrapper">

<?php else: //close button for pop ups ?>

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr><td align="right">
    &nbsp;&nbsp;<button onClick="popup_close()">Close</button>

<?php endif; ?>

<? } // end put_header_2014 ?>

<?
/***********************************************************************
funtion put footer
***********************************************************************/
function put_footer_2014($other="not pop up"){
?>  
    </div> <!-- end .main_content -->
  </div> <!-- end .main_container -->

  <!-- Footer 2014-->
  </td></tr>
   <tr>
    <td height="5" align="left" valign="top"></td>
    </tr>
<?
if ($other!='popup'){
?>
  <!--Footer-->  
    <div class="footer">
      <div class="motto_container">
          <q id="tutoring">Since 1991</q><q>Not just better grades... better thinkers</q>
        </div>
        <div><a href="#">privacy policy</a> &nbsp;- &nbsp;
          <a href="#">contact us</a> &nbsp;- &nbsp;
            <a href="#">cancelation/return policy</a> 
        </div>
    </div>
    <!--Footer-->   
<? } else { //yet another close button for popups ?>

&nbsp;&nbsp;<td align="right"><button onClick="popup_close()">Close</button>

<? }?> 
  </td>
    </tr>
  </table>
  </body>
  </html>
<?
} // end put_ptts_footer
?>