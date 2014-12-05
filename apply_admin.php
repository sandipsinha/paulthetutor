<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$popup = $_REQUEST[popup];
// printarray($_REQUEST);

put_ptts_header("Applying For Admin Position", $strAbsPath, "", $popup);

?>
  <link href="includes/paulthetutors.css" rel="stylesheet" type="text/css" />
<?


if ($_REQUEST[Submit] == "Submit"){
			$_REQUEST[application_date] = date("Y-m-d"); 
			$_REQUEST[stage] = "applied";
			$_REQUEST[notes] = "applied";
;
	 	 $msg = InsertFields("PT_Prospect_Admin", $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
		 echo "<div class=text_success style='text-align:center'>Your application has been received. <BR> Thanks for applying and we will be in contact soon.</div>";
		 
		 $app_name = "$_REQUEST[first_name] $_REQUEST[last_name]";
		 

		 $header = "From: Applicant- $app_name <$_REQUEST[email]>\r\n";
		 $header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		 
		 
		 $app_name = "$_REQUEST[first_name] $_REQUEST[last_name]";
		 $body = "<html><body>New Applicant<br>
<b>Name:</b> $app_name<br>
<b>Position:</b> $_REQUEST[position]<br>
<b>Email:</b> $_REQUEST[email]<br>
<b>Phone:</b> $_REQUEST[phone]<br>

<strong>Courses</strong>: $_REQUEST[cover_letter]<br>

<strong>Experience:</strong> $_REQUEST[resume]<br>

<strong>Experience:</strong> $_REQUEST[resume]<br>

<strong>Other Info:</strong> $_REQUEST[other_information]<br>


<a href=\"http://www.paulthetutors.com/admin/applicants.php?&amp;sort=id&amp;&amp;order=DESC\">See Applicants</a>

</body></html>
";
		 
		 ptts2_mail("applicant@paulthetutors.com","Applicant $_REQUEST[position] $app_name",$body ,$header,'-f$_REQUEST[email]');

}

?>
<fieldset>

<legend><strong>Application for Admin Position</strong></legend>

<form name="form1">
<table>
<tr>
<td width="300">&nbsp;  </td><td>&nbsp; </td></tr>

<?
$arFieldNames[courses] = "Courses You Can Tutor";

$strNotUsed = "stage,notes,application_date";

MySQL_BlankForm('PT_Prospect_Admin',$arFieldNames,$arFieldsVals,$arFieldComments,$arHidden,$strNotUsed,'');


?>
</table>
</form>
</fieldset>
<?
put_ptts_footer("popup");

?>
