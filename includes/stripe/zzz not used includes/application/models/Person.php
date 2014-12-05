<?php

// eventually make it: implements Zend_Acl_Role_Interface
class PTTS_Model_Person
{
  protected $_id;
  protected $_family_id;
  protected $_first_name;
  protected $_last_name;
  protected $_nickname;
  protected $_username;
  protected $_password;
  protected $_personal_email;
  protected $_mobile_phone;
  protected $_carrier_id;
  protected $_alert_pref;

// Getters
  public function getId() {
    return $this->_id;
  }

  public function getFamilyId() {
    return $this->_family_id;
  }

  public function getFirstName() {
    return $this->_first_name;
  }

  public function getLastName() {
    return $this->_last_name;
  }

  public function getNickname() {
    return $this->_nickname;
  }

  public function getUsername() {
    return $this->_username;
  }

  public function getPassword() {
    return $this->_password;
  }

  // alias to getPersonalEmail by default
  public function getEmail() {
    return $this->_personal_email;
  }

  public function getPersonalEmail() {
    return $this->_personal_email;
  }

  public function getMobilePhone() {
    return $this->_mobile_phone;
  }

  public function getCarrierId() {
    return $this->_carrier_id;
  }

  public function getAlertPref() {
    return $this->_alert_pref;
  }

// Setters

  public function setId($d) {
    $_id = (int) $d;
    return $this;
  }

  public function setFamilyId($d) {
    $_family_id = (int) $d;
    return $this;
  }

  public function setFirstName($d) {
    $_first_name =$d;
    return $this;
  }

  public function setLastName($d) {
    $_last_name = $d;
    return $this;
  }

  public function setNickname($d) {
    $_nickname = $d;
    return $this;
  }

  public function setUsername($d) {
    $_username = $d;
    return $this;
  }

  public function setPassword($d) {
    $_password = $d;
    return $this;
  }

  public function setEmail($d) {
    $this->setPersonalEmail($d);
    return $this;
  }

  public function setMobilePhone($d) {
    $_mobile_phone = $d;
    return $this;
  }

  public function setCarrierId($d) {
    $_carrier_id = (int) $d;
    return $this;
  }

  public function setAlertPref($d) {
    $_alertPref = $d;
    return $this;
  }

} // end class Person
