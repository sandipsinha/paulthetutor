<?php
ob_start();

include("../includes/pttec_includes.phtml");
include($strAbsPath . "/includes/tut_auth.php");
include("../includes/phtml_files/calendar05.phtml");
MySQL_PaulTheTutor_Connect();
$strBack = "../";  //if this page is in a subdirectory, the strBack is "../" so we look back a folder in links.
// $intTableFieldsid is the id of the info we are to update

$tutor_id = $_SESSION['tutor_id'];

isset($_REQUEST['month']) && $month =  $_REQUEST['month'];
isset($_REQUEST['year']) && $year = $_REQUEST['year'];

if(!isset($month) || isEmpty($month)){
	$str_month = date('F');
	$month = date('n');
}
else
{
	$str_month = date('F', mktime(0, 0, 0, $month, 11, 2000));
}	


if(!isset($year) || isEmpty($year)){
	$year = date('Y');

}
$tutor_id = $_SESSION['tutor_id'];



		
/**************************************************
Deal with added or deleted appointments or checked days
***************************************************/
// if a day has been checked, updated the datebase
If (isset($_REQUEST['checked']) && $_REQUEST['checked']<>NULL){
	$i_date = $_GET['year'] . "-" . $_GET['month'] . "-" . $_GET['checked'];

	$iQStr = "insert into PT_Checked_Day (checked,date,tid) VALUES (1,'$i_date',$_SESSION[tutor_id])";
//	echo $iQStr ."<BR><BR>";
	$iRS = runquery($iQStr);
}	

If (isset($_REQUEST['unchecked']) && $_REQUEST['unchecked']<>NULL){
	$i_date = $_GET['year'] . "-" . $_GET['month'] . "-" . $_GET['unchecked'];

	$iQStr = "DELETE FROM PT_Checked_Day WHERE date='$i_date' AND tid=$_SESSION[tutor_id]";
//	echo $iQStr ."<BR><BR>";
	$iRS = runquery($iQStr);
}

//process first form




put_ptts_header("Tutor's Calendar", $strAbsPath, "tutors", "");
?>
</td></tr></table>
</td></tr></table>
</td></tr></table>




<?

$i = 0;
$strQfid = "";
if(isset($_REQUEST['fid']) && !(isEmpty($_REQUEST['fid']))){
	$_SESSION['fid'] = $_REQUEST['fid'];	
}	

if(isset($_SESSION['fid']) && !(isEmpty($_SESSION['fid'])))
{
	$strQfid = " where id = ".$_SESSION['fid'];
}

$QStr = "select id as fid, students from PT_Family_Info $strQfid";

if(!($StudentInfoRS = mysql_query($QStr))){
	echo "$QStr <br>" . mysql_error();
}

//get each students info
// echo "si array is <BR>";
// printarray($SI);
// echo "end of first SI";

while($arStudentInfo = mysql_fetch_array($StudentInfoRS)){

	// get the scheduling information for the student
	if($arBillInfo = gettutBillInfo($month, $year, $arStudentInfo[0],$_SESSION['tutor_id'],'')){
		
		while (list ($key, $value) = each($arBillInfo)){
				$student_id = $value["student_id"];
			   $SI[$i]["name"] = get_student_name($student_id);
		   $SI[$i]["hrs"] =  $value["hours"];
		   $SI[$i]["start"] = $value["start_time"];
		$SI[$i]["dom"] = $value["printday"];
		   $SI[$i]["rate"] = $value["rate"];
		   $SI[$i]["pay"] = $value["pay"];
		   $SI[$i]["id"] = $value["id"];
 		   $SI[$i]["tid"] = $value["tid"];
			$i = $i + 1;
			}
		} // end if	
	}
echo"<table align='center'><tr><td><table width='90%'  border='0' cellpadding='0' cellspacing='0'  align='center' bordercolor='#000000'>";	
// first form on the page
// <tr><td align="right">

// <button onclick="javascript:popup('schedule_edit.php','AddSchedule','600','600')"> Recurring Tutoring Sessions</button>&nbsp;&nbsp;&nbsp;
// <button onclick="javascript:popup('addsess.php?popup=popup','Add Session','600','600')"> Tutoring Session</button>


// </td></tr>

// makeForm("form1", $month, $year, 0,0);

// printarray($SI);

