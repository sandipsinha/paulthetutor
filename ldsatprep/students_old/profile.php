<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");
$strTableName = "PT_TestPrep_Reg";
$class_id = $_REQUEST[class_id];
if ($_REQUEST['class'])
    $class_id = $_REQUEST['class'];
$student_id = $_REQUEST[student_id];
$username= $_REQUEST[username];
$password= $_REQUEST[password];

if ($class_id!='' && $username!='' && $password!=''){
    $res = runquery("select * from $strTableName WHERE username=\"".$username."\"");
    if (mysql_num_rows($res)){
        $msg_err = "The username is already in use. Please choose another one.";
    }else{
        $res = runquery("UPDATE $strTableName SET username=\"".$username."\", password=\"".$password."\" WHERE id='".$student_id."' LIMIT 1");
        $msg_success = "The username and password were stored. Please login <a href='login.php'>here</a>";
    }
}

?>
<table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
<tr>
    <td class=td_header>Create Profile</td>
</tr>
<tr>
<td height ="100" align="center">
 <form name = "form" method="POST"><input type="hidden" name="class" value="<?=$class_id?>"><br><table border="0" cellpadding="0" margin="0" align="center" cellspacing="5" bgcolor="#FFFFFF">    
<?

if ($msg_err)
    echo '<tr>
                <td colspan=2><div class="log_div_error" style="width:350px">'.$msg_err.'</div><br></td>
          </tr>';
elseif ($msg_success)
    echo '<tr>
                <td colspan=2><div class="text_success">'.$msg_success.'</div><br></td>
          </tr>';
if (!$msg_success){
if (!$class_id){
	$arr_classes[1] = "One on One Test Prep";
	
	$CQStr = "select * from PT_SAT_Class_Info WHERE end_date>='".date("Y-m-d")."'";
	
	// echo "$CQStr <BR>";
	
    $res = runquery($CQStr);
    while($row = mysql_fetch_array($res)){
        $arr_classes[$row[id]] = "Class $row[id] ($row[dow], $row[class_time]".($row[location] ? ", $row[location]" : "").")";
    }
    putSelectInput('Choose class number', 'class_id', $arr_classes, '', '', 'required','Choose a Class');
    $onclick = "if (!document.form.class_id.value) {alert('Please select a class'); return false;}";
}else{
    $res = runquery("select * from $strTableName WHERE class='".$class_id."' ORDER BY student_name");
    while($row = mysql_fetch_array($res)){
        $arr_students[$row[id]] = $row[student_name];
    }
    putSelectInput('Choose self ', 'student_id', $arr_students, $arr_students[$student_id], '', 'required','Choose self');
    putTextInput('Username ', 'username', 15, 20, $username, '','required');
    putPasswordInput('Password', 'password', 15, 20, $password,'required');
}
?>
<tr>
            <td colspan="2" align="center"><br>
                <input type="submit" value="Submit">
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset">
              </td>
</tr>
<?
if (!$class_id)
    $arRequired = array("class_id" =>"Class");
elseif (!$msg_success)
    $arRequired = array("student_id" =>"Self","username"=>"Username","password"=>"Password");
else
    $arRequired = array();
MySQL_JustForm_End($arRequired, "form","");
}else echo '</table>';
?>
      </form></td></tr></table>
<?
put_ptts_footer("");
?>