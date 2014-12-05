<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Testimonials", $strAbsPath, "admin", "");
$tablename = "PTTestimonials";
$move_id = isset($_POST['move_id'])?$_POST['move_id']:null;


If(!(empty($move_id))){
	$MQStr = "select * from $tablename where id=$move_id";
	$MRS = runquery($MQStr);
	if($MAR = mysql_fetch_assoc($MRS)){
		$DQStr = "delete from $tablename where id = $move_id";
		echo "<div class=text_success style='text-align:center'>Record $move_id has been deleted</div><BR>";
		mysql_query($DQStr);
	} 
} 

?>

<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id>

<?php 
$q = "SELECT * FROM $tablename";
$r = runquery($q);
?>
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#996600">
  <tr height="40">
    <td class="td_header">Testimonials</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
  	<th class="text_grey" width="15%"><b>Name</b></th>
  	<th class="text_grey" width="50%"><b>Testimonial</b></th>
  	<th class="text_grey" width="5%"><b>Position</b></th>
  	<th class="text_grey" width="15%"><b>School/Org</b></th>
  	<th class="text_grey" width="5%"><b>Grad Year</b></th>
  	<th class="text_grey" width="5%"><b>Verified</b></th>
  	<th class="text_grey" width="5%"><b>Action</b></th>
  </tr>
 
<?php 
while($row = mysql_fetch_array($r)){
echo '<tr><td>'.$row['name'].'</td><td>'.$row['testimonial'].'</td><td>'.$row['position'].'</td><td>'.$row['school_or_organization'].'</td><td>'.$row['year_of_graduation'].'</td><td style="text-align:middle;">';
$row['verified'] && print('<img src="../images/check.gif" style="margin:0 32%;"/>');
 			echo '</td><td><a onclick="javascript:popup(\'testimonial_edit.php?id='.$row['id'].'\',\'Details\',\'700\',\'820\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a onclick="if (confirm(\'Are you sure you want to delete this testimonial?\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="delete" border="0"></a>&nbsp;</td></tr>';
}

?>

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
