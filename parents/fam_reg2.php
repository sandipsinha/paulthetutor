<?php

/* ============================================= */
// This is a landing page, forwarded with neccessay GET variables from fam_reg.php

// Created in part by Leo H 10-14-2013 leo@radbitt.com
/* ============================================= */

include("../includes/pttec_includes.phtml");

MySQL_PaulTheTutor_Connect();

//Check to see if username is already being used. 

$username = trim($_POST['username']);	

$password = trim($_POST['password']);

$check_username_sql = "SELECT 
username 
FROM PT_Family_Info2 
WHERE username LIKE '$username' LIMIT 1";  

$username_taken_or_not = singlequery($check_username_sql);

if ( $username_taken_or_not )

header("Location: https://www.paulthetutors.com/parents/fam_reg.php?status=invalid");

//If username is not taken. Below this comment is executed. 

$insert_username_password_sql = "UPDATE
PT_Family_Info2
SET username = '$username', password = '$password'
WHERE id = $_GET[page]; 
";

runquery($insert_username_password_sql); 

put_ptts_header("Register", $strAbsPath, "parents", ""); 

// Select parents or parent from parents table where id = family id.
// If it this is true or there is a parent, then do something to make a green checkmark. 
// 

if (isset($_GET['page'])) {

	$fid = intval($_GET['page']);

	$sql_parents = "SELECT * FROM PT_Parent_Info WHERE family_id = " . $fid . " LIMIT 1";

	$sql_students = "SELECT * FROM PTStudentInfo_New WHERE fid = " . $fid . " LIMIT 1";

	$check_students = rowquery($sql_students);

	$check_parents = rowquery($sql_parents); 

} // Else we say something 
  // Have you already registered? 
  // Or click to register for the first time. Send to get new get var ID. 


?>

<script type="text/javascript">

    function makeMarks_CheckMarks(register) {

    	switch (register) {

    		case 'parent':

    		$('#parents_options_list li:first-child').css('background-image', 'url(../includes/images/check-6x.png)');

    		break;

    		case 'student':

    		$('#parents_options_list li:nth-child(2)').css('background-image', 'url(../includes/images/check-6x.png)');

    		break

    	}
    	
	}

</script>

<h1 class="main_header">Family Information</h3>

<div id="parents_options_container" class="auto-margin">

	<ul id="parents_options_list">

		<li>

			<div class="inline-block chalk-board">Parents</div>

			<a onclick="window.open('parent_info_edit.php?id=<?php echo $_GET['page']; ?>','Edit Parent Info','600','600'); return false">

			<img class="inline-block parent_action" src="../includes/images/plus-4x.png" title="Add Parent">

			<p class="inline-block">Add parent</p></a>

		</li>

		<li>
			<div class="inline-block chalk-board">Students</div>
			
			<a onclick="window.open('parent_student_edit.php?id=<? echo $_GET['page']; ?>','Add a Student','600','600')">

			<img class="parent_action" src="../includes/images/plus-4x.png" title="Add Student">

			<div class="inline-block"><p>Add students</p></div></a>

		</li>

		<li>

			<div class="inline-block chalk-board">Payment</div>

		</li>

	</ul>

</div>

<?php if ($check_parents) {

	echo 'parents returned'; ?>

	<script type="text/javascript">
	
	makeMarks_CheckMarks('parent');
	
	</script>

<?php } ?>

<?php if ($check_students) {

	echo 'students returned'; ?>

	<script type="text/javascript">
	
	makeMarks_CheckMarks('student');
	
	</script>

<?php } ?>

<?php put_ptts_footer(""); ?>
