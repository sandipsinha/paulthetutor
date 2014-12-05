<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

printarray($_REQUEST);

?>
  <link href="includes/paulthetutors.css" rel="stylesheet" type="text/css" />
<?
put_ptts_header("Applying To Be A Tutor", $strAbsPath, "", "popup");

if ($_REQUEST[Submit] == "Submit"){
	 	 $msg = InsertFields("PT_Prospect_Tutors", $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
		 echo "<div class=text_success style='text-align:center'>Your application has been received. <BR> Thanks for applying and we will be in contact soon.</div>";
		 
		 $header = 'From: applicant@paulthetutors.com';
		 
		 ptts2_mail("info@paulthetutors.com","New Job Applicant","There is a new applicant" ,$header,'-fapplicant@paulthetutors.com');

}

?>
<fieldset>
<legend><strong>Application for Tutoring Position</strong></legend>
To apply for a tutoring position at Paul the Tutor's, simply fill out the form below and we will be in touch shortly.
<form name="form1">
<table>
<tr>
<td width="300">&nbsp;  </td><td>&nbsp; </td></tr>

<?
$arFieldNames[courses] = "Courses You Can Tutor";

MySQL_BlankForm('PT_Prospect_Tutors',$arFieldNames,'','','','','');

?>
</table>
</form>
</fieldset>
<?
put_ptts_footer("popup");

?>
