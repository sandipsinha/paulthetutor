<?php
ob_start();
session_start();
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include("../includes/pttec_includes.phtml");



if(!(isEmpty($_SESSION[fid]))){
	$fid = $_SESSION[fid];
} else if (!(isEmpty($_REQUEST[fid]))){
	$fid = $_REQUEST[fid];
}	

// echo "fid is $fid <BR> and session fid is $_SESSION[fid]";


MySQL_PaulTheTutor_Connect();

$strBack = get_strBack();
put_ptts_header("", $strAbsPath, "parents", "");



//printarray($_REQUEST);
$stu_last = $_REQUEST[last_name];
$stu_last2 = substr($stu_last, 0, 2);  
$first_name = $_REQUEST[first_name];
$stu_name = $_REQUEST[first_name] . " " . $stu_last2;
$strTableName = $_REQUEST[strTableName];
$stuar = $_REQUEST;
$stuar[fid] = $fid;
$stuar[username] = $first_name;
$stuar[password] = $stu_last;
// echo "InsertFields( $strTableName, $stuar, $arMandFields, $strNotUsed, $tdstyle)";
// printarray($stuar);
// echo "InsertFields($strTableName, $stuar, $arMandFields, $strNotUsed, $tdstyle)is insert statement";
//---- check if the student is already inserted by a parent
$insertcheck=checkIfStudentExists($first_name, $stu_last, $fid);
if($insertcheck>0)
{
	//-- Similar Record Found
}
else
{
//--- if not
$tester = InsertFields($strTableName, $stuar, $arMandFields, $strNotUsed, $tdstyle);
$sid = mysql_insert_id();
if(!(isEmpty($fid))){  // if this person is a member of a family, enter the fid


$arFI=array();
$stidnum=0;
// echo "entered information for the family with id $fid";
	$RS = mysql_query("select students, number_of_students from PT_Family_Info where id = $fid");
	$arFI = mysql_fetch_array($RS);
	//echo  $arFI['number_of_students'];
	$stidnum = $arFI['number_of_students'] + 1;
	//echo "<br/>".$stidnum ;
	$strStudents = "$arFI[students] $stu_name";
	$strStudents = trim($strStudents);

	$QStr = "Update PT_Family_Info set number_of_students = $stidnum,  sid$stidnum = $sid, students = '$strStudents' where id = $fid";

// echo "the update string is $QStr<BR>";


	mysql_query($QStr);
} //if fid is set
}
// echo "tester is $tester<BR>";






$page_name = phptohtm();
?>
<style type="text/css">
<!--
.plain {
	font-weight: normal;
}
.style1 {font-weight: normal; font-size: 10px; }
.style3 {font-weight: normal; font-size: 12px; }
.style4 {font-size: 12px}
.book_position {
	left: 5px;
	top: 450px;
	position: absolute;
}
-->
</style>
<link href="../includes/paulthetutors.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php 
if($insertcheck>0)
{
	// notify that the student already exists
?>
<table width="686" border="0" cellpadding="5" cellspacing="0" background="../images/flowbg.gif">
  <tr >
    <td height="25" colspan="2"" valign="top" class="Head1_Green"><?=$first_name;?>'s Already exists </td>
    <td width="150" rowspan="2"" valign="top"><div align="right"><span class="style3">    </span><span class="Head2">      </span>      <br>
      <br>
      <br>
    </div></td>
  </tr>
  <tr>
    <td width="51" align="center" valign="bottom"><div align="center"><br>
          <br>
    </div>      <div align="left"></div></td>
    <td width="455" valign="top">      <span class="Head2">
      </span>
      <p><span class="Head2_Brown">More Options</span> <br>
        <br>
        - View student's Infomation (<a href="miviram_student_view.php?id=<?=$insertcheck;?>">Click here</a>)<br>
        - Edit student's Infomation (<a href="miviram_student_edit.php?id=<?=$insertcheck;?>">Click here</a>)<br>
        - Enter a different student (<a href="miviram_getstudentinfo.php?fid=<?=$fid;?>">Click here</a>) <br>	        
        - Go to parent's homepage (<a href="index_parents.php">Click here</a>)<br>        
        </p>
    </td>
  </tr>
</table>
<?php
}
else
{
?>
<table width="686" border="0" cellpadding="5" cellspacing="0" background="../images/flowbg.gif">
  <tr >
    <td height="25" colspan="2"" valign="top" class="Head1_Green"><?=$first_name;?>'s Information Has Been Entered </td>
    <td width="150" rowspan="2"" valign="top"><div align="right"><span class="style3">    </span><span class="Head2">      </span>      <br>
      <br>
      <br>
    </div></td>
  </tr>
  <tr>
    <td width="51" align="center" valign="bottom"><div align="center"><br>
          <br>
    </div>      <div align="left"></div></td>
    <td width="455" valign="top">      <span class="Head2">
      </span>
      <p><span class="Head2_Brown">More Options</span> <br>
        <br>
        - 
        Enter another
        student's Infomation (<a href="miviram_getstudentinfo.php?fid=<?=$fid;?>">Click
        here</a>)<br>
        - Go to parent's homepage (<a href="index_parents.php">Click
        here</a>)<br>
        - Register for an SAT Prep Class (<a href="testprepreg.php">Click here</a>) <br>
	  - Book
	  a session with Paul or one of his tutor's (<a href="../contactus.php">Click
	  Here</a>) </p>
    </td>
  </tr>
</table>
<?
}

// printarray($_SESSION);
// echo "<BR> non-user data<BR>";
// printarray($_REQUEST);


put_new_footer();

?>