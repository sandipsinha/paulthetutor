<?php
ob_start();
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "", "");


$x_from_login_page = 1;
include('.check_login.php');

if(isset($_REQUEST['logout']) && $x_conf_sid && !isset($_REQUEST['ldsat_sid'])){
    session_destroy();
    setcookie("ldsat_sid", "", time()-3600);
    $msg_success = "Logged Out";
}

if(isset($_REQUEST['referer']))
    $referer = $_REQUEST['referer'];
if ($referer == '')
    $referer = 'index.php';

    
if(isset($_REQUEST['username']) && $_REQUEST['username']!=''){
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $result = mysql_query("SELECT * FROM PT_TestPrep_Reg WHERE username = '$username' AND password = '$password'");
    if (!$result) {
        die(mysql_error());
    }
    elseif(mysql_num_rows($result) == 0){
        $msg_error = "Incorrect username and password combination";
    }
    else
        {
            $s_row = mysql_fetch_object($result);
            $_SESSION['ldsat_sid'] = $s_row->id;
            $_SESSION['student_id'] = $s_row->student_id;
            $_SESSION['token'] = md5($x_login_key.$s_row->id);
			
            if(isset($_REQUEST['remember'])){
                setcookie("ldsat_sid", $s_row->id, time()+60*60*24*365);
                setcookie("token", md5($x_login_key.$s_row->id), time()+60*60*24*365);
				setcookie("student_id", $s_row->student_id, time()+60*60*24*365);
            }
            else{
                setcookie("ldsat_sid","", time()-3600);
                setcookie("token","", time()-3600);
				setcookie("student_id", $s_row->student_id);

            }
            
            if($referer!=''){
                header("Location: $referer");
            }
        }    
}

?>
<form method="POST">
<input type=hidden name='referer' value="<?php echo $_REQUEST['referer']?>">  
<?php if ($msg_success == 1)?>
<div class="log_txt_logged_out" style="padding: 5px"><?php echo $msg_success?></div>
<fieldset>  
<legend class="Head1_Green">Student Login </legend>  
<?php if ($msg_error!=''){?>
<div class="log_div_error"><?php echo $msg_error ?></div><br>
<?php }?>
<br>
 Names are case sensitive.  Be sure to capitalize your names appropriately <BR>
<br>
<div>  
<label for="username" <?php echo $msg_error ? "class=log_txt_error" : ""?>>Student's First
Name:</label>  
<input id="username" name="username" class="text" type="text" style="width:150px"/>  
</div>  
<div style="margin-top:2px">   
<label for="password" <?php echo $msg_error ? "class=log_txt_error" : ""?>>Student's Last
Name :&nbsp;</label>  
<input id="password" name="password" class="text" type="text"  style="width:150px"/>  
</div>  
<div style="margin-top:2px">
<input name="remember" id="remember" class="text" type="checkbox" />   
<label for="remember">Store my information on this computer</label> 
</div> 
<BR>
</fieldset>
<fieldset class="submit">  
<input class="submit" type="submit" value="Login" />  
</fieldset>  
</form>

<br><br><br><br>
<?php
put_ptts_footer("");
?>