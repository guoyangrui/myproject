<?php

class Application_Model_Relationship
{
	protected $_guid;
	protected $_requester;
	protected $_requested;
	protected $_message;
	protected $_approved;
	
    public function __construct(array $options = null)
    {
    	if (is_array($options)) {
    		$this->setOptions($options);
    	}
    }
    	
    public function __set($name, $value)
    {
    	$method = 'set' . $name;
    	if (('mapper' == $name) || !method_exists($this, $method)) {
    		throw new Exception('Invalid user property: ' . $name);
    	}
    	$this->$method($value);
    }
    	
    public function __get($name)
    {
    	$method = 'get' . $name;
    	if (('mapper' == $name) || !method_exists($this, $method)) {
    		throw new Exception('Invalid user property: ' . $name);
    	}
    	return $this->$method();
    }
    	
    public function setOptions(array $options)
    {
    	$methods = get_class_methods($this);
    	 
    	foreach ($options as $key => $value) {
    		$method = 'set' . ucfirst($key);
    		if (in_array($method, $methods)) { 			
    			$this->$method($value);
    		}
    	}    	   	
    	return $this;
    }
    
    public function setGuid($guid)
    {
    	$this->_guid = $guid;
    	return $this;
    }
    
    public function getGuid($guid)
    {
    	return $this->_guid;
    }
        
    public function setRequester($requester)
    {
    	$this->_requester = $requester;
    	return $this;
    }
    
    public function getRequester()
    {
    	return $this->_requester;
    }
    
    public function setRequested($requested)
    {
    	 $this->_requested = $requested;
    	 return $this;
    }
    
    public function getRequested()
    {
    	 return $this->_requested;
    }    
  
    public function setMessage($message)
    {
    	 $this->_message = (string) $message;
    	 return $this;
    }
    
    public function getMessage()
    {
    	 return $this->_message;
    }
    
    public function setApproved($approved)
    {
    	 $this->_approved = (int) $approved;
         return $this;
    }
    
    public function getApproved()
    {
    	 return $this->_approved;    	
    }
     
}