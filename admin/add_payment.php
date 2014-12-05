<?php
ob_start();
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin",'popup');

if(!(isEmpty($_REQUEST[pay_fid]))){
	$pay_fid = $_REQUEST[pay_fid];
	echo "payment_process($pay_fid,$_REQUEST[amount])<BR>";
	payment_process($pay_fid,$_REQUEST[amount], $_REQUEST[comment]);
	echo '<script type="text/javascript">opener_reload();</script>';

}	
?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
     <form method="post"  name="form1">

<div align="center"><BR>
    <BR>
  

<table  cellspacing="3" cellpadding="3" width="80%" bordercolor="#666666">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" class="Head1_Brown">
		<div align="center">Enter Payment Information
        </div></td></tr>
	
   
        <? 
		
	
		put_fam_search ("drop", 'pay_fid', "", "Payment By", "");
?>
       
    <tr><td>Amount: $</td><td>
    <input name="amount" type="text" id="amount"></td></tr>
       
    <tr><td>Comment: </td><td>
    <input name="comment" type="text" id="comment" size="40" maxlength="100">
</td>

</tr>
    <tr><td>Date: </td><td>
    <input type="text" id="date_filter" name="date" value="<? echo date('m-d-Y'); ?>">
</td>
</tr>

<tr>
	<td colspan="2">
	  <div align="left">
	    <fieldset class="submit">  
        <button type="submit" name="Submit">Submit</button>
        <button onclick="popup_close()">Close</button>
	    </fieldset>
      </div></td>
</tr></table></div>
</form>
<script type="text/javascript">

$(document).ready(function(){
	jquery_date('date');
});
</script>
