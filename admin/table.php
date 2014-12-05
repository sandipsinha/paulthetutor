<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

$query = "CREATE TABLE `PT_cell_email` (
`carrier` VARCHAR( 255 ) NOT NULL ,
`domanin` VARCHAR( 255 ) NOT NULL
);";
$FRS = runquery($query);

$query = "ALTER TABLE `PT_cell_email` ADD PRIMARY KEY ( `carrier` )";
$FRS = runquery($query);

$query = "INSERT INTO `PT_cell_email` (
`carrier` ,
`domanin`
)
VALUES (
'AT&T', 'txt.att.net'
), (
'Verizon', 'vtext.com'
), (
'T-Mobile ', 'tmomail.net'
), (
'Sprint_PCS', 'messaging.sprintpcs.com'
), (
'Virgin_Mobile', 'vmobl.com'
), (
'US_Cellular', 'email.uscc.net'
), (
'Nextel', 'messaging.nextel.com'
), (
'Boost', 'myboostmobile.com'
), (
'Alltel', 'message.alltel.com'
); ";
$FRS = runquery($query);

$query="ALTER TABLE `ZZ_PT_Tutors_Archive` DROP `gc_username` ,
DROP `gc_password`;";
$FRS = runquery($query);

$query="ALTER TABLE `PT_Tutors` CHANGE `bio` `bio` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;";
$FRS = runquery($query);

$query="ALTER TABLE `PT_Tutors` CHANGE `cell_carrier` `cell_carrier` VARCHAR( 25 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL COMMENT 'We need your cell phone company to send you texts';";
$FRS = runquery($query);

$query="ALTER TABLE `PT_Credits` CHANGE `date` `date` DATE NOT NULL;";
$FRS = runquery($query);

$query="ALTER TABLE `PT_Family_Info` ADD `where_did_u_hear_about_us` ENUM( 'Web Search', 'Friend', 'Ad', 'Other' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `can_policy`;";
$FRS = runquery($query);

$query="ALTER TABLE `PT_Family_Info` ADD `please_specify` VARCHAR( 50 ) NOT NULL AFTER `where_did_u_hear_about_us`;";
$FRS = runquery($query);

$query="UPDATE `PT_Family_Info` SET `where_did_u_hear_about_us`='';";
$FRS = runquery($query);

$query="ALTER TABLE `PT_TestPrep_Reg` DROP `family_id`   ;";
$FRS = runquery($query);

$query="ALTER TABLE `ZZ_PT_Family_Info_Old` ADD `where_did_u_hear_about_us` ENUM( 'Web Search', 'Friend', 'Ad', 'Other' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `can_policy`;";
$FRS = runquery($query);

$query="ALTER TABLE `ZZ_PT_Family_Info_Old` ADD `please_specify` VARCHAR( 50 ) NOT NULL AFTER `where_did_u_hear_about_us`;";
$FRS = runquery($query);


?>
