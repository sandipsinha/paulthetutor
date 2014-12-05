<?php
// phpinfo();
/**
 * Uses the following library/helper functions:
 *
 *          MySQL_PaulTheTutor_Connect
 *  		isTheStringEmpty
 *  		runquery
 *          myAddContact
 *
 *  TODO: need to refine code, might take too long
 */
$strAbsPath = "/home/paulthetutor/paulthetutors.com";
include($strAbsPath . "/includes/pttec_includes.phtml");


function isTheStringEmpty($varString) {
	return ((is_string($varString) && trim($varString) === "") ? true : false);
}



//added zend library requirments above for this function, modified
//addContact only takes first,middle,last,phone,email,company,position
function myAddContact($contact, $username, $password) {
    try {
    	//echo 'before protocal';
        // perform login and set protocol version to 3.0
        $client = Zend_Gdata_ClientLogin::getHttpClient(
            $username, $password, 'cp');
        $gdata = new Zend_Gdata($client);
        $gdata->setMajorProtocolVersion(3);
        //echo 'past protocal';
        //var_dump($client);
        // create new entry
        $doc  = new DOMDocument();
        $doc->formatOutput = true;
        $entry = $doc->createElement('atom:entry');
        $entry->setAttributeNS('http://www.w3.org/2000/xmlns/' ,
            'xmlns:atom', 'http://www.w3.org/2005/Atom');
        $entry->setAttributeNS('http://www.w3.org/2000/xmlns/' ,
            'xmlns:gd', 'http://schemas.google.com/g/2005');
        $doc->appendChild($entry);
        // add name element
        $name = $doc->createElement('gd:name');
        $entry->appendChild($name);
        $givenName = $doc->createElement('gd:givenName', $contact['first_name']);
        $name->appendChild($givenName);
        $middleName = $doc->CreateElement('gd:additionalName', $contact['middle_name']);
        $name->appendChild($middleName);
        $lastName = $doc->CreateElement('gd:familyName', $contact['last_name']);
        $name->appendChild($lastName);

        // Add Home phone
        $home = $doc->createElement('gd:phoneNumber', $contact['phone']);
        $home->setAttribute('rel', 'http://schemas.google.com/g/2005#home');
        $entry->appendChild($home);
        // // Add mobile phone
        $mobile = $doc->createElement('gd:phoneNumber', $contact['mobile']);
        $mobile->setAttribute('rel', 'http://schemas.google.com/g/2005#mobile');
        $entry->appendChild($mobile);
        // // Add work phone
        // $work = $doc->createElement('gd:phoneNumber', $contact['work']);
        // $work->setAttribute('rel', 'http://schemas.google.com/g/2005#work');
        // $entry->appendChild($work);

        // Add email
        $email = $doc->createElement('gd:email');
        $email->setAttribute('address' ,$contact['email']);
        $email->setAttribute('rel' ,'http://schemas.google.com/g/2005#home');
        $entry->appendChild($email);

        // Add organization
        $org = $doc->createElement('gd:organization');
        $org->setAttribute('rel' ,'http://schemas.google.com/g/2005#work');
        $entry->appendChild($org);

        $orgName = $doc->createElement('gd:orgName', $contact['company']);
        $org->appendChild($orgName);

        // Add position
        $orgPosition = $doc->createElement('gd:orgTitle', $contact['position']);
        $org->appendChild($orgPosition);

        //var_dump($contact);
        // insert entry
        //$entryResult = $gdata->insertEntry($doc->saveXML(),
        //'https://www.google.com/m8/feeds/contacts/default/full');
        echo '<h3>Contact ' . $contact['first_name'] . ' ' . $contact['last_name'] . ' added! Please check your gmail address book</h3>';
    } catch (Exception $e) {
    	echo 'The contact ' . $contact['first_name'] . ' ' . $contact['last_name'] . ' failed!';
        die('Google returned an error:<br><br>' . $e->getMessage());
    }
}


