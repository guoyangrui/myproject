<?php

class Application_Model_User
{
	protected $_guid;
    protected $_email;
    protected $_password;
    protected $_firstName;
    protected $_lastName;
    protected $_active;
    protected $_admin;
    protected $_timeCreated;
    
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
    	
    public function setEmail($text)
    {
    	$this->_email = (string) $text;
    	return $this;
    }
    
    public function getEmail()
    {
    	return $this->_email;
    }
    	
    public function setPassword($password)
    {
    	$this->_password = md5((string) $password);
    	return $this;
    }
    	
    public function getPassword()
    {
    	return $this->_password;
    }
    
    public function setFirstName($firstName)
    {
    	$this->_firstName = (string) $firstName;
    	return $this;
    }
     
    public function getFirstName()
    {
    	return $this->_firstName;
    }
    
    public function setLastName($lastName)
    {
    	$this->_lastName = (string) $lastName;
    	return $this;
    }
     
    public function getLastName()
    {
    	return $this->_lastName;
    }
    
    public function setActive($active)
    {
    	$this->_active = (int) $active;
    	return $this;
    }
    	
    public function getActive()
    {
    	return $this->_active;
    }
    	
    public function setAdmin($admin)
    {
    	$this->_admin = (int) $admin;
    	return $this;
    }
     
    public function getAdmin()
    {
    	return $this->_admin;
    }
     
    public function setBanned($banned)
    {
    	$this->_banned = (int) $banned;
    	return $this;
    }
     
    public function getbanned()
    {
    	return $this->_banned;
    }
    
    public function setTimeCreated($timeCreated)
    {
    	$this->_timeCreated = $timeCreated;
    	return $this;
    }
     
    public function getTimeCreated()
    {
    	return $this->_timeCreated;
    }
     
    public function setGuid($guid)
    {
    	$this->_guid = (string) $guid;
    	return $this;
    }
    	
    public function getGuid()
    {
    	return $this->_guid;
    }
    	 
}

