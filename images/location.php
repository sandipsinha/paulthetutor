<?
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");
put_ptts_header("Location", $strAbsPath, "",($_REQUEST[popup] ? "popup" : ""));

$location_name = isset($_REQUEST["id"]) ? $_REQUEST["id"] : 1;
$location = get_location( $location_name );

/**
  id of location
  address 
  name
  phone_number
  description
  rate(all the rates are the same)
  image_url(300x235)(google maps, use the id of location get the image form images)
  map_url(google maps)
  map_image_url(saved google maps, use the id of location get the map image from images)

  Piedmont
  piedmont
  4235 Piedmont Avenue, Oakland, CA 94611 
  Piedmont
  (510) 730-0390
  We are located on Piedmont Avenue, across from Fenton's Creamery.
  NONE
  http://www.paulthetutors.com/images/sidewalk.jpg
  http://maps.google.com/maps?oi=map&q=4235+Piedmont+Ave,+Oakland,+CA
  http://www.paulthetutors.com/images/laf_map.jpg

  San Mateo
  sanmat
  San Mateo

  Lafayette
  lafayette
  Lafayette

**/

//@param $location_name (String) case sensitive 

function get_location( $location_name ) {
  //check if where clause is case sensitive
  $query = "SELECT * FROM PT_Locations WHERE id = $location_name"; //"LIMIT 0,1" ;
  $result = runquery( $query );
  $query = "SELECT * FROM PT_Rates_Loc WHERE location_id = $location_name";
  $result_rates = runquery($query);
  if( !$result ) {

    $query = "SELECT * FROM  WHERE shortname = 'PT_Locations'";
   $result = mysql_query( $query );

  }
  $location= NULL;
  while( $rows = mysql_fetch_array( $result ) ) {
    
    $location = array(
      "name" => $rows[ 'name' ],
      "address" => $rows[ 'address' ],
      "phone" => $rows[ 'phone'],
      "city"=> $rows['city'],
      "state"=> $rows['state'],
      "zip"=> $rows['zip'],
      "description" => $rows[ 'description' ],
      "map_url" => $rows[ 'map url' ],
      "image_url" => $rows[ "image_url" ],
      "mapimage_url" => $rows[ "mapimage_url" ],

    );
    
  }
  while( $rows = mysql_fetch_array( $result_rates ) ) {
      
    
    if($location_name !=8) {
      $location["rate"] = $rows[ 'rate' ];
    }else { 
      $location["rate"] = "125/hour for in-home with Paul, $70/hour for in-home with other tutor's";
  
    }
    return $location;
  }

  echo "nothing meets the query ".$query;
  return false;
  
}

?>

<link href="includes/css_files/locations.css" rel="stylesheet" type="text/css">

<table align="center" border="0"><tr><td>
  <p><span class="loc_image_address"> 
         
    <?php if($location_name != 9 && $location_name != 8) {?>


    <a href=" <?= $location["map_url"]?> " target="_blank">
      <img src="<?= $location["mapimage_url"] ?>" width="267" height="267" />
    </a> 

    <br /> 
    <br />
    
    <span class="loc_address">
      

          <a href="<?= $location["map_url"] ?>" target="_blank">Map and Directions</a>

          <br />
          
            </span> 
        </span>
<span class="Head1_Green">Paul the Tutor's - <?= $location["name"] ?> </span><br />
          <p>
    <?= $location["description"] ?>
  </p>
  <!-- what todo about this? -->
  <p>&nbsp;</p>
     <?= $location["address"]  ?>
      <br>
      <!-- <?php var_dump($location) ?> -->
      <?= $location["city"].",".$location["state"]."&nbsp".$location["zip"] ?>
      <br />
       <?= $location["phone"] ?>
                
<?php }else{ ?>
      </span>
      <span class="Head1_Green" float="left">Paul the Tutor's - <?= $location["name"] ?> </span><br />
  <p>
    <?= $location["description"] ?>
  </p>

  <!-- what todo about this? -->
  <p>&nbsp;</p>
     </span>
     <?php if($location_name==9) {?>
     <b>Currently the Berkeley office is not open until it opens
      we offer in-home tutoring at in-office rates.</b></p>
      <?php }?>
     <?php }?>
     <ul>
       <li><strong>Traditional</strong> Subject Matter Tutoring</li>
       <li><strong>Learning Disabilities</strong> Targeted Instruction</li>
       <li>General<strong> Cognitive Skill </strong>Development</li>
     </ul>
     
          <p>&nbsp;</p>
          
          <p></p>
          
          <p>&nbsp;</p>
               <p class="Head3">Rates starting at $<?= $location["rate"] ?>

            (<a href="contact.php" target="_blank">contact us for rate details</a>)</p>
          <p class="Head3">Find out More   (<a href="tutoring.php">get tutoring information</a>)</p>
          <p class="Head3">Ready to Get Started? (<a href="contact.php">click here</a>)</p>
          <p class="Head3">Contact Us (<a href="contact.php">click here</a>)</p>
          
          <p>&nbsp;</p>

          <p><img src="<?= $location["image_url"] ?>" width="330" height="220" /></p>
          
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          
          <p></p>
          
          <p>&nbsp;</p>

</div>

</td></tr></table>

<? put_ptts_footer(); ?>
