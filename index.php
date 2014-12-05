<?php

$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

put_ptts_header("Paul the Tutor's Education Center Home", $strAbsPath, "", "");

/***********************************************
* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/

?>

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
<script>
    $(function(){

      $("#accordion").bind('mouseleave', function()
      {
        ddaccordion.collapseall("accordion_header");
      });

    $("#slides").slides({
      preload: true,
        slideSpeed: 0, //2000
        preloadImage: 'includes/images/loading.gif',
        play: 5000,
        pause: 2000,
        hoverPause: true,
        animationStart: function(current){
          if (window.console && console.log) {
            // example return of current slide number
            //console.log('animationStart on slide: ', current);
          };
        },
        animationComplete: function(current){
          if (window.console && console.log) {
            // `example return of current slide number
            //console.log('animationComplete on slide: ', current);
          };
        },
        slidesLoaded: function() {
        }
    });
    });

</script>
<style type="text/css">

td img {display: block;}
td img {display: block;}
</style>

<style type="text/css">
  /**this is for the first slide of the slideshow,
  parents' best bronze star award**/
  .slide-msg {
    width: 40%;
    font-size: 18px;
    position: relative;
    margin: auto 20px;
    float: left;
    top: 70px;
    color: darkblue;
    line-height: 200%;
  }

  .slide-msg b {
    font-size: 32px;
  }

  .slide-msg-text {
    width: 100%;
    font-size: 40px;
    font-weight: bold;
    position: relative;
    margin: 0 auto;
    color: #fff;
    line-height: 200%;
    top: 120px;
  }

  .brown {
    background-color: #996633;
  }

  .green {
    background-color: #006633;
  }

  .no-underline {
    text-decoration: none !important;
  }

</style>
  <div class="content_wrapper_home">

      <div class="main_content">

<!-- STOP HEADER FUNCTION TEXT -->

        	 <div id="slides">
             	<div class="slides_container">

              <div class="slide">
                
                <a class="no-underline" href="https://www.paulthetutors.com/contact.php">

                  <div style=" height: 380px; ">
<!--                       <p class="slide-msg-text">
                          <b>Free Half Hour Meeting with Paul the Tutor</b>
                      </p> -->

                      <img src="images/logo_print.jpg" height="150" width="350" 
                      style="
                          margin-left: 10px;
                          margin-top: 100px;
                          float: left; ">

                      <p class="slide-msg">
                        <b>Free Half Hour</b>
                        <br />
                        <b>Cognitive Analysis</b>
                        <br />
                        with
                        <br />
                        <b>Paul the Tutor</b>
                      </a>
                    </p>
                  </div>

                </a>

                <div class="caption" style="clear: left;">
                    <h3>Cognitive Analysis</h3>
                    <h4>Talk to Paul about your student's educational needs and goals. 
                      Get honest and comprehensive feedback. 
                      Call now: (510)730-0390
                    </h4>
                </div>

              </div>

					    <div class="slide">

                <div style=" height: 380px; ">
                    <a href="http://www.parentspress.com/Best-of-Parents-Press?additionalinfo=Best+Testing+Preparation+Program">

                      <img src="includes/images/slides/bronze_star.png?1405634308258" height="350" width="350"
                        style="
                          margin-left: 10px;
                          margin-top: 10px;
                          float: left; ">

                    </a>

                    <p class="slide-msg">
                     <a href="http://www.parentspress.com/Best-of-Parents-Press?additionalinfo=Best+Tutorial+Programs" style="text-decoration: none;">
                        <b>Voted</b>
                        <br />
                        one of the
                        <br />
                        <b>Top</b>
                        <br />
                        <b>Tutoring Centers</b>
                        <br />
                        in the
                        <br/>
                        <b>East Bay</b>
                      </a>
                    </p>
                </div>

                <div class="caption" style="clear: left;">
                    <h3>Paul the Tutor's Wins Parents' Press Bronze Star</h3>
                    <h4>Thank you Parents' Press and all the readers who supported us.</h4>
                </div>

              </div>

              <div class="slide">

                  <!--actual image size width=500, height=346-->
                  <a href="testimonials.php" alt="More Testimonials">
                    <img name="new_locations_slide" src="includes/images/slides/new_locations_slide.jpg"
						        width="668" height="371" border="0" id="new_locations_slide" usemap="#m_new_locations_slide" alt="" />
                  </a>
                        <!--label width:149, height: 36-->
      						<map name="m_new_locations_slide" id="m_new_locations_slide">
      						  <area shape="rect" coords="516,4,665,40" href="davis.php" alt="" />
      						  <area shape="rect" coords="190,127,339,164" href="berkeley.php" alt="" />
      						  <area shape="rect" coords="38,287,187,323" href="sanmat.php" alt="" />
      						  <area shape="rect" coords="410,145,559,181" href="lafayette.php" alt="" />
      						  <area shape="rect" coords="273,200,423,236" href="piedmont.php" alt="" />
      						</map>

                  <div class="caption">
							       <h3>See Our New Locations!</h3>
                     <h4>We're still on <a href="piedmont.php">Piedmont Ave.</a> too.</h4>
						      </div>

                    </div>

                    <div class="slide">

                    	<img src="includes/images/slides/image3.jpg">

                      <div class="caption">
						              <h3> "Paul the Tutor's is awesome" - Evan Daniels</h3>
                          <h4><a href="testimonials.php" alt="More Testimonials">Review more testimonials</a></h4>
                          <h4><a href="bpnandyelp.php" alt="Yelp & BPN">They love us in Berkeley Parent Network and Yelp!</a></h4>
                      </div>

                    </div>

                    <div class="slide">

                      <img src="includes/images/slides/image1.jpg" height="463" width="668">

                    </div>

                </div>
            </div>
        </div>

<?
  put_ptts_footer("");
?>
