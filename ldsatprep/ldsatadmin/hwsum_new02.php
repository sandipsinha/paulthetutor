<?php
include("../../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();
$class_id = $_REQUEST[class_id];
put_ptts_header("Homework summary for student ".$class_id, $strAbsPath, "admin", "index");
$order = $_REQUEST['order'];
$sort = $_REQUEST['sort'];
$move_id = $_REQUEST['move_id'];
$tablename = "TP_HW_Summary";
if ($sort == "")
    $sort = "due_date";
if($order==""){
    $order="ASC";
}else
    $order=$_REQUEST['order'];
$order2 = ($order == "ASC" ? "DESC" : "ASC"); 

if(!(empty($move_id))){
    $MQStr = "DELETE from $tablename where id=$move_id";
    runquery($MQStr);
} 
?>
<form name=form method="post"><input type="submit" style="display:none"><input type="hidden" name=move_id><input type="hidden" name=class_id value="<?=$class_id?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
      <td align="right" style="padding-bottom:5px"><button onclick="javascript:popup('gethwsum.php?class_id=<?=$class_id?>&popup=1','Details','600','600')" style="cursor:pointer">Add New Homework</button></td>
  </tr>
  <tr height="40">
    <td class="td_header">Homework summary for class <?=$class_id?></td>
  </tr>
  <tr>
    <td  valign="top" bgcolor="#FFFFFF">
  <table border=1 width="100%" cellpadding="6" cellspacing="0" class="table_1" align="center" cellpadding="2" cellspacing="0">
  <tr style="background: #eee; height: 35px">
      <td nowrap>

	  
<?php  

show_sec_results(288,NULL,5,10);


/*

echo '<a class=a_grey href="?class_id='.$class_id."&sort=week_number&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Week number</b>'.($sort == 'week_number' ? ' <img border=0 src="'.$strAbsImgPath.'/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
      <td nowrap><?php  echo '<a class=a_grey href="?class_id='.$class_id."&sort=assigned_date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Assigned date</b>'.($sort == 'assigned_date' ? ' <img border=0 src="'.$strAbsImgPath.'/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
      <td nowrap><?php  echo '<a class=a_grey href="?class_id='.$class_id."&sort=due_date&".($order == "ASC" ? "&order=DESC" : "order=ASC").'" style="text-decoration:none"><b>Due date</b>'.($sort == 'due_date' ? ' <img border=0 src="'.$strAbsImgPath.'/order_'.($order == "ASC" ? "down" : "up").'.png">' : '').'</a>';?></td>
      <td class="text_grey"><b>Assignment</b></td>
      <td class="text_grey"><b>Action</b></td>
  </tr>

<? 

$QStr = "select * from $tablename WHERE class_id='".$class_id."' order by ".($sort!="id" ? "trim($sort)" : "$sort")." $order";
$RS = runquery($QStr);
while($row = mysql_fetch_array($RS)){
 echo '<tr>
         <td>'.$row['week_number'].'&nbsp;</td>
         <td>'.format_date_print($row[assigned_date],'yy-mm-dd','-','mm/dd/yy','/').'&nbsp;</td>
         <td>'.format_date_print($row[due_date],'yy-mm-dd','-','mm/dd/yy','/').'&nbsp;</td>
         <td>'.nl2br($row[assignment]).'&nbsp;</td>
         <td nowrap  align=center>
	             <a onclick="javascript:popup(\'gethwsum.php?id='.$row[id].'&popup=1\',\'Details\',\'600\',\'600\')"><img SRC="'.$strAbsImgPath.'edit_pencil.gif" ALT="edit" border="0"></a>&nbsp;
             <a href="#void" onclick="if (confirm(\'Are you sure you want to delete this record?\')) {document.form.move_id.value='.$row[id].'; document.form.submit()}"><img SRC="'.$strAbsImgPath.'/del_x.gif" ALT="archive" border="0"></a>&nbsp;
         </td>
 </tr>';
}


*/
?>
</table>
</td>
</tr>    
</table>
</form>
<?
put_ptts_footer("");
?>