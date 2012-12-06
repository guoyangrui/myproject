<?php

class Application_Model_StatusMapper
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
			$this->setDbTable('Application_Model_DbTable_Status');
		}
		return $this->_dbTable;
	}	
   
    public function save(Application_Model_Status $status) 
    {
    	$data = array(
    			 'SUBJECT' => $status->getSubjectID(),
    	         'ACTION'  => $status->getActionID(),
    	         'OBJECT'  => $status->getObjectID()
    	);    	
    	$this->getDbTable()->insert($data);    	 
    }
    
    public function getDisplay ($user, $stream, $column) 
    {
    	$list = array();
    	foreach ($stream as $item) {
    		$list[] = $item->$column;    				
    	}
    	return $list;
    }
    
    public function getAction($user, $network) {
    	
    	if (null == $network) $network = $user;
    	
    	$result = $this->getDbTable()->select()->setIntegrityCheck(false)
    	    ->distinct()
    	    ->from('SQWORDLIST', array('VERB' => 'SQWORDLIST.PRESENT', 'VERBID' => 'SQWORDLIST.GUID'))
    	    ->join('SQACTION', 'SQWORDLIST.GUID = SQACTION.ACTION', array())
    	    ->join('SQUSER', 'SQUSER.GUID = SQACTION.SUBJECT', array())
    	    ->where('SQUSER.GUID in (?)', $network);    	 
    	
    	$status = $this->getDbTable()->fetchAll($result);
    	$final = array();
    	foreach ($status as $item) {
    		$final[] = array('GUID' => $user, 'VERB' => $item->VERB, 'VERBID' => $item->VERBID);    		
    	}
    	return $final;
    }
    
    public function getClass($user, $network) {
    	
    	if (null == $network) $network = $user;    	 
    	
    	$result = $this->getDbTable()->select()->setIntegrityCheck(false)
    	    ->distinct()
    	    ->from('SQCLASSNAME', array('CLASS' => 'SQCLASSNAME.CLASSNAME', 'CLASSID' => 'SQCLASSNAME.GUID'))
    	    ->join('SQDOCUMENT', 'SQDOCUMENT.CLASSID = SQCLASSNAME.GUID', array())    	    	
    	    ->join('SQACTION', 'SQACTION.OBJECT = SQDOCUMENT.GUID', array())
    	    ->join('SQUSER', 'SQUSER.GUID = SQACTION.SUBJECT', array())
    	    ->where('SQUSER.GUID in (?)', $network);
    	
    	$status = $this->getDbTable()->fetchAll($result);  
    	$final = array();
    	foreach ($status as $item) {
    		$final[] = array('GUID' => $user, 'CLASS' => $item->CLASS, 'CLASSID' => $item->CLASSID);
    	}
    	return $final;    	 
    }
    
    public function getByUser($user, $options)
    {
    	return $this->getStream($user, null, $options);    	
    }
    
    public function getStream($user, $network, $options)
    {
    	if (null == $network) $network = $user;

    	$result = $this->getDbTable()->select()->setIntegrityCheck(false)
    	    ->from('SQACTION', array('SQACTION.GUID', 'SQACTION.TIMECREATED', 'OBJECTID' => 'SQACTION.OBJECT', 'SQACTION.COMPLEMENT'))
    	    ->joinLeft('SQWORDLIST', 'SQACTION.ACTION = SQWORDLIST.GUID', array( 'VERBID' => 'SQWORDLIST.GUID', 'VERB' => 'SQWORDLIST.PRESENT'))
    	    ->joinLeft(array('SUBJECT' => 'SQUSER'), 'SQACTION.SUBJECT = SUBJECT.GUID', array('SUBJECT_FN' => 'SUBJECT.FIRSTNAME', 'SUBJECT_LN' => 'SUBJECT.LASTNAME', 'SUBJECTID' => 'SUBJECT.GUID'))
    	    ->joinLeft('SQDOCUMENT', 'SQDOCUMENT.GUID = SQACTION.OBJECT', array('TITLE' => 'SQDOCUMENT.TITLE', 'SQDOCUMENT.AUTHORID', 'SQDOCUMENT.CLASSID', 'SQDOCUMENT.CONTENT'))    	                             
    	    ->joinLeft('SQCLASSNAME', 'SQDOCUMENT.CLASSID = SQCLASSNAME.GUID', array('CLASSNAME' => 'SQCLASSNAME.CLASSNAME'))    	                             
    	    ->joinLeft(array('AUTHOR' => 'SQUSER'), 'SQDOCUMENT.AUTHORID = AUTHOR.GUID', array('AUTHOR_FN' => 'AUTHOR.FIRSTNAME', 'AUTHOR_LN' => 'AUTHOR.LASTNAME'));
    	
    	if (array_key_exists('CLASSID', $options) && null != $options['CLASSID']) {
    		return $this->getDbTable()->fetchAll($result
    				->where('CLASSID = ?', $options['CLASSID'])
    				->where('(SUBJECT.GUID = ?', $user)
    				->orWhere('SUBJECT.GUID IN (?))', $network)
    				->order('TIMECREATED DESC'));     				
    	}
    	
    	else if (array_key_exists('VERBID', $options) && null != $options['VERBID']) {
    		return $this->getDbTable()->fetchAll($result
    				->where('SQWORDLIST.GUID = ?', $options['VERBID'])
    				->where('(SUBJECT.GUID = ?', $user)
    				->orWhere('SUBJECT.GUID IN (?))', $network)
    				->order('TIMECREATED DESC'));
    	}    	
    	
    	else {
    		return $this->getDbTable()->fetchAll($result
    				->where('(SUBJECT.GUID = ?', $user)
    				->orWhere('SUBJECT.GUID IN (?))', $network)
    				->order('TIMECREATED DESC'));
    	} 
    		   
    }
    
}

