<?php
session_start();
include("../includes/pttec_includes.phtml");
include("../includes/phtml_files/calendar05.phtml");
MySQL_PaulTheTutor_Connect();
printarray($_REQUEST);

$month = isset($_REQUEST['month']) ? $_REQUEST['month'] : null;
$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : null;


if((isset($_REQUEST['j_tid'])) or (!(isEmpty($_SESSION['j_tid']))))	{
	
	if(isEmpty($_REQUEST['j_tid'])) $_REQUEST['j_tid'] = $_SESSION['j_tid'];
	//if it is set then this page is opened first time for that tutor and his id should be saved
	//$_SESSION['j_tid']  is the chosen tutor from calendar.php
	$_SESSION['j_tid'] = isset($_REQUEST['j_tid']) ? $_REQUEST['j_tid'] : null;
	$j_tid = $_SESSION['j_tid'];
	//also the tutor's name must be retrieved
	$r=mysql_query("select first_name, last_name from PT_Tutors where id = '$j_tid'");
	$row1=mysql_fetch_array($r);
	$_SESSION['j_tid_name'] = "$row1[first_name] ".strtoupper(substr($row1['last_name'],0,1));
	$j_tid_name = $_SESSION['j_tid_name']; 
	
	//if no tutor is selected, array with all tutors is created, so their appointments could be shown 
	if(empty($j_tid))
	{
		
		$query = "select distinct id from PT_Tutors where (position LIKE '%tutor%' OR position LIKE '%class%' OR position LIKE '%admin%') and archived = 0";
		if(!($res = mysql_query($query))){
			echo "Query:  $query <BR>" . mysql_error() . "<BR><BR>";
		}
		$tutno=mysql_num_rows($res);
		$tuts=Array();
		$tut_info = Array();
		while($tut = mysql_fetch_array($res))
		{
			array_push($tuts,$tut['id']);
			$tutid=$tut['id'];
			$q1= "select first_name, last_name from PT_Tutors where id=$tutid";
			$r1 = mysql_query($q1);
			$row1 = mysql_fetch_array($r1);
			$tutname = "$row1[first_name] ".strtoupper(substr($row1['last_name'],0,1));
			//array tutinfo holds tutor id and his name, so it can be written in the function outputCalendar()
			$tut_info[$tutid] = $tutname;
			//echo $row1[0] . $row1[1];
		}
		
		//printArray($tuts);
		//printArray($tut_info);
	}
}
else	 //if it isn't then the page is called from itself and the tutor id should rest the same
{
	$j_tid = isset($_SESSION['j_tid']) ? $_SESSION['j_tid'] : null;
	$j_tid_name = isset($_SESSION['j_tid_name']) ? $_SESSION['j_tid_name'] : null;
	
	//if no tutor is selected, array with all tutors is created, so their appointments could be shown 
	if(empty($j_tid))
	{
	
		$query = "select distinct id from PT_Tutors";
		if(!($res = mysql_query($query))){
			echo "Query:  $query <BR>" . mysql_error() . "<BR><BR>";
		}
		$tuts=Array();
		$tutno=mysql_num_rows($res);
		while($tut = mysql_fetch_array($res))
		{
			array_push($tuts,$tut['id']);
			$tutid=$tut['id'];
			$q1= "select first_name, last_name from PT_Tutors where id=$tutid";
			$r1 = mysql_query($q1);
			$row1 = mysql_fetch_array($r1);
			$tutname = "$row1[first_name] ".strtoupper(substr($row1['last_name'],0,1));
			//array tutinfo holds tutor id and his name, so it can be written in the function outputCalendar()
			$tut_info[$tutid] = $tutname;
			//echo $row1[0] . $row1[1];
		}
		
		//printArray($tuts);
	}
}

//$tutor_id is the id of the logged person(like in the tutors calendar)
$tutor_id = isset($_SESSION['tutor_id']) ? $_SESSION['tutor_id'] : null ;


if(isEmpty($month)){
	$str_month = date('F');
	$month = date('n');
}
else
{
	$str_month = date('F', mktime(0, 0, 0, $month, 11, 2000));
}	

if(isEmpty($year)){
	$year = date('Y');
}





put_ptts_header("Admin Calendar for $str_month $year", $strAbsPath, "tutors", "");
?>
</td></tr></table>
</td></tr></table>
</td></tr></table>




<?

///tareklink///



$i = 0;
$strQfid = " where 1 = 1 ";

/*if(!(isEmpty($_REQUEST['fid']))){
	$_SESSION['fid'] = $_REQUEST['fid'];	
}	

if(!(isEmpty($_SESSION['fid'])))
{
	$strQfid = " where id = ".$_SESSION['fid'];
}*/

$QStr = "select id as fid, students from PT_Family_Info $strQfid and id IN (select family_id from PTAddedApp where month(date) = $month and year(date) = $year)";

if(!($StudentInfoRS = mysql_query($QStr))){
	echo "$QStr <br>" . mysql_error();
}
//get each students info
// echo "si array is <BR>";
// printarray($SI);
// echo "end of first SI";

