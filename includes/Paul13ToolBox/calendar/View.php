<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Panel</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<fieldset>
<h3>Show Date format</h3>
<form name="AdminPage">
<?php
include("db_connect.php");

$sql="SELECT id, DATE_FORMAT(dt_of_birth, '%m/%d/%Y') AS dt_of_birth FROM test_date";
$result = mysql_query($sql);
$rowno=mysql_num_rows($result);
?>
<table cellpadding="0" cellspacing="0" border="1" class="reference">
<tr>
<th>ID</th>
<th>Date Format</th>
</tr>
<?php 
while($row = mysql_fetch_array($result))
{
?>
 <tr>
 <td><?php echo $row['id']; ?></td>
 <td><?php echo $row['dt_of_birth']; ?> </td>
 </tr>
 <?php
 }
 ?>
</table>
<br />
</form>
<a href="index.html">Back</a>
</fieldset>
</body>
</html>