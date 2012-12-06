<?php

class TitleController extends Zend_Controller_Action
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
    	 
    	$queryString = $this->getRequest()->getParam('title');
    	$wordlist = new Application_Model_DbTable_Document();
    	$query = $wordlist->select()
    	->from('SQDOCUMENT', array('name' => 'TITLE', 'id'=> 'GUID'))
    	->where("TITLE LIKE '%$queryString%'");
    	 
    	$jsonp = Zend_Json::encode($wordlist->fetchAll($query)->toArray());
    	$callback = $this->getRequest()->getParam('callback');
    	 
    	if (null != $callback) {
    		$jsonp = $callback . "(" . $jsonp . ")";
    	}
    	$this->getResponse()->setHeader('Content-type', 'application/javascript')->setBody($jsonp);
    }


}

