<?php
ob_start();
include("../includes/pttec_includes.phtml");
// include("../includes/sri_functions.php");
MySQL_PaulTheTutor_Connect(); 
$folder = getfolder('','','');
printarray($_REQUEST);

put_ptts_header("", $strAbsPath, $folder, $_REQUEST['popup']);

$strTableName = "PTAddedApp";
//get tutor id based on folder
// $tutor_id = NULL;
// if ($folder == "tutors")
//     $tutor_id = $_SESSION['tutor_id'];
// if ($folder == "admin")
//     $tutor_id = $_REQUEST['tid'];
if(isset($_POST['submit'])) {
    if ($_REQUEST['date_range'] == 'all') {
        //$month =
        rerate_test_sessions($_REQUEST['fid']);
    } else if ($_REQUEST['date_range'] == 'one_month') {
        echo 'one_month';
        $start =  '$_REQUEST[month]' . '-1-' . '$_REQUEST[year]';
        rerate_test_sessions($_REQUEST['fid'], $start, '', '',$month);
    } else {
        rerate_test_sessions($_REQUEST['fid']);
    }
}
?>

<table  cellspacing="0" cellpadding="0" width="100%">
<?php  if (!$_REQUEST['popup'] == 'popup'){?>
<?php }?>
<form method="post"  name="form1" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="popup" value="<?php echo $_REQUEST['popup']?>">
    <tr>
        <td>
            <fieldset>
                <div style="padding:10px">
                    <p>Would you like to recalculate rates?</p>
                    <input type="submit" name="submit" value="YES">
                    <input type="submit" name="close" value="NO" onclick="popup_close()">
                    <select name="date_range">
                        <option value="all">All</option>
                        <option value="one_month">One month</option>
                    </select>
                    <?  putHiddenField("fid", $_REQUEST["fid"]); ?>
                    <?
                        if(isset($_POST['fid'])) {
                            echo "Data has been updated!";
                        }
                    ?>

                </div>
            </fieldset>
        </td>
    </tr>
</form>
</table>
<?
put_ptts_footer($_REQUEST['popup']);
?>

