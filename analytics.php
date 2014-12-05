<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$popup = $_REQUEST[popup];
// printarray($_REQUEST);

?>
<?php 
	put_ptts_header("Applying For Admin Position", $strAbsPath, "", $popup);
?>
<?php 
	/*function check_and_update_visits() {
		$url = $_SERVER['REQUEST_URI'];
		$db_result = singlequery("SELECT count(*) FROM PT_Analytics where URL = '$url'");
		$result = "";
		/*while($row = mysql_fetch_array($db_result)) {
			if($row['url'] == $url) {
				mysql_query("UPDATE PT_Analytics SET visits = visits + 1 
						 WHERE url = '".$url."';");
			} else {
				mysql_query("INSERT INTO PT_Analytics(url, visits) 
						 VALUES ('" .$url. "', 1);");
			}
		}
		
		if($db_result == 0) {
			$result = "insert";
			$iq = "INSERT INTO PT_Analytics(url, visits) VALUES ('$url', 1);";
			mysql_query($iq);
		} else {
			$result = "update";
			mysql_query("UPDATE PT_Analytics SET visits = visits + 1 
						 WHERE url = '$url';");
		}
		echo "The results are: $result <br> url is: $url" ;
		
	}
	*/
	//check_and_update_visits();
?>
<?
MySQL_PaulTheTutor_Connect();
analytics();
put_ptts_footer("popup");

?>