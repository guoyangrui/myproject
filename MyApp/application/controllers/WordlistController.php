<?php

class WordlistController extends Zend_Controller_Action
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

    	$queryString = $this->getRequest()->getParam('v');
    	$wordlist = new Application_Model_DbTable_Wordlist();
    	$query = $wordlist->select()
    	->from('SQWORDLIST', array('name' => 'PRESENT', 'id'=> 'GUID'))
    	->where("PRESENT LIKE '%$queryString%'");

    	$jsonp = Zend_Json::encode($wordlist->fetchAll($query)->toArray());
    	$callback = $this->getRequest()->getParam('callback');
    				
    	if (null != $callback) {
    	    $jsonp = $callback . "(" . $jsonp . ")";
        }
    	$this->getResponse()->setHeader('Content-type', 'application/javascript')->setBody($jsonp);
				
    				
    }


}

