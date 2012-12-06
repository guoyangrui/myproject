<?php

class Application_Model_Status
{
    protected $_guid;
    protected $_subjectID;
    protected $_actionID;
    protected $_objectID;
    protected $_passive;
    protected $_complement;
    
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
    
    public function getGuid()
    {
    	return $this->_guid;
    }
    
    public function setSubjectID($subjectID)
    {
    	$this->_subjectID = $subjectID;
    	return $this;
    }
    
    public function getSubjectID()
    {
    	return $this->_subjectID;
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
    
    public function getActionID()
    {
    	return $this->_actionID;
    }   
        
    public function setObjectID($objectID)
    {
    	$this->_objectID = $objectID;
    	return $this;
    }
    
    public function getObjectID()
    {
    	return $this->_objectID;
    }
    
    public function setPassive($passive)
    {
    	$this->_passive = $passive;
    	return $this;
    }
    
    public function getPassive()
    {
    	return $this->_passive;
    }
    
    public function setComplement($complement)
    {
    	$this->_complement = $complement;
    	return $this;
    }
    
    public function getComplement()
    {
    	return $this->_complement;
    }    
    
}

