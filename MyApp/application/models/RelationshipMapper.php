<?php

class Application_Model_RelationshipMapper
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
			$this->setDbTable('Application_Model_DbTable_Relationship');
		}
		return $this->_dbTable;
	}
	
	public function fetch($result)
	{
		$resultSet = $this->getDbTable()->fetchAll($result);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_Relationship();
			$entry->setGuid($row->GUID)
			->setRequester($row->REQUESTER)
			->setRequested($row->REQUESTED)
			->setApproved($row->APPROVED);
			$entries[] = $entry;
		}
		return $entries;
	}
			
	public function save(Application_Model_Relationship $relationship)
	{
		$data = array(
			'REQUESTER' => $relationship->getRequester(),
		    'REQUESTED' => $relationship->getRequested(),
		);		
		$this->getDbTable()->insert($data);
	}
	
	public function getByUser()
	{
		
	}
	
	public function getRelationship($guidA, $guidB)
	{
		$result = $this->getDbTable()->select()
		                             ->from('SQRELATIONSHIP', array('SQRELATIONSHIP.REQUESTER', 'SQRELATIONSHIP.REQUESTED', 'SQRELATIONSHIP.APPROVED'))
		                             ->where("SQRELATIONSHIP.REQUESTER = '$guidA' AND SQRELATIONSHIP.REQUESTED = '$guidB'")
		                             ->orWhere("SQRELATIONSHIP.REQUESTER = '$guidB' AND SQRELATIONSHIP.REQUESTED = '$guidA'");
		return $this->getDbTable()->fetchRow($result);
	}
	
	public function getIDs ($network) 
	{
		$list = array();
		foreach ($network as $item) 
		{
			$list[] = $item->GUID;
		}
		return $list;
	}
	
	
	public function getNetwork($user)
	{
		$result = $this->getDbTable()->select()
		                             ->setIntegrityCheck(false)
		                             ->from('SQRELATIONSHIP', array('SQRELATIONSHIP.REQUESTER', 'SQRELATIONSHIP.REQUESTED'))
		                             ->join('SQUSER', 'SQUSER.GUID = SQRELATIONSHIP.REQUESTER OR SQUSER.GUID = SQRELATIONSHIP.REQUESTED', array('SQUSER.GUID', 'SQUSER.FIRSTNAME', 'SQUSER.LASTNAME'))
		                             ->where("SQUSER.GUID != '$user'")
		                             ->where("(SQRELATIONSHIP.REQUESTER = '$user' OR SQRELATIONSHIP.REQUESTED = '$user')")
		                             ->where('SQRELATIONSHIP.APPROVED = ?', 1);
		return $this->getDbTable()->fetchAll($result);
		
	}
	
	public function isApproved(Application_Model_Relationship $relationship)
	{
		return $relationship->getApproved();
	}
	
	public function getUserB(Application_Model_Relationship $relationship)
	{
		return $relationship->getRequested();
	}
	public function approve(Application_Model_Relationship $relationship)
	{
		$relationship->setApproved(1);
	}
	
	public function block(Application_Model_Relationship $relationship)
	{
		$relationship->setApproved(-1);
	}
	
	public function deleteRelationship($id)
	{
		$row = $this->getDbTable()->find($id)->current();
		if ($row) {
			$row->delete();
			return true;
		}
		else {
			throw new Zend_Exception('Delete relationship failed; could not find row!');
		}
	}
	
}

