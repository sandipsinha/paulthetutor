<?PHP
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Payments", $strAbsPath, "admin", "");
$tablename1 = "PT_Payments"; 
$tablename2 = "PT_Family_Info";
$tablename3 = "ZZ_PT_Family_Info_Old";
$fid = $_REQUEST['fid'];
$fid_old = $_REQUEST['fid_old'];
$date_start = format_date_db($_REQUEST['date_start']);
$date_end = format_date_db($_REQUEST['date_end']);
$tablename_2 = $tablename2;
if ($date_end == '')
  $date_end = date("Y-m-d");
if ($date_start == '' && !$fid && !$fid_old)
  $date_start = adddate($date_end,-270);
if($fid_old)
  $tablename_2 = $tablename3;
$where = "1";  
if ($fid)
  $where.= " AND f.id=".$fid;
elseif($fid_old)
  $where.= " AND f.old_id=".$fid_old;
if ($date_start)
  $where.= " AND p.date>='".$date_start."'";
if ($date_end)
  $where.= " AND p.date<='".$date_end."'";;
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="table_1">
  <tr height="40">
    <td class="td_header">Payments</td>
  </tr>
  <form name=form method="post">
  <tr>
    <td align="center"><input type="submit" style="display:none">
    <?php
    echo "<b>Refine Payment List</b><br>";
   echo "".fam_menu("last", "fid", $fid, "Payments for What Family", $other). "&nbsp;&nbsp;&nbsp;";
 //   echo "><b>OR</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Archived families&nbsp;".fam_menu("last", "fid_old", $fid_old, "Select Family", "archive").'</div>';
    echo "<input style='width:80px' name='date_start' id='date_start' value='Start Date'>&nbsp;&nbsp;&nbsp;and&nbsp;&nbsp;&nbsp;<input style='width:80px' name='date_end' id='date_end' value='End Date'>";
    echo "<input type=submit value='Show payments'>";
    ?>
    <div align="right"><button onclick="javascript:popup('add_payment.php','Add A Payment','600','600')">
    Add New Payment
    </button></div></td>
  </tr>
</form>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="99%" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
    <td nowrap><?php  echo '<b>Payment ID</b>'?></td>
    <td nowrap><?php  echo '<b>Date</b>'?></td>
    <td nowrap><?php  echo '<b>Account</b>'?></td>
    <td nowrap><?php  echo '<b>Parent</b>'?></td>
    <td nowrap><?php  echo '<b>Amount</b>'?></td>
    <td nowrap><?php  echo '<b>Comments</b>'?></td>
    <td nowrap><?php  echo '<b>Students</b>'?></td>
  </tr> 

<? 

$QStr = "select p.*,f.id as fid,f.billing_name,f.students from $tablename1 p LEFT JOIN $tablename_2 f ON p.fid=f.".($fid_old ? "old_id" : "id")." WHERE $where order by p.id DESC";
if (!$fid && !$fid_old)
  $QStr = "select p.*,IF(f1.billing_name!='',f1.billing_name,f2.billing_name) as billing_name,IF(f1.students!='',f1.students,f2.students) as students, f1.id as fid from $tablename1 p LEFT JOIN $tablename2 f1 ON p.fid=f1.id LEFT JOIN $tablename3 f2 ON p.fid=f2.old_id WHERE $where order by p.id DESC";

$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
     <td>'.$row[id].'</td>
     <td>'.format_date_print(substr($row[date],0,10),"yy-mm-dd","-","mm/dd/yy","/").'&nbsp;</td>
     <td>'; 
$row_fid = $row['fid'];	 
	 
	
	 
?>

<div align="center"> <a href="javascript:popup('families_view.php?id=<?=$row_fid;?>&popup=popup','','500','500')">

<? 
echo 	"$row[fid] ";
?>
</a> </div>
<?
echo "	 </td>
     <td>".$row['billing_name'].'&nbsp;</td>
     <td>'.$row[amount].'&nbsp;</td>
     <td>'.$row[comment].'&nbsp;</td>
     <td>'.$row[students].'&nbsp;</td>
     </td>
 </tr>';
}
if (!mysql_num_rows($RS))
  echo '<tr>
        <td colspan=10>No payments found</td>
    </tr>';

?>
</table>
</td>
</tr>  
</table>
<?
put_ptts_footer("");
?>
<script type="text/javascript">
$(document).ready(function(){
  jquery_date('date_start');
  jquery_date('date_end');
  $('#fid').click(function() {
    $('#fid_old').val('');
  });
  $('#fid_old').click(function() {
    $('#fid').val('');
  });
});
</script>
