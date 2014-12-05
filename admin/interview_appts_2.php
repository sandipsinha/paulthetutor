<?php
ob_start();



$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

if(!(isEmpty($_REQUEST))){
	foreach($_REQUEST as $key=>$value) { global ${$key}; ${$key} = $value;}
}


put_ptts_header("Interview Manager", $strAbsPath, "tutors", "");

$strTable = "PT_interview_res";

 $booledit = "full";
// printarray($_SESSION);
if(!(isEmpty($_REQUEST[sortby]))){
	$sortby = $_GET[sortby];
} else {
	$sortby = "date ASC,time ASC";
}
if(!(isEmpty($_REQUEST[sortorder]))){
	$sortorder = $_REQUEST[sortorder];
} else {
	$sortorder = "";
}

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


  <link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
<div align="center"><a class="Head2" onclick="javascript:popup('edit_record.php?strTable=<?=$strTable;?>','Details','400','500')"> <img src="../images/add_256.png" alt="Add Entry" width="27" height="27">  <span class="style2">Add
an Entry</span>  </a><BR>
  <span class="Head1"><?=$TName;?> Table</span><BR><BR>

  <?
// tableview($strTable, $strFields, $arColumn, $strRestrictions, $booledit, $sortby, $sortorder, $tableclass, "ampm");

// format_time_print();

if(isEmpty($strFields)){
  $FQStr = "select main_fields from PT_Table_Info where name = '$strTable'";
  $strFields = singlequery($FQStr);
  // if there is nothing listed as columns to show for that table, show all of them
  if(isEmpty($strFields)){
    $strFields = "*";
  }
}

$_SESSION[strTable] = $strTable;
// get's name of the page
$page_name = $_SERVER['PHP_SELF'];
$arPage = explode("/",$page_name);
$numSlash = substr_count("$page_name", "/");
$page_name = $arPage[$numSlash];
// echo $page_name;
//if the order is indicated, create an oderby statement
if(!(isEmpty($sortby))){
  $orderby = "order by $sortby";
  //if the order is indicated, also include that in the orderby statment
  if(!(isEmpty($sortorder))){
    $orderby = $orderby . " " . $sortorder;
  }
}
?>
<table border="1" cellspacing="0" cellpadding="4" bordercolor="#000000" class=<?=tableclass;?>><tr>
<?
if(isEmpty($strRestrictions)) {
	$today = date('Y-m-d',strtotime("today"));
	$strRestrictions = "date >= '$today'";
}

// get the information from the table
// make sure the id is in the search
$strFields = $strFields . ", id as hidden_id";
$QStr = "select $strFields from $strTable where $strRestrictions $orderby ";
$tempRS = runquery($QStr);
$temparray = mysql_fetch_assoc($tempRS);
// while loop will put the titles for every field
while(list($key,$value ) = each($temparray)){
  if($key <> "hidden_id"){ // don't show the hidden id number
  // If the name for a column is set, use it, otherwise, use the function which maipulates names
      if(isset($arFieldNames[$key])){
        $disName = $arFieldNames[$key];
      } else {
        $disName = setDisplayFieldVals($key);
      } ?>
      <th style="white-space: nowrap">
        <?=$disName;?>
      <a href='<?=$page_name;?>?strTable=<?=$strTable;?>&sortby=<?=$key;?>&sortorder=DESC'>&darr;</a><a href='<?=$page_name;?>?strTable=<?=$strTable;?>&sortby=<?=$key;?>&sortorder=ASC'>&uarr;</a>
      </th>
      <?
    } else {// if  Hidden_id store it
      $hidden_id = $value;
    }
} //while
    if($booledit == "view" or $booledit == "edit" or $booledit == "full") echo "<th> Action </th></tr>";
  reset($temparray); // go back to the beginning of the array
  do{ // cycle through each row in the table
    echo "<TR>";
    while(list($key,$value ) = each($temparray)){ //print each value from each cell in the row
      if($key <> "hidden_id" ){
        if(isEmpty($value)) $value = "&nbsp;";
        If (strlen($value) >= 50){
          $value = substr($value,0,50);
          $value = $value . "... [truncated]";
        }

		// if the variable is a time, convert it
		$is_time = substr_count($key, 'time');
		if($is_time > 0) {
      echo $value;
			$value = format_time_print($value);
      echo $value;
		}

		// if the field is a date, format it
		$is_date = substr_count($key, 'date');
		if($is_date > 0) {
			$temp_date = $value;
			$date_num = strtotime($temp_date);
			$date_str = date('D M jS, Y', $date_num);
			$value = $date_str;


	//		$value = format_date_print($value);
		}

	    echo "<TD align=\"center\">$value</TD>   ";
      } else {// if  Hidden_id store it
        $hidden_id = $value;
      }
    }
    if($booledit == "view" or $booledit == "edit" or $booledit == "full") {
      ?>
<td align=\"center\" >
<? if($booledit == "view" or $booledit == "edit" or $booledit == "full") { // if the user has right to view, edit or delete
?>
  <a onClick="javascript:popup('show_record.php?hidden_id=<?=$hidden_id;?>','Details','600','820')">
      <img src="../images/view.gif" border="0"></a> &nbsp;
<? if($booledit == "edit" or $booledit == "full") { // if the user has right to edit
?>
  <a onClick="javascript:popup('edit_record.php?id=<?=$hidden_id;?>&strTable=<?=$strTable;?>','Details','600','820')">
      <img src="../images/edit_pencil.gif" width="16" height="14" border="0"> </a>
<!-- &nbsp;&nbsp;<img src="../images/del_x.gif" width="13" height="13"></td></tr> -->
      <?
    } // end if can see or edit
        } // end if can edit
      }
  } while($temparray = mysql_fetch_assoc($tempRS));
  echo "</tr></table><BR>";




put_ptts_footer("");
?>
