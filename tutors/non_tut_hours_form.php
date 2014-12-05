<form method="post" name="nontuthours" id="nontuthours" action="non_tut_hours_add.php<?=(isset($_REQUEST['popup'])?'?popup=true':'')?>">
<?php 
if ($admin)
  echo '<input type="hidden" name="tid" value="'.$tutor_id.'" />';
MySQL_BlankForm("PT_NonTut_Hrs", null, null, null, null, 'id,tutor_id', "nontuthours");
?>
</form>
