<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "");
?>

	  <!--functionality for the admin-->
	  
	 <table width="100%"  align="center" cellspacing="2" cellpadding="0" class=table_1>
		  <tr>
			<td class=td_header>Look at the Calendar For One or All Tutors:</td>
		  </tr>
		  <tr>
			<td height ="100" align="left">
			 <form name = "form2" method="GET" action="calendar_action.php">
				<table border="0" cellpadding="3" margin="0" align="left" cellspacing="3" width="100%" bgcolor="#FFFFFF">
				  <TR align="left">
				  
				  <div align="left">
				  
				  
		  <?
		
		
		//$QStrsi = runquery("select * from PT_Tutors ORDER BY first_name");
		
		$QStrsi = runquery("select * from PT_Tutors where (position LIKE '%tutor%' OR position LIKE '%class%' OR position LIKE '%admin%') and archived = 0 ORDER BY first_name");
		
		
		while($arsi = mysql_fetch_array($QStrsi)){
			$arr_tutors[$arsi[id]] = "$arsi[first_name] $arsi[last_name]";
		}
// putSelectInput('Tutor', 'j_tid', $arr_tutors, '', '', 'required','Choose a Tutor');
		get_tutor_id($j_tid, "j_tid", "", "","Choose a Tutor");
		?>
				  <TR>
					<TD width="51%">
					  <div align="right">Month </div>
					<TD width="49%">
		<? putMonthsSelect('month'); ?> </td> </tr>
				  <TR>
					<TD width="51%">
					  <div align="right">Year </div>
					<TD width="49%">
		<? putYearsSelect(year); ?>

		</td></tr><TR>
					<TD colspan="2">
					  <div align="center">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="Submit" value="Submit">
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="Reset">
					  </div>

				</table>
			  </form></td></tr></table>
	  
	  
<?
put_ptts_footer("");
?>
