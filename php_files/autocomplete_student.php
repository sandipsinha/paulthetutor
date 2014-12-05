<?
include($strAbsPath . "../pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();


    $q=$_GET['q'];
    $string=mysql_real_escape_string($q);

	/*$QStrsi = runquery("select finfo.id,PTs.first_name as stdf,PTs.last_name as stdl, finfo.main_name, finfo.students from PT_Family_Info finfo 	
	left join PTStudentInfo_New PTs on PTs.id in (select id from PTStudentInfo_New where fid=finfo.id)
	where finfo.main_name like '%".$string."%'
	or finfo.billing_name like '%".$string."%'
	or finfo.id like '%".$string."%'	
	or PTs.first_name like '%".$string."%'
	or PTs.last_name like '%".$string."%'
	ORDER BY finfo.main_name");
*/
	$QStrsi = runquery("select PTs.id,PTs.first_name as stdf,PTs.last_name as stdl, finfo.main_name, finfo.students 	
	from PTStudentInfo_New PTs 	
	left join PT_Family_Info finfo 
	on finfo.id = PTs.fid 
	where (finfo.main_name like '%".$string."%'
	or finfo.billing_name like '%".$string."%'
	or finfo.id like '%".$string."%'	
	or PTs.first_name like '%".$string."%'
	or PTs.last_name like '%".$string."%'
	or PTs.id like '%".$string."%')
	and PTs.archived <> 1
	ORDER BY finfo.main_name");


    if($QStrsi)
    {      
		while($arsi = mysql_fetch_array($QStrsi)){
			$getstudents = "";
			$flag=true;
			if($arsi['stdf']!="")
			{
				$getstudents =  $arsi['stdf'];
				if($arsi['stdl']!="")
					$getstudents .=  " ".$arsi['stdl'];
				$flag=false;
			}			
			echo $getstudents." (".$arsi['main_name'].") ".$arsi['id']."|".$arsi['id']."\n";
		}
    }
?>

