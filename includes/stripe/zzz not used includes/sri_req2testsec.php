<?php
/*----------------------------------------------------------------------------------
req2testsec($request) - Function returns the section_id or test_id from the data sent in the request
REQUEST{
  test_id > test_id
  section_id > section_id
  section_num - along with test_id > section_id
  questions > test_id or section_id
  bb_page_num - passes a page number from the blue book and sets the section number
  page_num[] num=>page number,  source => id number from TP_Test_Sources, return => "section" or "test"
    returns the test or section that contains that page depending on
}

globally set {
  $test_id
  $section_id
  $sections // array of all of the sections[id] = sec_num
}


-----------------------------------------------------------------------------------*/
function sri_req2testsec($ps){
//printarray($ps);

  global $section_id, $test_id, $sections;
    if(!isEmpty($ps[bb_page_num])){

    $pnqs = "select id from TP_Test_Sections where first_page <= $ps[bb_page_num] and last_page >= $ps[bb_page_num] and test_id >= 4 and test_id <= 14";

      $ps[section_id] = $section_id = singlequery($pnqs);
// echo "1sec and test ids are $section_id, $test_id <BR>";

  }

  if(!isEmpty($ps[ptts_page_num])) {
    $pttsqs = "SELECT section_number FROM TP_PTTS_ACT_BOOK WHERE first_page <= $ps[ptts_page_num] AND last_page >= $ps[ptts_page_num]";
    $ps[section_id] = $section_id = singlequery($pttsqs);
    echo " SECTION ID :  " . $section_id . " !";
  }

  if(!isEmpty($ps[sections]))
    $sections = $ps[sections];

  if(!isEmpty($ps[test_id])){
    $test_id = $ps[test_id];
    global $test_info;
    $test_info = get_test_info($test_id);


    if(!isEmpty($ps[section_num]) ){
      if(is_array($ps[section_num])){
        foreach($ps[section_num] as $sec_num => $a){
          $sec_id = get_section_id('',$ps[test_id], $sec_num);
          $sections[$sec_id] = $sec_num;

        }

      } else {
        $section_id = get_section_id('',$ps[test_id], $ps[section_num]);

        global $section_info;
        $section_info = get_section_info($section_id);

        if(isEmpty($sections)){
          $sections = array($section_id => $ps[section_num]);
        }
      }
    }




    if(isEmpty($sections)){
      $secwhere = " where test_id = $test_id ";
      $sections = MySQL_fillArray("id", "section_num", " TP_Test_Sections ", $secwhere, "id");
    }

  }
// echo "2sec and test ids are $section_id, $test_id <BR>";

  if(!isEmpty($ps[section_id]) and !is_array($ps[section_id])){
// echo "3sec and test ids are $section_id, $test_id <BR>";
// printarray($ps[section_id]);

    $section_id = $ps[section_id];
    global $section_info;
    $section_info = get_section_info($section_id);

    if(isEmpty($sections)){
      $sections = array($section_id => $ps[section_num]);
    }
// echo "4sec and test ids are $section_id, $test_id <BR>";

  }





  if(!isEmpty($ps[page_num]) and !(isEmpty($ps[test_source_id]))){
    $test_source_id = $ps[test_source_id];
    $pnqs = "select id from TP_Test_Sections where first_page <= $ps[bb_page_num] and last_page >= $ps[bb_page_num] and test_id in (select id from TP_Test_Info where test_source_id = $test_source_id)";

    $ps[section_id] = $section_id = singlequery($pnqs);
    echo " in sri_req2testsec";
     var_dump($ps);
  }

}
