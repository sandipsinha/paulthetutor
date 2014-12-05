<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("Get All Emails", $strAbsPath, "admin", "");
$tinfo = $_POST['selection'];
$emailinf= $_POST['emailform'];
$dinfo = $_POST['daterange'];

function getEmails( $tinfo, $emailinf, $dinfo ) {

    $end_date = date ("Y-m-d");
    $last_month = time() - (31*24*60*60);
    $start_date = date('Y-m-d', $last_month );
    $Qstr= "";
    $columnname="";
    $where = "";
    $table_name="";
    $secondcolumn="PTAddedApp.date";
    $innerjoin="";
    if($tinfo == "tutors" ) {

        $innerjoin=" INNER JOIN PTAddedApp on PTAddedApp.tid = PT_Tutors.id";
        $columnname = "email";
        $table_name= "PT_Tutors";
        $where="WHERE PT_Tutors.position ='tutor' AND ";

    } else if($tinfo == "parents") {

        $innerjoin=" INNER JOIN PTAddedApp on PTAddedApp.sid = PT_Family_Info.id";
        $columnname="main_email";
        $table_name="PT_Family_Info";
        $where="WHERE ";

    } 
    if($dinfo == "1") {
        
        $where = $where."archived = 0";

    }else if($dinfo == "2") {

      $where = " ";

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

    $Qstr="SELECT DISTINCT $table_name.$columnname from $table_name $innerjoin $where order by date DESC";
    $result = runquery($Qstr);

// echo "qstr is $Qstr <BR>"; 	

    $allemails="";
    if($result!="" && $result != FALSE){
        $n = 0;
        while($row = mysql_fetch_array($result)) {
           // echo "<div style='text-align:justify'>".$row[$columnname].";"."</div>";
            if($n == 0) {
            
                $allemails=$row[$columnname];
            
            }else{
            
                $allemails=$allemails.";".$row[$columnname];
            
            }
            $n++;
        }
         ?>

        <h4 align="center">Your emails are ready!</h4>

        <?php
        if ($emailinf == "none") { ?>

            <h3 align="center"><a onclick="Alert()"href="mailto:<?= $allemails ?>">Email All Selected Emails</a></h3>
        
        <? } else if($emailinf == "cc") { ?>

            <h3 align="center"><a onclick="Alert()"href="mailto:info@paulthetutors.com?cc=<?= $allemails ?>">Email All Selected Emails</a></h3>
        
        <?php } else if($emailinf == "bcc") { ?>
            
            <h3 align="center"><a href="mailto:info@paulthetutors.com?bcc=<?= $allemails ?>">Email All Selected Emails</a></h3>

        <?php }

    } else {

        echo "Failure";
        echo $Qstr;
    
    }
}

if( !is_null( $dinfo ) ) getEmails(  $tinfo, $emailinf, $dinfo );

?>

<link href="../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />

<form align="center" action="get_current_emails.php" method="POST">
<input type="radio" name="selection" value="tutors">Tutor Emails<br>
<input type="radio" name="selection" value="parents">Parent Emails<br>
<br />
<input type="radio" name="emailform" value="none">None<br>
<input type="radio" name="emailform" value="cc">CC<br>
<input type="radio" name="emailform" value="bcc">BCC<br>
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

<?php
put_ptts_footer("");
?>
