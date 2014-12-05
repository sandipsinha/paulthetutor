<?php
ob_start();



$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

if(!(isEmpty($_REQUEST))){
	foreach($_REQUEST as $key=>$value) { global ${$key}; ${$key} = $value;}
}	


$NQst = "select show_name from PT_Table_Info where name = '$strTable'";
$TName = singlequery($NQst);



put_ptts_header("$TName Viewer", $strAbsPath, "tutors", "");


if(isEmpty($strTable)){
	$strTable = "PT_Tutors";
}	
 $booledit = "full";
// printarray($_SESSION);

$sortby = $_GET[sortby];
$sortorder = $_GET[sortorder];

$refresh_link = $_SERVER['REQUEST_URI'];

?>
<style type="text/css">
<!--
.style2 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>

  <form name="form1" method="post" action="">

    <div align="center">
  <select name="strTable" id="strTable" onchange='this.form.submit()'>
      <option value="<?=$strTable;?>">View Another Table</option>
      <?
$TQst = "select name, show_name from PT_Table_Info order by show_name";
$TRS = runquery($TQst);
While($arTI = mysql_fetch_array($TRS)){ ?>
	      <option value="<?=$arTI[0];?>">
	      <?=$arTI[1];?>
	      </option>
      <? } ?>	
     
  </select>
  
	  
  </div>
  </form>
  
  <link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
<div align="center"><a class="Head2" onclick="javascript:popup('edit_record.php?strTable=<?=$strTable;?>','Details','600','820')"> <img src="../images/add_256.png" alt="Add Entry" width="27" height="27">  <span class="style2">Add
an Entry</span>  </a><BR>
  <span class="Head1"><?=$TName;?> Table</span><BR><BR>

  <?
tableview($strTable, $strFields, $arColumn, $strRestrictions, $booledit, $sortby, $sortorder, $tableclass, $other);


put_ptts_footer("");
?>
