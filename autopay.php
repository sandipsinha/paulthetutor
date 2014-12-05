<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

put_ptts_header("", $strAbsPath, "", "");
?>
<style type="text/css">
#discount12hrs {
}
#discount24hrs {
}
</style>
<link href="includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />

<div align="center">

<table width="800" border="0">

<tr height="20"><td>&nbsp;</td></tr>

<tr>
<td>


<hr size="2" color="black">
<div align="center" class="Head1">Paul the Tutor's Auto Pay</div>
<a href="https://www.paulthetutors.com/parents/strippay_action3.php" target="_parent"><img src="../images/Sign-Up-Button-Green.png" alt="edit" width="153" height="44" class="float_right" border="0" /></a>
 
<span class="Head2_Green">How It Works</span><BR />

<span >Your ebill will still be emailed to you as it normally is. You will have two days to review the bill before money is automatically deducted by the credit card on file. Basically, it works like any other automatic payment system.<BR />
</span><br />
<span class="Head2_Green">Is It Safe?</span><BR />
<span >We do not store the credit card informaiton ourselves; instead our credit card processing company, <a href="http://www.stripe.com" target="_blank">Stripe</a>, which specializes in online credit card payments stores your information in their secure and encrypted server. All we do is send them your id number and they do the rest. And your id number only works with Paul the Tutor's, so there isn't anything nafarious people could do with that either.<BR />
</span><br />
<span class="Head2_Green">Save $10/hr</span><BR />
<span >That's right. Any session which is paid through autopay will be automatically receive a reduced rate of $10/hr. Please note that &quot;paid through autopay&quot; means that charges are accepted the first time. This discount can not be combined with any other offers though, sorry. See the <a onclick="javascript:popup('autopay_terms.php','Details','800','600')"><span class="underline">terms and conditions</span></a> of the autopay discount.<BR />
</span><br />
<span class="Head2_Green">How do I Sign Up?</span>
<a href="https://www.paulthetutors.com/parents/strippay_action3.php" target="_parent"><img src="../images/Sign-Up-Button-Green.png" alt="edit" width="153" height="44" class="float_right" border="0" /></a>
<br />
<span ><a href="https://www.paulthetutors.com/parents/strippay_action3.php" target="_blank">Click Here</a> and fill out the form just as you would if you were making a payment, but select &quot;sign up for autopay&quot;. </span><BR />

<br /><br />


<hr></td>
</tr>
</table>






<?
put_ptts_footer("");

?>
