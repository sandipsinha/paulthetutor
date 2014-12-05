<?
include("../includes/pttec_includes.phtml");
$son = $_SERVER['HTTPS'];
if($son <> "on"){
	header( "Location: https://www.paulthetutors.com/admin/strip_saved_charge2.php");
}
MySQL_PaulTheTutor_Connect();
$folder = getfolder('','','');
if($folder <> 'admin' and $folder <> 'parents')
	die("You are not authorized to view this site!");	
	
if($folder == 'parents'){
	include("../includes/.check_login.php");
}

$popup = $_REQUEST[popup];


put_ptts_header("Payment Processing for Paul the Tutor's", $strAbsPath, $folder, $popup);

?>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
<table  border="2" cellspacing="2" cellpadding="3" bgcolor="#996600" class=table_1>
  <tr>
    <td  class=td_header>Enter Payment Information</td>
  </tr>
  <tr>
    <td >


<table width="100%" bgcolor="#FFFFFF">
        <!-- to display errors returned by createToken -->
        <span class="payment-errors"></span>
        <form action="strippay_process4.php" method="POST" id="payment-form">
		    <div class="form-row">
             
			 <?
			 
			 if($popup == "popup"){
				 puthiddenfield("popup", "popup");
			 }
			 
			$select_name = "Saved Customer";
			$par_where = "  ";
			
			if($folder == 'parents'){
				$select_name = "Saved Card";
				$family_id = $_SESSION['fid'];
				$par_where = " and user_id = $family_id and 1=1";
				$sqs_name = "'Card '";
			}
			
			if($folder == 'admin')
				$sqs_name = "SUBSTRING_INDEX(main_name, ' ', -1), ', ', SUBSTRING_INDEX(main_name, ' ', 1)";
			
				 $sqs = "select f.id as fam_id, s.id as card_id, $sqs_name as cust_name, CONCAT( $sqs_name, ' (xxxx-xxxx-xxxx-', last_four, ')') as account, (select ROUND(sum(b.amount - b.paid_amount),2) from PT_Billing b where b.fid = user_id) as due  from PT_Strip_Info s JOIN  PT_Family_Info f on user_id = f.id  where s.archived = 0   $par_where  HAVING due > 0 order by due DESC, cust_name ASC, card_id DESC";
				 $sRS = runquery($sqs);
				 
				 //echo "qs is $sqs <BR>";
				 while($row = mysql_fetch_array($sRS)){
					 
					 $tot_due = get_amount_due($row[fam_id]);
					$disArray[$row[card_id]] = "$row[account] \$$row[due] \$$tot_due";
					
				}

				putSelectInput("Family", "card_id", $disArray, $select_name, $strComment, $special, "Choose a Family");
				
//				 SelectFromQuery($sqs, $select_name, "card_id");

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
