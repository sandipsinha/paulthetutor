<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
?>
  <link href="includes/paulthetutors.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
  #mid_button {
	position: relative;
	left: 375px;
	bottom: 100px;
}
  </style>
<?
put_ptts_header("Applying To Be A Tutor", $strAbsPath, "", "");

if ($_REQUEST[action] == "insert"){
	 	 $msg = InsertFields($_REQUEST[strTable], $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
		 echo "<div class=text_success style='text-align:center'>Your application has been received. <BR> Thanks for applying and we will be in contact soon.</div>";
		 
		 $header = 'From: applicant@paulthetutors.com';
		 
		 ptts2_mail("info@paulthetutors.com","New Job Applicant","There is a new applicant" ,$header,'-fapplicant@paulthetutors.com');

}

?>
<table width="632" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="364" class="Head1">Applying To Be A Tutor </td>
    <td width="254"><a onclick="javascript:popup('apply.php','Edit Schedule','600','700')"><img src="../images/ApplyButton_Green.png" alt="edit" width="150" height="50" border="0" /></a></td>
  </tr>
</table>
  We are always on the lookout for good tutors. If you believe that you 
  can help students learn and develop the thinking skills they will need to succeed in school and beyond, and you meet our requirements, click here to apply for a spot at Paul the Tutor's<br />
  <br />
  <span class="Head2_Green">Why Paul the Tutor's?</span><br />
  - Great Pay! Where else can you go to earn $35 to $50/hr tutoring?<br />
  - Flexible Schedule - You tell us when you want to tutor and we find you the students<br />
  - Various Locations - We have offices in Piedmont, Berkeley, Lafayette, Peninsula and Davis (In Home Only)
  <br />
  - We provide paid training<br />
  - Learn to tutor new subject and get even more work
  <br />
  - Free snacks and drinks
  <br />
  <br />
  <span class="Head2_Green">Job Description</span><br />
  - 
  One on one tutoring and  occasional class instruction<br />
  - 
  $35/hr at Paul the Tutor's $45+/hr in home tutoring<br />
  - Let us know when you want to tutor and we find your students for you<br />
  - Paid monthly by Paul the Tutor's
<br />
<a onclick="javascript:popup('apply.php','Edit Schedule','600','600')"></a><br />
<span class="Head2_Green">Requirements<br />
</span><span class="Head3">Minimum Requirements</span><br />
- Degree (earned or working towards) from a well regarded college or university<br />
- At least one year of tutoring experience<br />
- Ability to tutor at least two subjects at  honors/AP level<br />
- Patient and NEVER condescending<br />
- Able to tutor through the current academic year
<BR />
<a onclick="javascript:popup('apply.php','Edit Schedule','600','600')"></a><br />
<span class="Head3">Ideal Qualifications</span><br />
- The more subjects you can tutor the better<br />
- 
Willingness to learn test prep<br />
- Worked with students with learning disabilities<br />
- Hoping to tutor through the following academic year<br />
- Able to work in Lafayette office
<br />
<p>  <a onclick="javascript:popup('apply.php','Edit Schedule','600','600')"><img src="../images/ApplyButton_Green.png" alt="edit" width="150" height="50" id="mid_button" border="0" /></a><br />
  <br />
  <?
put_ptts_footer("");

?>
