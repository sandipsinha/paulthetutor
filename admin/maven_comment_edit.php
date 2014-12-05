<?php
ob_start();
include("../includes/maven_pttec_includes.phtml");
// printarray($_REQUEST);
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');
$msg = "";
$folder = getfolder('','','');

// echo "$folder is the folder <BR>";


if ($folder == "tutors"){

	include("../includes/tut_auth.php");
	$tutor_id = $_SESSION['tutor_id'];
}
// if an id is passed, get student_id and $tutor_id from database

	
$strTableName = "PT_Comments_Student";
if(isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
	$student_id = singlequery("select student_id from $strTableName where id = $id");
	$tutor_id = singlequery("select tutor_id from $strTableName where id = $id");
}	

$days_week_int = array("Sunday"=>0, "Monday"=>1,"Tuesday"=>2,"Wednesday"=>3,"Thursday"=>4,"Friday"=>5,"Saturday"=>6);

?>
<table  cellspacing="0" cellpadding="0" width="100%" border="0">
  <tr bgcolor="#FFFFFF">
    <td>
     <form method="post"  name="form1">
<table cellspacing="0" cellpadding="0"  width="100%" >   
<tr>
	<td ><fieldset>  
<legend>Comments</legend>  
<?
$QStr = "select * from $strTableName where id = '$id'";
$arFieldsVals = array();

	
putHiddenField("strNotUsed", $strNotUsed);
$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);



/*************************************************************
if ($id && $tutor_id && ($tutor_id!=$arFieldsVals['tid']))	
	die("Error. You are not authorized to edit this schedule.");
****************************************************************/	
	
if ($tutor_id)
	$arFieldsVals['tid'] = $tutor_id;


// if anything is supposed to be updated or inserted it is done here
if(isset($_REQUEST['action']) && $_REQUEST['action'] && isset($_REQUEST['strTableName'])){

// put the date in format to be put into database and get printable version.
if(isEmpty($_REQUEST['date'])) {
	$show_date = $_REQUEST['date'];
	$_REQUEST['date']=date('y-m-d h:m:s');
}	 
	
	
	$_REQUEST_U = $_REQUEST;
	 $_REQUEST_I = $_REQUEST;
	$_REQUEST['date'] = format_date_db($_REQUEST['date']);
	if ($_REQUEST['action'] == "update" && isset($_REQUEST['id'])){
		$strWhere = " id = '$id'";
		$msg = UpdateFields($_REQUEST['strTableName'], $_REQUEST_U, $arMandFields, '', $tdStyle, $strWhere); 
	}
	//insert	
	 elseif ($_REQUEST['action'] == "insert"){
	 	if(folder == 'tutors') { // if this is being done in a tutors folder, the commentor is that tutor
			$_REQUEST_I[tutor_id] = $_SESSION[tutor_id];
			$_REQUEST[tutor_id] = $_SESSION[tutor_id];
		}	
	 		//print_r($_REQUEST_I);
	 	  $msg = InsertFields($_REQUEST['strTableName'], $_REQUEST_I, $arMandFields, '', $tdStyle, $strWhere);  
	 	 
// send a mail notification about the comment
	$tutname = $get_tutor_name($_REQUEST[tutor_id]);
	if($_REQUEST[student_id] == -1){
		$student_name = "$_REQUEST[first_name] $_REQUEST[last_name]";
	} else {
		$student_name = get_student_name($_REQUEST[student_id]);
	}
	
	$msubject = "$tutname noted $_REQUEST[title] about $student_name";
	$mmessage = "$msubject
	
	$_REQUEST[comment]";
	$strHeader = "From: notes@paulthetutors.com<PTTS Student Notes>\r\ncc:paul@paulthetutors.com";
	$addparameters = "-fnotes@paulthetutors.com";

	 
	  mail("info@paulthetutors.com", $msubject, $mmessage, $strHeader, $addparameters) ;

	 }
	 
	if (!$msg || is_int($msg))
		echo "<div class=text_success style='text-align:center'>The data has been saved.".(is_int($msg) ? " Added record: $msg" : "")."</div>";
	else 
		echo $msg;
	echo '<script type="text/javascript">opener_reload();</script>';
	}

if ($id){
	putHiddenField("id", $id);
	putHiddenField("action", "update");
}else {
	putHiddenField("action", "insert");
}
?>
<div style="padding:10px">  
<table cellspacing="0" cellpadding="2" width="100%" border="0">
<?
$FieldsRS = runquery($QStr);
$arFieldsVals = mysql_fetch_array($FieldsRS);

$opts['required'] = 1;

if ($folder == "tutors"){	

//	echo "<BR> folder is $folder too <BR>";


	putHiddenField("tutor_id", $tutor_id);
	putHiddenField("tid", $tutor_id);
}
else{
	echo '<tr>
			<td  align=right width="35%">Tutor <font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;</td>
			<td>';
		tutorsid_menu($tutor_id,"tutor_id","","all");
	echo '</td>
	</tr>';
}

	echo '<tr>
			<td align=right width="35%">Student <font color="#FF0000">*</font>&nbsp;&nbsp;&nbsp;</td>
			<td>';
		studentid_menu($student_id,"student_id","","required,other");
	echo '</td>
	</tr>';

//IF THIS IS AN EDIT, AND NOT AN INSERT, PUT THE DATE FIELD HERE

?>

<?

	$strNotUsed = "id,tutor_id, student_id";
	
//if we are inserting and not updating, we do not ask for the date
	if(isEmpty($_REQUEST[id])) $strNotUsed = $strNotUsed . ",date";
	
	
	MySQL_JustForm($strTableName, $arFieldNames, $arFieldsVals, $arFieldComments, $arHidden, $strNotUsed, $formName);
	
	
if ($folder == "tutors"){
?>
		 <script type="text/javascript">
		 $('#commentor').hide();
		 </script>  
  
  		<?php

}
?>


<?php
$arRequired = array("tid"=>"Tutor","student_id"=>"Student","pay"=>"Pay","start_date"=>"Start Date","end_date"=>"End Date","dow"=>"Day Of Week");
?>
</table></div>
</fieldset></td></tr>
<tr>
	<td><fieldset class="submit">  
<button type="submit" name="Submit">Save</button> &nbsp;&nbsp;<button onclick="popup_close()">Close</button>
</fieldset></td>
</tr> 
</form></td></tr></table>
<?
put_ptts_footer("popup");
?>
<script type="text/javascript">

$(document).ready(function(){
	jquery_date('start_date');
	jquery_date('end_date');
});
</script>
