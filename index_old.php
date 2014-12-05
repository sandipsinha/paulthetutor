<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Paul the Tutor's Education Center", $strAbsPath, "", "");
?>

<div class="content_box" id="home-page">

<!--Begin Left Column -->
<div class="twocol-left">

<a href="parents/fam_register.php" class="left_nav" id="register-button">Register</a>
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
    <li><a href="speaking.php">Hear Paul Speak</a></li>
</ul>


<a id="bpn-rec" href="http://bit.ly/nZzyZB" title="See what they have to say about us!">The Berkeley Parents Network Recommends Us</a>
<div id="testimonial">
<p class="align-center"><a class="testimonial" href="/testimonials.php">
<?php random_testimonial();?>
</a>
</div><!-- End Testimonial-->
<div id="read_testimonials"><a href="/testimonials.php">Read all Testimonials</a></div>
<div id="yelp">

<?php require_once('yelp.php'); ?>

</div> <!--End Yelp Review -->


<div id="book">
<p class="center-text">

<a href="http://www.amazon.com/Study-Guide-Ed-M-Paul-Osborne/dp/159257887X/ref=tag_stp_st_edpp_url" target="_book">
<img class="align-center" src="images/book.png" alt="LD SAT Study Guide: Test Prep and Strategies for Students with Learning Disabilities" title="Buy on Amazon" />
</a>

The only <strong>SAT prep</strong> manual<br />for student with<br /><strong>learning disabilities</strong></p>
</div><!--End Book -->
</div><!--End Left Column -->

<div class="twocol-main">

<h1 class="center-text">
<img style="margin-bottom:10px;" src="/images/main-page-header.png" alt="Tutoring and test preparation services for students with learning disabilities and non-traditional students" />
<img src="/images/students-studying.jpg" alt="Students at Paul the Tutor's Education Center" />
</h1>

</div>

<br class="clear" />

</div><!-- End Content-box -->

<?
put_ptts_footer("");

?>
