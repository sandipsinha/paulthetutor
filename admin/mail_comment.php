<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$strTable = "PT_Emails";
$mail_id = $_REQUEST[mail_id];
$QStr = "select * from $strTable where id = $id";

// printarray($_REQUEST);
// if editing comment, should be able to update the date

if ($_REQUEST[Insert]){
	
	if($_REQUEST[first_contact] == 1){
		$MIQS = "select * from PT_Emails where id = $mail_id";
		$arm = rowquery($MIQS);
// printarobj($arm);
		
		$IQS = "insert into PT_First_Contact (parents, email, phone, comments, follow_up, contact_by, answered_by_eid, assigned_to_eid) values ('$arm[from_name]', '$arm[email_address]', '$arm[phone]', \"$arm[body]\", \"$_REQUEST[comment]\", 'email', '$_REQUEST[answered_by]', '$_REQUEST[assigned_to]')";
		
// echo "$IQS <BR>";		
		$new_contact_id = runquery($IQS);
	}

// add the employee information
	$comment = $_REQUEST[comment];
	if(!(isEmpty($_REQUEST[answered_by]))) {
		$ans_by = tutor_info($_REQUEST[answered_by]);
		$comment = "$comment <BR>Answered By: $ans_by[name]";
	}

	if(!(isEmpty($_REQUEST[assigned_to]))) {
		$assigned_to = tutor_info($_REQUEST[answered_by]);
		$comment = "$comment <BR>Assigned To: $assigned_to[name]";
	}
		 
		 

	
	$MQS = "update PT_Emails set comments = '$comment' where id = $mail_id"; 
	runquery($MQS);
		 
}

?>

<table  cellspacing="2" cellpadding="2" width="100%">
  <tr bgcolor="#FFFFFF">
    <td>
    Comments on email <?=$mail_id;?> <BR /><BR />
     <form method="post"  name="form1">
<?     
 putTextBox("Comments", "comment", 50, 20, "",$strComment, $special);
 
 
$opts['all'] = 1; 
putHiddenField("mail_id", $mail_id);
putBoolInput("First Contact?", "first_contact", '', "Is this the frist time they contacted us?");
get_employee_id("Answered By","answered_by",$arFieldsVals[answered_by]);
get_employee_id("Assigned To","assigned_to",$arFieldsVals[assigned_to]);
?>

</table></div>
</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
<button type="submit" name="Insert" value="insert">Insert</button>
<button onclick="popup_close()">Close</button>
</fieldset></td>
</tr></table>
</form></td></tr></table>
<?php
put_ptts_footer("popup");
?>
<script type="text/javascript">
$(document).ready(function(){
	jquery_date('date');
});
</script>