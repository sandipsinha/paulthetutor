<?php
ob_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();
$strBack = get_strBack();

put_ptts_header("", $strAbsPath, "tutors", "");


$x_from_login_page = 1;
include('../includes/.check_login.php');

if(isset($_REQUEST['logout']) && $_SESSION['fid'] && !isset($_REQUEST['username'])){
	session_destroy();
	if(isset($_SESSION['tid']))
		unset($_SESSION['tid']);
	setcookie("fid", "", time()-3600);
	$msg_success = "Logged Out";
}


if(isset($_REQUEST['referer']))
	$referer = $_REQUEST['referer'];
if ($referer == '')
	$referer = 'index_parents.php';

	
if(isset($_REQUEST['username'])){
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	$result = mysql_query("SELECT * FROM PT_Family_Info WHERE username = '$username' 
		AND password = '$password' AND archived = 0");
	if (!$result) {
        die(mysql_error());
    }
	elseif(mysql_num_rows($result) == 0){
		$msg_error = "Incorrect username and password combination";
	}
	else
		{
			$family_row = mysql_fetch_object($result);
			$_SESSION['fid'] = $family_row->id;
			$_SESSION['token'] = md5($x_login_key.$family_row->id);
			if(isset($_REQUEST['remember'])){
				setcookie("fid", $family_row->id, time()+60*60*24*365);
				setcookie("token", md5($x_login_key.$family_row->id), time()+60*60*24*365);
			}
			else{
				setcookie("fid","", time()-3600);
				setcookie("token","", time()-3600);
			}
			
			if($referer!=''){
				header("Location: $referer");
			}
		}	
}

?>

<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
<style>
.log_div_error{padding:10px; background: #fee3e3; border: solid 1px #fa936e; color: #ff3131; font-size:12px; text-align:left; width:290px; margin-top:3px}
.log_txt_error{color: #ff0000;}
.log_txt_logged_out{color: #008800; font-weight:bold;}
.a_blue{color: #008800; font-weight:bold;}
</style>
<form method="POST">
<input type=hidden name='referer' value="<?php echo $_REQUEST['referer']?>">  
<?php if ($msg_success == 1)?>
<div class="log_txt_logged_out" style="padding: 5px"><?php echo $msg_success?></div>
<fieldset>  
<legend class="Head1_Green">Login </legend>  
<?php if ($msg_error!=''){?>
<div class="log_div_error"><?php echo $msg_error ?></div><br>
<?php }?>

<div>  
<label for="username" <?php echo $msg_error ? "class=log_txt_error" : ""?>>Username:</label>  
<input id="username" name="username" class="text" type="text" />  
</div>  
<div style="margin-top:2px">   
<label for="password" <?php echo $msg_error ? "class=log_txt_error" : ""?>>Password:&nbsp;</label>  
<input id="password" name="password" class="text" type="password" />  
</div>  
<div style="margin-top:2px">
<input name="remember" id="remember" class="text" type="checkbox" />   
<label for="remember">Store my information on this computer</label> 
</div> 
<BR>
</fieldset>
<fieldset class="submit">  
<input class="submit" type="submit" value="Login" />  
&nbsp;&nbsp;&nbsp;&nbsp;<a href="getlostinfo.php">Forgot Your Information?</a></fieldset>  
</form>
<BR><BR>
<span class="Head2"><a href="fam_register.php">Click Here</a> to register as a new user<BR><BR>
LD SAT Prep Students <a href="../ldsatprep/students/index.php">Log In Here</a></span>



<?php
put_new_footer();
?>