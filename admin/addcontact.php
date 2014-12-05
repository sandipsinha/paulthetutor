<?php

//require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/mirivam_includes.phtml';
//$strAbsPath = "/home/paulthetutor/paulthetutors.com";
//include($strAbsPath . "/includes/phtml_files/vworker_includes.phtml");

// Set Zend path
$zendLibraryPath = $_SERVER['DOCUMENT_ROOT'] . '/includes/library';
set_include_path(get_include_path() . PATH_SEPARATOR . $zendLibraryPath);

// load Zend Gdata libraries
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Http_Client');
Zend_Loader::loadClass('Zend_Gdata_Query');
Zend_Loader::loadClass('Zend_Gdata_Feed');

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
        $home = $doc->createElement('gd:phoneNumber', $contact['home']);
        $home->setAttribute('rel', 'http://schemas.google.com/g/2005#home');
        $entry->appendChild($home);
        // Add mobile phone
        $mobile = $doc->createElement('gd:phoneNumber', $contact['mobile']);
        $mobile->setAttribute('rel', 'http://schemas.google.com/g/2005#mobile');
        $entry->appendChild($mobile);
        // Add work phone
        $work = $doc->createElement('gd:phoneNumber', $contact['work']);
        $work->setAttribute('rel', 'http://schemas.google.com/g/2005#work');
        $entry->appendChild($work);
        
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

        // insert entry
        $entryResult = $gdata->insertEntry($doc->saveXML(), 
        'https://www.google.com/m8/feeds/contacts/default/full');
        echo '<h3>Contact ' . $contactName . ' added! Please check your gmail address book</h3>';
    } catch (Exception $e) {
        die('Google returned an error:<br><br>' . $e->getMessage());
    }
}



// Set username and password from $_POST
$usern = $_POST['gmail_username'];
$passw = $_POST['gmail_password'];

//var_dump($_POST);

myAddContact($_POST, $usern, $passw);

?>
