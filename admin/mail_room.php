<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Email from Website", $strAbsPath, "admin", "");
$tablename = "PT_Emails";

//mark all mail as read
$MQS = "Update PT_Emails set viewed = 1";
$MRS = runquery($MQS);


$remail_id = (!(isEmpty($_REQUEST['remail_id'])))?$_REQUEST['remail_id']:null;
// echo "remail_id is $remail_id <BR>";
If(!(empty($remail_id))){
	$MQStr = "select * from $tablename where id=$remail_id";
	$MRS = runquery($MQStr);
	if($MAR = mysql_fetch_assoc($MRS)){
		
		echo "remailing email from $remail_id <BR>";
		
		
		$subject = "Resend: $MAR[subject]";
		$message = $MAR[body];
		$pttmess = "From the website of Paul the Tutor's:\n\n" . $message . "\n\n Phone: $phone";
		$send_name = $MAR[from_name];
		$email_address = $MAR[email_address];

		$strHeader = "From: website@paulthetutors.com.\r\nReply-to: $email_address";
		
		$addparameters = "-f".$email_address;
		
		ptts_mail("websitemail@paulthetutors.com", $subject, $message, array('from'=>array('name'=>$send_name, 'email'=>$email_address)));
		$name = $send_name;
		$email = $email_address;
		$pttmess = $message;
//		ptts_mail("info@paulthetutors.com", $subject, $pttmess, array('from'=>array('name'=>$name, 'email'=>$email)));

				
		echo "mail(websitemail@paulthetutors.com,$subject,$message,$strHeader,$addparameters)";
		mail("paul@paulthetutor.com",$subject,$message,$strHeader,$addparameters);
		ptts_mail("info2@paulthetutor.com", $subject, $pttmess, array('from'=>array('name'=>$name, 'email'=>$email)));


	} 
} 

?>
<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 

$sort = $_REQUEST[sort];
if(isEmpty($sort))	$sort = "id";
$order = $_REQUEST[order];
if(isEmpty($order)) $order = "DESC";

$sortby = "Order by $sort $order";
	


$QStr = "select * from $tablename $where $sortby";
$rs = runquery($QStr);

?>
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Email From Website</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
<?
put_sorting_header("ID", "id",$sort,$order);
put_sorting_header("From", "from_name",$sort,$order);
put_sorting_header("Email", "body",$sort,$order);
put_sorting_header("Comment", "comment",$sort,$order);
put_sorting_header("Date", "date",$sort,$order);

echo"<th>Action</th></tr><tr> ";
 
while($row = mysql_fetch_array($rs)){
	
	
	
	echo '<td>'.$row['id'].'</td>';
	echo '<td>'.$row['from_name']. '<br>email: ' . $row['email_address']. '<br>phone: ' . $row['phone'] . '</td>';
	echo '<td>'.$row['subject']. '<BR>' . substr($row['body'],0,400).'</td>';
	echo '<td>'.$row['comments'].'</td>'; 
	echo '<td>'.$row['date'].'</td>';
	
	$email_bod100 = substr($row[body],0,50);
	
	echo '<td> <a onclick="javascript:popup(\'email_view.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/view.gif" ALT="view" border="0"></a>'; ?>
	
&nbsp;<A HREF="mailto:<?=$row[email_address];?>?subject=Re:<?=$row[subject];?>&body=<?=$email_bod100;?>"><img src="../images/reply.png" name="Reply"  width="16" height="16" alt="Reply" /></a>
<?
echo '&nbsp <a href="mail_room.php?remail_id='.$row['id'].'"><img SRC="../images/resend.jpg" ALT="archive" border="0"></a>';
echo '&nbsp <a onclick="javascript:popup(\'mail_comment.php?mail_id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/comment-add.png" ALT="add comment" border="0"></a></td></tr>';

}?>

</table>
<br/>


<br />
</td>
</tr>	
</table>

</form>

<?
put_ptts_footer("");
?>
