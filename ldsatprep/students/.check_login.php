<?php
  session_start();
  $x_login_key = "paul_key123_xx{_";

  if ($_SESSION['ldsat_sid']!='' && $_SESSION['token'] == md5($x_login_key.$_SESSION['ldsat_sid'])){
      $x_conf_sid = $_SESSION['ldsat_sid'];
  }elseif($_COOKIE['ldsat_sid']!='' && $_COOKIE['token'] == md5($x_login_key.$_COOKIE['ldsat_sid'])){
      $_SESSION['ldsat_sid'] = $_COOKIE['ldsat_sid'];
      $x_conf_sid = $_SESSION['ldsat_sid'];
  }
  else{
            if (!$x_from_login_page)
                header("Location: login.php?referer=".$_SERVER['REQUEST_URI']);
  }
  
  if ($x_conf_sid && $x_from_login_page && !$_REQUEST['logout']){
  	 	if ( $link_index_ldsatprep == 1)
  	 		header("Location: index.php");	
        else
        	header("Location: ".$strAbsPath."//paulthetutors_com/ldsatprep/parents/index_parents.php");
  }
  
  //set class_id
  if ($x_conf_sid){
      $result = mysql_query("SELECT * FROM PT_TestPrep_Reg WHERE id='".$x_conf_sid."' order by id DESC");
        if (!$result) {
            die(mysql_error());
        }
      $s_row = mysql_fetch_array($result);
      $x_conf_class = $s_row['class'];
      $x_conf_name = $s_row['student_name'];
      $_SESSION['sat_id'] =  $s_row['id'];
      $_SESSION['sat_class_id'] = $s_row['class'];
      //if (!$not_link_login)
        //echo "<div align=right style='padding-bottom:4px'><a href='login.php?logout=1'><b>Logout</b></a>&nbsp;</div>";
  }
  
  
?>