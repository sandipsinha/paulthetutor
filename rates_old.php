<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

include( "put_header_2014.php" );
put_header_2014("Paul the Tutor's - Rates", $strAbsPath);

MySQL_PaulTheTutor_Connect();

//put_header_2013("", $strAbsPath, "", "");
?>
<style type="text/css">
#discount12hrs {
}
#discount24hrs {
}
</style>
<link href="includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />

<div align="center" class="Head1">Rates</div>

<span class="Head2_Green">Rates<a name="Rates" id="Rates"></a></span> (see our <a href="#Discounts">discount rates</a>)<br />
  <span class="Head3">$85/hr - at Paul the Tutor's Education Centers</span><br />
  <span class="Head3">$100/hr - In Home Tutoring*</span><br />
  <span class="Head3">$75/hr - Online Tutoring </span>
<br /><br />  <span class="Head3">Rates with Paul the Tutor</span><br />
  $200/hr
  - at Paul the Tutor's<br />
  $150/hr - online<br />
  <br />
  <span class="Head3">Rates with Trainee Tutors</span><br />
  $60/hr
  - at Paul the Tutor's<br />
  <br />
  <span class="form_comments">*Rates start at $100/hr. May be higher for tutoring outside of our normal area</span><br />
  <hr />
 
  <p><span class="Head2_Green">Discount Rates</span><a name="Discounts" id="Discounts"></a><br />
    When you prepay for blocks of hours your receive a discount on your rates. 
      The bigger the block, the bigger the discount. And your hours can be used for any sibling and any type of tutoring: academic, test prep, guidence, consulting etc...<br />  
  <table width="500" border="2" cellspacing="0" bordercolor="#000000">
    <tr>
      <th width="243">Tutoring</th>
      <th width="109">12 hrs</th>
      <th width="128">24 hrs</th>
      </tr>
    <tr>
      <td>Discount</td>
      <td class="center-text">10%</td>
      <td class="center-text">20%</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="center-text">&nbsp;</td>
      <td class="center-text">&nbsp;</td>
    </tr>
    <tr>
      <td>Standard (at Paul the Tutor's)</td>
      <td class="center-text">$925</td>
      <td class="center-text">$1625</td>
      </tr>
    <tr>
      <td>In-Home </td>
      <td class="center-text">$1075</td>
      <td class="center-text">$1925</td>
      </tr>
    <tr>
      <td>Distance/Online</td>
      <td class="center-text">$810</td>
      <td class="center-text">$1450</td>
      </tr>
    <tr >
      <td>&nbsp;</td>
      <td class="center-text">&nbsp;</td>
      <td class="center-text">&nbsp;</td>
    </tr>
    <tr>
      <td>Paul the Tutor</td>
      <td class="center-text">$2150</td>
      <td class="center-text">$3850</td>
      </tr>
    <tr>
      <td>Paul the Tutor Distance Tutoring</td>
      <td class="center-text">$1500</td>
      <td class="center-text">$2675</td>
      </tr>
  </table>

<?
//put_ptts_footer("");
put_footer_2014("");

?>
