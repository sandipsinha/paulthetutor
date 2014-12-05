<?php
  $strAbsPath=str_replace(array("/includes","\\includes"),array("",""),dirname(__FILE__));	
  $_root = str_replace('\\','/',substr($strAbsPath,strlen(rtrim($_SERVER['DOCUMENT_ROOT'],'/\\'))));
  $http_server_name=((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT']==80 || $_SERVER['SERVER_PORT']==443 ? '' : ':'.$_SERVER['SERVER_PORT']);
  $full_root=$http_server_name.$_root;
  define("MAIN_BASE_PATH",$_root);
  define("FULL_BASE_PATH",$full_root);
  ?>
