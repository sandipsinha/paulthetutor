<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$arlinks = get_top_links($folder);
?>
<!DOCTYPE html>
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="google-site-verification" content="unawIL1y5LuUsTZ1mQiUnNzCruL_L1mktNdyqCjBQIg" />
  <meta http-equiv="pragma" content="no-cache">
 <meta name="keywords" content="Tutoring, LD tutoring, Learning Disability, Learning Disability SAT, LD SAT, SAT, SAT Prep, LD SAT Prep, LD Test Prep, LD SAT Tutoring" />
  <title>Paul the Tutor's Education Center</title>
  <link href="includes/paulthetutors_new_paul.css" rel="stylesheet" type="text/css">
  </head>
  <body>

<div class="page_wrapper">
<!--Start Top Banner -->  
<div class="top_banner">    
  <div class="header_bg">
<a id="logo-link" href="/"></a>
    <div class="header_right_txt">
    (510) 730-0390<br /> 
  4235 Piedmont Ave.<br />
  Oakland, CA 9461
  </div>
  </div>
  

<div >
    <ul id="top_links">
        <li><a href="index.php" >Home</a></li>
            <li class="navi_space"><img src="/images/navi_space.jpg" class="navi_space"  alt="space" /></li>
        <li><a href="services.php">Services</a><ul>
            <li><a href="tutoring.php">Tutoring</a></li><li>
            <a href="testprep.php">Test Prep</a></li><li>
            <a href="distance.php"><div class="text9pt">Distance Learning</div></a></li><li>
            <a href="ld.php"><div class="text9pt">Learning Disabilities</div></a></li><li></ul>
                
       
        </li>
            <li><img src="/images/navi_space.jpg" class="navi_space"  alt="space" /></li>
        <li><a  href="index.php">Why PtT's?</a><ul>
            <li><a href="tutoring.php">Tutoring</a></li><li>
            <a href="testprep.php">Test Prep</a></li><li>
            <a href="distance.php"><div class="text9pt">Distance Learning</div></a></li><li>
            <a href="ld.php"><div class="text9pt">Learning Disabilities</div></a></li><li>
            <a href="logistics.php">Rates</a></li><li>
            <a href="logistics.php">Locations</a></li><li>
            <a href="contact.php">Book A Session</a></li></ul>
                
        
        
        </li>
        
             <li><img src="/images/navi_space.jpg" class="navi_space"  alt="space" /></li>
       
        
        <li><a  href="index.php">Locations</a><ul>
            <li><a href="tutoring.php">Tutoring</a></li><li>
            <a href="testprep.php">Test Prep</a></li><li>
            <a href="distance.php"><div class="text9pt">Distance Learning</div></a></li><li>
            <a href="ld.php"><div class="text9pt">Learning Disabilities</div></a></li><li>
            <a href="logistics.php">Rates</a></li><li>
            <a href="logistics.php">Locations</a></li><li>
            <a href="contact.php">Book A Session</a></li></ul>
                
        
        
        </li>
        <li><img src="/images/navi_space.jpg" class="navi_space"  alt="space" /></li>
        
        <li><a  href="index.php">How it Works</a><ul>
            <li><a href="tutoring.php">Tutoring</a></li><li>
            <a href="testprep.php">Test Prep</a></li><li>
            <a href="distance.php"><div class="text9pt">Distance Learning</div></a></li><li>
            <a href="ld.php"><div class="text9pt">Learning Disabilities</div></a></li><li>
            <a href="logistics.php">Rates</a></li><li>
            <a href="logistics.php">Locations</a></li><li>
            <a href="contact.php">Book A Session</a></li></ul>
                
        
        
        </li>
                <li><img src="/images/navi_space.jpg" class="navi_space"  alt="space" /></li>
            <li><a  href="index.php">Contact Us</a></li>
        
        
            <li><img src="/images/navi_space.jpg" class="navi_space"  alt="space" /></li>
        <li><a href="Contacts">Book A Session</a>
         </li>

            
	</ul>
</div> <!--Top_links -->    

 </div>   
<!--End Top Banner --> 
<div class="clear">   </div>


<div class="content_box" id="home-page">

<!--Begin Left Column -->
<div class="twocol-left">

<a href="parents/fam_register.php" class="left_nav" id="register-button">Register</a>
<a href="login.php" class="left_nav" id="login-button">Log-In</a>
<a href="ccpay/" class="left_nav" id="pay-button">Pay Your Bill</a>

<h3 class="nav-title">Services</h3>

<ul class="left_nav" id="services">
    <li><a href="tutoring.php">Tutoring</a></li>
    <li><a href="testprep.php">Test Prep</a></li>
    <li><a href="distance.php">Distance Learning</a></li>
    <li><a href="orgcoaching.php">Study Skills</a></li>
</ul>

<h3 class="nav-title">About Us</h3>
<ul class="left_nav" id="about">
    <li><a href="aboutus.php">Who we are</a></li>
    <li><a href="whyus.php">Why Us</a></li>
    <li><a href="logistics.php">Rates, Hours, Location</a></li>
    <li><a href="/testimonials.php">Recommendations</a></li>
    <li><a href="speaking.php">Hear Paul Speak</a></li>
</ul>


<a id="bpn-rec" href="http://bit.ly/nZzyZB" title="See what they have to say about us!">Berkeley Parents Network Recommendations</a>
<?php 
// random_testimonial();
?>
<!-- End Testimonial-->
<div id="yelp">

<?php require_once('yelp.php'); ?>

</div> <!--End Yelp Review -->


</div><!--End Left Column -->

<div class="twocol-main">

<img style="margin-bottom:10px;" src="/images/main-page-header.png" alt="Tutoring and test preparation services for students with learning disabilities and non-traditional students" />
<img src="/images/students-studying.jpg" alt="Students at Paul the Tutor's Education Center" />

</div>

</div>

<div class="footer_box">

    <div class="footer_bg"><div class="footer_Not_Just" >Not Just Better Grades... Better Thinkers </div></div>
    


</div>
</div>    
<div class="footer_wrapper">
	    <div class="bottom_links"> <a href="privacy.php" target="_blank">privacy policy</a> | <a href="contact.php">contact us</a> | <a href="cancpolicy.php" target="_blank">cancelation/return policy</a></div>   

    <br /><div class="footer_txt"> &copy; 2010 Paul The Tutor's Education Center</div>
</div>

<!-- end footer-box -->
  </body>
  </html>