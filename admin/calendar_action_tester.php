<?php
session_start();
include("../includes/pttec_includes.phtml");
include("../includes/calendar05.phtml");
MySQL_PaulTheTutor_Connect();

$month = isset($_REQUEST['month']) ? $_REQUEST['month'] : null;
$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : null;

if(isset($_REQUEST['j_tid']))				//if it is set then this page is opened first time for that tutor and his id should be saved
{
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
		
		$query = "select distinct id from PT_Tutors";
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
else								       //if it isn't then the page is called from itself and the tutor id should rest the same
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

//function that makes form that adds appointment , $type is 1 if the form is for admin or 0 if it is not
function makeForm($nameOfTheForm, $m, $y,$type,$count_date=0)	
{
?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">


<?	
	$month = $m;
	$year = $y;
	echo "<form name='$nameOfTheForm' method='post' action='calendar_action.php'  aonsubmit=\"return checkInputs0(".$count_date.",'".$nameOfTheForm."')\">
			
			<tr>
				<td nowrap>
                                        <span class=\"Head2_Green\">Enter Tutoring Sessions</span>
					<div align='center'>
					<input name='month' type='hidden' value='$month'>
					<input name='year' type='hidden' value='$year'>
			
					<select name='add_fid' id='sid'>
					<option value=''>  Choose Student </option>";
				
	$QStrsi = "select students, billing_name, id from PT_Family_Info order by students";
	if(!($siRS = mysql_query($QStrsi)))
	{
		echo "QStr:  $QStrsi <BR>" . mysql_error() . "<BR><BR>";
	}

	
	
	while($arsi = mysql_fetch_array($siRS))
	{
		$sel_str = "$arsi[billing_name] ($arsi[students])";
	
		echo "<option value=$arsi[id]>
			$sel_str
			</option>";
    } 
    echo"</select>
	&nbsp;&nbsp;&nbsp;";
	
	if($type == 1)
	{
		/*$QStrsi1 = "select pt.first_name, pt.last_name, pt.id from PT_Tutors pt ";
		if(!($siRS1 = mysql_query($QStrsi1)))
		{
			echo "QStr:  $QStrsi1 <BR>" . mysql_error() . "<BR><BR>";
		}

		
		echo "<select name='tutors'>
				<option value=''></option>";

			
		while($arsi1 = mysql_fetch_array($siRS1))
		{
			$sel_str = "$arsi1[first_name] $arsi1[last_name]";
		
			echo "<option value=$arsi1[id]>
				$sel_str
				</option>";
		} 
		echo"</select>
		&nbsp;&nbsp;&nbsp;";*/
		
		tutorsid_menu(-1,"add_tid");
	}	
	
	 /* echo "$month";
	  echo"
	  -  
	  <input name='numday' type='text' id='date' size='3'>
	  -
	  $year*/
	echo "&nbsp;&nbsp;Date <input name='tut_date".$count_date."' type='text' id='tut_date".$count_date."' style='width:80px'>&nbsp;&nbsp;Start time
	<input name='start_time' type=text id='start_time' size='4' maxlength='4'>
	<select name='ampm' id='ampm'>
	  <option value='0'>am</option>
	  <option selected>pm</option>
	</select>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hours &nbsp;
	<input name='hours' type='text' id='hours' size='5' maxlength='5'>
	&nbsp;&nbsp; rate 
	<input name='rate' type='text' id='rate' size='5' maxlength='5'>
	&nbsp;&nbsp; pay 
	<input name='pay' type='text' id='pay' size='4' maxlength='4'>
	<BR>
	  <input name='action' type='submit' value='Add'>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</div>

		</td>
	  </tr>
	</table>
	</form>
	";
	

}


		
/**************************************************
Deal with added or deleted appointments or checked days
***************************************************/
// if a day has been checked, updated the datebase
If (isset($_REQUEST['checked']) && $_REQUEST['checked']<>NULL && $_SESSION['j_tid']){
	$i_date = $_GET['year'] . "-" . $_GET['month'] . "-" . $_GET['checked'];

	$iQStr = "insert into PT_Checked_Day (checked,date,tid) VALUES (1,'$i_date',$_SESSION[j_tid])";
//	echo $iQStr ."<BR><BR>";
	$iRS = runquery($iQStr);
}	

If (isset($_REQUEST['unchecked']) && $_REQUEST['unchecked']<>NULL && $_SESSION['j_tid']){
	$i_date = $_GET['year'] . "-" . $_GET['month'] . "-" . $_GET['unchecked'];

	$iQStr = "DELETE FROM PT_Checked_Day WHERE date='$i_date' AND tid=$_SESSION[j_tid]  LIMIT 1";
//	echo $iQStr ."<BR><BR>";
	$iRS = runquery($iQStr);
}


// if a add command has been given, insert the info into PTAddedApp
If (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Add'){
	
	$start_time = $_REQUEST['start_time'];
	$ampm_temp = $_REQUEST['ampm'];
	$start_time = format_time_db_input($start_time, $ampm_temp);            
	//$add_date = $_REQUEST['year'] . "-" . ($_REQUEST['month']<10 ? "0".$_REQUEST['month'] : $_REQUEST['month']) . "-" . $_REQUEST['numday'];     
	if ($_REQUEST['tut_date0'])
		$add_date = format_date_db($_REQUEST['tut_date0']);
	elseif($_REQUEST['tut_date1'])
		$add_date = format_date_db($_REQUEST['tut_date1']);
	if ($_REQUEST['add_fid']){
			$FQStr = "select students from PT_Family_Info where id = ".$_REQUEST['add_fid'];
			$FRS = runquery($FQStr);
			$far = mysql_fetch_array($FRS);
			$_REQUEST['name'] = $far['students'];
		}
	$Str_Mess = session_add2($add_date, $start_time, $_REQUEST['add_fid'], $_REQUEST['hours'], $_REQUEST['rate'], $_REQUEST['pay'], $_REQUEST['add_tid'],'','', $_REQUEST['name']); 

	
//	echo "$add_date, $start_time, $add_fid, $_REQUEST[hours], $_REQUEST[rate], $_REQUEST[pay], $add_tid <BR>";
	
	
	
//	$AQStr = "INSERT INTO PTAddedApp (sid, date, hours, rate, start_time) VALUES ('$add_fid', '$add_date', '$hours', '$rate', '$start_time')";
// echo $AQStr . "<br>";
//	$ARS = runquery($AQStr);
//	$Str_Mess = "<strong>Added $hours hours at $$rate / hour on $numday $_REQUEST[addname] </strong><BR><BR>";
} // end if	



put_ptts_header("Admin Calendar for $str_month $year", $strAbsPath, "tutors", "");
?>
</td></tr></table>
</td></tr></table>
</td></tr></table>




<?

///tareklink///



If (isset($_REQUEST['action_other']) && $_REQUEST['action_other'] == 'Add'){
	
	$start_hours = $_REQUEST['start_time_hours'];
	$start_mins = $_REQUEST['start_time_minutes'];
	if(strlen($start_mins)==1)$start_mins='0'.$start_mins;
	$start_ampm = $_REQUEST['start_ampm'];
	$end_hours = $_REQUEST['end_time_hours'];
	$end_mins = $_REQUEST['end_time_minutes'];
	if(strlen($end_mins)==1)$end_mins='0'.$end_mins;
		$end_ampm = $_REQUEST['end_ampm'];
		$start_time = format_time_db_input($start_hours.$start_mins, $start_ampm);
		$end_time = format_time_db_input($end_hours.$end_mins, $end_ampm);               
	
	$tutor_id=$_REQUEST['other_tutors'];
	
	$name = $_REQUEST['name'];
	$email =  $_REQUEST['email'];
	$phone =  $_REQUEST['phone'];
	$comments =  $_REQUEST['comments'];
	
	$other_date = format_date_db($_REQUEST['other_date']); 
	non_tut_session_add($other_date, $start_time, $end_time, $tutor_id, $name, $email, $phone, $comments);
	
        if ($paid)
	  $hoursid = non_tut_hours('add',array(
            'tutor_id'=>$tutor_id,
            'date'=>$other_date,
            'hours'=>$hours,
            'rate'=>$_REQUEST['rate'],
            'description'=>'Non-Tut Appt: '.$name,
            'comments'=>$comments,
            'other_appt_id'=>$apptid,
          ), '', 'id', '', '');

        mysql_query('UPDATE PT_Other_Appt SET work_hours_id = '.$hoursid.' WHERE id='.$apptid);
	mysql_query($query);
//	$AQStr = "INSERT INTO PTAddedApp (sid, date, hours, rate, start_time) VALUES ('$add_fid', '$add_date', '$hours', '$rate', '$start_time')";
// echo $AQStr . "<br>";
//	$ARS = runquery($AQStr);
//	$Str_Mess = "<strong>Added $hours hours at $$rate / hour on $numday $_REQUEST[addname] </strong><BR><BR>";
 // end if	

}

///endtareklink///

?>

<?

$i = 0;
$strQfid = "";

/*if(!(isEmpty($_REQUEST['fid']))){
	$_SESSION['fid'] = $_REQUEST['fid'];	
}	

if(!(isEmpty($_SESSION['fid'])))
{
	$strQfid = " where id = ".$_SESSION['fid'];
}*/

$QStr = "select id as fid, students from PT_Family_Info $strQfid";

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
	if(!empty($j_tid))
	{
		if($arBillInfo = gettutBillInfo($month, $year, $arStudentInfo[0],$j_tid,null))
		{

			while (list ($key, $value) = each($arBillInfo)){

			   $SI[$i]["name"] = $arStudentInfo[1];
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

				   $SI[$i]["name"] = $arStudentInfo[1];
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
echo"<table align='center'><tr><td><table width='1000'  border='1' cellpadding='0' cellspacing='0'  align='center' bordercolor='#000000'>";	
// first form on the page
makeForm("form1", $month, $year, 1,0);

// printarray($SI);


?>

<?
// echo "this is the array that is passed.  month and year are $month and $year<BR>";
 //printarray($SI);
   
///tareklink///

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


//calls the function which fill the table
outputCalendar($SI,$month,$year,$itype,isset($_REQUESST['day'])?$day:'',$irate,1);	

///endtareklink///

?>





<!-- tareklink -->
<!--form on the bottom-->
<br>
<form name="form3" onsubmit="return checkInputs()" method="post" action="calendar_action.php">

<table width="1000"  border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" align='center'>
  <tr>
    <td width="837">
<span class="Head2_Green">Non-Tutoring Appointment</span>  <br>
      <div align="center">
          <input name="month" type="hidden" value="<?=$month?>">
          <input name="year" type="hidden" value="<?=$year?>">
    
  <div style="text-align:left">
  Tutor:
  <?tutorsid_menu(-1,"other_tutors",null,array('all'=>true));?>
  
  Name
  :  
  <input name="name" type="text" id="other_name" size="8">
 
  &nbsp;&nbsp;&nbsp; 
  Email
  :  
  <input name="email" type="text" id="other_email" size="8">
  
  &nbsp;&nbsp;&nbsp;
  Phone
  :  
  <input name="phone" type="text" id="other_phone" size="8">
    </div>
    <br />
    <div style="text-align:left">
    
  
	 

  Date
  :  
  <input name="other_date" type="text" id="other_date" size="7">

&nbsp;&nbsp;&nbsp;starts at 
<input name="start_time_hours" type=text id="other_start_time_hours" size="4" maxlength="4">
 : 
<input name="start_time_minutes" type="text" id="other_start_time_minutes" size="5" maxlength="5">


<select name="start_ampm" id="start_ampm">
  <option value="am">am</option>
  <option value="pm" selected>pm</option>
</select>

&nbsp;&nbsp;&nbsp;ends at 
<input name="end_time_hours" type=text id="other_end_time_hours" size="4" maxlength="4">
 : 
<input name="end_time_minutes" type="text" id="other_end_time_minutes" size="5" maxlength="5">


<select name="end_ampm" id="end_ampm">
  <option value="am">am</option>
  <option value="pm" selected>pm</option>
</select>
&nbsp;&nbsp;

Comments: 
<textarea name="comments" id="comments"></textarea>
&nbsp;&nbsp;
<hr />
<div style="text-align:left; vertical-align:middle">
Is this a paid or unpaid appointment: <select id="other_ispaid" name=ispaid style="text-align:left; vertical-align:top"><option value='' selected></option><option value="unpaid">Unpaid</option><option value="paid">Paid</option></select>
&nbsp;&nbsp;Rate: <input name="rate" value="0" style="vertical-align:middle;" >
&nbsp;&nbsp;
  <input name="action_other" type="submit" value="Add">
  
  </div>
        </div>

	</td>
  </tr>
  <tr><td><br>To add non-tutoring hours that do not show as busy, click <a href="work_hours_edit.php">here</a><br><br></td></tr>
</table>
</form>
<link rel="stylesheet" href="/styles/paulthetutor.css" type="text/css"> 

<script type="text/javascript">

$(document).ready(function(){

	$("#other_date").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$month?>-01-<?=$year?>'  });
	$("#tut_date0").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$month?>-01-<?=$year?>'  });
	$("#tut_date1").datepicker({ dateFormat: 'mm-dd-yy', defaultDate: '<?=$month?>-01-<?=$year?>'  });
	
});


/*function checkInputs0(count_date,form_name)
{
	alert($("form[name='"+form_name+"']").child('sid').attr("value"));
	if($("form[name='"+form_name+"']").child('#sid').attr("value")=="")
	{
		alert("Please choose the student");
		return false;
	}
	else if($("input[name='add_tid']").attr("value")=="")
	{
		alert("Please select a tutor");
		return false;
	}
	else if($("#tut_date"+count_date).attr("value")=="")
	{
		alert("Please enter a date");
		return false;
	}
	else if($("#start_time").attr("value")=="")
	{
		alert("Please enter start time");
		return false;
	}
	else if($("#pay").attr("value")=="")
	{
		alert("Please enter the pay");
		return false;
	}

	return true;
}*/


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

	return true;
}

</script>

<!-- endtareklink -->

<?
put_ptts_footer("");
?>
