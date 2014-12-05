<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");


put_ptts_header("", $strAbsPath, "", "");
 $page_name = phptohtm();
include("$page_name"); 
$QStr = "SELECT concat(lower(first_name),'_',id,'.jpg') pictureid ,id,concat(first_name,' ',last_name) Name, bio, subjects FROM `PT_Tutors` WHERE archived <> 1 and position = 'tutor' and id > 1 order by id";
$BIRS = runquery($QStr);
$num_rows = mysql_num_rows($BIRS);

	if($num_rows > 0){
        $number = 1;
		
		while($Far = mysql_fetch_array($BIRS)){
		   echo "<div id=\"t1\">" ;
		  if ($number % 2 != 0) {
            echo "<p align=\"left\" id=\"t4\"> <span class=\"Head2\">". $Far['Name']. "</span><br>"  .  $Far['bio'] . "</p><p id=\"t2\"><img src=\"images/" .$Far['pictureid']. "\" width=\"150\" border=\"3\" bordercolor=\"#000000\" alt=\"". $Far['Name']."\"><i>".'Subjects: '. $Far['subjects']. "</i></p>";
 		    }
		  else
             {
             echo " <p id=\"t2\"> <img src=\"images/" .$Far['pictureid']. "\" width=\"150\" border=\"3\" bordercolor=\"#000000\" alt=\"".$Far['Name']."\"><i>". 'Subjects: '. $Far['subjects']."</i></p><p align=\"left\" id=\"t4\"> <span class=\"Head2\">". $Far['Name']."</span><br>".  $Far['bio']."</p>";
             }			
		   echo "</div>";	 
		$number +=1;			 
         }
    }		 
put_ptts_footer("");

?>