while($arStudentInfo = mysql_fetch_array($StudentInfoRS))
{

	// get the scheduling information for the student
	$ses_where = "where 1 = 1 and ";
	
	if(!empty($j_tid))
	{
		$ses_where .= " tid = j_tid ";
		if($arBillInfo = gettutBillInfo($month, $year, $arStudentInfo[0],$j_tid,null))
		{

			while (list ($key, $value) = each($arBillInfo)){
				$student_id = $value["student_id"];

			   $SI[$i]["name"] = get_student_name($student_id);
			   $SI[$i]["hrs"] =  $value["hours"];
			   $SI[$i]["start"] = $value["start_time"];
			   $SI[$i]["dom"] = $value["printday"];
			   $SI[$i]["rate"] = $value["rate"];
			   $SI[$i]["pay"] = $value["pay"];
			   $SI[$i]["tutname"] = $_SESSION['j_tid_name'];
			   $SI[$i]["id"] = $value["id"];
			   $SI[$i]["tid"] = $value["tid"];
			   $i = $i + 1;
				}
	
		} // end if	
	}
	else				//appointments for all the tutors
	{
		for($j=0;$j<$tutno;$j++)
		{

			if($arBillInfo = gettutBillInfo($month, $year, $arStudentInfo[0],$tuts[$j],null))
			{
				
				while (list ($key, $value) = each($arBillInfo)){

				$student_id = $value["student_id"];
				   $SI[$i]["name"] = get_student_name($student_id);
				   $SI[$i]["hrs"] =  $value["hours"];
				   $SI[$i]["start"] = $value["start_time"];
				   $SI[$i]["dom"] = $value["printday"];
				   $SI[$i]["rate"] = $value["rate"];
				   $SI[$i]["pay"] = $value["pay"];
				   $SI[$i]["tutname"] = $tut_info[$tuts[$j]];
				   $SI[$i]["tid"] = $value["tid"];
				   $SI[$i]["id"] = $value["id"];
				   
				   $i = $i + 1;
					}
		
			} // end if	
		
		}
	
	}
}




$query = "SELECT o.*,t.first_name as t_first_name, t.last_name as t_last_name FROM PT_Other_Appt o LEFT JOIN PT_Tutors t ON o.tutor_id=t.id WHERE 1 ".($j_tid ? " AND o.tutor_id=".$j_tid : "")." and o.date >= '$year-$month-01' AND o.date <= '$year-$month-31' ORDER BY o.date";

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
	$temp['tutname'] = $row->t_first_name." ".strtoupper(substr($row->t_last_name,0,1));
	$temp['type']=2;
	

	
	array_push($other_arr,$temp);
	
}

$query = "SELECT w.*,t.first_name as t_first_name, t.last_name as t_last_name FROM PT_NT_Work_Hours w LEFT JOIN PT_Tutors t ON w.tutor_id=t.id WHERE 1 ".($j_tid ? " AND w.tutor_id=".$j_tid : "")." and w.date >= '$year-$month-01' AND w.date <= '$year-$month-31' ORDER BY w.date";

$result = mysql_query($query);

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
//die('<pre>'.var_export($non_tut_hrs,true).'</pre>');

if(isset($j_tid) && $j_tid) {
  $sched = Array();
  for($day=1; $day<=31;++$day) {
    $dow=date("w",strtotime("$year-$month-$day"));
    $query = "SELECT * FROM PT_SchedSS_Norm WHERE  tutor_id=".$j_tid ." AND start_date <= '$year-$month-$day' AND end_date >= '$year-$month-$day' AND dow=$dow ORDER BY start_date";

    $result = mysql_query($query);


    while($row = mysql_fetch_object($result)) {	
	$temp = Array();
	$temp['id'] = $row->id;
	$temp['start'] = $row->clock_in;
	$temp['end'] = $row->clock_out;
	$temp['tid'] =$row->tutor_id;
	$temp['dom']=$day;
	$temp['type']=CAL_IN_OUT;
	array_push($sched,$temp);
	
    }
  }
}
if(!isset($SI))
	$SI = Array();
if(!isset($sched))
	$sched = Array();
if(!isset($other_arr))
	$other_arr = Array();

$SI = array_merge($other_arr, $SI);
$SI = array_merge($non_tut_hrs, $SI);
$SI = array_merge($sched, $SI);

//die('<pre>'.var_export($SI,true).'</pre>');
echo"<table align='center'>
<tr>
<td>
<table width='1000'  border='1' cellpadding='0' cellspacing='0'  align='center' bordercolor='#000000'>";	

if(!isset($SI))
	$SI = Array();


# sort alphabetically by name
//usort($merged, 'compare_dom');
/*
echo "<pre>";
print_r($merged);
echo "</pre>";
 
*/
// $rate = $HTTP_GET_VARS['rate'];

 $irate = isset($_REQUEST['rate']) ? $_REQUEST['rate']:null;
 $itype = isset($_REQUEST['type']) ? $_REQUEST['type']:null;

//Tutor and Date Table

//calls the function which fill the table

outputCalendar($SI,$month,$year,$itype,isset($_REQUESST['day'])?$day:'',$irate,1);	

///endtareklink///

echo"</table></td></tr></table>"

?>


<link rel="stylesheet" href="/includes/paulthetutor.css" type="text/css"> 

<script type="text/javascript">

$(document).ready(function(){

	$("#other_date").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$month?>-01-<?=$year?>'  });
	$("#tut_date0").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$month?>-01-<?=$year?>'  });
	$("#tut_date1").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$month?>-01-<?=$year?>'  });
	
});


</script>


  		</td>
    </tr>
</table>

<!-- endtareklink -->

<?
put_ptts_footer("");
?>

<script type="text/javascript">
	//the calendar table is being rendered below the footer
	//this script moves the table above the footer when document loads
	$( document ).ready(
		$( ".footer" ).before( $( "table" )[0] )
	);
	
</script>
