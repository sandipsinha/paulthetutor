<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");
include("../includes/.check_login.php");

// Contact page for parents 

//check if the user is logged in
MySQL_PaulTheTutor_Connect();
put_ptts_header("Sign Up for LD SAT Prep at Paul the Tutor's", $strAbsPath, "parents", "");

$fid=$_SESSION['fid'];
$main_name = getMainName($fid);
?>
Hello <?echo $main_name;?></span><span> (<?echo "Not $main_name?";?> <a href='login_parents.php?logout=1'>Logout</a>)<br/><br/>


<style type="text/css">
<!--
.plain {
	font-weight: normal;
}
.book_position {
	left: 5px;
	top: 450px;
	position: absolute;
}
.style6 {font-weight: normal; font-size: 11px; }
.pic_location {
	position: absolute;
	left: 450px;
	top: 175px;
}
-->
</style>
<SCRIPT LANGUAGE="javascript">
<!--
function openpop(strURL){
window.open (strURL,'newwindow',config='height=400,width=550,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no');
}
-->
</SCRIPT>

<table width="686" border="0" cellpadding="2" cellspacing="0" background="images/flowbg.gif">
  <tr >
    <td height="25" colspan="2"" valign="top" class="Head1_Green">Sign Up for
      Test Prep </td>
    <td width="96" rowspan="2"" valign="top"><div align="right">      
      <br>
      <p><a href="http://www.paulthetutor.com/contact.php">Contact Paul</a><br>
        <a href="http://www.paulthetutor.com/testprepreg.php">Sign Up</a><br>
      </p>
	  <p>&nbsp;      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;        </p>
      <p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td width="30" valign="top"><div align="left"></div></td>
    <td width="548" valign="top"> <p><br>
      
  <?
$IAR = $_POST;

$famQStr = "select main_name, main_email, main_phone from PT_Family_Info where id = $fid";
$frs = runquery($famQStr);
$famar = mysql_fetch_array($frs);
$IAR[name] = $famar[main_name];
$IAR[phone_number] = $famar[main_phone];
$IAR[email] = $famar[main_email];
$IAR[fid] = $fid;
$IAR[family_id] = $fid;
$IAR[student_name] = $_REQUEST['student_name'];

if($_REQUEST['student_id']!="0")
$check=class_add_student($_REQUEST['student_id'], $_REQUEST['class'], $_REQUEST['paid'], $_REQUEST['fee'], $_REQUEST['learning_disability'], $_REQUEST['extended_time'], $_REQUEST['tutor_id'], '', '0');	 
if($check){	
?>
  <span class="Head1"> Unfortunately, something went wrong with the registration.  Please <a href="http://www.paulthetutors.com/contact.php">email
    us</a> or call (510) 730-0390 and we will register you.  </span><BR>
      
  <? } else {  //provided the insert worked.
$class_val = $_POST['class'];
//setup the two sessions for the student

$res_cl = runquery("select id,cost,start_date, class_name from PT_SAT_Class_Info WHERE id='".$_REQUEST['class']."' LIMIT 1");
$row_cl = mysql_fetch_array($res_cl); 
$class_name = $row_cl['class_name'];
$dep_rate = $row_cl['cost']-50;
$start_date=$row_cl['start_date'];
$dep_date = last_saturday_of_last_month($start_date);
$late_reg = false;
if (strtotime($start_date) < time()) {
  $dep_date = date('Y-m-d');
  $late_reg = true;
  $dep_rate = $row_cl['cost'];
} 
?>
      <span class="Head1">3. Registration Successful Pending $<?=$late_reg ? $dep_rate. " Payment" : "50 Deposit";?>
        </span><BR>
       
      <?= $late_reg ? "A payment of $".$dep_rate : " A $50 deposit"; ?>
      is required to hold your spot in Class
  <?=$class_name;?>.
      Please follow the <a href="../ccpay" target="_blank">Pay Now</a> link to pay by credit card, or mail us a check.</p>
      <p>Make Check Payable to: Paul the Tutor's Education Center</p>
      <p>        mail
        to:<br>
        Paul the Tutor's Education Center<br>
        4235 Piedmont Ave.
        Oakland, CA 94611<br>
        <br>
      </p>
<? } // this is the end of the else, if the submit worked ?>	  
  
    </td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" class="style6">

	
	</td>
  </tr>
</table>
	 
<?


put_ptts_footer("");
?>
