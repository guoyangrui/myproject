<?php

class Application_Model_ProfileMapper
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
			$this->setDbTable('Application_Model_DbTable_Profile');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Profile $profile)
	{
		$data = array(
				'PROFILE'   => $profile->getXML()
		);	
		$this->getDbTable()->update($data, array('GUID = ?' => $profile->getGuid()));
	}	
}

