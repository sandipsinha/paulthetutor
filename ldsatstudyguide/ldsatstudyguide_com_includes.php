<?
$strAbsPath = "/home/paulth40/public_html";
include($strAbsPath . "/Paul13ToolBox/MySQL_functions.phtml");
include($strAbsPath . "/Paul13ToolBox/Paul13Includes.phtml");
include($strAbsPath . "/Paul13ToolBox/FormFunctions.phtml");

function ldssg_top($title, $blank){ 
// This is the top portion of the LDSATStudyGuide.com
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$title; ?></title>

<meta name="keywords" content="LDSAT Study Guide, SAT, learning disability SAT, learning disabilities, SAT, learning disability, learning disabilities, learning, disability, disability, Paul the Tutor, Paul Osborne, LD SAT Study Guide" />

<style type="text/css">
<!--
@import url("css/style.css");
.style1 {
	font-size: 18px;
	color: #FF0000;
}
-->
</style>
</head>
<!-- /* Coded by Ellen James patternext@gmail.com */ -->
<body>
 <div id="container">
   <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" id="tblContainer">
     <tr>
       <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
       <tr><td width="15"><img src="img/middle-left.gif" width="15" height="148" /></td>
         <td background="img/middle-middle.gif" valign="top">
		
		 <div id="logo"></div>
		 <div  id="bannerText" ></div>
		 <div id="bookPic"></div>
		
		 </td>
         <td width="15"><img src="img/middle-right.gif" width="15" height="148" border="0" /></td>
       </tr>
       <tr>
         <td><img src="img/middle-b-left.gif" width="15" height="80" /></td>
         <td align="left" valign="top" background="img/middle-b-middle.gif">
		 
		 <table border="0" cellpadding="0" cellspacing="0">
           <tr>
             <td width="116" height="28" align="center" valign="middle" background="img/tab_117.gif">
			 <span class="navText"><a href="index.php">Home</a></span></td>
             <td width="117" height="28" align="center" valign="middle" background="img/tab_117.gif">
			 <span class="navText"><a href="book.php">About the Guide</a></span></td>
              <td width="117" height="28" align="center" valign="middle" background="img/tab_117.gif">
			 <span class="navText"><a href="ptp.php">Students</a></span></td>
              <td width="137" height="28" align="center" valign="middle" background="img/tab_137.gif">
			  <span class="navText"><a href="prep.php">Parents/Educators</a></span>
			  <td width="137" height="28" align="center" valign="middle" background="img/tab_137.gif">
			 <span class="navText"><a href="owners.php">Bonus Material</a></span></td>
			  <td width="117" height="28" align="center" valign="middle" background="img/tab_117.gif">
			 <span class="navText"><a href="http://www.paulthetutor.com/contact.php" target="_blank">Contact Us</a></span></td>
			 </tr>
         </table>

<? } //end of the top of each page
// this does not included the second row of links
?>

<?
function ldssg_middle($blank){
?>
		 </td>
         <td><img src="img/middle-b-right.gif" width="15" height="80" /></td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       </table>
       </td>
     </tr>
     <tr>
       <td>
	   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
         <tr>
           <td background="img/middle-m-top.gif" height="25">&nbsp;</td>
         </tr>
		 
		 <tr><td> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" height="300" >
         <tr>
		  <td align="center" valign="top" bgcolor="#FFFFFF" height="100">
<? } // end the middle part

function ldssg_bottom($blank){
?>
	</td></tr></table>
         <tr>
           <td  height="50"  bgcolor="#155B39">&nbsp;</td>
         </tr>
       </table></td>
     </tr>
   </table>
</div>
</body>
</html>
<?
} // end of the bottom of the page


/// These are all the functions to put the second rows of links.
function ldssg_links_intro(){
?>
		   <div class="footertext" >
		   <a href="index.php">Home</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="http://www.tinyurl.com/ldsatstudyguide" target="_blank">Buy The Book</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="http://www.paulthetutor.com" target="_blank">About Paul the Tutor</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="http://www.paulthetutor.com/ldsat.php" target="_blank">Classes/Tutoring</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp; &nbsp;
<!--		   <a href="login.php">Important Info</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp; 
		   <a href="contact.php">Contact Us</a>
-->		   
		   </div>
<?
} /// end of ldssg_links_intro()

function ldssg_links_pared(){
?>
		   <div class="footertext" >
		   <a href="index.php">Home</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="ldnsat.php">LD's and SAT</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="http://www.paulthetutor.com" target="_blank">The Author</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="http://www.paulthetutor.com/ldsat" target="_blank">Classes/Tutoring</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp; &nbsp;
		   <a href="http://www.amazon.com/SAT-Study-Guide-Strategies-Disabilities/dp/159257887X" target="_blank">Buy the Guide</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp; 
		   </div>
<?
} /// end of ldssg_links_intro()

function ldssg_links_bonusmat(){ // links for the bonus material
?>
		   <div class="footertext" >
		   <a href="index.php">Home</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="bmmath.php">Math</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="bmcr.php">Critical Reading</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="bmwriting.php">Writing</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   <a href="errata.pdf">Errata</a>&nbsp;&nbsp;<span style="color:#fff">|</span>&nbsp;&nbsp;
		   </div>
<?
} /// end of ldssg_links_intro()



?>

		 

