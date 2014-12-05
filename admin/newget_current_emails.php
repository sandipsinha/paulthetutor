<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Parent's Emails", $strAbsPath, "admin", "");
$tinfo = $_POST['tutor'];
$pinfo = $_POST['parents'];
$dinfo = $_POST['daterange'];
$con=mysqli_connect("mysql.paulthetutors.com","vworker","vw0rker","paulth40_db");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$end_date = date ("Y-m-d");
$last_month = time() - (31*24*60*60);
$start_date = date('Y-m-d', $last_month );
$Qstr= "";
$columnname="";
$where = "";
$table_name="";
$secondcolumn="PTAddedApp.date";
$innerjoin="";

if($tinfo) {
    $innerjoin=" INNER JOIN PTAddedApp on PTAddedApp.tid = PT_Tutors.id";
    $columnname = "email";
    $table_name= "PT_Tutors";
    $where="WHERE PT_Tutors.position ='tutor' AND ";
}else if($pinfo){

    $innerjoin=" INNER JOIN PTAddedApp on PTAddedApp.sid = PT_Family_Info.sid1";
    $columnname="main_email";
    $table_name="PT_Family_Info";
    $where="WHERE";

} 
if($dinfo == "1") {
    $where = $where."archived = 0";
}else if($dinfo == "2") {
    $where;

}else if($dinfo=="3") {
    $month=date("Y-m"). "-00";
    $where=$where . "$secondcolumn >= '$month'" ;
} else if($dinfo == "4"){
    $month=date("Y-m"). "-00";
    $temp=substr($month, 5,2);
    $temp = intval($temp) - 3;
    if($temp<0) {
        $temp = $temp-13;
        $temps=substr($month, 0,4); - 1;
    }else{
        $temps=date("Y");
    }
    $month=$temps."-"."0".$temp."-"."00";
    $where=$where . "$secondcolumn >= '$month'" ;
}
else if($dinfo == "5"){
    $month=date("Y-m"). "-00";
    $temp=substr($month, 5,2);
    $temp = intval($temp) - 6;
    if($temp<0) {
        $temp = $temp-13;
        $temps=substr($month, 0,4); - 1;
    }else{
        $temps=date("Y");
    }
    $month=$temps."-"."0".$temp."-"."00";
    $where=$where . "$secondcolumn >= '$month'" ;
}
else if($dinfo == "6"){
    $month=date("Y-m"). "-00";
    $temp=substr($month, 5,2);
    $temp = intval($temp) - 12;
    if($temp<0) {
        $temp = $temp-13;
        $temps=substr($month, 0,4); - 1;
    }else{
        $temps=date("Y");
    }
    $month=$temps."-"."0".$temp."-"."00";
    $where=$where . "$secondcolumn >= '$month'" ;
}

$Qstr="SELECT DISTINCT $table_name.$columnname from $table_name $innerjoin $where";
$result = mysqli_query($con,$Qstr);
?>
<link href="../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />
<span class="Head1" align= "center">Email Addresses<br /><br /></span> 

<form align="center" action="newget_current_emails.php" method="POST">
<input type="radio" name="tutor" value="tutors">Tutor Emails<br>
<input type="radio" name="parents" value="parents">Parent Emails<br>
<br />
<select name="daterange">
	<option value="1"> All </option>
    <option value="2"> All(Including Archived)</option>
	<option value="3"> This Month </option>
    <option value="4"> 3 Months </option>
    <option value="5"> 6 Months </option>
    <option value="6"> 12 Months </option>
</select>
<br>
<br>
<button type="submit">Submit</button> 
</form>
<?
$allemails="";
if($result!="" && $result != FALSE){
    while($row = mysqli_fetch_array($result)) {
       // echo "<div style='text-align:justify'>".$row[$columnname].";"."</div>";
        $allemails=$allemails.$row[$columnname];
    }
    ?>
<h3 align="center"><a onclick="Alert()"href="mailto:<?= $allemails ?>">Email All Selected Emails</a></h3>
    <!--<h3 align="right"><a href="mailto:<?=$allemails?>" target="_top">Email All</a></h3> -->
<script>
function Alert() {
    alert("Are you sure you would like to send an email to everyone?");
}
</script>
<?php
}else{
	echo "Failure";
}
put_ptts_footer("");
?>
