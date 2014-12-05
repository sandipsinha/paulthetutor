<?php

// Set Zend Gdata path
$zendLibraryPath = './ZendGdata-1.12.0rc4/library';
set_include_path(get_include_path() . PATH_SEPARATOR . $zendLibraryPath);

// load Zend Gdata libraries
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Http_Client');
Zend_Loader::loadClass('Zend_Gdata_Query');
Zend_Loader::loadClass('Zend_Gdata_Feed');

/* Adds a Gmail contact; $contact array goes like this:

    $contact['name']
    $contact['middle_name']
    $contact['last_name']
    $contact['home']
    $contact['mobile']
    $contact['work']
    $contact['email']
    $contact['company']
    $contact['position']

   This assumes that all fields are set, if that's not the case, google
   will return an error indicating what field is missing
*/
function addContact($contact, $username, $password) {
    try {
        // perform login and set protocol version to 3.0
        $client = Zend_Gdata_ClientLogin::getHttpClient(
            $username, $password, 'cp');
        $gdata = new Zend_Gdata($client);
        $gdata->setMajorProtocolVersion(3);

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
        'http://www.google.com/m8/feeds/contacts/default/full');
        echo '<h3>Contact ' . $contactName . ' added! Please check your gmail address book</h3>';
    } catch (Exception $e) {
        die('Google returned an error:<br><br>' . $e->getMessage());
    }

}

// Set username and password from $_POST
$usern = $_POST['gmail_username'];
$passw = $_POST['gmail_password'];

addContact($_POST, $usern, $passw);

?>
