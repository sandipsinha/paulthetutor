<?php 
	function create_note($table_name, $f_id) {
			
		$QS = "SELECT comment from $table_name where family_id = $f_id";
		$RES = runquery($QS);
		$note = "";
		if($QS != null) {
			while($row =  mysql_fetch_array($RES)) {
				$note = $row['comment'];	
			}
			//echo $note;
		}

		//page reloads before note is inserted into db
		//this check will grab note from post
		if($_POST['fid'] == $f_id) {
			$note = $_POST['notes'];
		}
		
		$table_column = '
 			<td valign=top class="note-container">
				<form method="post" action="">
					<textarea type="text" name="notes" class="notes" cols="20" rows="10" style="resize:none;">'.$note.'</textarea>
					<button type="submit" id="btn" style="display:none">Save</button>
					<textarea type="text" name="fid" style="display: none">'.$f_id.'</textarea>
				</form>&nbsp;
			</td>';
		
		echo $table_column; 
	}
	//header("Location: families_test.php");
?>