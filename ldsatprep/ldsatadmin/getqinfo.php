<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
printarray($_REQUEST);
reqToVars();
req2testsec($_REQUEST);


// insert section information
if($action == "insert"){
	$iqs = "insert into TP_Test_Sections (test_id, section_num, section_type_id, first_page, last_page, time) VALUES ";
	for($i = 1; $i <= $num_sections; $i++){
		if($exclude[$i] <> "exclude"){
			$isqs = "$iqs ($test_id, $section_num[$i], $section_type_id[$i], '$first_page[$i]', '$last_page[$i]', $time[$i]) ";
			$section_id[$i] = runquery($isqs);
		}
		
	}
	
// printarray($section_id);
	
}


put_ptts_header("Get the Answers for Test $test_id", $strAbsPath, "", "");
?>
<link href="../../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />

 <form name = "form" method="POST" action="putqinfo.php">
<?


// echo "secid is $section_id<BR>";
// printarray($section_info);


if(!isEmpty($test_id)){
	putHiddenField("test_id", $test_id);
	$ans_title = "Test $test_info[name] for $student_name ";
}

if(!isEmpty($section_id)){
	putHiddenField("section_id",$section_id);
	$ans_title = "Test $section_info[test_name] Section $section_info[section_num] $section_info[sec_name] for $student_name ";

}

putHiddenField("num_questions",$num_questions);
putHiddenField("num_sections",$num_sections);
putHiddenField("test_id",$test_id);

?>

<table  align="center" cellspacing="2" cellpadding="3" class=table_1>
<tr>
    <td class=td_header>Enter Answers for <?=$ans_title;?></td>
</tr>
<tr valign="top"><td align="center">
<table cellpadding="5" border="0"><tr>
<?
for($i = 1; $i <= $num_sections; $i++){
if($exclude[$i] <> "exclude"  ){
	$sec_type_name = singlequery("select name from TP_Section_Type where id = $section_type_id[$i] ");
	If( $sec_type_name <> "Essay"){
	?>
	<td class="vert_align_top">
    <table border="2" bordercolor="1">
	<tr>
	<td colspan="2" class="Head2">Section <?=$i;?></td></tr>
	
	
	<?
	$cqs = "SHOW FULL COLUMNS FROM TP_Test_Questions WHERE field =  'checkable'";
	$car = rowquery($cqs);
	$arCheckableVals = MySQL_SetToArray($car["Type"]);
	
	for($j = 1; $j <= $num_questions[$i]; $j++){
?>
		<tr><td>
		
<?
		echo $j;
		if ( (!isEmpty($spr[$i])) and ($j >= $spr[$i]) ){
			$size = 8;
			$maxlen = 20;
		} else {
			$maxlen = $size = 1;
		}
?> 
        <input name="correct_answer[<?=$section_id[$i];?>][<?=$j;?>]" type="text" size="<?=$size;?>" maxlength="<?=$maxlen;?>" />	
        </td>
        
        
<?        
       	if ( (!isEmpty($spr[$i])) and ($i >= $spr[$i]) ){

            justSelectInput('', "checkable[$sections[$i]][$j]", $arCheckableVals, $checkable, $strComment, $special, NULL);
		
		}
?>		
		</tr>
<?	} ?>	
	</table></td>
<? }}} // for $i and if not excluded
?> 
 

</tr></table></td></tr>
<tr><td><input name="" type="submit" /></td></tr>
</table></form>
<?php
put_ptts_footer("");
?>