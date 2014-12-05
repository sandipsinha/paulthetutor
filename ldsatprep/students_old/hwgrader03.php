<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$ref_page = "hwgrader04.php";



 printarray($_REQUEST);


if(!(isEmpty($_REQUEST[bb_page_num]))){
	$pagenum = $_REQUEST[bb_page_num];
	
	$SQS = "select test_id, section_number, id from TP_SAT_Sections where first_page <= $pagenum and last_page >= $pagenum and test_id >= 4 and test_id <= 14";
	
//	echo "sqs is $SQS <BR>";
	
	
	$secar = rowquery($SQS);
	$section_num = $secar[section_number];
	$test_id = $secar[test_id];
	$section_id = $secar[id];
}	else {
	$section_num = $_REQUEST[section_num];
	$test_id = $_REQUEST[test_id];
}

// echo "they are $section_num and $test_id <BR>";

$folder = getfolder('','','');
if($folder == "ldsatadmin"){
	

} else {
	include('.check_login.php');
	$testprep_id = $x_conf_sid;

}
	

// printarray($_REQUEST);

$student_id = NULL;
if ((!isEmpty($_REQUEST[testprep_id]))) $testprep_id = $_REQUEST[testprep_id];
if ((!isEmpty($_REQUEST[student_id])))  $student_id = $_REQUEST[student_id];
if ((!isEmpty($x_conf_sid))) $testprep_id = $x_conf_sid;

if((isEmpty($_REQUEST[student_id])) and (!(isEmpty($testprep_id)))){
	
//echo "the tpid is $testprep_id";
	
	$sQS = "select student_id from PT_TestPrep_Reg where id = $testprep_id";
	$student_id = singlequery($sQS);
//	echo "student is = $student_id <br>";
}

if((!(isEmpty($student_id))) and (isEmpty($_REQUEST[testprep_id]))){
	
	$sQS = "select id from PT_TestPrep_Reg where student_id = $student_id";
	$testprep_id = singlequery($sQS);
	echo "tpid is = $testprep_id <br>";
}

//if($folder == "ldsatadmin")
//	$ref_page = "hwsum_student02.php?testprep_id=$testprep_id";


//	echo "student is = $student_id <br>";

$strTableName = "TP_SAT_Questions";
$strTableName2 = "TP_HW_Answers";

if(!(isEmpty($_REQUEST[section_id]))){
		$section_id = $_REQUEST[section_id];
		$section_num = singlequery("select section_number from TP_SAT_Sections where id = $section_id");
		$test_id = singlequery("select test_id from TP_SAT_Sections where id = $section_id");
}

if ($test_id && $section_num){
	
// get the test's name
$res_test = runquery("select name from TP_SAT_Tests where id = $test_id");
$row_test = mysql_fetch_array($res_test);
?>
<form name = "form2" method="POST" action="<?=$ref_page;?>" style="margin:0px; padding:0px">
<input type="hidden" name="test_id" value="<?=$test_id?>">
<input type="hidden" name="section_num" value="<?=$section_num?>">
<input type="hidden" name="testprep_id" value="<?=$testprep_id?>"></form>

<?	
if ($_REQUEST[action]){
    $strNotUsed = "";
	
    $res = runquery("select * from $strTableName WHERE section_num=$section_num AND test_id=$test_id");
            while($row=mysql_fetch_array($res)){
                $resa = runquery("select * from $strTableName2 WHERE section_num=$section_num AND test_id=$test_id AND (student_id = $student_id or testprep_id = $testprep_id) AND problem =".$row[number]." LIMIT 1");
                $rowa = mysql_fetch_array($resa);
                $_REQUEST[testprep_id] = $testprep_id;
                $_REQUEST[student_id] = $student_id;
                $_REQUEST[section_num] = $section_num;
                $_REQUEST[test_id] =$test_id;
                $_REQUEST[problem] = $row[number];
                $_REQUEST[answer] = $_REQUEST["answer".$row[number]];
                $_REQUEST[corect_answer] = $row[answer];
                $_REQUEST[class_id] = $x_conf_class;
                //get the result
                $arr_result = getSATQResult($_REQUEST["answer"], $row[answer], $row[checkable], $row[spr]);
                $_REQUEST[result] = $arr_result[res];
                $_REQUEST[raw_points] = $arr_result[raw];
// echo "the row thing is $rowa[id]<BR>";   
                if ($rowa[id]){ //already answered
                    $uqs = "UPDATE $strTableName2 SET answer=\"".$_REQUEST[answer]."\", result=\"".$_REQUEST[result]."\", raw_points=\"".$_REQUEST[raw_points]."\"  WHERE id='".$rowa[id]."' LIMIT 1";

					$upd = mysql_query($uqs);
					
// echo "update is $uqs<BR>";	
                    if (!$upd)
                    	$msg.=mysql_error();
                }else{
					
                    $ins = mysql_query("INSERT INTO $strTableName2 SET answer=\"".$_REQUEST[answer]."\", result=\"".$_REQUEST[result]."\", raw_points=\"".$_REQUEST[raw_points]."\", testprep_id=\"".$_REQUEST[testprep_id]."\", section_num=\"".$_REQUEST[section_num]."\", student_id = \"".$student_id."\", test_id=\"".$_REQUEST[test_id]."\", problem=\"". $_REQUEST[problem]."\", corect_answer=\"".$_REQUEST[corect_answer]."\", date=NOW() , class_id=\"".$_REQUEST[class_id]."\", section_id = \"".$_REQUEST[section_id]."\" ");

                     if (!$ins)
                    	$msg.=mysql_error();
                }
			echo "<BR>";	
            }
// exit(); 
    
   if ($msg == "")
    	echo '<script>document.form2.submit();</script>';
    else 
        echo $msg;
}
	
?>

<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Enter Answers for <?=$row_test[name]?>, Section <?=$section_num?></td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST"><input type="hidden" name="test_id" value="<?=$test_id?>"><input type="hidden" name="section_num" value="<?=$section_num?>"><input type="hidden" name="action" value="ins"><input type="hidden" name="testprep_id" value="<?=$testprep_id?>">
<br><table border="1" cellpadding="5" margin="0" align="center" cellspacing="0" bgcolor="#FFFFFF" class="table_1">   
   <tr style="background: #eee; height: 35px">
      <td class="text_grey" width="80" align="center"><b>Question#</b></td>
      <td class="text_grey" width="100"  align="center"><b>Answer</b></td>
  </tr>
<?
    $res = runquery("select * from $strTableName WHERE section_num=$section_num AND test_id=$test_id ORDER BY number ASC");
    while($row = mysql_fetch_array($res)){
    	 $resa = runquery("select * from $strTableName2 WHERE section_num=$section_num AND test_id=$test_id AND (student_id = '$student_id' or testprep_id = '$testprep_id') AND problem =".$row[number]." LIMIT 1");
         $rowa = mysql_fetch_array($resa);
         
    	echo '<tr>
    				<td align=center><b>'.$row[number].'.</b></td><td align=center>';
    	if ($row[spr] == 0)
    		echo '<input name="answer'.$row[number].'" type="text" size="1" maxlength="1" value="'.$rowa[answer].'">';
    	else
    		echo '<input name="answer'.$row[number].'" type="text" size="6" maxlength="20" value="'.$rowa[answer].'">';
    	echo '</td>
    		</tr>';	
    }
?>
</table></td></tr>
<tr>
            <td colspan="2" align="center"><br>
                <input type="submit" value="Submit answers">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset"><br><br>
              </td>
</tr>
      </form></td></tr></table><br>
<?php
}
put_ptts_footer("");
?>