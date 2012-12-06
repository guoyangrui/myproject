<?php

class Application_Model_DbTable_ContentNode extends Zend_Db_Table_Abstract
{

    protected $_name = 'ContentNode';
    
    protected $_referenceMap = array(
    		'Page' => array(
    				'columns' => array('page_id') ,
    				'refTableClass' => 'Application_Model_DbTable_Page' ,
    				'refColumns' => array('id') ,
    				'onDelete' => self::CASCADE ,
    				'onUpdate' => self::RESTRICT)
    );
    
    public function setNode ($pageId, $node, $value)
    {
    	// fetch the row if it exists
    	$select = $this->select();
    	$select->where("page_id = ?", $pageId);
    	$select->where("node = ?", $node);
    	$row = $this->fetchRow($select);
    	//if it does not then create it
    	if (! $row) {
    		$row = $this->createRow();
    		$row->page_id = $pageId;
    		$row->node = $node;
    	}
    	//set the content
    	$row->content = $value;
    	$row->save();
    }


}

