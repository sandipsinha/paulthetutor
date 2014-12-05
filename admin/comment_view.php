<?php
ob_start();

include("../includes/pttec_includes.phtml");

//if this is being called from the tutor's folder
$folder = getfolder('','','');
if ($folder == "tutors"){

	include("../includes/tut_auth.php");
	$tutor_id = $_SESSION['tutor_id'];
}



MySQL_PaulTheTutor_Connect();
put_ptts_header("View Comment", $strAbsPath, "admin",'popup');
$id = $_REQUEST[id];
$strTableName = "PT_Comments_Student";

if(isset($id)){
	$query = "SELECT * FROM $strTableName WHERE id = $id";
	$result = mysql_query($query);
	if($result)
		$row = mysql_fetch_array($result);
}
else
	die("Error");

?>
<fieldset>  
<legend>Record Info</legend>  
<table cellspacing="2" cellpadding="3">  

<tr>
  <td valign="top" > <strong>Student:&nbsp;</strong>
  <?
$student_info = get_student_info($row[student_id]);

echo "$student_info[first_name] $student_info[last_name] ($row[student_id])"; ?>
  </td>
</tr>

<tr>
  <td valign="top" ><strong>Commentor:&nbsp;</strong>
    <? 
$str_date = format_date_print($row[date]);
echo "$row[commentor]";?></td>
</tr>

<tr>
  <td valign="top" ><strong>Date:&nbsp;</strong>
    <? 
$str_date = format_date_print($row[date]);
echo "$str_date";?>
<hr /></td>
</tr>

<tr>
  <td valign="top" ><strong>Subject:&nbsp;</strong>
    <? 
echo "$row[title]";?></td>
</tr>

<tr>
  <td valign="top"> 
  
  <?
// make the line breaks visible
$comment = $row[comment];
$comment = str_replace(array("\r\n", "\r", "\n"), "<br />", $comment);
echo $comment;
?>
  </td>
</tr>






</table>
</fieldset>  
<fieldset class="submit">  

<!-- 
<button class="edit" onclick="document.location='class_student_edit.php?id=<?=$id?>&tab=<?=$strTableName?>'">Edit</button>
 -->
<button onclick="popup_close()">Close</button>
</fieldset> 
<?
put_ptts_footer("popup");
?>
