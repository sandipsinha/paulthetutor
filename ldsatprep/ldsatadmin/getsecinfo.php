<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
req2testsec($_REQUEST);
// printarray($_REQUEST);
// die();

// get the number of sections
$num_sections = 0;

// if a test_id was passed, get the sections
if (!isEmpty($_REQUEST[test_id])){
	$ress = "select *, id as section_id from TP_Test_Sections  WHERE test_id='$test_id' ORDER BY section_num";
	$res = runquery($ress);
	$num_sections = 0;
	while($row = mysql_fetch_assoc($res)){
		$test_secs[$row[section_num]] = $row;
		$num_sections = $num_sections + 1;
		$test_secs[$row[section_num]][num_questions] = singlequery("select count(*) from TP_Test_Questions where section_id = $row[section_id]");
		$test_secs[$row[section_num]][spr] = singlequery("select min(question_num) from TP_Test_Questions where section_id = $row[section_id] and spr > 0");
		
//		echo " sec number is $row[section_num] <BR>";
	}
	$test_type_id = singlequery("select test_type_id from TP_Test_Info where id = $test_id");
	
	printarray($test_secs);
//	echo "num secs = $num_sections <BR>";
} 
//if there are no 
if($num_sections < 1) {

	$test_type_id = $_REQUEST[test_type_id];
	if(isEmpty($_REQUEST[num_sections])){
		$num_sections = singlequery("select num_sections from TP_Type_Tests where id = $test_type_id");
	} else {
		$num_sections = $_REQUEST[num_sections];
	}
}
// echo "num sections is $num_sections <BR>";

// processing information about a test, not sections
if ($_REQUEST[action]){
    $_REQUEST[strNotUsed] = "";
   
   
    If($_REQUEST[action] == "update" and isset($_REQUEST[id]) and isset($_REQUEST[strTableName])){
		$strWhere = " id = $id";
		$msg = UpdateFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, $_REQUEST[strNotUsed], $tdStyle, $strWhere); 
	} elseif ($_REQUEST[action] == "insert"){
         $test_id = InsertFields($_REQUEST[strTableName], $_REQUEST, $arMandFields, '', $tdStyle, $strWhere); 
		 
		 echo "test id is $test_id <BR>";
	}

}

put_ptts_header("Enter Section Information for Test $test_id", $strAbsPath, "admin",($_REQUEST[popup] ? "popup" : ""));
// printarray($_REQUEST);

$first_section = 1;
// if a test_id was passed, get all of the sections associated with that test

switch ($test_type_id) {
   case 1:
		if(isEmpty($test_secs[1])){
			$test_secs = array( "1" => array("section_num" => 1, "section_type_id" => 8 )); 
		}
		if(isEmpty($num_sections)) 
			$num_sections = 10;
        break;
		
   case 3: // ACT
   		
		$where = " where test_type_id = $test_type_id ";
		$num_questions = MySQL_fillArray("id", "number_problems", "TP_Section_Type", $where);

		$test_secs = array("1" => array("section_num" => 1,  "section_type_id" => 4, "time" => 45 , "num_questions" =>  $num_questions[4]), 2=> array("test_id" => $test_id, "section_num" => 2, "section_type_id" => 5, "time" =>  60, "num_questions" =>  $num_questions[5]), 3 => array("test_id" => $test_id, "section_num" => 3, "section_type_id" => 6, "time" => 35, "num_questions" =>  $num_questions[6]), 4 => array("test_id" => $test_id, "section_num" => 4, "section_type_id" => 7, "time" => 35, "num_questions" =>  $num_questions[7]), 5 => array("test_id" => $test_id, "section_num" => 5, "section_type_id" => 9, "time" => 30, "num_questions" =>  $num_questions[9]));
		if(isEmpty($num_sections)) 
			$num_sections = 10;
		
	  	break;
}

// printarray($test_secs);

?>
<link href="../../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />

<form method="post" action="getqinfo.php"  name="form1">
<table width="50%" cellspacing="5" cellpadding="10"  border="1" class="table_1">
<tr>
    <td class="td_header"><?=$rowTest[name]?> Sections </td>
</tr>
<tr>
    <td>
   <table cellpadding="0" width="100%">

<?php
// if we already have test sections, pass that information on to the next page
if(!isEmpty($test_secs))
	putHiddenField("test_secs", $test_secs);

putHiddenField("num_sections", $num_sections);
putHiddenField("action", "insert");
putHiddenField("test_id", $test_id);
$strNotUsed = "id,test_id,section_num,section_number,answers_stored,student_produced_response";
putHiddenField("strNotUsed", $strNotUsed);
    
$arFieldNames = array("section_type"=>"Type","num_questions"=>"Number questions","time"=>"Time (minutes) ");
$arFieldComments = array("num_questions"=>"How many questions in the sections?");

for ($i=1; $i<=$num_sections; $i++){
	if($_REQUEST[missing_section] == $i){
		$checked = " checked=\"checked\" ";
?>
<script>
$(document).ready(function(){
 
    $("#form<?=$i;?>").hide();

});
</script>


<?		
		
		
	} else {
		$checked = "";
	}
// echo "i is $i <BR>";		
?>
        <tr  bgcolor="#e3e3e3">
            <td bordercolor="#e3e3e3"  bgcolor="#e3e3e3"><span class="Head2">Section <?=$i;?></span></td>
            <td bordercolor="#e3e3e3" align="right" class="float_right"> Exclude <input id="exclude<?=$i;?>" name="exclude[<?=$i;?>]" type="checkbox" value="exclude" <?=$checked;?> /></td>
        </tr>		<tbody id="form<?=$i?>">

        <?
		
		if(!isEmpty($test_type_id)) 
			$where = " where test_type_id = $test_type_id ";
		$QStr = "select id, name from TP_Section_Type $where order by name";
		$sec_type_array = MySQL_fillArray("id", "name", "TP_Section_Type",$where);
		putSelectInput("Section Type", "section_type_id[$i]", $sec_type_array, $test_secs[$i][section_type_id], $strComment);

		putHiddenField("section_num[$i]", $i);
        $arFieldsVals = $test_secs[$i];
        $arRequired = array("section_type".$i=>"Section Type");
		$strNotUsed .= ", section_type_id";

        MySQL_JustForm("TP_Test_Sections", "", $test_secs[$i], $arFieldComments, $arHidden, $strNotUsed, $formName,"[$i]");
		putTextInput("Number of Problems", "num_questions[$i]", 3, 3, $test_secs[$i][num_questions],'');
		if($test_type_id == 1)
			putTextInput("First SPR", "spr[$i]", 3, 3, $test_secs[$i][spr],'Problem number of the first SPR Problem');

		
		
		?>
        </tbody>
         
  

<? }
    


 ?>
 </table></td></tr>
 <tr>
    <td style="padding:10px" align="center"><button type="submit" name="Submit">Submit and go to answers</button></td>
</tr>

</table>
</td></tr>
</table>
</form>
<?
put_ptts_footer(($_REQUEST[popup] ? "popup" : ""));
?>
<script>
$(document).ready(function(){
<?
for ($i=1; $i<=$num_sections; $i++){
?>	 


 $('#exclude<?=$i;?>').click(function(){
    $("#form<?=$i;?>").toggle();
});
<? } ?>
});
</script>
