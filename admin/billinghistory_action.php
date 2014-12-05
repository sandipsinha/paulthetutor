<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$fid = $_REQUEST[family_id];
if(!isEmpty($_REQUEST[fid]))
	$fid = $_REQUEST[fid];
$fam_name = get_fam_name($fid);
$title = "Billing Information for ".$fam_name;
$type = $_REQUEST['type'];
if ($type == '')
	$type = 'all';
put_ptts_header($title, $strAbsPath, "admin", "");
?>
<table width="100%" border="0" height="0" cellpadding="0" margin="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
    <td class="td_header">&nbsp;<?php echo $title;?>&nbsp;</td>
  </tr>
   <tr height=35>
    <td><div style="float:right"><?php echo '<u>'.fam_contact($fid).'</u>';?>&nbsp;</div>
    <?php 
    echo '<a href="billinghistory_action.php?fid='.$fid.'&type=all">All</a>&nbsp;
    <a href="billinghistory_action.php?fid='.$fid.'&type=bills">Bills</a>&nbsp;
    <a href="billinghistory_action.php?fid='.$fid.'&type=payments">Payments</a>';
    ?>
    &nbsp;|&nbsp;<?php echo '<a href="allbills_action.php?fid='.$fid.'">All Bills</a>';?>&nbsp;
    </td>
  </tr>
<tr>
  <td>
  <?php billing_history($fid,$type);?>
  </td>
</tr>
</table>
<?
put_ptts_footer("");
?>
