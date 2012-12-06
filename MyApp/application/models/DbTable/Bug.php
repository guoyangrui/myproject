<?php

class Application_Model_DbTable_Bug extends Zend_Db_Table_Abstract
{

    protected $_name = 'bug';

    public function createBug ($name, $email, $date, $url, $description, $priority, $status) 
    {
    	$row = $this->createRow();
    	
    	$row->author = $name;
    	$row->email = $email;
    	$dateObject = new Zend_Date($date);
    	//$row->date = Zend_Date::now();//$dateObject->get(Zend_Date::TIMESTAMP);
    	$row->url = $url;
    	$row->description = $description;
    	$row->priority = $priority;
    	$row->status = $status;
    	
    	$row->save();
    	$id = $this->_db->lastInsertId();
    	return $id;
    }
    
    public function fetchBugs($filters = array(), $sortField = null, $limit = null, $page = 1) 
    {
    	$select = $this->select();
    	if (count($filters) > 0) {
    		foreach ($filters as $field => $filter) {
    			$select->where($field . ' = ?', $filter);
    		}
    	}
    	
    	if (null != $sortField) {
    		$select->order($sortField);
    	}
    	return $this->fetchAll($select);
    }
    
    public function updateBug($id, $name, $email, $date, $url, $description, $priority, $status)
    {
    	$row = $this->find($id)->current();
    	
    	if ($row) {
    		$row->author = $name;
    		$row->email = $email;
    		$d = new Zend_Date($date);
    		$row->date = $d->get(Zend_Date::TIMESTAMP);
    		$row->url = $url;
    		$row->description = $description;
    		$row->priority = $priority;
    		$row->status = $status;
    		
    		$row->save();
    	}
    	
    	else {
    		throw new Zend_Exception('Update function failed; could not find row!');
    	}
    }
    
    public function deleteBug($id)
    {
    	$row = $this->find($id)->current();
    	if ($row) {
    		$row->delete();
    		return true;
    	}
    	else {
    		throw new Zend_Exception('Delete function failed; could not find row!');
    	}
    }
}