//echo "tutors id is $_SESSION[tutor_id] right now";

?>

<?
// echo "this is the array that is passed.  month and year are $month and $year<BR>";
 //printarray($SI);
 
///tareklink///

$query = "SELECT * FROM PT_Other_Appt WHERE tutor_id = '$tutor_id' and date >= '$year-$month-01' AND date <= '$year-$month-31' ORDER BY date";

$result = mysql_query($query);


$other_arr = Array();

while($row = mysql_fetch_object($result))
{	
	$curr_date = "";
	
	$temp = Array();
	$temp['id'] = $row->id;
	$temp['name']= $row->name;
	$temp['start'] = $row->start_time ;//"21:00:00";
	$temp['end'] =$row->end_time;
	$temp['tid'] =$row->tutor_id;
	$temp['dom']=date("d",strtotime($row->date));
	$temp['type']=2;
	

	
	array_push($other_arr,$temp);
	
}


$query = "SELECT w.*,t.first_name as t_first_name, t.last_name as t_last_name FROM PT_NT_Work_Hours w LEFT JOIN PT_Tutors t ON w.tutor_id=t.id WHERE w.tutor_id=".$tutor_id." AND w.date >= '$year-$month-01' AND w.date <= '$year-$month-31' ORDER BY w.date";

$result = runquery($query);
$non_tut_hrs = Array();

while($row = mysql_fetch_object($result))
{	
	$curr_date = "";
	$temp = Array();
	$temp['id'] = $row->id;
	$temp['name']= $row->description;
	$temp['start'] = null ;//"21:00:00";
	$temp['end'] = null;
	$temp['tid'] =$row->tutor_id;
	$temp['dom']=date("d",strtotime($row->date));
	$temp['tutname'] = $row->t_first_name." ".strtoupper(substr($row->t_last_name,0,1));
	$temp['type']=CAL_WORK_HOURS;
        $temp['hours']=$row->hours;
        $temp['rate']=$row->rate;
	array_push($non_tut_hrs,$temp);
	
}

function compare_dom($a, $b)
{
  return strnatcmp($a['dom'], $b['dom']);
}


if(!isset($SI))
	$SI = Array();

$merged = array_merge($other_arr, $SI);
$merged = array_merge($non_tut_hrs, $merged);

# sort alphabetically by name
//usort($merged, 'compare_dom');
/*
echo "<pre>";
print_r($merged);
echo "</pre>";
 
*/
// $rate = $HTTP_GET_VARS['rate'];

$irate = isset($_GET['rate']) ? $_GET['rate'] : null;
$itype = isset($_GET['type']) ? $_GET['type'] : null;
$show_rates = 0;

//calls the function which fill the table
outputCalendar($merged,$month,$year,$itype,'',$show_rates,0);	

///endtareklink///

	
?>

<br>
<!-- tareklink -->
<!--form on the bottom-->
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
function checkInputs()
{
	if($("#other_name").attr("value")=="")
	{
		alert("Please enter your name");
		return false;
	}
	else if($("#tid").attr("value")=="")
	{
		alert("Please select a tutor");
		return false;
	}
	else if($("#other_date").attr("value")=="")
	{
		alert("Please select date");
		return false;
	}
	else if($("#other_ispaid").attr("value")=="")
	{
		alert("Please select Paid or Unpaid");
		return false;
	}
	else if($("#other_start_time_hours").attr("value")=="" || $("#other_start_time_minutes").attr("value")=="")
	{
		alert("Please enter start time");
		return false;
	}
	else if($("#other_end_time_hours").attr("value")=="" || $("#other_end_time_minutes").attr("value")=="")
	{
		alert("Please enter end time");
		return false;
	}

        // is the date entered recent enough?
        var odate = new Date($("#other_date").attr("value"));
        var now = new Date();
	if(odate.getDate()+2 < now.getDate())
	{
		alert("Warning: You are adding hours that are more than two days old. Soon you will not be able to add late hours.");
		//return false;
	}

	return true;
}

</script>

<!-- endtareklink -->

<?
put_ptts_footer("");
?>
<script type="text/javascript">
$(document).ready(function(){
	jquery_date('other_date');
	$("#tut_date0").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$month?>-01-<?=$year?>'  });
	$("#tut_date1").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$month?>-01-<?=$year?>'  });
});
</script>
