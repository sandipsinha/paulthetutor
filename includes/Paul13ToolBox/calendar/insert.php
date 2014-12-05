<?php	
include("db_connect.php");
$dt=$_POST['testinput'];

if($_POST['submit'])
{
$query="INSERT INTO  test_date(dt_of_birth) VALUES(STR_TO_DATE('$dt', '%m/%d/%Y'))";
mysql_query($query);
}
include("index.html");
?>
