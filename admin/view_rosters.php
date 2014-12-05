<?php
$strBack = "";
if($folder == "ldsatadmin") $strBack = "../";


include("$strBack../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin","");
$class = $_REQUEST['class'];
$move_id = $_REQUEST['move_id'];
$tablename = "PT_TestPrep_Reg";
if(substr($class,0,1) == "s"){ // if roster is for a seminar
		$semid = substr($class,1);
		$tablename = "TP_Seminar_Reg";
}

if(!(isEmpty($_REQUEST['class']))){
	$class_name = singlequery("select class_name from PT_SAT_Class_Info where id = $class");
}	

$text_class = (!$semid ? "Class ".$class_name : "Seminar ".$semid);
If(!(empty($move_id))){
	$MQStr = "DELETE from $tablename where id=$move_id";
	runquery($MQStr);
} 

?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">

<form action="view_rosters.php" method="post" name=form><input type="hidden" name=move_id>
<table border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" class=table_1>
  <tr>
    <td class=td_header><? echo $text_class; ?> Rosters</td>
  </tr>
  <tr>
    <td height="148" align="center"  valign="top" bgcolor="#FFFFFF">
<? 
if(!(isEmpty($class))){
?>
<table border=1 cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
<tr>
	<td align="right" colspan=7 style="padding-bottom:5px"><button onclick="javascript:popup('class_student_edit.php?tab=<?=$tablename?>&cls=<?=$text_class?>','','700','700')" style="cursor:pointer">Add New Student</button></td>
</tr>
 	<tr style="background: #eee; height: 35px">
  		<td class="text_grey"><b>Student</b></td>
 		<td class="text_grey"><b>Parent</b></td>
  		<td class="text_grey"><b>Phone</b></td>
  		<td class="text_grey"><b>Email</b></td>
  		<td class="text_grey"><b>Extended Time</b></td>
  		<td class="text_grey"><b>Action</b></td>
  </tr>
<?
$where =  ($semid ? "seminar_id=".$semid : "class=".$class);
$QStr = "select * FROM $tablename WHERE $where order by id DESC";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
 		<td>'.$row['student_name'].'&nbsp;</td>
 		<td>'.($semid ? $row['parent_name'] : $row['name']).'&nbsp;</td>
 		<td>'.$row[phone_number].'&nbsp;</td>
 		<td>'.$row[email].'&nbsp;</td>
 		<td>'.$row[extended_time].'&nbsp;</td>
 		<td nowrap  align=center><a style="cursor:pointer" onclick="javascript:popup(\'class_student_view.php?id='.$row[id].'&tab='.$tablename.'\',\'Details\',\'700\',\'700\')"><img SRC="../images/view.gif" ALT="view" border="0"></a>&nbsp;
 			<a style="cursor:pointer" onclick="javascript:popup(\'class_student_edit.php?class_id='.$class.'&registration_id='.$row[id].'&tab='.'&student_id='.$row[student_id].'&tab='.$tablename.'\',\'Details\',\'700\',\'700\')"><img SRC="../images/edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
 			<a style="cursor:pointer" onclick="if (confirm(\'Are you sure you want to delete this student?\')) {document.form.move_id.value='.$row[id].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" border="0"></a>&nbsp;
 		</td>
 </tr>';
}
?>
<tr height=40>
      	<td colspan="10" align="center"><?
      	email_all_link($tablename, "", $where, "");
      	?></td>
      </tr>
</table>
<hr>
<?
}	



// printarray($HTTP_POST_VARS);?>	
	

	<table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <th colspan="2" scope="col"><div align="center">Which Roster Would You Like to View? </div>
          <span class="form_comments">Only classes with students enrolled are available</span><br>
		
		
		</th>
      </tr>
      <tr>
        <td align=center><br>
          <br>
          Class&nbsp;
          <select name="class" id="class">
            <option value=""></option> 
			<option value = "1">One on One</option>
<?
$CQStr = "select DISTINCT c.id, c.class_name from PT_TestPrep_Reg f LEFT JOIN PT_SAT_Class_Info c ON f.class=c.id WHERE c.id>0 order by c.id DESC";
$CRS = runquery($CQStr);
while ($car = mysql_fetch_array($CRS)){ //this will put each class that someone is enrolled in in the list.
?>
			<option value="<?=$car[id];?>" <?= ($class == $car[id] ? "selected" : "")?>>Class <?=$car[class_name];?></option>
<? } //ends the while loop

$CQStr = "select DISTINCT s.class_name, s.id from TP_Seminar_Reg f LEFT JOIN TP_Seminar_Info s ON f.seminar_id=s.id WHERE s.id>0 order by s.id DESC";
$CRS = runquery($CQStr);
while ($car = mysql_fetch_array($CRS)){ //this will put each class that someone is enrolled in in the list.
?>
			<option value="s<?=$car[0];?>" <?= ($class == "s".$car[0] ? "selected" : "")?>>Seminar <?=$car[0];?></option>
<? } //ends the while loop
?>			                  
				  
		  </select><BR>
			</td>
      </tr>
      <tr>
        <td colspan="2"><br><div align="center">
          <input type="submit" name="Submit" value="Submit">
          &nbsp;&nbsp;&nbsp;
          <input type="reset" name="Reset" value="Reset">
        </div></td>
        </tr>
    </table>
	</form>	
	</td>
  </tr>
</table><br>
<?php
put_ptts_footer("");
?>