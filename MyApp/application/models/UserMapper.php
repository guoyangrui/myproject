<?php

class Application_Model_UserMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Application_Model_DbTable_User');
		}
		return $this->_dbTable;
	}
	
	public function listUsers()
	{
		$result = $this->getDbTable()->select()->setIntegrityCheck(false)
		                             ->from('SQUSER')
		                             ->where('SQUSER.ACTIVE = 1');
		return ($this->getDbTable()->fetchAll($result)); 
	}
	
	public function listUsersByName($name)
	{
		$result = $this->getDbTable()->select()->setIntegrityCheck(false)
		                             ->from('squser', array('id', 'first_name', 'last_name'))
		                             ->where('squser.isbanned = 0')
		                             ->where('squser.isactive = 1')
		                             ->where('squser.lastname LIKE ?', '%' . $name . '%');
		return $result;
	}
	
    public function save(Application_Model_User $user)
    {
        $data = array(
            'EMAIL'   => $user->getEmail(),
        	'PASSWORD'	   => $user->getPassword(),
        	'FIRSTNAME'   => $user->getFirstName(),
        	'LASTNAME'    => $user->getLastName()
        );

        if (null == $user->getGuid()) {
            //unset($data['GUID']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('GUID = ?' => $user->getGuid()));
        }
    }
    
    public function find($guid, Application_Model_User $user)
    {
    	$result = $this->getDbTable()->find($guid);
    	if (0 == count($result)) {
    		return;
    	}
    	$row = $result->current();
    	$user->setId($row->ID)
    		->setUserEmail($row->EMAIL)
    		->setFirstName($row->FIRSTNAME)
    		->setLastName($row->LASTNAME);
    	return $user;
    }
    
    public function getProfile($guid)
    {
    	$result = $this->getDbTable()->find($guid);
    	if (0 == count($result)) {
    		return;
    	}    	 
    	$row = $result->current();
    	return $row;
    }
    
    public function fetchAll()
    {
    	$resultSet = $this->getDbTable()->fetchAll();
    	$entries   = array();
    	foreach ($resultSet as $row) {
    		$entry = new Application_Model_User();
    		$entry->setId($row->ID)
    		->setUserEmail($row->EMAIL)
    		->setFirstName($row->FIRSTNAME)
    		->setLastName($row->LASTNAME);
    		$entries[] = $entry;
    	}
    	return $entries;
    }       
}

