<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
put_ptts_header("", $strAbsPath, "admin", "index");
?>
<link href="../../includes/css_files/styles_main.css" rel="stylesheet" type="text/css" />


<table border="1" cellspacing="2" cellpadding="0" width="100%" class="table_1">
  <tr>
    <td class="td_header">LDSATPREP Admin Home</td>
  </tr>
  <tr>
    <td align="center"><br>
      <table width="100%" border="0" height="" cellpadding="7" margin=0 cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td class="Head3">Classes: <a href="view_rosters.php" style="font-weight:bold">Class Rosters</a> - <a href="class_student_edit.php">Add a Student</a></td>
        </tr>
        <tr>
          <td class="Head3">Test Information: <a href="standardized_tests.php" style="font-weight:bold">View Test</a> - <a href="gettestinfo.php" style="font-weight:bold">Enter A New Test</a> - <a href="edit_test_parts.php" style="font-weight:bold">Edit Test Information</a></td>
        </tr>
        <tr>
          <td class="Head3">Homework:  <a href="gethwsum.php?popup=popup" target="_blank">Add HW Summary</a> - <a href="homework.php">See HW Summaries</a> - <a href="homework.php">See Gradable Homework</a> - <a href="get_grsec.php">Grade Homework</a></td>
        </tr>
        <tr>
          <td class="Head3">Scoring: <a href="get_grtest.php">Score a Test</a> - <a href="get_grsec.php">Score a Section</a></td>
        </tr>        
        <tr>
          <td class="Head3">Results: <a href="get_grsec.php?action=ans_grader.php&amp;type=sec">Section Results</a> - <a href="get_grtest.php?action=ans_grader.php&amp;type=test">Test Results</a> - <a href="score_sum.php">See Score Summaries</a></td>
        </tr>
      </table><br>
    </td>
  </tr>
</table>
<?
put_ptts_footer("");
?>