<?
include("../includes/pttec_includes.phtml");
$son = $_SERVER['HTTPS'];
if($son <> "on"){
	header( "Location: https://www.paulthetutors.com/admin/strippay_action2.php");
}
MySQL_PaulTheTutor_Connect();
$folder = getfolder('','','');
if($folder <> 'admin')
	die("You are not authorized to view this site!");	

put_ptts_header("Payment Processing for Paul the Tutor's", $strAbsPath, $folder, "");

?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
<table width="751" border="2" cellspacing="2" cellpadding="3" bgcolor="#996600" class=table_1>
  <tr>
    <td width="737" class=td_header>Enter Payment Information</td>
  </tr>
  <tr>
    <td >


<table width="100%" bgcolor="#FFFFFF">
        <!-- to display errors returned by createToken -->
        <span class="payment-errors"></span>
        <form action="strippay_process_test.php" method="POST" id="payment-form">
		    <div class="form-row">
             
			 <?
				 $sqs = "select user_id, CONCAT( SUBSTRING_INDEX(main_name, ' ', -1), ', ', SUBSTRING_INDEX(main_name, ' ', 1), '(', last_four, ')') as account  from PT_Strip_Info s JOIN  PT_Family_Info f on user_id = f.id where s.archived = 0 order by account ASC";
				 
				 //echo "qs is $sqs <BR>";
				 SelectFromQuery($sqs, "account", "user_id");

	?>		
				
			 			 
            </div>

		    <div class="form-row">
                <tr><td align="right">Payment Amount: $</td><td>
<?
// determine what will be the preset amount based on the folder.
$due = NULL;
?>
                <input name="amount" type="text" class="payment_amount" id="Name" size="10" value="<?=$due;?>" autocomplete="off" />
				&nbsp;&nbsp;&nbsp;
<? if($folder == "admin"){ ?>
           <span class="form_little_link"><a onclick="javascript:popup('get_total_due.php','','500','500')" font-weight:bold;">See Total Due for An Account</a></span>
		   
<? }  // end if admin
?>
				
				
				</td>
                </tr>
            </div>          

<? if($folder == "admin") { ?> 
            <div class="form-row">
                <tr>
                    <td align="right">Password: </td>
                    <td> <input name="password" type="password" />
                  </td>
                </tr>
            </div>
<? } ?>		
		
			<tr><td colspan="2" align="center">  
            	<button type="submit" class="submit-button">Submit Payment</button>
			</td></tr>
       
	   
	    </form>
		</table>
		</td></tr></table>
    </body>
</html>
