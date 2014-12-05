<?
include($strAbsPath . "../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();


    $q=$_GET['q'];
    $string=mysql_real_escape_string($q);

	$QStrsi = runquery("select finfo.id,PTs1.first_name as stdf1,PTs1.last_name as stdl1, PTs2.first_name as stdf2, PTs2.last_name as stdl2, PTs3.first_name as stdf3, PTs3.last_name as stdl3, PTs4.first_name as stdf4, PTs4.last_name as stdl4, finfo.main_name, finfo.students from PT_Family_Info finfo 	
	left join PTStudentInfo_New PTs1 on PTs1.id = finfo.sid1
	left join PTStudentInfo_New PTs2 on PTs2.id = finfo.sid2
	left join PTStudentInfo_New PTs3 on PTs3.id = finfo.sid3
	left join PTStudentInfo_New PTs4 on PTs4.id = finfo.sid4
	where finfo.main_name like '%".$string."%'
	or finfo.billing_name like '%".$string."%'
	or finfo.id like '%".$string."%'
	or finfo.sid1 like '%".$string."%'
	or finfo.sid2 like '%".$string."%'
	or finfo.sid3 like '%".$string."%'
	or finfo.sid4 like '%".$string."%'
	or PTs1.first_name like '%".$string."%'
	or PTs1.last_name like '%".$string."%'
	or PTs2.first_name like '%".$string."%'
	or PTs2.last_name like '%".$string."%'
	or PTs3.first_name like '%".$string."%'
	or PTs3.last_name like '%".$string."%'
	or PTs4.first_name like '%".$string."%'
	or PTs4.last_name like '%".$string."%'
	ORDER BY finfo.main_name");

    if($QStrsi)
    {      
		while($arsi = mysql_fetch_array($QStrsi)){
			$getstudents = "";
			$flag=true;
			if($arsi['stdf1']!="")
			{
				$getstudents =  $arsi['stdf1'];
				if($arsi['stdl1']!="")
					$getstudents .=  " ".$arsi['stdl1'];
				$flag=false;
			}
			if($arsi['stdf2']!="")
			{
				if($flag==false)
					$getstudents .=",";
				$getstudents .=  $arsi['stdf2'];
				if($arsi['stdl2']!="")
					$getstudents .=  " ".$arsi['stdl2'];
				$flag=false;
			}
			if($arsi['stdf3']!="")
			{
				if($flag==false)
					$getstudents .=",";
				$getstudents .=  ",".$arsi['stdf3'];
				if($arsi['stdl3']!="")
					$getstudents .=  " ".$arsi['stdl3'];
				$flag=false;
			}
			if($arsi['stdf4']!="")
			{
				if($flag==false)
					$getstudents .=",";
				$getstudents .=  ",".$arsi['stdf4'];
				if($arsi['stdl4']!="")
					$getstudents .=  " ".$arsi['stdl4'];
				$flag=false;
			}
			echo $arsi['main_name']." (".$getstudents.") ".$arsi['id']."|".$arsi['id']."\n";
		}
    }
?>

