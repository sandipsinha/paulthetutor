<?php
  $site_dir=str_replace("includes","",dirname(__FILE__));
	define("SITE_DIR",$site_dir);
	
	$_root = str_replace('\\','/',substr($site_dir,strlen(rtrim($_SERVER['DOCUMENT_ROOT'],'/\\'))));
	$http_server_name=($_SERVER['HTTPS']=='on' ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT']==80 || $_SERVER['SERVER_PORT']==443 ? '' : ":$_SERVER[SERVER_PORT]");
	$full_root=$http_server_name.$_root;
	echo "root: ".$_root."<br>";
	echo "site_dir:".$site_dir."<br>";
	echo "full_root:".$full_root."<br>";
?>
