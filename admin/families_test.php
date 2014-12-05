<?php
include("../includes/pttec_includes.phtml");
//include("notes.php");
MySQL_PaulTheTutor_Connect();
isset($folder) || $folder='admin';

put_ptts_header("View Families for Paul The Tutor's", $strAbsPath, "admin", "");
$order = isset($_REQUEST['order'])? $_REQUEST['order'] : null;
$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : null;
$move_id = isset($_REQUEST['move_id']) ? $_REQUEST['move_id'] : null;
$tablename = "PT_Family_Info";
if(isEmpty($archived))
	$archived = 0;
$where = " where archived = $archived  or ISNULL(archived)";
$tablename_archive = "ZZ_PT_Family_Info_Old";
$tablename_students = "PTStudentInfo_New";
$tablename_students_archive = "ZZ_PTStudentInfo_Archive";
if ($sort == "")
	$sort = "id";
if($order==""){
	$order="DESC";
}else
	$order=$_REQUEST['order'];
$order2 = ($order == "ASC" ? "DESC" : "ASC"); 

If(!(empty($move_id))){
	archive($move_id, $tablename);
}
?>
<SCRIPT type=text/javascript>

jQuery(document).ready(function($){
  // filter input
  $('#filterInput').keyup(function() {
      DynamicFilter($('#filterInput').val());
  });
  // disable enter key
  $('#filterInput').keydown(function(e){
    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    if (key == 13) {
      e.preventDefault();
    }
  });
 
  //toggle submit button
  /*$('.notes').on('click', function(){
	  	var notes = $(this);
        if($(this).next().css('display') == 'none') {
			$(this).addClass('expand');
			$(this).next().css('display', 'block');
		} else {
			$(this).removeClass('expand');
			$(this).next().css('display', 'none');
		} 
		notes.next().toggle();
		notes.toggleClass('expand');
		//console.log(notes);
		
   });  */
  
  //show button, expand textarea on focus
  $('textarea.notes').on('focus', function() {
        var thisNote = $(this);
        //console.log($(this).next('#btn'));
        thisNote.next('#btn').show();
        thisNote.addClass('expand');
  });

});

//strip off html taqs
function stripHTML (field) {
    return field.replace(/<([^>]+)>/g,'');
}

function DynamicFilter(text) {
  text = text.toLowerCase();
  $('tr.familylist').each(function() {
    if ($(this).attr("class") != "familyheader") {
      source = stripHTML($(this).html());
      source = source.toLowerCase();
      if (source.indexOf(text) < 0) {
        $(this).hide();
      } else {
        $(this).show();
      }
    }
  });
}

</script>

<input type="hidden" name=move_id>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height="40">
    <td class="td_header">Families Information</td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0" class="familylist">
 <?php if ($folder != "tutors"){?>
    <tr height=25>
  		 	<td colspan="2">&laquo;<a href="returnfamilies.php" style="text-decoration:none">See Archived Families</a></td>
                        <td colspan=8 class='Filter' width='125px'>Search: <form name=form method="post"><input type="submit" style="display:none"><input type="Text" id="filterInput" onsubmit="return(false);">
</form></td>
    </tr>
 <?php }?>
  <tr style="background: #eee; height: 35px" class="familyheader">
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=id&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Family ID</b>'.($sort == 'id' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=last_name&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Parents</b>'.($sort == 'last_name' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<td nowrap><?php  echo '<a class=a_grey href="?'."&sort=students&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Students</b>'.($sort == 'students' ? ' <img border=0 src="../images/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
  	<!--  <td class="text_grey"><b>Email</b></td>
        <td class="text_grey"><b>Phone</b></td> -->
    <td class="contact"><b>Contact</b></td>
    <td class="notes"><b>Notes</b></td>
   <?php if ($folder != "tutors"){?>
        <td class="text_grey"><b>Action</b></td>
  <?php }?>
  </tr>

<? 

$QStr = "select *, SUBSTRING_INDEX(main_name, ' ', -1) as last_name, SUBSTRING_INDEX(main_name, ' ', 1) as first_name from PT_Family_Info $where order by ".($sort!="id" ? "trim($sort)" : "$sort")." $order";
$RS = runquery($QStr);

while($row = mysql_fetch_array($RS)) {

$email = $row['main_email'];
$phone = $row['main_phone'];
if ($folder == 'tutors'){
	$arr_emails = array($row['main_email'],$row['mothers_email'], $row['fathers_email'],$row['guardians_email']);
	$arr_phones = array($row['main_phone'],$row['mothers_phone'], $row['fathers_phone'],$row['guardians_phone']);
	$email = implode('<br>',array_unique($arr_emails));
	$phone = implode('<br>',array_unique($arr_phones));
}

$students_name = get_family_snames($row['id']);


 echo '<tr id="family-table-row-'.$row['id'].'" class="familylist">

 		<td valign=top>'.$row['id'].'</td>
 		<td valign=top>'.$row['last_name'].($row['first_name']!='' ? ', '.$row['first_name'] : '').'&nbsp;</td>
 		<td valign=top>'.$students_name.'&nbsp;</td>
 		<td valign=top>'
						."Email: ".$email . '<br>' 
						."Phone: ".$phone .'</td>';
		create_comment('PT_Comments_Family', $row['id']); //create comment area
		
 	if ($folder != "tutors"){
 		echo '<td nowrap  align=center>
		<a onclick="javascript:popup(\'families_view.php?popup=popup&id='.$row[id].'\',\'View Comment\',\'600\',\'600\')"><img SRC="../images/view.gif" ALT="view" title="view" border="0"></a>&nbsp;
 		<a onclick="javascript:popup(\'families_edit.php?popup=popup&id='.$row[id].'\',\'View Comment\',\'600\',\'600\')"><img SRC="../images/edit_pencil.gif" ALT="edit" title="edit" border="0"></a>&nbsp;
		<a href="allbills_action.php?fid='.$row['id'].'"><img SRC="../images/dollar-sign.png" ALT="billing history" title="billing history" border="0" height="16" width="20"></a>&nbsp;
		<br>
		<a onclick="javascript:popup(\'student_edit.php?family_id='.$row['id'].'\',\'Add a Student\',\'600\',\'600\')"><img SRC="../images/add_user3.png" ALT="Add a Student" title="Add a Student" border="0"></a>&nbsp;
		<a target=_blank href="studentinfo.php?fid='.$row[id].'"><img SRC="../images/roster_users1.png" ALT="View Students" title="Students" border="0"></a>&nbsp;
 		<a href="#void" onclick="if (confirm(\'Are you sure you want to archive this family?\')) {document.form.move_id.value='.$row['id'].'; document.form.submit()}"><img SRC="../images/del_x.gif" ALT="archive" title="archive" border="0"></a>&nbsp;

			
			</td>';
	}

 echo "</tr>\n";
}


//post the data to the comment database
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['notes'] != "") {
		add_comment("PT_Comments_Family", $_POST['fid'], $_POST['notes']); //table, row_id, comment
}

?>



</table>
</td>
</tr>	
</table>
<?
put_ptts_footer("");
?>
