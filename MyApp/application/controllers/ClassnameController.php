<?php

class ClassnameController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	// action body
    	   
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$queryString = $this->getRequest()->getParam('classname');
    	$wordlist = new Application_Model_DbTable_Classname();
    	$query = $wordlist->select()
    	->from('SQCLASSNAME', array('name' => 'CLASSNAME', 'id'=> 'GUID'))
    	->where("CLASSNAME LIKE '%$queryString%'");
    	
    	$jsonp = Zend_Json::encode($wordlist->fetchAll($query)->toArray());
    	$callback = $this->getRequest()->getParam('callback');
    	
    	if (null != $callback) {
    		$jsonp = $callback . "(" . $jsonp . ")";
    	}
    	$this->getResponse()->setHeader('Content-type', 'application/javascript')->setBody($jsonp);
    }


}

