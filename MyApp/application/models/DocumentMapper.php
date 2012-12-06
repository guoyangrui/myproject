<?php

class Application_Model_DocumentMapper
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
			$this->setDbTable('Application_Model_DbTable_Document');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Document $document)
	{
		
		$objectID = $this->getDbTable()->fetchRow($this->getDbTable()->select()->setIntegrityCheck(false)->from('DUAL', array('GUID' => 'SYS_GUID()')));
	
		$data = array(
				'GUID'    => $objectID->GUID,
				'AUTHORID'   => $document->getAuthorID(),
				'CLASSID'	   => $document->getClassID(),
				'TITLE'   => $document->getTitle(),
				'CONTENT'    => '<?xml version="1.0" encoding ="uft8"?><document>' . $document->getContent() . '</document>'
		);
		
		if (null == $document->getGuid()) {
			//unset($data['GUID']);
			$this->getDbTable()->insert($data);		
			$this->saveStatus($data['AUTHORID'],  $document->getActionID(), $objectID->GUID);
		} else {
			$this->getDbTable()->update($data, array('GUID = ?' => $document->getGuid()));
		}
	}
	
	public function fetch($result)
	{
		$resultSet = $this->getDbTable()->fetchAll($result);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_Document();
			$entry->setGuid($row->GUID)
			->setAuthorID($row->AUTHORID)
			->setClassID($row->CLASSID)
			->setTitle($row->TITLE)
			->setContent($row->CONTENT);
			$entries[] = $entry;
		}
		return $entries;
	}
	
	public function getByUser($user)
	{
		$result = $this->getDbTable()->select()->
		                               from('SQDOCUMENT')->
		                               join('SQCLASSNAME', 'SQCLASSNAME.GUID = SQDOCUMENT.CLASSID')->
		                               where('SQDOCUMENT.AUTHORID = ?', $user);
		//where('contains (SQCLASSNAME.CLASSNAME, $')
		return $this->fetch($result);
	}
	
	public function getAllDocument($user, $class)
	{
		$result = $this->getDbTable()->select()->setIntegrityCheck(false)->
		from('SQDOCUMENT')->
		join('SQCLASSNAME', 'SQDOCUMENT.CLASSID = SQCLASSNAME.GUID', array('CLASS' => 'SQCLASSNAME.CLASSNAME'))->
		join('SQUSER', 'SQUSER.GUID = SQDOCUMENT.AUTHORID', array('FIRSTNAME', 'LASTNAME'))->
		where('SQDOCUMENT.AUTHORID = ?', $user);
		return $this->getDbTable()->fetchAll($result);
		//return $this->fetch($result);		
	}
	
	public function getDocumentByID($docid)
	{
		$result = $this->getDbTable()->select()->setIntegrityCheck(false)->
		from('SQDOCUMENT')->
		join('SQCLASSNAME', 'SQDOCUMENT.CLASSID = SQCLASSNAME.GUID', array('CLASS' => 'SQCLASSNAME.CLASSNAME'))->
		join('SQUSER', 'SQUSER.GUID = SQDOCUMENT.AUTHORID', array('FIRSTNAME', 'LASTNAME'))->
		where('SQDOCUMENT.GUID = ?', $docid);
	
		return $this->getDbTable()->fetchRow($result);
	}
	
	public function getClass($user)
	{
		$result = $this->getDbTable()->select()->setIntegrityCheck(false)->
		distinct()->
		from('SQDOCUMENT', array('SQDOCUMENT.CLASSID'))->
		join('SQCLASSNAME', 'SQDOCUMENT.CLASSID = SQCLASSNAME.GUID', array('CLASS' => 'SQCLASSNAME.CLASSNAME'))->
		where('SQDOCUMENT.AUTHORID = ?', $user);

		return $this->getDbTable()->fetchAll($result);
		//return $this->fetch($result);
	}
	
	public function saveStatus($subjectID, $actionID, $objectID) {
		$status = new Application_Model_Status();
		$statusMapper = new Application_Model_StatusMapper();
		$status->setSubjectID($subjectID)
		->setActionID($actionID)
		->setObjectID($objectID);		
		$statusMapper->save($status);
	}
	
	public function delete($guid)
	{
		
	}

}

