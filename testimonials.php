<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

put_ptts_header("Testimonials", $strAbsPath, "", "");

?>

<div align="center">

<table border="0">
<tr>
<td>

<hr size="2" color="black">
<div align="center"><span class="Head1">Testimonials</span></div>

</td></tr>

<tr><td>
<? 
	foreach(get_testimonials() AS $row) {
 ?>

	 <p class="testimonial_wrapper">
	 	
	 	<span class="testimonial"> <?= $row['testimonial'] ?> </span> 
	 	<span class="testimonial-attrib"> - 
	 		<span class="testimonial-author"> <?= $row['name'] ?> </span>
	 		<span class="testimonial-date"> ( 
	 			<? if( $row['date'] == "0000-00-00 00:00:00" ) { 
	 				
	 					if( is_null( $row['year_of_graduation'] ) ) 
	 						echo "-";
	 					else
	 						echo $row['year_of_graduation']; 
	 				
	 				} else {
	 					echo $row['date'];
	 				}
	 			?> ) 
	 		</span>

	 	</span>

	 </p>

	 <div class="testimonial-divider"></div>

<? } ?>

<p id="write_testimonial"><a href='testimonial_write.php'>Write your own testimonial</a>

 </td>
</tr>


</table>
<? put_ptts_footer("");