//get everybody's first and last name, and adds it to contacts...from families table.
function updateContactBook() {
    $sql = sprintf("SELECT * FROM PT_Family_Info limit 1"); //get family information

    $result = runquery($sql);
    if($result === false) {
    	die("Could not query database");
    }

    $contact_array = array();
    while($row = mysql_fetch_assoc($result))
    {

    	$mother_array = array();
    	$father_array = array();
    	$guardian_array = array();

    	$fam_id = $row[id];
    	//$main_name = getMainName($fam_id);
    	$company = $row[students]; //can't guarantee number
    	$position = "";
    	$firstName = "";
    	$lastName = "";
    	$middleName = "";

    	$mother_name = $row[mother];
    	$father_name = $row[father];
    	$guardian_name = $row[guardian];

    	$mother_phone = $row[mothers_phone];
    	$father_phone = $row[fathers_phone];
		$guardian_phone = $row[guardians_phone];

		$mother_email = $row[mothers_email];
		$father_email = $row[fathers_email];
		$guardian_email = $row[guardians_email];

    	$address = $row[address];
    	$main_phone = $row[main_phone];
    	$billing_email= $row[billing_email];

    	echo $fam_id . ' ' . $main_name . ' ' . $address . ' ' . $main_phone . ' ' . $billing_email . "<br>";

		/**
		*
		* CREATE A BUILD CUSTOM ARRAY FUNCTION to make sure code is "DRY"
		*/
    	if(!isTheStringEmpty($mother_name) && !isTheStringEmpty($mother_email)) {
    		$position = "mother";
    		$nameArr = explode(" ", $mother_name);
    		$firstName = $nameArr[0];

    		if(sizeof($nameArr) > 2) {
    			$middleName = $nameArr[1];
    			$lastName = $nameArr[2];
    		} else {
    			$lastName = $nameArr[1];
    		}
    		//$mother_array["name"] = $mother_name;
    		$mother_array["first_name"] = $firstName;
    		$mother_array["middle_name"] = $middleName;
    		$mother_array["last_name"] = $lastName;
    		//$mother_array["phone"] = ($mother_phone !== '' ? $mother_phone : $main_phone );
            $mother_array["phone"] = ($main_phone !== '' ? $main_phone : "none");
            $mother_array["mobile"] = ($mother_phone !== '' ? $mother_phone : "none");
    		$mother_array["email"] = $mother_email;
    		$mother_array["company"] = $company;
    		$mother_array["position"] = $position;
    		//array_push($mother_array, $mother_name, $mother_email, $mother_phone, $mother_email, $company, $position);
    		echo '<pre>';
    		//var_dump($mother_array);
    		//myAddContact($mother_array, "ptts.docs@gmail.com", "paul_the_tutor");
    		myAddContact($mother_array,"ptts.contacts@gmail.com","paulthetutors");
            //echo $fam_id . ' ' . $mother_name . ' ' . $mother_email . ' ' . $mother_phone . ' ' . $mother_email . ' ' . $company . ' ' . $position . "<br>";
    	} else {
    		//echo "no mother details for $fam_id";
    		echo "<br>";
    	};

		/**
		*
		* CREATE A BUILD CUSTOM ARRAY FUNCTION to make sure code is "DRY"
		*/
    	if(!isTheStringEmpty($father_name) && !isTheStringEmpty($father_email)) {
    		$position = "father";
    		$nameArr = explode(" ", $father_name);
    		$firstName = $nameArr[0];

    		if(sizeof($nameArr) > 2) {
    			$middleName = $nameArr[1];
    			$lastName = $nameArr[2];
    		} else {
    			$lastName = $nameArr[1];
    		}
    		//$mother_array["name"] = $mother_name;
    		$father_array["first_name"] = $firstName;
    		$father_array["middle_name"] = $middleName;
    		$father_array["last_name"] = $lastName;
    		//$father_array["phone"] = ($father_phone !== '' ? $father_phone : $main_phone );
    		$father_array["phone"] = ($main_phone !== '' ? $main_phone : "none");
            $father_array["mobile"] = ($father_phone !== '' ? $father_phone : "none");
            $father_array["email"] = $father_email;
    		$father_array["company"] = $company;
    		$father_array["position"] = $position;
    		//myAddContact($father_array, "ptts.docs@gmail.com", "paul_the_tutor");
    		myAddContact($father_array,"ptts.contacts@gmail.com","paulthetutors");
            //array_push($father_array,$father_name, $father_email, $father_phone, $father_email, $company, $position);
    		echo '<pre>';
    		///var_dump($father_array);
    		//echo $fam_id . ' ' . $father_name . ' ' . $father_email . ' ' . $father_phone . ' ' . $father_email . ' ' . $company . ' ' . $position . "<br>";
    	} else {
			//echo "no father details for $fam_id";
    		echo "<br>";
    	};

		/**
		*
		* CREATE A BUILD CUSTOM ARRAY FUNCTION to make sure code is "DRY"
		*/
    	if(!isTheStringEmpty($guardian_name) && !isTheStringEmpty($guardian_email)) {
    		$position = "guardian";
    		$nameArr = explode(" ", $guardian_name);
    		$firstName = $nameArr[0];

    		if(sizeof($nameArr) > 2) {
    			$middleName = $nameArr[1];
    			$lastName = $nameArr[2];
    		} else {
    			$lastName = $nameArr[1];
    		}
    		//$guardian_array["name"] = $guardian_name;
    		$guardian_array["first_name"] = $firstName;
    		$guardian_array["middle_name"] = $middleName;
    		$guardian_array["last_name"] = $lastName;
    		//$guardian_array["phone"] = ($guardian_phone !== '' ? $guardian_phone : $main_phone );
    		$guardian_array["phone"] = ($main_phone !== '' ? $main_phone : "none");
            $guardian_array["mobile"] = ($guardian_phone !== '' ? $guardian_phone : "none");
            $guardian_array["email"] = $guardian_email;
    		$guardian_array["company"] = $company;
    		$guardian_array["position"] = $position;
    		//myAddContact($guardian_array, "ptts.docs@gmail.com", "paul_the_tutor");
    		myAddContact($guardian_array,"ptts.contacts@gmail.com","paulthetutors");
            //array_push($guardian_array, $guardian_name, $guardian_email, $guardian_phone, $guardian_email, $company, $position);
    		echo '<pre>';
    		//var_dump($guardian_array);
    		//echo $fam_id . ' ' . $guardian_name . ' ' . $guardian_email . ' ' . $guardian_phone . ' ' . $guardian_email . ' ' . $company . ' ' . $position . "<br>";
    	} else {
			//echo "no guardian details for $fam_id";
    		echo "<br>";
    	};

    }
}


MySQL_PaulTheTutor_Connect();
updateContactBook();
