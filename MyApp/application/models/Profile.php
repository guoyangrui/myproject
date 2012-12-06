<?php

class Application_Model_Profile
{
    protected $_guid;
    protected $_firstName;
    protected $_lastName;
    protected $_xml;
    
    public function __construct($guid)
    {
    	if (null != $guid) {
    		$this->_guid = $guid;
    		$userMapper = new Application_Model_UserMapper();
    		$this->_firstName = $userMapper->getProfile($guid)->FIRSTNAME;
    		$this->_lastName = $userMapper->getProfile($guid)->LASTNAME;    		
    		$this->_xml = $userMapper->getProfile($guid)->PROFILE;
    	}    		
    }
    
    public function getFirstName() {
    	return $this->_firstName;
    }
    
    public function getLastName() {
    	return $this->_lastName;
    }
    
    
    public function getGuid() {
    	return $this->_guid;
    }
    
    public function getXML() {
    	return $this->_xml;
    }
    
    public function setGuid($guid) {
    	$this->_guid = $guid;
    	return $this;
    }
    
    public function setXML($xml) {
    	$this->_xml = $xml;
    	return $this;
    }
    
    public function setFirstName($firstName) {
    	$this->_firstName = $firstName;
    	return $this;
    }
    
    public function setLastName($lastName) {
    	$this->_lastName = $lastName;
    	return $this;
    }
    
}

