<?php

class Application_Model_Document
{
    protected $_guid;
    protected $_timeCreated;
    protected $_actionID;
    protected $_authorID;
    protected $_classID;
    protected $_title;
    protected $_content;
    
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
    	$this->_guid = (string) $guid;
    	return $this;
    }
    
    public function getGuid()
    {
    	return $this->_guid;
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
    
    public function setActionID($actionID)
    {
    	$this->_actionID = $actionID;
    	return $this;    	 
    }
    
    public function getActionID($actionID)
    {
    	return $this->_actionID;
    }
    
    public function setAuthorID($authorID)
    {
    	$this->_authorID = $authorID;
    	return $this;
    }
    
    public function getAuthorID()
    {
    	return $this->_authorID;
    }
    
    public function setClassID($classID)
    {
    	$this->_classID = $classID;
    	return $this;
    }
    
    public function getClassID()
    {
    	return $this->_classID;
    }
    
    public function setTitle($title)
    {
    	$this->_title = $title;
    	return $this;
    }
    
    public function getTitle()
    {
    	return $this->_title;
    }
    
    public function setContent($content)
    {
    	$this->_content = $content;
    	return $this;
    }
    
    public function getContent()
    {
    	return $this->_content;
    }
    
    

}

