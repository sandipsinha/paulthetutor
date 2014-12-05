<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "index");
?>

<table border="1" cellspacing="2" cellpadding="0" width="100%" class="table_1">
  <tr>
    <td class="td_header">LDSATPREP Admin Home</td>
  </tr>
  <tr>
    <td align="center"><br>
      <table width="100%" border="0" height="" cellpadding="7" margin=0 cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td><a href="class_rosters.php" style="font-weight:bold">View Class Rosters</a></td>
        </tr>
        <tr>
          <td><a href="ldsathw.php" style="font-weight:bold">Homework Home Page</a></td>
        </tr>
         <tr>
           <td><a href="standardized_tests.php" style="font-weight:bold">View Test</a></td>
         </tr>
         <tr>
           <td><a href="gettestinfo.php" style="font-weight:bold">Enter A New Test</a></td>
         </tr>
        <tr>
          <td><a href="getsectionsinfo01.php" style="font-weight:bold">Enter Info About Test's Sections</a></td>
        </tr>
        <tr>
          <td><a href="getcorrectans01.php" style="font-weight:bold">Enter Test Answers</a></td>
        </tr>
         <tr>
          <td><a href="satgrader.php" style="font-weight:bold">Grader A Student's Test</a></td>
        </tr>
         <tr>
          <td><a href="testresults.php" style="font-weight:bold">View Student's Test Results</a></td>
        </tr>
         <tr>
          <td><a href="hwgrader01.php" style="font-weight:bold">Grade a Student's Homework</a></td>
        </tr>
         <tr>
          <td><a href="homeworkresults.php" style="font-weight:bold">View Students Homework Results</a></td>
        </tr>
      </table><br>
    </td>
  </tr>
</table>
<?
put_ptts_footer("");
?>